<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Jobs;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function list(Request $request)
    {
        $job = Jobs::with(['category'])->where('id', '<>', null);

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
                'message' => 'Found Jobs',
                'data'   => $result
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Found Jobs',
            'data'   => $result
        ]);
    }
}
