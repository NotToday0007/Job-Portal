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
                        <form method="POST" id="resetForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="" class="mb-2">Title<span class="req">*</span></label>
                                    <input type="text" placeholder="Job Title" id="title" name="title" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="" class="mb-2">Category<span class="req">*</span></label>
                                    <select name="jobcategory" id="jobcategory" class="form-control form-select" required>
                                        <option value="">Select Category</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Other Fields -->
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="" class="mb-2">Job Types<span class="req">*</span></label>
                                    <select  name="jobtypes"  type="text" class="form-control form-select" id="jobtypes">
                                        <option value="">Select Type</option>

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
                                <button id="saveBtn" type="button" class="btn btn-primary">Save Job</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    axios.defaults.headers.common['X-CSRF-TOKEN'] = "{{ csrf_token() }}";

    document.addEventListener('DOMContentLoaded', function () {
        FillCategoryDropDown();
        document.getElementById('saveBtn').addEventListener('click', onRegistration);
    });

    async function FillCategoryDropDown() {
        try {
            let categoryRes = await axios.get("/list-category");
            categoryRes.data.forEach(item => {
                let option = `<option value="${item.id}">${item.name}</option>`;
                document.getElementById('jobcategory').insertAdjacentHTML('beforeend', option);
            });
            let jobTypeRes = await axios.get("/job-types");
            jobTypeRes.data.forEach(item => {
                let option = `<option value="${item.id}">${item.name}</option>`;
                document.getElementById('jobtypes').insertAdjacentHTML('beforeend', option);
            });
        } catch (error) {
            console.error('Error fetching categories or job types:', error);
            alert('Failed to load job categories or job types. Please try again later.');
        }
    }

    async function onRegistration(event) {
    event.preventDefault();
    // Get all form values
    let title = document.getElementById('title').value;
    let jobcategory = document.getElementById('jobcategory').value;
    let vacancy = document.getElementById('vacancy').value;
    let jobtypes = document.getElementById('jobtypes').value;
    let location = document.getElementById('location').value;
    let company_name = document.getElementById('company_name').value;
    let company_location = document.getElementById('company_location').value;
    let company_website = document.getElementById('company_website').value; // Corrected from company_location to company_website
    let benefits = document.getElementById('benefits').value;
    let qualifications = document.getElementById('qualifications').value;
    let description = document.getElementById('description').value;
    let experience = document.getElementById('experience').value;
    let salary = document.getElementById('salary').value;
    let responsibility = document.getElementById('responsibility').value;
    let position = document.getElementById('position').value;
    let keywords = document.getElementById('keywords').value;

    // Validation check
    if (keywords.length === 0) {
        showError('Keywords are required');
        return; // Added return to exit the function if validation fails
    }

    try {
        let res = await axios.post("{{ url('/save-job') }}", {
            title: title,
            vacancy: vacancy,
            jobtypes: jobtypes,
            jobcategory:jobcategory,
            location: location,
            company_name: company_name,
            company_location: company_location,
            company_website: company_website,
            benefits: benefits,
            qualifications: qualifications,
            description: description,
            experience: experience,
            salary: salary,
            responsibility: responsibility,
            position: position,
            keywords: keywords,
        });

        if (res.status === 201) {

            alert('saved successfully');
            document.getElementById("resetForm").reset();
        } else {
            showError(res.data['message']);
        }
    } catch (error) {
        showError(error.response?.data?.message || 'An unexpected error occurred.');
    }
}

function showSuccess(message) {
    const messageDiv = document.getElementById('message');
    messageDiv.innerHTML = `<div style="color: green;">${message}</div>`;
    messageDiv.style.display = 'block';
}

function showError(message) {
    const messageDiv = document.getElementById('message');
    messageDiv.innerHTML = `<div style="color: red;">${message}</div>`;
    messageDiv.style.display = 'block';
}

</script>
@endsection
