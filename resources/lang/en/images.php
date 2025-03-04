<?php

return [
    'title' => 'Images',
    'alt' => 'Show the Image',
    'upload' => [
        'title' => 'Upload',
        'button' => 'Upload',
        'content' => 'You just uploaded a new image',
    ],
    'table' => [
        'delete_all' => 'Delete the Selected Images',
        'name' => 'File Name',
        'size' => 'Image Size',
        'action' => 'Action',
        'delete' => 'Delete',
    ],
    'modal' => [
        'title' => 'Confirmation',
        'content' => 'Do you really want to remove this image?',
        'content_all' => 'Do you really want to delete these images?',
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
            'content' => 'You just deleted an image.'
        ]
    ],
    'textarea' => [
        'title' => 'Add an Image'
    ]
];
