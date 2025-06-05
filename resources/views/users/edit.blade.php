@extends('master')

@section('title', 'Edit Student Details')

@section('head-extra')
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
        <form class="form-up" id="editForm" method="post" enctype="multipart/form-data" UserId="{{$user->id}}">

            @csrf
            @method('PUT')

            <h1 style="text-align: center;margin-top: 0;">Welcome to Neovate University, </h1>
            <h1 style="text-align: center;margin-top: 0;"> Edit Your Profile:</h1>

            <!-- Full Name -->
            <div>
                <label for="FullName">Full Name:</label>
                <input type="text" id="FullName" name="FullName" class="input" required value="{{ $user->full_name }}"
                       onkeyup="Valid()" placeholder="Enter your Full Name">
                <div id="full_nameAlert" class="alert alert-danger w-100 mt-2 d-none">
                    Minimum 3 characters, only letters and spaces allowed.
                </div>
            </div>

            <!-- Username -->
            <div>
                <label for="signUpName">Username:</label>
                <input type="text" id="signUpName" name="signUpName" class="input" required
                       value="{{ $user->user_name }}" onkeyup="Valid()" placeholder="Enter your Username" disabled>
                <div id="user_nameAlert" class="alert alert-danger w-100 mt-2 d-none">
                    Minimum 3 characters, special characters not allowed
                </div>
            </div>

            <!-- Phone -->
            <div>
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" class="input" required value="{{ $user->phone }}"
                       onkeyup="Valid()" placeholder="Enter your Phone number">
                <div id="phoneAlert" class="alert alert-danger w-100 mt-2 d-none">
                    Enter a valid phone number (10-15 digits).
                </div>
            </div>

            <!-- WhatsApp -->
            <div>
                <label for="whatsapp">WhatsApp Number:</label>
                <div>
                    <select id="countryCode" name="whatsappCountryCode" class="input" required onchange="Valid()">
                        <option value="+20" {{ substr($user->whatsup_number, 0, 3) === '+20' ? 'selected' : '' }}>🇪🇬 +20
                            (Egypt)
                        </option>
                        <option value="+1" {{ substr($user->whatsup_number, 0, 2) === '+1' ? 'selected' : '' }}>🇺🇸 +1
                            (USA)
                        </option>
                        <option value="+44" {{ substr($user->whatsup_number, 0, 3) === '+44' ? 'selected' : '' }}>🇬🇧 +44
                            (UK)
                        </option>
                        <option value="+971" {{ substr($user->whatsup_number, 0, 4) === '+971' ? 'selected' : '' }}>🇦🇪
                            +971 (UAE)
                        </option>
                        <option value="+91" {{ substr($user->whatsup_number, 0, 3) === '+91' ? 'selected' : '' }}>🇮🇳 +91
                            (India)
                        </option>
                    </select>

                    <input type="tel" id="whatsapp" name="whatsapp" class="input" required
                           @if(substr($user->whatsup_number, 0, 3) === '+20')
                               value="{{ substr($user->whatsup_number, 3) }}"
                           @elseif(substr($user->whatsup_number, 0, 2) === '+1')
                               value="{{ substr($user->whatsup_number, 2) }}"
                           @elseif(substr($user->whatsup_number, 0, 3) === '+44')
                               value="{{ substr($user->whatsup_number, 3) }}"
                           @elseif(substr($user->whatsup_number, 0, 4) === '+971')
                               value="{{ substr($user->whatsup_number, 4) }}"
                           @elseif(substr($user->whatsup_number, 0, 3) === '+91')
                               value="{{ substr($user->whatsup_number, 3) }}"
                           @endif
                           onkeyup="Valid()" placeholder="Enter a valid WhatsApp number">
                </div>
                <small id="whatsappPreview" class="text-muted"></small>
                <div id="whatsup_numberAlert" class="alert alert-danger w-100 mt-2 d-none">
                    Enter a valid phone number (10-15 digits).
                </div>
            </div>

            <!-- Address -->
            <div>
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" class="input" value="{{ $user->address }}"
                       onkeyup="Valid()" placeholder="Enter your Address">
            </div>

            <!-- Email -->
            <div>
                <label for="signUpEmail">Email:</label>
                <input type="email" id="signUpEmail" name="signUpEmail" class="input" required
                       value="{{ $user->email }}" onkeyup="Valid()" placeholder="OmarAhmed@example.com">
                <div id="emailAlert" class="alert alert-danger w-100 mt-2 d-none">
                    Email not valid *exemple@yyy.zzz
                </div>
            </div>

            <!-- Password -->
            <div>
                <label for="signUpPassword">Password:</label>
                <input type="password" id="signUpPassword" name="signUpPassword" class="input" onkeyup="Valid()"
                       placeholder="Current password">
                <div id="passwordAlert" class="alert alert-danger w-100 mt-2 d-none">
                    Enter valid password *Minimum eight characters, at least one number and one special character*
                </div>
            </div>

            <!-- Current Image -->
            <div>
                <label>Current Profile Picture:</label><br>
                <img src="{{ asset('images/' . $user->student_img) }}" width="100" alt="Current Image"><br><br>
            </div>

            <!-- Upload New Image -->
            <div>
                <label for="userImage">Upload New Profile Picture:</label>
                <input type="file" id="userImage" name="userImage" class="input" accept="image/*" onchange="Valid()">
            </div>

            <!-- Submit Button -->
            <button id="signUpButton" type="submit">Update</button>

            <div class="register-link">
                <p style="margin-bottom: 0;">
                    <a href="{{ route('users.index') }}">Cancel</a>
                </p>
                <div id="alert"></div>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/validations.js') }}"></script>

@endsection
