<?php

return [
    'title' => 'Resources',
    'description' => 'Sell or upload your resources around zMenu',
    'add' => 'Add resource',
    'review' => 'ratings',
    'informations' => 'Informations',
    'review-all-time' => 'All-Time Rating',
    'review-current' => 'Version Rating',
    'tools' => 'Resource Tools',
    'review-send' => 'Submit Rating',
    'rate' => 'Rate This Resource',
    'overview' => 'Overview',
    'search' => 'Search...',
    'contributors' => 'Contributors',
    'code' => 'Source code',
    'support' => 'Support',
    'tested_versions' => 'Tested Minecraft Versions',
    'required_dependencies' => 'Required dependencies',
    'optional_dependencies' => 'Optional dependencies',
    'edit' => [
        'title' => 'Edit your resource',
        'description' => 'Edit your resource information',
        'icon' => 'Edit Resource Icon',
        'content' => 'Edit Resource',
        'update' => 'Post Resource Update',
        'purchase' => 'Buy the resource',
        'success' => [
            'title' => 'Resource updated !',
            'content' => 'You have just updated your resource'
        ],
        'icon_modal' => [
            'title' => 'Edit Resource Icon',
            'success' => [
                'title' => 'Felicitation !',
                'content' => 'You have just changed the icon of your resource'
            ]
        ]
    ],
    'create' => [
        'info' => [
            'title' => 'Add resource',
            'description' => 'You will create a resource, it will be checked by the moderation team of the site. Please save the description of your resource, if it is rejected you will not be able to retrieve it.',
        ],
        'success' => [
            'title' => 'You just create a new resource !',
            'content' => 'Your resource is being validated, wait few hours'
        ],
        'errors' => [
            'limit' => [
                'title' => 'You have reached the limit',
                'content' => 'You can no longer create a resource.',
            ],
        ],
        'button' => 'Save',
        'title' => [
            'name' => 'Title (Required)',
            'description' => 'Name of your resource, it must be concise and simply describe your resource',
        ],
        'version' => [
            'name' => 'Version (Required)',
            'description' => 'Version of your resource',
        ],
        'required_dependencies' => [
            'name' => 'Required dependencies (Optional)',
            'description' => 'List of dependencies required for the resource',
        ],
        'optional_dependencies' => [
            'name' => 'Optional dependencies (Optional)',
            'description' => 'List of dependencies optional for the resource',
        ],
        'tags' => [
            'name' => 'Tags (Required)',
            'description' => 'A short sentence to describe your resource',
        ],
        'native_version' => [
            'name' => 'Native Minecraft Version (Required)',
            'description' => 'Enter the version with which you have programmed the plugin (API version)',
        ],
        'contributor' => [
            'name' => 'Contributors (Optional)',
            'description' => 'A list of additional contributors to the resource',
        ],
        'minecraft_version' => [
            'name' => 'Tested Minecraft Versions (Required)',
            'description' => 'The versions of minecraft where the resource has been tested',
        ],
        'code' => [
            'name' => 'Source code (Optional)',
            'description' => 'Link to the source code of the resource',
        ],
        'donation' => [
            'name' => 'Donation link (Optional)',
            'description' => 'Link to a donation page',
        ],
        'lang' => [
            'name' => 'Supported languages (Optional)',
            'description' => 'Translations available in your plugin other than English',
        ],
        'informations' => [
            'name' => 'Informations URL (Optional)',
            'description' => 'Link to an information page of your resource',
        ],
        'support' => [
            'name' => 'Support URL (Required)',
            'description' => 'Link to your support system. (Your discord or your site. We advise you to create documentation on <a href="https://gitbook.com/" target="_blank">gitbook.com</a>)',
        ],
        'image' => [
            'name' => 'Icon (Required)',
            'description' => 'Icon of your resource, you can change it later',
        ],
        'file' => [
            'name' => 'File',
            'description' => 'File of your resource.',
        ],
        'category' => [
            'name' => 'Category',
            'description' => 'Category in which the resource will be displayed. Be careful, you will not be able to change the category after the resource has been created.',
        ],
        'price' => [
            'name' => 'Price',
            'description' => '<b>Read Me</b>: It appears that you are submitting a premium resource. Please take a moment to read the approval guidelines listed here. Not following them and our rules will lead to your resource getting rejected! Make sure that you save a copy of your description and other info locally, you will not be able to access that if rejected!',
            'permission' => 'You do not have permission to put a price on a resource. Click <a href="" target="_blank">here</a> to improve your account.',
            'payment' => 'You forgot to add a payment method to your account, we advise you to do it now <a href="https://minecraft-inventory-builder.com/profile/payment" target="_blank">here</a> !'
        ],
        'discord' => [
            'name' => 'Discord ID',
            'place' => 'Discord server id',
            'description' => 'Allows you to display a link to your discord. You must enable the widget on your discord server to use this feature.',
        ],
        'bstats' => [
            'name' => 'Bstats ID',
            'description' => 'Allows you to display the statistics of your plugin.',
        ],
    ],
    'download' => [
        'login' => 'You must be connected to download this file.',
        'access' => 'You need to purchase this resource.',
        'button' => 'Download',
        'errors' => [
            'same' => [
                'title' => 'You can\'t download this resource',
                'content' => 'An error occurred while downloading.',
            ],
            'ban' => [
                'title' => 'You are banned',
                'content' => 'You are banned, you can\'t download this resource.',
            ],
            'purchase' => [
                'title' => 'Error !',
                'content' => 'You don\'t have permission to download the plugin.',
            ],
            'cache' => [
                'title' => 'Wait few seconds',
                'content' => 'You have to wait a few seconds before you can download the plugin.',
            ],
            'other' => [
                'title' => 'Error !',
                'content' => 'Unable to find the file to download, please contact an administrator.',
            ],
        ]
    ],
    'reviews' => [
        'info' => 'Your review must be at least 30 characters.',
        'title' => 'Reviews',
        'author' => 'Author',
        'recent' => 'Recent Reviews',
        'read-all' => 'Read all reviews',
        'no' => 'No review for the moment.',
        'reply' => [
            'message' => 'Reply',
            'title' => 'Reply to Review',
            'content' => 'You just answered this review',
        ],
        'delete' => [
            'title' => 'You just deleted your review',
            'content' => 'Why did you delete your review ? Reviews are very important !',
        ],
        'errors' => [
            'permission' => [
                'title' => "You don’t have permission",
                'content' => 'You do not have permission to perform this action',
            ],
            'download' => [
                'title' => 'You can\'t review !',
                'content' => 'You must download the resource before you can rate it.',
            ],
            'already' => [
                'title' => 'You can\'t review !',
                'content' => 'You have already given a review for this version.',
            ],
            'self' => [
                'title' => 'You can\'t review !',
                'content' => 'You can\'t give yourself a rate.',
            ],
            'rate' => [
                'title' => 'You can\'t review !',
                'content' => 'Unable to find your note.',
            ],
        ],
        'success' => [
            'title' => 'You just leave a review',
            'content' => 'Thank you for taking the time to put a note to this resource.',
        ],
        'response' => [
            'title' => 'Success',
            'content' => 'You just delete your response.',
        ],
        'alert' => ':user just put a review to your resource :content'
    ],
    'update' => [
        'title' => 'Updates',
        'version' => [
            'name' => 'Version title',
            'version' => 'Version string',
        ],
        'success' => [
            'title' => 'Resource updated !',
            'content' => 'You have just updated your resource.',
        ],
        'info' => [
            'title' => 'Post Resource Update',
        ],
    ],
    'versions' => [
        'title' => 'Version History',
        'version' => 'Version',
    ],
    'buyers' => [
        'title' => 'Buyers',
        'search' => 'Find buyer',
        'user' => 'User',
        'username' => 'User Name',
        'price' => 'Price',
        'added_on' => 'Added on',
        'free' => 'Free',
        'remove' => [
            'title' => 'Perfect !',
            'content' => 'You have just removed the access to the resource'
        ],
        'create' => [
            'title' => 'Perfect !',
            'content' => 'You have just added a user to your resource'
        ],
        'error' => [
            'title' => 'Error !',
            'content' => 'Impossible to find this user.',
        ],
        'already' => [
            'title' => 'Error !',
            'content' => 'This user already has access to this resource.',
        ],
        'add' => 'Add buyer',
    ],
    'most' => [
        'title' => 'Most Resources',
    ],
    'category' => [
        'title' => 'Categories',
    ],
    'view' => [
        'errors' => [
            'pending' => [
                'title' => 'Error !',
                'content' => 'You don\'t have permission to see this resource',
            ],
            'deleted' => [
                'title' => 'Error !',
                'content' => 'You don\'t have permission to see this resource',
            ],
            'owner' => [
                'title' => 'Error !',
                'content' => 'You don\'t have permission to see this resource',
            ],
            'permission' => [
                'title' => 'Error !',
                'content' => 'You don\'t have permission to see this resource',
            ]
        ],
    ],
    'purchase' => [
        'button' => 'Buy now for :price€',
        'error' => 'Unable to purchase this resource at this time.'
    ],
    'actions' => [
        'resources' => 'your resources',
        'purchase' => 'purchases resources',
        'creator_board' => 'creator dashboard'
    ],

    'dashboard' => [
        'title' => 'Creator dashboard',
        'description' => 'Manage your resources, create gift codes, display your payments, all this happens in the creator dashboard',
        'overview' => [
            'title' => 'Overview',
            'resources' => 'Resources',
            'payments' => 'Transactions',
            'download' => 'Downloads',
            'earn' => 'Earnings all time'
        ],
        'products' => [
            'title' => 'My Resources'
        ],
        'gifts' => [
            'title' => 'Gift code',
        ],
        'discord' => [
            'title' => 'Discord Webhook',
            'create' => 'Create Discord Webhook',
            'url' => 'Discord Webhook URL',
            'event' => 'Event',
            'username' => 'Username',
            'avatar_url' => 'Avatar URL',
            'url_errors' => 'The url is not the right format.',
            'embed' => [
                'add' => 'Add Embed',
                'title' => 'Embed Title',
                'url' => 'Embed URL',
                'color' => 'Embed Color',
                'description' => 'Embed Description',
                'thumbnail' => 'Embed Thumbnail',
                'footer' => 'Embed Footer'
            ],
            'errors' => [
                'limit' => [
                    'title' => 'Limit reached',
                    'description' => 'You have just reached the webhook discord limit. You cannot create a new one.',
                ],
            ],
            'success' => [
                'title' => 'New Discord Webhook',
                'description' => 'You just created a discord webhook.',
            ],
            'update' => [
                'title' => 'Update Discord Webhook',
                'description' => 'You just updated a discord webhook.',
            ],
            'delete' => [
                'title' => 'Delete Discord Webhook',
                'description' => 'You just deleted a discord webhook.',
            ],
            'test' => [
                'title' => 'Test Discord Webhook',
                'description' => 'You just send a test for your discord webhook.',
            ],
            'table' => [
                'url' => 'URL',
                'actions' => 'Actions',
                'send' => 'Send a test',
                'delete' => 'Delete this webhook',
                'create' => 'Create a new webhook',
                'edit' => 'Edit this webhook'
            ],
            'documentation' => [
                'events' => 'Events',
                'title' => 'Documentation',
                'variable' => 'Variables',
                'description' => 'Description',
                'client_id' => 'The unique identifier of the user',
                'client_name' => 'The name of the user',
                'client_email' => 'The email address of the user',
                'payment_price' => 'The price of the payment',
                'payment_currency' => 'The currency used for the payment',
                'payment_id' => 'The external identifier of the payment',
                'payment_content_name' => 'The name of the content associated with the payment',
                'payment_content_id' => 'The identifier of the content associated with the payment',
                'resource_name' => 'The name of the resource',
                'resource_tag' => 'The tag associated with the resource',
                'resource_id' => 'The unique identifier of the resource',
                'resource_price' => 'The price of the resource',
                'resource_logo' => 'The path to the logo of the resource',
                'resource_download' => 'The number of downloads of the resource',
                'resource_link' => 'The link to the description of the resource',
                'resource_currency' => 'The currency associated with the resource',
                'author_name' => 'The name of the resource\'s author',
                'author_id' => 'The identifier of the resource\'s author',
                'resource_version' => 'The version of the resource',
                'resource_version_name' => 'The name of the resource version',
                'resource_version_download' => 'The download link for the resource version',
                'color_random' => 'A randomly generated color'
            ],
        ],
        'payments' => [
            'title' => 'Transactions',
            'resource' => 'Resource',
            'buyer' => 'Buyer',
            'transaction' => 'Transaction ID',
            'date' => 'Date',
            'earning' => 'Earnings',
            'details' => 'Details',
            'transaction_details' => 'Transaction details'
        ]
    ]
];
