@extends('layouts.app')

@section('content')
<div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="main-panel">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5">

                        <h4>New here?</h4>
                        <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                        <form class="pt-3" method="POST" action="{{ route('register_web') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- Circle for profile picture -->
                            <div class="form-group text-center">
                                <label for="profilePicture" class="profile-circle">
                                    <img id="profileImage" src="https://www.gravatar.com/avatar/?d=mp&s=120" alt="Profile Image" style="width: 120px; height: 120px; border-radius: 50%; cursor: pointer;">
                                </label>
                                <input type="file" id="profilePicture" name="profilePicture" accept="image/*" style="display: none;" onchange="previewImage(event)">
                                @error('profilePicture')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Other form fields -->
                            <div class="form-group">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus id="register_name" placeholder="Full Name">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control @error('userId') is-invalid @enderror" name="userId" value="{{ old('userId') }}" required autocomplete="userId" autofocus id="register_userId" placeholder="User ID">
                                @error('userId')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" id="password" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                            </div>
                            <div class="mb-4">
                                <div class="form-check">
                                    <label class="form-check-label text-muted">
                                        <input type="checkbox" class="form-check-input" id="termsCheckbox">
                                        I agree to all Terms & Conditions
                                    </label>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit" id="submitButton" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">{{ __('SIGN UP') }}</button>
                            </div>
                            <div class="text-center mt-4 font-weight-light">
                                Already have an account? <a href="{{ route('login') }}" class="text-primary">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
</div>
<script>
    // Trigger the hidden file input when the circle is clicked
    document.getElementById('profileImage').addEventListener('click', function() {
        document.getElementById('profilePicture').click();
    });

    // Preview the selected image inside the circle
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('profileImage');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    // Enable/Disable the submit button based on the Terms & Conditions checkbox
    document.addEventListener('DOMContentLoaded', function() {
        const termsCheckbox = document.getElementById('termsCheckbox');
        const submitButton = document.getElementById('submitButton');
        submitButton.disabled = true;
        termsCheckbox.addEventListener('change', function() {
            submitButton.disabled = !termsCheckbox.checked;
        });
    });
</script>
@endsection

@section('scripts')

@endsection