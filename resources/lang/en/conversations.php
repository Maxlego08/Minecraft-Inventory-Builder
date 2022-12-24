<?php

return [
    'title' => 'Conversations',
    'list' => [
        'title' => 'See the conversation',
        'start' => 'Started by :name :date',
        'last' => "Last <a class='conversation-link' href=':link#last' title='View last message'>message</a> by :name :date",
    ],
    'show' => [
        'title' => ':title',
    ],
    'create' => [
        'start' => 'Start a New Conversation with :user',
        'title' => 'New conversation - :user',
        'button' => 'Start a conversation',
        'subject' => 'Conversation title'
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
];
