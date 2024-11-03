<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Category;
use App\Models\JobType;
use App\Models\Job;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\View\View;
class HomeController extends Controller
{
    public function index(){

        $categories= Category::all();


        $job = Job::with('jobType','category')->orderBy('created_at', 'desc')->take(12)->get();

        // Check if the job exists and belongs to the current user
        if (!$job) {
            return redirect()->back()->with('error', 'Job not found or you do not have permission to view it.');
        }

        // Fetch all job types to populate the dropdown
        $jobTypes = JobType::all();
        $categories=Category::all();

        // Pass the job details and job types to the viewcategory
        return view('front.home', compact('job', 'jobTypes','categories'));
    }

    // public function getFeatureJob(Request $request)
    // {

    //    // Fetch the job details using the job ID and include the jobType and category relationships
    //     $job = Job::with('jobType', 'category')->get();

    //     // Check if the job exists and belongs to the current user
    //     if (!$job) {
    //         return response()->json(['status' => 'error', 'message' => 'Job not found or you do not have permission to view it.'], 404);
    //     }

    //     // Return job details as JSON
    //     return response()->json(['status' => 'success', 'data' => $job],200);
    // }


    public function getFeatureJob(Request $request)
    {
        // Fetch the latest 12 jobs including jobType and category relationships
        $jobs = Job::with('jobType', 'category')->orderBy('created_at', 'desc')->take(12)->get();

        // Check if jobs are found
        if ($jobs->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'No jobs found.'], 404);
        }

        // Process each job's description to limit it to the first 10 words
        $jobs->transform(function ($job) {
            // Limit the description to the first 10 words and add "..." if it exceeds 10 words
            $words = explode(' ', $job->description);
            $job->description = count($words) > 10
                ? implode(' ', array_slice($words, 0, 10)) . '...'
                : implode(' ', $words); // If less than 10 words, show the full description

            return $job;
        });

        // Return the latest 12 jobs with the transformed descriptions as JSON
        return response()->json(['status' => 'success', 'data' => $jobs], 200);
    }

}
