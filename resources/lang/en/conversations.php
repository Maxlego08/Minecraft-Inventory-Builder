<?php

return [
    'title' => 'Conversations',
    'list' => [
        'title' => 'See the Conversation',
        'start' => "<span class='me-1'>Started by</span> :name<span class='me-1'>,</span> :date",
        'last' => "<span class='me-1'>Last</span> <a class='conversation-link me-1' href=':link' title='View last message'>message</a> <span class='me-1'>by</span> :name<span class='me-1'>,</span> :date",
    ],
    'empty' => 'You have no conversations.',
    'enable' => 'Enable Conversations.',
    'show' => [
        'title' => ':title',
    ],
    'create' => [
        'start' => 'Start a New Conversation with :user',
        'title' => 'New Conversation - :user',
        'button' => 'Start a Conversation',
        'subject' => 'Conversation Title'
    ],
    'error_disable' => [
        'title' => 'Error',
        'description' => 'You cannot create a conversation with :name.'
    ],
    'error_access' => [
        'title' => 'Error',
        'description' => 'You do not have access to this conversation.'
    ],
    'error_content' => [
        'title' => 'Error',
        'description' => 'Unable to read this conversation.'
    ],
    'error_create_self' => [
        'title' => 'Error',
        'description' => 'You cannot perform this action.'
    ],
    'cooldown' => [
        'title' => 'Error',
        'description' => 'You must wait :seconds seconds between each message.'
    ],
    'create_success' => [
        'title' => 'New Conversation',
        'description' => 'You have just created a new conversation.'
    ],
    'textarea' => [
        'label' => '',
        'submit' => 'Post Reply',
    ],
    'send_success' => [
        'title' => 'New Reply',
        'description' => 'You have just sent a reply.'
    ],
    'auto' => [
        'title' => 'Auto Response',
        'permission' => 'You do not have permission to use automatic answers. You must have the role :role. Click <a href="">here</a> to upgrade your account.',
        'success' => [
            'title' => 'Update Auto Response',
            'description' => 'Update your auto response.'
        ],
        'enable' => 'Activate the Auto Response.',
        'info' => 'Auto-reply',
    ],
];
