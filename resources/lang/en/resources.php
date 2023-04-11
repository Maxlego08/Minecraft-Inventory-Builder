<?php

return [

    'create' => [
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
            'name' => 'Support URL',
            'description' => 'Link to your support system. (Your discord or your site. We advise you to create documentation on <a href="https://gitbook.com/" target="_blank">gitbook.com</a>)',
        ],
        'image' => [
            'name' => 'Icon (Required)',
            'description' => 'Icon of your resource, you can change it later',
        ],
        'file' => [
            'name' => 'File',
            'description' => 'Icon of your resource, you can change it later',
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
    ]

];
