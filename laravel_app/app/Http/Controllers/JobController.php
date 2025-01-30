<?php

namespace App\Http\Controllers;
use App\Models\EncodingJob;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class JobController extends Controller
{
    // Submit a new job
    public function submitJob(Request $request)
    {
        $validated = $request->validate([
            'input' => 'required|url',
            'storage' => 'required|string',
            'outputs' => 'required|array',
            'notification' => 'required|url',
            'job_settings' => 'nullable|array',
        ]);

        $job = EncodingJob::create([
            'user_id' => Auth::id(),
            'input' => $validated['input'],
            'storage' => $validated['storage'],
            'outputs' => json_encode($validated['outputs']),
            'notification' => $validated['notification'],
            'job_settings' => json_encode($validated['job_settings'] ?? []),
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Job submitted successfully',
            'job_id' => $job->id,
        ], 201);
    }

    // Check the status of a specific job
    public function checkJobStatus($job_id)
    {
        $job = EncodingJob::where('id', $job_id)->where('user_id', Auth::id())->first();

        if (!$job) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        return response()->json([
            'job_id' => $job->id,
            'status' => $job->status,
            'created_at' => $job->created_at,
            'updated_at' => $job->updated_at,
        ]);
    }
}
