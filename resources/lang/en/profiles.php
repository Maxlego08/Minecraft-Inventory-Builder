<?php

return [
    'dashboard' => 'Dashboard',
    'description' => "Welcome to the space for managing your account and resources.",

    'nav' => [
        'account' => 'Your Account',
        'details' => 'Account Details',
        'alerts' => 'Your Alerts',
        'conversations' => 'Conversations',
        'images' => 'Your Images',
        'resources' => [
            'your' => 'Your Resources',
            'add' => 'Add Resource',
        ],
        'color' => 'Change Name Color',
        'upgrade' => 'Account Upgrades',
        'change_name' => 'Change Username',
        'newsletter' => 'Newsletter',
    ],

    'avatar' => [
        'name' => 'Avatar',
        'delete' => 'Delete Your Avatar',
        'deleted' => 'You have just deleted your avatar',
        'added' => 'You have just added an avatar',
    ],

    'banner' => [
        'name' => 'Banner',
        'delete' => 'Delete Your Banner',
        'deleted' => 'You have just deleted your banner',
        'added' => 'You have just added a banner',
        'permission' => 'You must be Pro to add a banner',
    ],

    'email' => [
        'change' => 'Change Your Email',
        'new' => 'New Email',
        'updated' => 'You have just changed your email',
    ],

    'password' => [
        'change' => 'Change Password',
        'exist' => 'Your Existing Password',
        'new' => 'New Password',
        'confirm' => 'Confirm New Password',
        'updated' => 'You have just changed your password',
        'confirmed' => 'Confirm Password',
        'forgot' => 'Forgot Your Password?',
        'info' => 'Please confirm your password to perform more actions.',
    ],

    'discord' => [
        'discord' => 'Discord',
        'remove' => 'Remove Authorization',
        'info' => '<i class="bi bi-exclamation-diamond"></i> Linking your Discord account will allow our team to better assist you with Discord tickets. We strongly recommend linking your Discord account now.',
        'link' => 'Link Your Account',
        'removed' => 'You just deleted the link with Discord',
        'linked' => 'You have just linked your Discord account',
        'error' => [
            'url' => 'An error occurred while linking your Discord account (URL format)',
            'user' => 'An error occurred while linking your Discord account (User ID)',
            'api' => 'An error occurred while linking your Discord account (API URL)',
            'oauth' => 'An error occurred while linking your Discord account (OAuth2)',
            'already' => 'You have already linked your Discord account',
        ],
    ],

    'two_factor' => [
        'title' => 'Two-Factor',
        'enable' => 'Enable Two-Factor',
        'disable' => 'Disable Two-Factor',
        'confirm' => 'Confirm Two-Factor',
        'info' => 'Two-factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application.',
        'info2' => 'Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two-factor authentication device is lost.',
        'regen' => 'Regenerate Recovery Codes',
        'label' => 'Confirm Code (6 digits)',
        'key' => [
            'title' => 'Can\'t Scan the Code?',
            'info' => 'To add the entry manually, provide the following details to the application on your phone.',
            'key' => 'Key: ',
            'time' => 'Time-based:',
            'account' => 'Account:'
        ],
        'download' => 'Download Recovery Codes',
        'login' => [
            'info' => 'Please confirm access to your account by entering the authentication code provided by your authenticator application.',
            'info2' => 'Or confirm access to your account by entering one of your emergency recovery codes.',
        ],
    ],

    'command' => [
        'title' => 'Link Your Account',
        'description' => 'Allows you to link your account to the zMenu plugin on your server.',
        'info' => 'Click to display the command you will have to execute in-game. Note that if you click, you will need to reconnect the plugin.'
    ],

    'change' => [
        'history' => 'Username Changed',
        'title' => 'Change Username',
        'previous' => 'Previous Usernames',
        'info' => "Please note that you're about to change your username. Once changed, your old username will become available for anyone else to use. Additionally, you'll be able to change your username again in 30 days.",
        'new_name' => 'New Username',
        'old_name' => 'Old Username',
        'success' => [
            'title' => 'Success!',
            'description' => 'You just changed your username.',
        ],
        'error' => [
            'title' => 'Error!',
            'description' => "You can't change your username for now.",
        ],
        'error_time' => [
            'title' => 'Error!',
            'description' => "You must wait 30 days between each change.",
        ],
        'error_permission' => [
            'title' => 'Error!',
            'description' => "You must be Pro to change your username.",
        ],
    ]
];
