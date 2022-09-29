<?php

return [

    'dashboard' => 'Dashboard',
    'description' => "Welcome to the space for managing your account and resources.",

    'nav' => [
        'account' => 'Your Account',
        'alerts' => 'Your Alerts',
        'conversations' => 'View Conversations',
        'resources' => [
            'your' => 'Your Resources',
            'add' => 'Add Resource',
        ]
    ],

    'avatar' => [
        'name' => 'Avatar',
        'delete' => 'Delete your avatar',
        'deleted' => 'You have just deleted your avatar',
        'added' => "You have just added an avatar",
    ],

    'email' => [
        'change' => 'Change your email',
        'new' => 'New email'
    ],

    'password' => [
        'change' => 'Change password',
        'exist' => 'Your existing password',
        'new' => 'New password',
        'confirm' => 'Confirm new password',
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

];
