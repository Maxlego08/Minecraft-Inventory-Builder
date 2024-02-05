<?php

return [
    'title' => 'Images',
    'alt' => 'Show the image',
    'upload' => [
        'title' => 'Upload',
        'button' => 'Upload',
        'content' => 'You just upload a new image',
    ],
    'table' => [
        'name' => 'File name',
        'size' => 'Image size',
        'action' => 'Action',
        'delete' => 'Delete',
    ],
    'modal' => [
        'title' =>'Confirmation',
        'content' => 'You really want to remove this image.',
    ],
    'delete' => [
        'errors' => [
            'permission' => [
                'title' => 'Error',
                'content' => "You don't have permission to do this."
            ],
            'file' => [
                'title' => 'Error',
                'content' => "You can't delete this image."
            ],
        ],
        'success' => [
            'title' => 'Success',
            'content' => 'You just delete an image'
        ]
    ],
    'textarea' => [
        'title' => 'Add an image'
    ]
];
