<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Livewire\Job;
use App\Http\Resources\JobRS;
use App\Models\JobLikes;
use App\Models\Jobs;
use App\Models\User;
use Illuminate\Http\Request;
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
        if(!$job)
        {
            $job = new Job();
        }
        $job->user_id = $request->user_id;
        $job->job_id = $request->job_id;
        $job->status = $request->status;

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
    }
}
