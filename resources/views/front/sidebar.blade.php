<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Bundle JS (with Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<div class="card border-0 shadow mb-4 p-3">
    <div class="s-body text-center mt-3">
        <img id="profileImage" src="{{ asset('assets/images/avatar7.png') }}" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
        <h5 class="mt-3 pb-0">Mohit Singh</h5>
        <p class="text-muted mb-1 fs-6">Full Stack Developer</p>
        <div class="d-flex justify-content-center mb-2">
            <button data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" class="btn btn-primary">Change Profile Picture</button>
        </div>
    </div>
</div>

<div class="card account-nav border-0 shadow mb-4 mb-lg-0">
    <div class="card-body p-0">
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between p-3">
                <a href="account.html">Account Settings</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ url('/post-job') }}">Post a Job</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ url('/my-job') }}">My Jobs</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ url('/job-applied') }}">Jobs Applied</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ url('/job-saved') }}">Saved Jobs</a>
            </li>
        </ul>
    </div>
</div>

<!-- Modal for Changing Profile Picture -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title pb-0" id="exampleModalLabel">Change Profile Picture</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">


              <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                  <input type="file" class="form-control" id="image" name="image">
                  <p class="text-danger" id="image-error"></p>
              </div>
              <div class="d-flex justify-content-end">
                <button onclick="Save()" type="submit" class="btn btn-primary mx-3">Update</button>
                <button id="modal-close" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>

      </div>
    </div>
  </div>
</div>
{{-- <link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet" />
<script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script> --}}
<script>

document.addEventListener('DOMContentLoaded', async function() {
    try {
        // Make the GET request to retrieve the profile information
        let response = await axios.get('/get-profile');

        // Assuming the response contains the image URL in `image_url`
        const profileImage = response.data.image_url;

        // Update the profile image on the page
        if (profileImage) {
            document.getElementById('profileImage').src = profileImage;
        } else {
            console.log('No profile image found.');
        }
    } catch (error) {
        console.error('Error fetching profile data:', error);
    }
});



async function Save() {
    let image = document.getElementById('image').files[0];

    if (!image) {
        errorToast("Product Image Required !");
    } else {
        document.getElementById('modal-close').click();

        let formData = new FormData();
        formData.append('image', image);

        const config = {
            headers: {
                'content-type': 'multipart/form-data',
                'Authorization': `Bearer ${localStorage.getItem('token')}` // Pass JWT token
            }
        };

        try {
            let res = await axios.post("/create-product", formData, config);

            // Check if res.status is 201, meaning created successfully
            if (res.status === 201) {
                alert('Update successful');

                // Get the updated image URL from the response
                const updatedImageUrl = res.data.image_url;

                // Update the profile image src dynamically without page reload
                document.getElementById('profileImage').src = updatedImageUrl;

                console.log(res.data.message); // Ensure this is accessed correctly
            } else {
                alert('Update failed');
                console.log(res.data.message);
            }
        } catch (error) {
            console.error(error.response?.data?.message || "An error occurred");
        }
    }
}

</script>
