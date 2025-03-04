<?php

return [
    'title' => 'Payments',
    'nav' => 'Manage Your Payments',
    'description' => 'Manage your payment information here',
    'button' => 'BUY NOW',
    'how' => 'How do you want to pay?',

    'cancel' => 'Checkout Cancel',

    'details' => 'Your Details',
    'order' => 'Your Order',

    'content' => 'Content',
    'resource' => 'Resource',
    'price' => 'Price',
    'quantity' => 'Quantity',
    'total' => 'Total',
    'total_end' => 'Total:',
    'subtotal' => 'Subtotal:',
    'gift' => [
        'title' => 'Gift Code',
        'placeholder' => 'Enter Gift Code',
        'error' => 'Unable to validate the gift code. You cannot use it.'
    ],

    'stripe' => [
        'title' => 'Stripe',
        'sk_live' => 'Stripe Public Key',
        'pk_live' => 'Stripe Secret Key',
        'info' => 'Create key here: <a target="_blank" href="https://dashboard.stripe.com/apikeys">https://dashboard.stripe.com/apikeys</a>',
        'success' => [
            'title' => 'Update Completed',
            'description' => 'Update of your Stripe information'
        ],
        'delete' => [
            'title' => 'Delete Successful',
            'description' => 'Deletion of your Stripe information'
        ],
        'error_sk_live' => [
            'title' => 'Error',
            'description' => 'SK live key is not valid'
        ],
        'error_pk_live' => [
            'title' => 'Error',
            'description' => 'PK live key is not valid'
        ],
        'error_api' => [
            'title' => 'Error',
            'description' => 'Error with Stripe API'
        ],
    ],

    'paypal' => [
        'title' => 'PayPal',
        'email' => 'PayPal Email',
        'info' => 'Note: PayPal is less secure than Stripe. Customers can dispute without reason, and the tax on payments is also greater. We advise you to use Stripe.',
        'success' => [
            'title' => 'Update Completed',
            'description' => 'Update of your PayPal email'
        ],
        'delete' => [
            'title' => 'Delete Successful',
            'description' => 'Deletion of your PayPal information'
        ],
    ],

    'currency' => [
        'title' => 'Currency',
        'success' => [
            'title' => 'Update Completed',
            'description' => 'Update of your currency'
        ],
    ],

    'success' => [
        'title' => 'Successful Payment!',
        'info' => 'Your payment has been accepted. It will take a few more minutes to validate.',
    ],

    'dashboard' => [
        'buyer' => 'Buyer',
        'earning' => 'Your Earnings',
        'date' => 'Date',
        'transaction' => 'Transaction ID',
        'gateway' => 'Gateway'
    ],
];
