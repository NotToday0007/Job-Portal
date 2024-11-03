
@extends('front.layouts.app')
<!-- Loader HTML -->


@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="">Home</a></li>
                            <li class="breadcrumb-item active">Jobs</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('front.sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="card border-0 shadow mb-4 px-5 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="fs-4 mb-1">Jobs</h3>
                            <button data-bs-toggle="modal" data-bs-target="#create-modal"
                                class="btn bg-gradient-primary">Create</button>
                        </div>

                        <hr class="bg-secondary" />
                        <div class="table-responsive">

                            <table class="table" id="jobTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Title</th>
                                        <th>Job Created</th>

                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="jobTableBody">
                                    <!-- Data will be loaded here via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
{{-- <link href="{{asset('assets/css/jquery.dataTables.min.css')}}" rel="stylesheet" /> --}}

<script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadJobData();
    });

    async function loadJobData() {
    try {
        let response = await axios.get('/user/applied-jobs');
        console.log(response.data);
        let appliedJobsData = response.data;

        let jobTableBody = $('#jobTableBody');
        let jobTable = $('#jobTable');

        jobTable.DataTable().destroy(); // Destroy any existing DataTable instance
        jobTableBody.empty(); // Clear the table body

        appliedJobsData.forEach((job) => {
            let createdAt = new Date(job['created_at']);
            let formattedDate = `${createdAt.getDate()} ${createdAt.toLocaleString('en-GB', { month: 'short' })}, ${createdAt.getFullYear()}`;
            let status = job['status'] === 1 ? "Active" : "Inactive";
            let jobTypeName = job.job_type && job.job_type.name ? job.job_type.name : 'No Job Type';

            let row = `
                <tr>
                    <td>
                        <div class="job-name fw-500">${job['title']}</div>
                        <div class="info1">${job['location']} - ${jobTypeName}</div>
                    </td>
                    <td>${formattedDate}</td>
                    <td>${status}</td>
                    <td>
                        <div class="action-dots">
                            <button href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">

                              <li>
    <a href="#" class="dropdown-item" onclick="viewJob(event, ${job['id']})">
        <i class="fa fa-eye" aria-hidden="true"></i> View
    </a>
</li>



                                <li>
                                    <a href="#" class="dropdown-item" onclick="deleteJob(event, ${job['id']})">
                                        <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>`;
            jobTableBody.append(row);
        });

        jobTable.DataTable({
            order: [[0, 'desc']],
            lengthMenu: [5, 10, 15, 20, 30],
            drawCallback: function() {
                $('.dropdown-toggle').dropdown(); // Reinitialize dropdowns
            }
        });

    } catch (error) {
        console.error('Error fetching applied jobs data:', error);
    }
}

async function deleteJob(event, jobId) {
        event.preventDefault();
        showLoader();
    try {
        let res = await axios.post('/job-applied/delete', {
            id: jobId
        });

        console.log('Delete job response:', res.data);

        // Check if the response indicates successful deletion
        if (res.status === 200 && res.data['status'] === 'success') {
            hideLoader();

            loadJobData(); // Reload the job data to update the table
        } else {
            alert('Failed to delete the job: ' + res.data['message']);
        }
    } catch (error) {
        console.error('Error deleting job:', error);
        alert('An error occurred while trying to delete the job.');
    }
}

async function viewJob(event, jobview) {
    event.preventDefault(); // Prevent the default anchor click behavior
    showLoader(); // Show the loader

    // Use a short delay to allow the loader to appear before navigating
    setTimeout(() => {
        window.location.href = `/view/job-applied/${jobview}`; // Navigate to the job view page
        hideLoader(); // Ensure loader is hidden (in case the navigation is quick)
    }, 300); // Adjust the delay if necessary
}




</script>


