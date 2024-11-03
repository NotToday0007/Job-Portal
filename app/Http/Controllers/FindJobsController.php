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

class FindJobsController extends Controller
{

    public function findJobs(Request $request)
    {
        $query = Job::with('jobType', 'category');

        // Apply filters
        if ($request->filled('keyword')) {
            $query->where('title', 'LIKE', '%' . $request->keyword . '%')
                  ->orWhere('description', 'LIKE', '%' . $request->keyword . '%');
        }
        if ($request->filled('location')) {
            $query->where('location', 'LIKE', '%' . $request->location . '%');
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->has('job_type') && is_array($request->job_type)) {
            $query->whereHas('jobType', function ($q) use ($request) {
                $q->whereIn('id', $request->job_type);
            });
        }
        if ($request->filled('experience')) {
            $query->where('experience', $request->experience);
        }

        // Apply sorting: default is 'Latest' (desc)
        // Sorting logic: default to 'Latest' if no sorting is specified
    $sortOrder = $request->filled('sort') && $request->sort === 'Oldest' ? 'asc' : 'desc';
    $query->orderBy('created_at', $sortOrder);

    $jobs = $query->take(12)->get();
    $jobTypes = JobType::all();
    $categories = Category::all();

    if ($request->ajax()) {
        $view = view('front.partials.joblist', compact('jobs'))->render();
        return response()->json(['html' => $view]);
    }

        return view('front.findjobs', compact('jobs', 'jobTypes', 'categories'));
    }

}
