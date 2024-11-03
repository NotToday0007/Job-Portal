@extends('front.layouts.app')


@section('findjobs')

<section class="section-3 py-5 bg-2 ">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-10 ">
                <h2>Find Jobs</h2>
            </div>
            <form action="{{ url('/find-jobs') }}" method="GET" id="search-form">
            <div class="col-6 col-md-2">
                <div class="align-end">
                    <select name="sort" id="sort" class="form-control">
                        <option value="Latest" {{ request('sort') == 'Latest' ? 'selected' : '' }}>Latest</option>
                        <option value="Oldest" {{ request('sort') == 'Oldest' ? 'selected' : '' }}>Oldest</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row pt-5">
            <div class="col-md-4 col-lg-3 sidebar mb-4">
                <div class="card border-0 shadow p-4">
                    <div class="mb-4">
                        <h2>Keywords</h2>
                        <input type="text" name="keyword" placeholder="Keywords" class="form-control" value="{{ request('keyword') }}">
                    </div>

                    <div class="mb-4">
                        <h2>Location</h2>
                        <input type="text" name="location" placeholder="Location" class="form-control" value="{{ request('location') }}">
                    </div>

                    <div class="mb-4">
                        <h2>Category</h2>
                        <select name="category" id="category" class="form-control">
                            <option value="">Select a Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <h2>Job Type</h2>
                        <div class="form-check mb-2">
                            <input class="form-check-input" name="job_type[]" type="checkbox" value="1" id="fullTime">
                            <label class="form-check-label" for="fullTime">Full Time</label>
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input" name="job_type[]" type="checkbox" value="2" id="partTime">
                            <label class="form-check-label" for="partTime">Part Time</label>
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input" name="job_type[]" type="checkbox" value="3" id="freelance">
                            <label class="form-check-label" for="freelance">Freelance</label>
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input" name="job_type[]" type="checkbox" value="4" id="remote">
                            <label class="form-check-label" for="remote">Remote</label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h2>Experience</h2>
                        <input type="text" placeholder="experience" id="experience" name="experience" class="form-control" value="{{ request('experience') }}">

                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                    <button type="button" class="btn btn-warning" onclick="resetForm()">Reset</button>

                </div>
            </div>

        </form>

        <div class="col-md-8 col-lg-9">
            <div id="job-listings">
                @include('front.partial.joblist', ['jobs' => $jobs])
            </div>
        </div>
        </div>

    </div>
</section>

<script>
    function resetForm() {
        // Reset the form fields
        document.getElementById("search-form").reset();
        fetchJobs();
    }

    document.getElementById('search-form').addEventListener('submit', function(event) {
    event.preventDefault();
    fetchJobs();
});

// Add an event listener for the sort dropdown to re-fetch jobs
document.getElementById('sort').addEventListener('change', function() {
    fetchJobs();
});

// Reset form function that triggers the fetch after resetting
function resetForm() {
    document.getElementById("search-form").reset();
    fetchJobs();
}

function fetchJobs() {
    // Serialize form data for AJAX request
    const formData = new URLSearchParams(new FormData(document.getElementById('search-form'))).toString();

    fetch("{{ url('/find-jobs') }}?" + formData, {
        method: "GET",
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        // Insert the returned HTML into the job listings container
        document.getElementById('job-listings').innerHTML = data.html;
    })
    .catch(error => console.error('Error:', error));
}

</script>
    @endsection
