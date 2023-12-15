<?php


return [

    'title' => 'Payments',
    'nav' => 'Manage your payments',
    'description' => 'Gérer vos informations de paiement ici',
    'button' => 'BUY NOW',
    'how' => 'How do you want to pay ?',

    'cancel' => 'Checkout Cancel',

    'details' => 'Your Details',
    'order' => 'Your Order',

    'resource' => 'Resource',
    'price' => 'Price',
    'quantity' => 'Quantity',
    'total' => 'Total',
    'total_end' => 'Total:',
    'subtotal' => 'Subtotal:',
    'gift' => [
        'title' => 'Gift code',
        'placeholder' => 'Enter gift code',
        'error' => 'Unable to validate the gift code. You cannot use it.'
    ],

    'stripe' => [
        'title' => 'Stripe',
        'sk_live' => 'Stripe Public Key',
        'pk_live' => 'Stripe Secret Key',
        'info' => 'Create key here: <a target="_blank" href="https://dashboard.stripe.com/apikeys">https://dashboard.stripe.com/apikeys</a>',
        'success' => [
            'title' => 'Update completed',
            'description' => 'Update of your stripe informations'
        ],
        'delete' => [
            'title' => 'Delete successfully',
            'description' => 'Deletion of your stripe information'
        ],
        'error_sk_live' => [
            'title' => 'Error',
            'description' => 'Sk live key is no valide'
        ],
        'error_pk_live' => [
            'title' => 'Error',
            'description' => 'Pk live key is no valide'
        ],
        'error_api' => [
            'title' => 'Error',
            'description' => 'Error with Stripe API'
        ],
    ],

    'paypal' => [
        'title' => 'Paypal',
        'email' => 'Paypal email',
        'info' => 'Attention, paypal is less secure than stripe. Customers can dispute without reason, the tax on payments is also greater. We advise you to use stripe',
        'success' => [
            'title' => 'Update completed',
            'description' => 'Update of your paypal email'
        ],
        'delete' => [
            'title' => 'Delete successfully',
            'description' => 'Deletion of your paypal information'
        ],
    ],

    'currency' => [
        'title' => 'Currency',
        'success' => [
            'title' => 'Update completed',
            'description' => 'Update of your currency'
        ],
    ],

    'success' => [
        'title' => 'Successful payment !',
        'info' => 'Your payment has been accepted, another few minutes for it to validate.',
    ],

];
