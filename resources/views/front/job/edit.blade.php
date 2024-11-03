@extends('front.layouts.app')

@section('postjob')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('front.sidebar')
            </div>
            <div class="col-lg-9">
                <div class="card border-0 shadow mb-4">
                    <div class="card-body card-form p-4">
                        <h3 class="fs-4 mb-1">Job Details</h3>
                        <div id="message" class="my-3"></div> <!-- Message Display -->
                        <form method="POST" id="jobForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="" class="mb-2">Title<span class="req">*</span></label>
                                    <input type="text" placeholder="Job Title" id="title" name="title" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="jobcategory" class="mb-2">Category<span class="req">*</span></label>
                                    <select name="category_id" id="category" class="form-control">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $job->category && $job->category->id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="jobtypes" class="mb-2">Job Types<span class="req">*</span></label>
                                    <select name="job_type_id" id="jobType" class="form-control">
                                        @foreach($jobTypes as $jobType)
                                            <option value="{{ $jobType->id }}" {{ $job->jobType && $job->jobType->id == $jobType->id ? 'selected' : '' }}>
                                                {{ $jobType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6  mb-4">
                                    <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                    <input type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Position<span class="req">*</span></label>
                                    <input type="text" placeholder="position" id="position" name="position" class="form-control">
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Location<span class="req">*</span></label>
                                    <input type="text" placeholder="location" id="location" name="Location" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Salary</label>
                                    <input type="text" placeholder="Salary" id="salary" name="salary" class="form-control">
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Experience</label>
                                    <input type="text" placeholder="experience" id="experience" name="experience" class="form-control">
                                </div>


                            </div>

                            <div class="mb-4">
                                <label for="" class="mb-2">Description<span class="req">*</span></label>
                                <textarea class="form-control" name="description" id="description" cols="5" rows="5" placeholder="Description"></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Benefits</label>
                                <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits"></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Responsibility</label>
                                <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Responsibility"></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Qualifications</label>
                                <textarea class="form-control" name="qualifications" id="qualifications" cols="5" rows="5" placeholder="Qualifications"></textarea>
                            </div>


                            <div class="mb-4">
                                <label for="keywords" class="mb-2">Keywords<span class="req">*</span></label>
                                <input type="text" id="keywords" name="keywords" class="form-control" placeholder="Add keywords like Software, Web Developer, Coder">
                            </div>


                            <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Name<span class="req">*</span></label>
                                    <input type="text" placeholder="Company Name" id="company_name" name="company_name" class="form-control">
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Location</label>
                                    <input type="text" placeholder="Location" id="company_location" name="company_location" class="form-control">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="" class="mb-2">Website</label>
                                <input type="text" placeholder="Website" id="company_website" name="website" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer p-4">
                            <button type="submit" class="btn btn-primary">Update Job</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection

<script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    populateJobDetails();

    document.getElementById('jobForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission

        const jobData = @json($job);
        const jobId = jobData.id;

        const updatedJobData = {
            title: document.getElementById('title').value,
            category_id: document.getElementById('category').value,
            job_type_id: document.getElementById('jobType').value,
            vacancy: document.getElementById('vacancy').value,
            position: document.getElementById('position').value,
            location: document.getElementById('location').value,
            salary: document.getElementById('salary').value,
            experience: document.getElementById('experience').value,
            description: document.getElementById('description').value,
            benefits: document.getElementById('benefits').value,
            responsibility: document.getElementById('responsibility').value,
            qualifications: document.getElementById('qualifications').value,
            keywords: document.getElementById('keywords').value,
            company_name: document.getElementById('company_name').value,
            company_location: document.getElementById('company_location').value,
            company_website: document.getElementById('company_website').value,
        };

        // Send updated job data to the server
        axios.post(`/job/update/${jobId}`, updatedJobData)
            .then(response => {
                document.getElementById('message').innerHTML = `<div class="alert alert-success">${response.data.message}</div>`;
            })
            .catch(error => {
                document.getElementById('message').innerHTML = `<div class="alert alert-danger">An error occurred: ${error.response.data.message}</div>`;
            });
    });
});

function populateJobDetails() {
    // Assume jobData is populated from the server-side
    const jobData = @json($job);

    if (jobData) {
        document.getElementById('title').value = jobData.title || '';
        // document.getElementById('category').value = jobData.category ? jobData.category.name : '';
        // document.getElementById('jobType').value =jobData.job_type ? jobData.job_type.name : '';
        document.getElementById('vacancy').value = jobData.vacancy || '';
        document.getElementById('position').value = jobData.position || '';
        document.getElementById('location').value = jobData.location || '';
        document.getElementById('salary').value = jobData.salary || '';
        document.getElementById('experience').value = jobData.experience || '';
        document.getElementById('description').value = jobData.description || '';
        document.getElementById('benefits').value = jobData.benefits || '';
        document.getElementById('responsibility').value = jobData.responsibility || '';
        document.getElementById('qualifications').value = jobData.qualifications || '';
        document.getElementById('keywords').value = jobData.keywords || '';
        document.getElementById('company_name').value = jobData.company_name || '';
        document.getElementById('company_location').value = jobData.company_location || '';
        document.getElementById('company_website').value = jobData.company_website || '';
    }
}
</script>
