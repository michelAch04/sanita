<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */
    // lang/en/auth.php
    'verify_otp' => [
        'title' => 'Verify OTP',
        'mobile' => 'Mobile Number',
        'otp' => 'OTP Code',
        'submit' => 'Verify',
        'no_account_register' => 'Don\'t have an account? Register',
        'resend_otp' => 'Resend OTP',
    ],

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',

    'sign_in' => [
        'title' => 'Sign In',
        'email' => 'Email (optional)',
        'password' => 'Password',
        'remember_me' => 'Remember Me',
        'forgot_password' => 'Forgot Your Password?',
        'login' => 'Login',
        'no_account_signup' => "Don't have an account? Sign Up",
    ],
    'sign_up' => [
        'title' => 'Sign Up',
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'dob' => 'Date of Birth',
        'mobile' => 'Mobile',
        'gender' => 'Gender',
        'gender_male' => 'Male',
        'gender_female' => 'Female',
        'email' => 'Email (optional)',
        'password' => 'Password',
        'password_confirmation' => 'Confirm Password',
        'submit' => 'Sign Up',
        'already_account_signin' => 'Already have an account? Sign In',
        'select' => 'Select',
    ],
    'passwords' => [
        'email_title' => 'Reset Password',
        'email' => 'Email Address',
        'send_link' => 'Send Password Reset Link',
        'reset_password' => 'Reset Password',
        'password' => 'Password',
        'email_address' => 'E-Mail Address',
        'confirm_password' => 'Confirm Password',
    ],
    'invalid_mobile' => 'Invalid mobile number',
    'invalid_date' => 'Invalid date',
];
