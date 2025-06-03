@extends('master')

@section('title', 'Sign Up')

@section('head-extra')
    <!-- meta tag stores the CSRF token that Laravel generates -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<style>
  input::placeholder {
    font-size: 16px;
    font-family: "Times New Roman", Times, serif;
  }
</style>
<div class="page">
    <form class="form-up"  id="signUpForm" method="post" enctype="multipart/form-data">
        @csrf
        <h1 style="text-align: center;margin-top: 0;">Welcome to Neovate University, </h1>
        <h1 style="text-align: center;margin-top: 0;"> Sign Up Now:</h1>

        <div>
            <label for="FullName" >Full Name:</label>
            <input type="text" id="FullName" name="FullName" class="input" required onkeyup="Valid()" placeholder="Enter your Full Name">
            <div id="FullNameAlert" class="alert alert-danger w-100 mt-2 d-none">
                Minimum 3 characters, only letters and spaces allowed.
            </div>
        </div>

        <div>
            <label for="signUpName">Username:</label>
            <input type="text" id="signUpName" name="signUpName" class="input" required onkeyup="Valid()" placeholder="Enter your Username">
            <div id="nameAlert" class="alert alert-danger w-100 mt-2 d-none">
                Minimum 3 characters, special characters not allowed
            </div>

            <div>
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" class="input" required onkeyup="Valid()" placeholder="Enter your Phone number">
                <div id="phoneAlert" class="alert alert-danger w-100 mt-2 d-none">
                    Enter a valid phone number (10-15 digits).
                </div>
            </div>

            <div>
                <label for="countryCode"></label>
                <label for="whatsapp">WhatsApp Number:</label>
                <div>
                    <select id="countryCode" name="whatsappCountryCode" class="input" required>
                        <option value="+20" selected>🇪🇬 +20 (Egypt)</option>
                        <option value="+1">🇺🇸 +1 (USA)</option>
                        <option value="+44">🇬🇧 +44 (UK)</option>
                        <option value="+971">🇦🇪 +971 (UAE)</option>
                        <option value="+91">🇮🇳 +91 (India)</option>
                    </select>

                    <input type="tel" id="whatsapp" name="whatsapp" class="input" required onkeyup="Valid()" placeholder="Enter a valid WhatsApp number">
                </div>
                <div id="whatsappAlert" class="alert alert-danger w-100 mt-2 d-none">
                    Enter a valid phone number (10-15 digits).
                </div>

            </div>
            <button type ="button" id="checkWhatsApp" >Check WhatsApp</button>
        </div>

        <div>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" class="input" onkeyup="Valid()" placeholder="Enter your Address">
        </div>

        <div>
            <label for="signUpEmail">Email:</label>
            <input type="email" id="signUpEmail" name="signUpEmail" class="input" required onkeyup="Valid()" placeholder=" OmarAhmed@example.com ">
        </div>

        <div id="emailAlert" class="alert alert-danger w-100 mt-2 d-none">
            Email not valid *exemple@yyy.zzz
        </div>

        <label for="signUpPassword">Password:</label>
        <input type="password" id="signUpPassword" name="signUpPassword" class="input" required onkeyup="Valid()" placeholder="Create a password">
        <div id="passwordAlert" class="alert alert-danger w-100 mt-2 d-none">
            Enter valid password *Minimum eight characters, at least one number and one special character:*
        </div>

        <label for="signUpRePassword">Confirm Password:</label>
        <input type="password" id="signUpRePassword" name="signUpRePassword" class="input" required onkeyup="Valid()" placeholder="Confirm your password">
        <div id="repasswordAlert" class="alert alert-danger w-100 mt-2 d-none">
            Password doesn't match
        </div>

        <div>
            <label for="userImage">Upload Profile Picture:</label>
            <input type="file" id="userImage" name="userImage" class="input" required accept="image/*" onchange="Valid()">
            <div id="userImageAlert" class="alert alert-danger w-100 mt-2 d-none">
                There is no Image Uploaded
            </div>
        </div>
        <button id="signUpButton" type="submit">Register</button>

        <div class="register-link">
            <p style="margin-bottom: 0;">Already have an account? <a href="">Login</a></p>
            <div id="alert"></div>
        </div>
    </form>
</div>

<script src="{{ asset ('js/validations.js') }}"></script>
<script src="{{ asset ('js/api_ops.js') }}"></script>

@endsection
