<div class="job_lists">
    <div class="row">
        @foreach($jobs as $job)
        <div class="col-md-4">
            <div class="card border-0 p-3 shadow mb-4">
                <div class="card-body">
                    <h3 class="border-0 fs-5 pb-2 mb-0">{{ $job->title }}</h3>
                    <p>{{ $job->description }}</p>
                    <div class="bg-light p-3 border">
                        <p class="mb-0">
                            <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                            <span class="ps-1">{{ $job->location }}</span>
                        </p>
                        <p class="mb-0">
                            <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                            <span class="ps-1">{{ $job->category->name }}</span>
                        </p>
                        <p class="mb-0">
                            <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                            <span class="ps-1">{{ $job->salary }}</span>
                        </p>
                    </div>
                    <div class="d-grid mt-3">
                        <a href="{{ url('/job-details/' . $job['id']) }}" class="btn btn-primary btn-lg">Details</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
