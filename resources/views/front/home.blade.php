@extends('front.layouts.app')


@section('main')


<section class="section-0 lazy d-flex bg-image-style dark align-items-center" data-bg="{{ asset('assets/images/banner5.jpg') }}">

    <div class="container">
        <div class="row">
            <div class="col-12 col-xl-8">
                <h1>Find your dream job</h1>
                <a href="{{ url('/logout') }}" class="btn btn-primary mb-4 mb-sm-0">logout</a>
                <div class="banner-btn mt-5"><a href="{{ url('/userprofile') }}" class="btn btn-primary mb-4 mb-sm-0">Explore Now</a></div>
            </div>
        </div>
    </div>
</section>

<section class="section-1 py-5 ">
    <div class="container">
        <div class="card border-0 shadow p-5">
            <div class="row">
                <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                    <input type="text" class="form-control" name="search" id="search" placeholder="Keywords">
                </div>
                <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                    <input type="text" class="form-control" name="search" id="search" placeholder="Location">
                </div>
                <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                    <select name="category" id="category" class="form-control">
                        <option value="">Select a Category</option>
                        <option value="">Engineering</option>
                        <option value="">Accountant</option>
                        <option value="">Information Technology</option>
                        <option value="">Fashion designing</option>
                    </select>
                </div>

                <div class=" col-md-3 mb-xs-3 mb-sm-3 mb-lg-0">
                    <div class="d-grid gap-2">
                        <a href="jobs.html" class="btn btn-primary btn-block">Search</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-2 bg-2 py-5">
    <div class="container">
        <h2>Popular Categories</h2>
        <div class="row pt-5">
            <!-- Category 1 -->
            @foreach($categories as $category)

            <div class="col-lg-4 col-xl-3 col-md-6">
                <div class="single_catagory">
                    <a href="#"><h4 class="pb-2">{{ $category->name }}</h4></a>
                    <p class="mb-0"> <span>50</span> Available position</p>
                </div>
            </div>
            @endforeach


        </div>
    </div>
</section>


<section class="section-3 py-5">
    <div class="container">
        <h2>Featured Jobs</h2>
        <div class="row pt-5">
            <div class="job_listing_area">
                <div class="job_lists">
                    <div class="row" id="jobList">
                        <!-- Jobs will be dynamically added here by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-3 bg-2 py-5">
    <div class="container">
        <h2>Latest Jobs</h2>
        <div class="row pt-5">
            <div class="job_listing_area">
                <div class="job_lists">
                    <div class="row">
                        @foreach($job as $jobs)
                        <div class="col-md-4">
                            <div class="card border-0 p-3 shadow mb-4">
                                <div class="card-body">
                                    <h3 class="border-0 fs-5 pb-2 mb-0">{{ $jobs->title }}</h3>
                                    <p>{{ $jobs->description }}</p>
                                    <div class="bg-light p-3 border">
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                            <span class="ps-1">{{ $jobs->location }}</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                            <span class="ps-1">{{ $jobs->category->name }}</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                            <span class="ps-1">{{ $jobs->salary }}</span>
                                        </p>
                                    </div>

                                    <div class="d-grid mt-3">
                                        <a href="{{url('/find-jobs')}}" class="btn btn-primary btn-lg">Details</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var categoriesData = @json($job);
    console.log(categoriesData); // This will log the data to the browser's console

    // Call the function to fetch featured jobs
    getFeatureJob();

    async function getFeatureJob() {
    try {
        let res = await axios.get("/get-featureJob");

        if (res.status === 200 && res.data['status'] === 'success') {
            let data = res.data['data'];
            console.log(data);

            // Check if data is an array and has job objects
            if (Array.isArray(data) && data.length > 0) {
                // Clear any existing content before adding new jobs
                document.getElementById('jobList').innerHTML = '';

                // Loop through each job in the data array
                data.forEach((job) => {
                    // Create a new div or any HTML element to display the job data
                    const jobElement = document.createElement('div');
                    jobElement.classList.add('col-md-4');

                    // Add job details to the jobElement with the limited description
                    jobElement.innerHTML = `
                        <div class="card border-0 p-3 shadow mb-4">
                            <div class="card-body">
                                <h3 class="border-0 fs-5 pb-2 mb-0">${job.title || 'No title available'}</h3>
                                <p>Description: ${job.description || 'No description available'}</p>
                                <div class="bg-light p-3 border">
                                    <p class="mb-0">
                                        <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                        <span class="ps-1">${job.location || 'Location not specified'}</span>
                                    </p>
                                    <p class="mb-0">
                                        <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                    <span class="ps-1">${job.job_type ? job.job_type.name : 'Job type not specified'}</span>
                                    </p>
                                    <p class="mb-0">
                                        <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                        <span class="ps-1">${job.salary || 'Salary not specified'}</span>
                                    </p>
                                </div>

                                <div class="d-grid mt-3">
                        <a href="/job-details/${job.id}" class="btn btn-primary btn-lg">Details</a>
                                </div>
                            </div>
                        </div>
                    `;

                    // Append the jobElement to the container
                    document.getElementById('jobList').appendChild(jobElement);
                });
            } else {
                console.log('No job data available');
            }
        } else {
            console.log('Error:', res.data['message']);
        }
    } catch (error) {
        console.error('Error fetching jobs:', error);
    }
}

</script>


@endsection


