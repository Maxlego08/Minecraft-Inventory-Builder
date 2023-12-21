<?php

return [

    'dashboard' => 'Dashboard',
    'description' => "Welcome to the space for managing your account and resources.",

    'nav' => [
        'account' => 'Your Account',
        'details' => 'Account details',
        'alerts' => 'Your Alerts',
        'conversations' => 'Conversations',
        'images' => 'Your Images',
        'resources' => [
            'your' => 'Your Resources',
            'add' => 'Add Resource',
        ],
        'color' => 'Change name color'
    ],

    'avatar' => [
        'name' => 'Avatar',
        'delete' => 'Delete your avatar',
        'deleted' => 'You have just deleted your avatar',
        'added' => "You have just added an avatar",
    ],

    'banner' => [
        'name' => 'Banner',
        'delete' => 'Delete your banner',
        'deleted' => 'You have just deleted your banner',
        'added' => "You have just added a banner",
        'permission' => 'You must be pro to add a banner',
    ],

    'email' => [
        'change' => 'Change your email',
        'new' => 'New email',
        'updated' => 'You have just changed your email',
    ],

    'password' => [
        'change' => 'Change password',
        'exist' => 'Your existing password',
        'new' => 'New password',
        'confirm' => 'Confirm new password',
        'updated' => 'You have just changed your password',
        'confirmed' => 'Confirm password',
        'forgot' => 'Forgot your password ?',
        'info' => 'Please confirm your password to perform more actions.',
    ],

    'discord' => [
        'discord' => 'Discord',
        'remove' => 'Remove authorization',
        'info' => '<i class="bi bi-exclamation-diamond"></i> Relier votre compte discord va permettre à notre équipe de mieux vous aider dans les tickets Discord. Nous vous conseillons fortement de relier votre compte Discord dès maintenant.',
        'link' => 'Link your account',
        'removed' => 'You just deleted the link with discord',
        'linked' => 'You have just linked your discord account',
        'error' => [
            'url' => 'An error occurred while linking your discord account (Url format)',
            'user' => 'An error occurred while linking your discord account (User id)',
            'api' => 'An error occurred while linking your discord account (Api URL)',
            'oauth' => 'An error occurred while linking your discord account (OAuth2)',
            'already' => 'You have already linked your discord account',
        ],
    ],

    'two_factor' => [
        'title' => 'Two factor',
        'enable' => 'Enable Two-Factor',
        'disable' => 'Disable Two-Factor',
        'confirm' => 'Confirm Two-Factor',
        'info' => 'Two factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application.',
        'info2' => 'Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.',
        'regen' => 'Regenerate Recovery Codes',
        'label' => 'Confirm code (6 digits)',
        'key' => [
            'title' => 'Can\'t scan the code?',
            'info' => 'To add the entry manually, provide the following details to the application on your phone.',
            'key' => 'Key: ',
            'time' => 'Time based:',
            'account' => 'Account:'
        ],
        'download' => 'Download recovery codes',
        'login' => [
            'info' => 'Please confirm access to your account by entering the authentication code provided by your authenticator application.',
            'info2' => 'Or confirm access to your account by entering one of your emergency recovery codes.',
        ],
    ],

    'command' => [
        'title' => 'Link your account',
        'description' => 'Allows you to link your account to the zMenu plugin on your server.',
        'info' => 'Click to display the command you will have to do in game. Attention, if you click you will have to reconnect the plugin.'
    ],

];
