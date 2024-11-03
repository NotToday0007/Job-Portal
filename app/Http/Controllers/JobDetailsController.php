<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\JobType;
use App\Models\Job;
use App\Models\JobApply;
use App\Models\JobSaved;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class JobDetailsController extends Controller
{


  public function jobDetails($id)
  {




      // Fetch the job details using the job ID and include the jobType relationship
      $job = Job::with('jobType','category')->where('id', $id)->first();

      // Check if the job exists and belongs to the current user
      if (!$job) {
          return redirect()->back()->with('error', 'Job not found or you do not have permission to view it.');
      }

      // Pass the job details and job types to the viewcategory
      return view('front.jobdetails', compact('job'));
  }


  public function jobSaved(Request $request, $id)
  {
      // Fetch the user ID from the request header
      $user_id = $request->header('id');

      // Fetch the job details using the job ID
      $job = Job::find($id);

      // Check if the job exists
      if (!$job) {
          return redirect()->back()->with('error', 'Job not found.');
      }

      // Check if the job is already saved by the user
      $existingSavedJob = JobSaved::where('job_id', $id)->where('user_id', $user_id)->first();
      if ($existingSavedJob) {
        return response()->json(['success' => false, 'message' => 'You have already saved this job.']);
      }

      // Create a new record in the saved_jobs table
      JobSaved::create([
          'job_id' => $job->id, // Use the job ID
          'user_id' => $user_id, // Use the user ID from the request header
          'saved_time' => now(), // Optionally set the saved time to the current timestamp
      ]);

      return response()->json(['success' => true, 'message' => 'Job saved successfully!']);
  }


  public function jobApplied(Request $request, $id)
  {
      // Fetch the user ID from the request header
      $user_id = $request->header('id');

      // Fetch the job details using the job ID
      $job = Job::find($id);

      // Check if the job exists
      if (!$job) {
          return redirect()->back()->with('error', 'Job not found.');
      }

      // Check if the job is already saved by the user
      $existingAppliedJob = JobApply::where('job_id', $id)->where('user_id', $user_id)->first();
      if ($existingAppliedJob) {
        return response()->json(['success' => false, 'message' => 'You have already applied this job.']);
      }

      // Create a new record in the saved_jobs table
      JobApply::Create([
          'job_id' => $job->id, // Use the job ID
          'user_id' => $user_id, // Use the user ID from the request header

      ]);

      return response()->json(['success' => true, 'message' => 'Job Applied successfully!']);
  }

  function jobsAppliedRedirect(){
  return view("front.jobapplied");
  }



  public function getUserAppliedJobs(Request $request)
{
    // Step 1: Get the user ID from the request header
    $userId = $request->header('id');

    // Step 2: Fetch all job applications for the specific user
    $appliedJobs = JobApply::where('user_id', $userId)->get();

    // Step 3: Collect job IDs from the applications
    $jobIds = $appliedJobs->pluck('job_id');

    // Step 4: Fetch job details for the collected job IDs
    $jobs = Job::whereIn('id', $jobIds)->with('jobType')->get();




    // Step 6: Return the data as JSON
    return response()->json($jobs);
}

function jobsSaved(){
    return view('front.jobsaved');
}
public function getUserSavedJobs(Request $request)
{
    // Step 1: Get the user ID from the request header
    $userId = $request->header('id');

    // Step 2: Fetch all job applications for the specific user
    $appliedJobs = JobSaved::where('user_id', $userId)->get();

    // Step 3: Collect job IDs from the applications
    $jobIds = $appliedJobs->pluck('job_id');

    // Step 4: Fetch job details for the collected job IDs
    $jobs = Job::whereIn('id', $jobIds)->with('jobType')->get();




    // Step 6: Return the data as JSON
    return response()->json($jobs);
}


public function jobAppliedView( $id)
{


    // Fetch the job details using the job ID and include the jobType relationship
    $job = Job::with('jobType','category')->where('id', $id)->first();

    // Check if the job exists and belongs to the current user
    if (!$job) {
        return redirect()->back()->with('error', 'Job not found or you do not have permission to view it.');
    }



    // Pass the job details and job types to the viewcategory
    return view('front.job.view', compact('job'));
}

 function jobAppliedDelete(Request $request)
{
    // Retrieve the job ID and user ID from the request
    $job_id=$request->input('id');

    // Update the job details using the query approach
    $updateStatus = JobApply::where('job_id', $job_id)
                        ->delete();

                        if ($updateStatus) {
                            // Job was successfully deleted
                            return response()->json(['status' => 'success', 'message' => 'Job deleted successfully'], 200);
                        } else {
                            // Job not found or not deleted
                            return response()->json(['status' => 'error', 'message' => 'Job not found or already deleted'], 404);
                        }

}

function jobSavedDelete(Request $request)
{
    // Retrieve the job ID and user ID from the request
    $job_id=$request->input('id');

    // Update the job details using the query approach
    $updateStatus = JobSaved::where('job_id', $job_id)
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
