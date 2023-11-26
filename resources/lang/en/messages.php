<?php
return [
    'header' => [
        'language' => 'Set To Jpn',
        'profile' => 'Profile',
        'logout' => 'Logout',
        'record' => 'Record',
    ],
    'home' => [
        'record' => "'s Record",
        'match' => 'Matching Start',
        'first' => 'Welcome to BinGonichiwa.',
        'second' => 'This service allows you to easily play bingo with other people.',
        'third' => 'LogIn and enjoy.',
        'winning_rate' => ':name\'s winning rate',
    ],
    'auth' => [
        'logout' => 'Are you sure logout？',
        'login' => 'Login',
        'password' => 'Password',
        'error' => 'Whoops! Something went wrong.',
        'register' => 'Register',
        'already_registered' => 'Already registered?',
        'name' => 'Name',
        'confirm_password' => 'Confirm Password',
        'wrong' => 'These credentials do not match our records.'
    ],
    'profile' => [
        'saved' => 'Saved',
        'save' => 'Save',
        'update_information' => [
            'title' => 'Profile Information',
            'description' => 'Update your account\'s profile information and email address.',
            'name' => 'Name',
            'id' => 'ID',
        ],
        'update_password' => [
            'title' => 'Update Password',
            'description' => 'Ensure your account is using a long, random password to stay secure.',
            'current_password' => 'Current Password',
            'new_password' => 'New Password',
            'confirm_password' => 'Confirm Password',
        ],
        'delete_account' => [
            'title' => 'Delete Account',
            'description' => 'Permanently delete your account.',
            'content' => 'Once your account is deleted, all of its resources and data will be permanently deleted.',
            'delete_account_button' => 'Delete Account',
            'modal' => [
                'title' => 'Delete Account',
                'content' => 'Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.',
                'input_placehorder' => 'Password',
                'cancel' => 'Cancel',
                'button' => 'Delete Account',
                'wrong' => 'This password does not match our records.',
            ]
        ],
    ],
    'validation' => [
        'id' => [
            'unique' => 'The ID has already been taken.',
        ],
        'password' => [
            'confirmed' => 'The password confirmation does not match.',
            'match' => 'The provided password does not match your current password.'
        ],
    ],
    'custom_password_messages' => [
        'default' => 'The :attribute must be at least :length characters.',
    ],
    'records' => [
        'name' => '\'s Record',
        'win' => 'Win',
        'lose' => 'Lose',
        'opponent' => 'Opponent',
        'result' => 'Result',
        'time' => 'Time',
        'games' => 'games',
        'wins' => 'wins',
        'loses' => 'loses',
        'winning_rate' => 'winning rate',
        'page_prev' => 'Previous',
        'page_next' => 'Next',
        'withdrawal' => 'Withdrawal',
        'no_records' => 'No records...',
    ],
    'errors' => [
        '404' => 'Not Found',
        'message' => 'to home page',
    ],
    'waiting' => [
        'wait' => 'Please wait...',
        'match_cancel' => 'Cancel',
        'cancel_confirm' => 'Are you sure you want to cancel?',
        'start_confirm' => 'The other person has been found. Would you like to start the game?',
    ],
];
