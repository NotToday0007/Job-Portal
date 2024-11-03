<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\JobType;
use App\Models\Job;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
class JobController extends Controller
{
    function postJob(){
        return view ('front.postjob');
    }

    function myJob(){


        return view ('front.myjobs');
    }
    public function getJobsWithApplicantCount()
{
    $jobs = Job::with('jobType') // Load the related job type
                ->withCount('appliedJobs') // Count the related applied jobs
                ->get();

    return response()->json($jobs);
}

    public function CategoryList()
    {
        try {
            $categories = Category::orderBy('name')->get();
            return response()->json($categories);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching categories'], 500);
        }
    }

    public function JobTypes()
    {
        try {
            $jobTypes = JobType::orderBy('name')->get();
            return response()->json($jobTypes);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching job types'], 500);
        }
    }


    public function saveJob(Request $request)
    {
        $user_id = $request->header('id');
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'vacancy' => 'required|integer|min:1',
           // Assuming jobtypes is an ID
            'location' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'company_location' => 'nullable|string|max:255',
            'company_website' => 'nullable|url|max:255',
            'benefits' => 'nullable|string',
            'qualifications' => 'nullable|string',
            'description' => 'required|string',
            'experience' => 'nullable|string',
            'salary' => 'nullable|string',
            'responsibility' => 'nullable|string',
            'position' => 'nullable|string',
            'keywords' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        // Save To Database
        $job = Job::create([
            'user_id' => $user_id,
            'title' => $request->input('title'),
            'vacancy' => $request->input('vacancy'),
            'job_type_id' => $request->input('jobtypes'),
            'category_id' => $request->input('jobcategory'),
            'location' => $request->input('location'),
            'company_name' => $request->input('company_name'),
            'company_location' => $request->input('company_location'),
            'company_website' => $request->input('company_website'),
            'benefits' => $request->input('benefits'),
            'qualifications' => $request->input('qualifications'),
            'description' => $request->input('description'),
            'experience' => $request->input('experience'),
            'salary' => $request->input('salary'),
            'responsibility' => $request->input('responsibility'),
            'position' => $request->input('position'),
            'keywords' => $request->input('keywords'),
        ]);

        // Return a JSON response after successful creation
        return response()->json([
            'message' => 'Saved successfully',
            'status' => 'success',
            'data' => $job
        ], 201);

    }



    public function getJobs(Request $request)
    {
        // Retrieve the user ID from the request header
        $user_id = $request->header('id');
        logger('User ID from header: ', ['user_id' => $user_id]);

        // Fetch jobs that belong to the user with the specified user ID, including the job type
        $jobs = Job::with('jobType')->where('user_id', $user_id)->get();

        return response()->json($jobs);
    }

    // public function myJobView(Request $request)
    // {
    //     // Retrieve the user ID from the request header
    //     $user_id = $request->header('id');
    //     $job_id=$request->input('id');
    //     $user= Job::where('id',$job_id)->where('user_id',$user_id)->get();

    //     if ($user) {
    //         return response()->json([
    //             'message' => 'Saved successfully',
    //             'status' => 'success',


    //         ], 201);
    // } else {
    //     // Return an error message if the job is not found or the user is unauthorized
    //     return response()->json(['success' => false, 'message' => 'Job not found or you do not have permission to view this job.'], 403);
    // }


    // }
    // function JobView(){
    //     return view ('front.my_job.myjob_view');
    // }
    public function JobView($id)
    {
        // Fetch job details using the job ID
        $job = Job::find($id);

        // Pass the job data to the view
        return view('front.my_job.myjob_view', compact('job'));
    }

    public function show(Request $request, $id)
    {
        $user_id = $request->header('id');

        // Fetch the job details using the job ID and include the jobType relationship
        $job = Job::with('jobType','category')->where('id', $id)->where('user_id', $user_id)->first();

        // Check if the job exists and belongs to the current user
        if (!$job) {
            return redirect()->back()->with('error', 'Job not found or you do not have permission to view it.');
        }

        // Fetch all job types to populate the dropdown
        $jobTypes = JobType::all();
        $category=Category::all();

        // Pass the job details and job types to the viewcategory
        return view('front.job.view', compact('job', 'jobTypes','category'));
    }

    public function myJobView(Request $request)
    {
        // Retrieve the user ID from the request header
        $user_id = $request->header('id');
        $job_id = $request->input('id');

        // Fetch the job details using the job ID and ensure it belongs to the user
        $job = Job::with('jobType', 'category')->where('id', $job_id)->where('user_id', $user_id)->first();

        // Check if the job exists and belongs to the current user
        if ($job) {
            // Fetch all job types and categories
            $jobTypes = JobType::all();
            $categories = Category::all();

            // Pass the job, job types, and categories to the view
            return view('front.job.edit', compact('job', 'jobTypes', 'categories'));
        } else {
            // Return an error message if the job is not found or the user is unauthorized
            return response()->json(['success' => false, 'message' => 'Job not found or you do not have permission to view this job.'], 403);
        }
    }



    public function edit(Request $request, $id)
    {
        $user_id = $request->header('id');

        // Fetch the job details using the job ID and include the jobType relationship
        $job = Job::with('jobType','category')->where('id', $id)->where('user_id', $user_id)->first();

        // Check if the job exists and belongs to the current user
        if (!$job) {
            return redirect()->back()->with('error', 'Job not found or you do not have permission to view it.');
        }

        // Fetch all job types to populate the dropdown
        $jobTypes = JobType::all();
        $categories=Category::all();

        // Pass the job details and job types to the viewcategory
        return view('front.job.edit', compact('job', 'jobTypes','categories'));
    }


public function update(Request $request, $id)
{
    // Retrieve the job ID and user ID from the request
    $job_id = $id;
    $user_id = $request->header('id');

    // Update the job details using the query approach
    $updateStatus = Job::where('id', $job_id)
                        ->where('user_id', $user_id)
                        ->update([
                            'title' => $request->input('title'),
                            'category_id' => $request->input('category_id'),
                            'job_type_id' => $request->input('job_type_id'),
                            'vacancy' => $request->input('vacancy'),
                            'position' => $request->input('position'),
                            'location' => $request->input('location'),
                            'salary' => $request->input('salary'),
                            'experience' => $request->input('experience'),
                            'description' => $request->input('description'),
                            'benefits' => $request->input('benefits'),
                            'responsibility' => $request->input('responsibility'),
                            'qualifications' => $request->input('qualifications'),
                            'keywords' => $request->input('keywords'),
                            'company_name' => $request->input('company_name'),
                            'company_location' => $request->input('company_location'),
                            'company_website' => $request->input('company_website'),
                        ]);

    // Check if the update was successful
    if ($updateStatus) {
        return response()->json(['message' => 'Job details updated successfully.'], 200);
    } else {
        return response()->json(['message' => 'Job not found or update failed.'], 404);
    }
}

public function delete(Request $request)
{
    // Retrieve the job ID and user ID from the request
    $job_id=$request->input('id');

    $user_id = $request->header('id');

    // Update the job details using the query approach
    $updateStatus = Job::where('id', $job_id)
                        ->where('user_id', $user_id)
                        ->delete();

                        if ($updateStatus) {
                            // Job was successfully deleted
                            return response()->json(['status' => 'success', 'message' => 'Job deleted successfully'], 200);
                        } else {
                            // Job not found or not deleted
                            return response()->json(['status' => 'error', 'message' => 'Job not found or already deleted'], 404);
                        }

}




}

