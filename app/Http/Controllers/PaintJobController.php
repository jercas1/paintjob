<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaintJob;

class PaintJobController extends Controller
{
    public function markCompleted($paint_job_id) {
        $paint_job = PaintJob::find($paint_job_id);

        return response()->json([
            'success' => true,
            'paint_job_id' => $paint_job_id,
        ]);
    }

    public function create(Request $request) {
        $paint_job = new PaintJob;
        $paint_job->plate_number = $request->input('plate_number');
        $paint_job->current_color = $request->input('current_color');
        $paint_job->target_color = $request->input('target_color');
        $paint_job->status = "processing";
        $paint_job->save();

        return response()->json([
            'success' => true,
            'request' => $request->input('plate_number')
        ]);
    }

    public function get() {
        $paint_jobs = PaintJob::where('status', 'processing')->get();

        return response()->json([
            'success' => true,
            'paint_jobs' => $paint_jobs
        ]);
    }
}
