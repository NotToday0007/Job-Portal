@extends('front.layouts.app')

@section('login')
<section class="section-5">
    <div id="message" style="display:none;"></div>
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Login</h1>
                    <div id="message" style="display:none;"></div> <!-- Message container -->

                    <!-- Form begins -->
                    <form method="POST" action="{{ url('/UserLin') }}">
                        @csrf <!-- CSRF protection -->

                        <!-- Email Input -->
                        <div class="mb-3">
                            <label for="email" class="mb-2">Email*</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="example@example.com" required>
                        </div>

                        <!-- Password Input -->
                        <div class="mb-3">
                            <label for="password" class="mb-2">Password*</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
                        </div>

                        <!-- Login Button and Forgot Password Link -->
                        <div class="justify-content-between d-flex">
                            <button type="button" class="btn btn-primary mt-2" id="logIN">Login</button>
                            <a href="forgot-password.html" class="mt-3">Forgot Password?</a>
                        </div>
                    </form>
                    <!-- Form ends -->
                </div>

                <div class="mt-4 text-center">
                    <p>Do not have an account? <a href="{{ url('/Registration') }}">Register</a></p>
                </div>
            </div>
        </div>
        <div class="py-lg-5">&nbsp;</div>
    </div>
</section>

<!-- Include Axios CDN -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- CSRF Meta Tag -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
   document.getElementById('logIN').addEventListener('click', async function(event) {
    event.preventDefault();

    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;
    document.getElementById('message').innerHTML = '';
    document.getElementById('message').style.display = 'none';

    if (email.length === 0) {
        showError("Email is required");
    } else if (password.length === 0) {
        showError("Password is required");
    } else {
        try {
            // Configure Axios with CSRF Token
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Make the login request via Axios
            let res = await axios.post("{{ url('/UserLogin') }}", {
                email: email,
                password: password,
                _token: "{{ csrf_token() }}" // Alternatively send CSRF here
            });

            if (res.status === 201 && res.data['status'] === 'success') {
                showSuccess(res.data['message']);
                // Redirect after showing the success message
                setTimeout(function () {
                    window.location.href = '/';
                }); // Redirect after 1 second
            } else {
                showError(res.data['message']);
            }
        } catch (error) {
            console.error('Error details:', error.response); // Log the full error response
            showError('An unexpected error occurred.');
        }
    }
});

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
