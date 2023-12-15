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
            'permission' => 'You do not have permission to put a price on a resource. Click <a href="" target="_blank">here</a> to improve your account.'
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
    ]
];
