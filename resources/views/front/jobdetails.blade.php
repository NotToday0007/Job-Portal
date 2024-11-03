@extends('front.layouts.app')

@section('jobdetails')

<div id="message" style="display: none;"></div>

<section class="section-4 bg-2">
    <div class="container pt-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('/find-jobs') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Jobs</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
<div class="container job_details_area">
    <div class="row pb-5">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="job_details_header">
                    <div class="single_jobs white-bg d-flex justify-content-between">
                        <div class="jobs_left d-flex align-items-center">

                            <div class="jobs_conetent">
                                <a href="#">
                                    <h4>{{ $job->title }}</h4>
                                </a>
                                <div class="links_locat d-flex align-items-center">
                                    <div class="location">
                                        <p> <i class="fa fa-map-marker"></i>{{  $job->location}}</p>
                                    </div>
                                    <div class="location">
                                        <p> <i class="fa fa-clock-o"></i> {{ $job->jobType->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="jobs_right">
                            <div class="apply_now">
                                <a class="heart_mark"  onclick="saveJob({{ $job->id }})" style="cursor: pointer;"> <i class="fa fa-heart-o" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="descript_wrap white-bg">
                    <div class="single_wrap">
                        <h4>Job description</h4>
                   <p>{{ $job->description }}</p>
                    </div>
                    <div class="single_wrap">
                        <h4>Responsibility</h4>
                        <ul>
                            <li>{{ $job->responsibility }}</li>

                        </ul>
                    </div>
                    <div class="single_wrap">
                        <h4>Qualifications</h4>
                        <ul>
                            <li>{{ $job->qualifications }}</li>

                        </ul>
                    </div>
                    <div class="single_wrap">
                        <h4>Benefits</h4>
                        <p>{{ $job->benefits }}</p>
                    </div>
                    <div class="border-bottom"></div>
                    <div class="pt-3 text-end">
                        <button class="btn btn-secondary" onclick="saveJob({{ $job->id }})">Save</button>
                        <button class="btn btn-secondary" onclick="applyJob({{ $job->id }})">Apply</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow border-0">
                <div class="job_sumary">
                    <div class="summery_header pb-1 pt-4">
                        <h3>Job Summery</h3>
                    </div>
                    <div class="job_content pt-3">
                        <ul>
                            <li>Published on: <span>{{ \Carbon\Carbon::parse($job->created_at)->format('d M, Y') }}</span></li>

                            <li>Vacancy: {{ $job->vacancy }} <span> Position</span></li>
                            <li>Salary: <span>{{ $job->salary }}</span></li>
                            <li>Location: <span>{{ $job->location }}</span></li>
                            <li>Job Position: <span>{{ $job->position}}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card shadow border-0 my-4">
                <div class="job_sumary">
                    <div class="summery_header pb-1 pt-4">
                        <h3>Company Details</h3>
                    </div>
                    <div class="job_content pt-3">
                        <ul>
                            <li>Name: <span>{{ $job->company_name }}</span></li>
                            <li>Locaion: <span>{{ $job->company_location }}</span></li>
                            <li>Webite: <span>{{ $job->company_website }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>


<script>

    function saveJob(jobId) {

        const url = `/job-save/${jobId}`; // Set the URL to your route

        makeRequest(url, 'GET') // Assuming you want to pass the user ID from the session
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage(data.message, 'success'); // Call showMessage for success

            } else {
                showMessage(data.message, 'error'); // Call showMessage for error
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('An error occurred while saving the job.', 'error'); // Show error message
        });
    }
    function applyJob(jobId) {

        const url = `/job-apply/${jobId}`; // Set the URL to your route

        makeRequest(url, 'GET') // Assuming you want to pass the user ID from the session
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage(data.message, 'success'); // Call showMessage for success

            } else {
                showMessage(data.message, 'error'); // Call showMessage for error
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('An error occurred while saving the job.', 'error'); // Show error message
        });
    }
</script>




@endsection
