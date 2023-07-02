<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Livewire\Job;
use App\Http\Resources\JobRS;
use App\Models\JobLikes;
use App\Models\Jobs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function list(Request $request)
    {
        $category_id = null;
        if($request->get('user_id'))
        {
            $user = User::find($request->get('user_id'));

            if($user)
            {
                $category_id = $user->category_id;
            }
        }
        $job = Jobs::with(['category'])->where('id', '<>', null);

        if($category_id)
        {
            $job->where('category_id', '=', $category_id);
        }

        if ($rawperpage = $request->get('rawperpage', null)) {
            $job->take($rawperpage)->skip($request->start);
        }

        $clone_job = clone $job;
        $totalRecords = $totalRecordwithFilter = $clone_job->count();

        $result = $job->get();

        if($result->count() === 0)
        {
            return response()->json([
                'status' => true,
                'message' => 'Jobs not found'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Found Jobs',
            'data'   => JobRS::collection($result)
        ]);
    }

    public function job_likes(Request $request)
    {
        $request_data = $request->all();

        $validation  = Validator::make($request_data, [
            'job_id' => [
                'required',
                'exists:jobs,id'
            ],
            'user_id'=> [
                'required',
                'exists:users,id'
            ],
            'status'=> [
                'required'
            ]
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status'   => false,
                'message'   => $validation->errors()->first(),
                'error'      => $validation->errors()
            ], 422);
        }

        $job = JobLikes::where('user_id', $request->user_id)->where('job_id', $request->job_id)->first();
        if(!isset($job->id))
        {
            $job = new JobLikes();
        }
        $job->user_id = $request->user_id;
        $job->job_id = $request->job_id;
        $job->status = $request->status;
        $job->save();

        return response()->json([
            'status'   => true,
            'message'   => "Update status",
        ], 200);
    }

    public function generateResult(Request $request)
    {
        $request_data = $request->all();

        $validation  = Validator::make($request_data, [
            'user_id'=> [
                'required',
                'exists:users,id'
            ]
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status'   => false,
                'message'   => $validation->errors()->first(),
                'error'      => $validation->errors()
            ], 422);
        }

        $user_id = $request->user_id;

        $collection = $this->logicOfResult($user_id);

        // dd($result);

        return response()->json([
            'status'   => true,
            'message'   => "Found result based on your interest",
            'data'      => $collection
        ], 200);
    }

    public function generateViewCloudResult(Request $request)
    {
        $request_data = $request->all();

        $validation  = Validator::make($request_data, [
            'user_id'=> [
                'required',
                'exists:users,id'
            ]
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status'   => false,
                'message'   => $validation->errors()->first(),
                'error'      => $validation->errors()
            ], 422);
        }

        $user_id = $request->user_id;

        $data['result'] = $this->logicOfResult($user_id)->toArray();

        $data['skill_string'] = implode('... ', array_column($data['result'], 'skill'));

        /**
         * Return view
         */
        return view('cloud_result')->with($data);

    }

    public function logicOfResult($user_id)
    {
        /**
         * Get Unique Skills
         */
        $jobs = DB::table('jobs')->select(DB::raw('skills'))->get();
        $skills_array = [];
        foreach($jobs as $job)
        {
            $skills = explode(',', $job->skills);
            $skills_array = array_merge($skills_array, $skills);
        }
        // dd($skills_array);

        // $skills_array = explode(',', $job->skills);
        $skills_unique = array_unique($skills_array);

        /**
         * Fetch Job likes
         */
        $develop_array = [];
        foreach($skills_unique as $skill){
            // dd($skill);
            $data['skill'] = $skill;
            $job_likes = JobLikes::where('user_id', $user_id);
            $job_likes->where('status', 1);
            $job_likes->whereHas('job', function($query) use($skill){
                $query->where('skills', 'like', '%' . $skill . '%');
            });
            $data['interest_count'] = $job_likes->count();
            $develop_array[] = $data;
        }

        $collection = collect ($develop_array);

        $result = $collection->sortByDesc('interest_count')->take(12);

        return $result;
    }
}
