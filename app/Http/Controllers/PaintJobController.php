<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaintJob;

use DB;

class PaintJobController extends Controller
{
    public function getBreakDown() {
        $breakdown = PaintJob::select('target_color', DB::raw('count(*) as breakdown'))
            ->where('status', 'completed')
            ->groupBy('target_color')
            ->get();

        return response()->json([
            'success' => true,
            'breakdown' => $breakdown,
        ]);
    }

    public function markCompleted($paint_job_id) {
        $paint_job = PaintJob::find($paint_job_id);
        $paint_job->status = "completed";
        $paint_job->save();

        return response()->json([
            'success' => true,
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
            'paint_job' => $paint_job
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
