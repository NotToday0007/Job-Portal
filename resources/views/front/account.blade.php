

@extends('front.layouts.app')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Bundle JS (with Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

@section('account')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
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
        <div class="card-body  p-4">
            <h3 class="fs-4 mb-1">My Profile</h3>
            <div class="mb-4">
                <label for="" class="mb-2">Name*</label>
                <input id="name" type="text" placeholder="Enter Name" class="form-control" value="">
            </div>
            <div class="mb-4">
                <label class="mb-2">Email Address</label>
                <input readonly id="email" placeholder="User Email" class="form-control" type="email"/>
            </div>
            <div class="mb-4">
                <label for="" class="mb-2">Designation*</label>
                <input id="designation" type="text" placeholder="Designation" class="form-control">
            </div>
            <div class="mb-4">
                <label for="" class="mb-2">Mobile*</label>
                <input id="mobile" type="mobile" placeholder="Mobile" class="form-control">
            </div>
        </div>
        <div class="card-footer  p-4">
            <button onclick="onUpdate()" type="button" class="btn btn-primary">Update</button>
        </div>
    </div>
    <div class="card border-0 shadow mb-4">
        <div class="card-body p-4">
            <h3 class="fs-4 mb-1">Change Password</h3>
            <div class="mb-4">
                <label for="" class="mb-2">Old Password*</label>
                <input type="password" id="oldpass"  placeholder="Old Password" class="form-control">
            </div>
            <div class="mb-4">
                <label for="" class="mb-2">New Password*</label>
                <input type="password" id="newpass" placeholder="New Password" class="form-control">
            </div>
            <div class="mb-4">
                <label for="" class="mb-2">Confirm Password*</label>
                <input type="password" id="confirmpass" placeholder="Confirm Password" class="form-control">
            </div>
        </div>
        <div class="card-footer  p-4">
            <button type="button" onclick="passUpdate()" class="btn btn-primary">Update</button>
        </div>

</div>

</div>
</div>
</div>
</section>
@endsection

<script>
 getProfile();
async function getProfile() {
    // showLoader();  // Remove or comment out if not defined
    let res = await axios.get("/user-profile");
    // hideLoader();  // Remove or comment out if not defined
    if (res.status === 200 && res.data['status'] === 'success') {
        let data = res.data['data'];
        document.getElementById('email').value = data['email'];
        document.getElementById('name').value = data['name'];
        document.getElementById('designation').value = data['designation'];
        document.getElementById('mobile').value = data['mobile'];
    } else {
        console.error(res.data['message']);  // You can log the error for now
    }
}



async function onUpdate() {
    let name = document.getElementById('name').value;
    let designation = document.getElementById('designation').value;
    let mobile = document.getElementById('mobile').value;

    if (name.length === 0) {
        console.log('Name is required');  // Replaces errorToast
    } else if (designation.length === 0) {
        console.log('Designation is required');  // Replaces errorToast
    } else if (mobile.length === 0) {
        console.log('Mobile is required');  // Replaces errorToast
    } else {
        console.log('Starting profile update...');  // Simulating loader display

        try {
            let res = await axios.post("/update-profile", {
                name: name,
                designation: designation,
                mobile: mobile
            });

            console.log('Profile update completed');  // Simulating loader hide

            if (res.status === 200 && res.data['status'] === 'success') {
                console.log(res.data['message']);  // Replaces successToast
                alert('update successful')
                await getProfile();  // Reload profile data after update
            } else {
                console.log(res.data['message']);  // Replaces errorToast
            }
        } catch (error) {
            console.log('Error updating profile');  // Replaces errorToast
            console.error(error);
        }
    }
}

async function passUpdate() {
    let oldpass = document.getElementById('oldpass').value;
    let newpass = document.getElementById('newpass').value;
    let confirmpass = document.getElementById('confirmpass').value;

    // Check if passwords match
    if (newpass !== confirmpass) {
        console.log('New password and confirm password do not match');
        return;
    }

    if (oldpass.length === 0 || newpass.length === 0 || confirmpass.length === 0) {
        console.log('All fields are required');
        return;
    }

    try {
        let res = await axios.post("/update-password", {
            oldpass: oldpass,
            newpass: newpass
        });

        if (res.status === 200 && res.data['status'] === 'success') {
            alert('Password updated successfully');
              // Clear the input fields after successful update
            document.getElementById('oldpass').value = '';
            document.getElementById('newpass').value = '';
            document.getElementById('confirmpass').value = '';
        } else {
            console.log(res.data['message']);
        }

    } catch (error) {
        console.log('Error updating password');
        console.error(error);
    }
}


</script>





{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<div class="col-lg-9">
    <div class="card border-0 shadow mb-4">
        <div class="card-body  p-4">
            <h3 class="fs-4 mb-1">My Profile</h3>
            <div class="mb-4">
                <label for="" class="mb-2">Name*</label>
                <input id="name" type="text" placeholder="Enter Name" class="form-control" value="">
            </div>
            <div class="mb-4">
                <label class="mb-2">Email Address</label>
                <input readonly id="email" placeholder="User Email" class="form-control" type="email"/>
            </div>
            <div class="mb-4">
                <label for="" class="mb-2">Designation*</label>
                <input id="designation" type="text" placeholder="Designation" class="form-control">
            </div>
            <div class="mb-4">
                <label for="" class="mb-2">Mobile*</label>
                <input id="mobile" type="mobile" placeholder="Mobile" class="form-control">
            </div>
        </div>
        <div class="card-footer  p-4">
            <button onclick="onUpdate()" type="button" class="btn btn-primary">Update</button>
        </div>
    </div>
    <div class="card border-0 shadow mb-4">
        <div class="card-body p-4">
            <h3 class="fs-4 mb-1">Change Password</h3>
            <div class="mb-4">
                <label for="" class="mb-2">Old Password*</label>
                <input type="password" id="oldpass"  placeholder="Old Password" class="form-control">
            </div>
            <div class="mb-4">
                <label for="" class="mb-2">New Password*</label>
                <input type="password" id="newpass" placeholder="New Password" class="form-control">
            </div>
            <div class="mb-4">
                <label for="" class="mb-2">Confirm Password*</label>
                <input type="password" id="confirmpass" placeholder="Confirm Password" class="form-control">
            </div>
        </div>
        <div class="card-footer  p-4">
            <button type="button" onclick="passUpdate()" class="btn btn-primary">Update</button>
        </div>
    </div>
</div>
</div>
</div>



    <script>


    getProfile();
   async function getProfile() {
       // showLoader();  // Remove or comment out if not defined
       let res = await axios.get("/user-profile");
       // hideLoader();  // Remove or comment out if not defined
       if (res.status === 200 && res.data['status'] === 'success') {
           let data = res.data['data'];
           document.getElementById('email').value = data['email'];
           document.getElementById('name').value = data['name'];
           document.getElementById('designation').value = data['designation'];
           document.getElementById('mobile').value = data['mobile'];
       } else {
           console.error(res.data['message']);  // You can log the error for now
       }
   }



   async function onUpdate() {
       let name = document.getElementById('name').value;
       let designation = document.getElementById('designation').value;
       let mobile = document.getElementById('mobile').value;

       if (name.length === 0) {
           console.log('Name is required');  // Replaces errorToast
       } else if (designation.length === 0) {
           console.log('Designation is required');  // Replaces errorToast
       } else if (mobile.length === 0) {
           console.log('Mobile is required');  // Replaces errorToast
       } else {
           console.log('Starting profile update...');  // Simulating loader display

           try {
               let res = await axios.post("/update-profile", {
                   name: name,
                   designation: designation,
                   mobile: mobile
               });

               console.log('Profile update completed');  // Simulating loader hide

               if (res.status === 200 && res.data['status'] === 'success') {
                   console.log(res.data['message']);  // Replaces successToast
                   alert('update successful')
                   await getProfile();  // Reload profile data after update
               } else {
                   console.log(res.data['message']);  // Replaces errorToast
               }
           } catch (error) {
               console.log('Error updating profile');  // Replaces errorToast
               console.error(error);
           }
       }
   }

   async function passUpdate() {
       let oldpass = document.getElementById('oldpass').value;
       let newpass = document.getElementById('newpass').value;
       let confirmpass = document.getElementById('confirmpass').value;

       // Check if passwords match
       if (newpass !== confirmpass) {
           console.log('New password and confirm password do not match');
           return;
       }

       if (oldpass.length === 0 || newpass.length === 0 || confirmpass.length === 0) {
           console.log('All fields are required');
           return;
       }

       try {
           let res = await axios.post("/update-password", {
               oldpass: oldpass,
               newpass: newpass
           });

           if (res.status === 200 && res.data['status'] === 'success') {
               alert('Password updated successfully');
                 // Clear the input fields after successful update
               document.getElementById('oldpass').value = '';
               document.getElementById('newpass').value = '';
               document.getElementById('confirmpass').value = '';
           } else {
               console.log(res.data['message']);
           }

       } catch (error) {
           console.log('Error updating password');
           console.error(error);
       }
   }

   </script>
 --}}


