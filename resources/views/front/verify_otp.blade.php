<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OTP Verification Form</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/script.js') }}" defer></script>
</head>

<body>
    <div class="container">
        <header>
            <i class="bx bxs-check-shield"></i>
          </header>
        <h4>Enter OTP Code</h4>
        <div class="input-field">
            <input type="number" id="digit1" maxlength="1" oninput="moveToNext(this, 'digit2')" />
            <input type="number" id="digit2" maxlength="1" oninput="moveToNext(this, 'digit3')" />
            <input type="number" id="digit3" maxlength="1" oninput="moveToNext(this, 'digit4')" />
            <input type="number" id="digit4" maxlength="1" />
        </div>
        <button type="button" id="sendOTP">Verify OTP</button>
    </div>

    <script>
        $(document).ready(function() {
            $('#sendOTP').click(function() {
                console.log('Button clicked'); // Debugging statement
                var digit1 = $('#digit1').val();
                var digit2 = $('#digit2').val();
                var digit3 = $('#digit3').val();
                var digit4 = $('#digit4').val();

                var otp = digit1 + digit2 + digit3 + digit4;

                console.log('OTP:', otp); // Debugging statement

                if (otp.length === 4) {
                    $.ajax({
                        url: '/verify-otp',
                        type: 'POST',
                        data: {
                            otp: otp,
                            email: sessionStorage.getItem('email'),
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log('Response:', response); // Debugging statement
                            if (response.status === 'success') {
                                alert('OTP verified successfully!');
                                window.location.href = '/login'; // Redirect to the desired page
                            } else {
                                alert('OTP verification failed: ' + response.message);
                            }
                        },
                        error: function(error) {
                            console.error('Error:', error); // Debugging statement
                            alert('Error: ' + error.responseText);
                        }
                    });
                } else {
                    alert('Please fill in all four digits of the OTP.');
                }
            });
        });

        function moveToNext(current, nextFieldId) {
            if (current.value.length === 1) {
                document.getElementById(nextFieldId).focus();
            }
        }
    </script>
</body>

</html>
