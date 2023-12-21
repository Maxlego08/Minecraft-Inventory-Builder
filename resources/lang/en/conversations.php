<?php

return [
    'title' => 'Conversations',
    'list' => [
        'title' => 'See the conversation',
        'start' => "<span class='me-1'>Started by</span> :name<span class='me-1'>,</span> :date",
        'last' => "<span class='me-1'>Last</span> <a class='conversation-link me-1' href=':link' title='View last message'>message</a> <span class='me-1'>by</span> :name<span class='me-1'>,</span> :date",
    ],
    'empty' => 'You have no conversations.',
    'enable' => 'Enable conversations.',
    'show' => [
        'title' => ':title',
    ],
    'create' => [
        'start' => 'Start a New Conversation with :user',
        'title' => 'New conversation - :user',
        'button' => 'Start a conversation',
        'subject' => 'Conversation title'
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
        'description' => 'Impossible to read this conversation.'
    ],
    'error_create_self' => [
        'title' => 'Error',
        'description' => 'You can\'t do this action.'
    ],
    'cooldown' => [
        'title' => 'Error',
        'description' => 'You must wait :seconds seconds between each message.'
    ],
    'create_success' => [
        'title' => 'New conversation',
        'description' => 'You have just created a new conversation.'
    ],
    'textarea' => [
        'label' => '',
        'submit' => 'Post reply',
    ],
    'send_success' => [
        'title' => 'New reply',
        'description' => 'You have just sent a reply'
    ],
    'auto' => [
        'title' => 'Auto Response',
        'permission' => 'You do not have permission to use automatic answers. You must have the role :role. Click <a href="">here</a> to upgrade your account.',
        'success' => [
            'title' => 'Update Auto Response',
            'description' => 'Update your auto response.'
        ],
        'enable' => 'Activate the auto response.',
        'info' => 'auto-reply',
    ],
];
