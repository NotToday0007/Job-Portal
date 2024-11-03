@extends('front.layouts.app')

@section('login')
<section class="section-5">
    <div id="message" style="display:none;"></div>

    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Register</h1>
                    <form method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="mb-2">Name*</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="mb-2">Email*</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="mb-2">Password*</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                        </div>
                        <div class="mb-3">
                            <label for="cpassword" class="mb-2">Confirm Password*</label>
                            <input type="password" name="password_confirmation" id="cpassword" class="form-control" placeholder="Confirm Password">
                        </div>
                        <div class="mb-3">
                            <label for="mobile" class="mb-2">Mobile</label>
                            <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Enter Mobile (optional)">
                        </div>
                        <div class="mb-3">
                            <label for="designation" class="mb-2">Designation</label>
                            <input type="text" name="designation" id="designation" class="form-control" placeholder="Enter Designation (optional)">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="mb-2">Profile Image</label>
                            <input type="text" name="image" id="image" class="form-control" placeholder="Profile Image URL (optional)">
                        </div>
                        <button type="button" class="btn btn-primary mt-2" id="register-btn">Register</button>

                    </form>

                </div>
                <div class="mt-4 text-center">
                    <p>Have an account? <a href="{{ route('logIN') }}">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>

axios.defaults.headers.common['X-CSRF-TOKEN'] = "{{ csrf_token() }}";

document.getElementById('register-btn').addEventListener('click', onRegistration);

async function onRegistration(event)
{
    event.preventDefault();  // Prevent the form from submitting the traditional way

    let email = document.getElementById('email').value;
    let name = document.getElementById('name').value;
    let password = document.getElementById('password').value;
    let cpassword = document.getElementById('cpassword').value;
    let mobile = document.getElementById('mobile').value;
    let designation = document.getElementById('designation').value;
    let image = document.getElementById('image').value;

    // Clear previous messages
    document.getElementById('message').innerHTML = '';
    document.getElementById('message').style.display = 'none';

    // Form Validation
    if (email.length === 0) {
        showError('Email is required');
    } else if (name.length === 0) {
        showError('Name is required');
    } else if (password.length === 0) {
        showError('Password is required');
    } else if (password !== cpassword) {
        showError('Passwords do not match');
    } else {
        try {
            let res = await axios.post("{{ url('/UserRegistration') }}", {
                email: email,
                name: name,
                password: password,
                password_confirmation: cpassword,
                mobile: mobile,
                designation: designation,
                image: image
            });

            if (res.status === 201 && res.data['status'] === 'success') {
                showSuccess(res.data['message']);
                sessionStorage.setItem('email', email);
                setTimeout(function () {
                    window.location.href = '/verify';  // Redirect to the login page
                });  // 1-second delay before redirecting
            } else {
                showError(res.data['message']);
            }
        } catch (error) {
            if (error.response && error.response.data) {
                showError(error.response.data.message || 'An unexpected error occurred.');
            } else {
                showError('An unexpected error occurred.');
            }
        }
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
