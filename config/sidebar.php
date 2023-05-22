<?php

use App\Models\UserRole;

return [

    'elements' => [

        'management' => [

            'title' => 'Gestion',
            'routes' => [
                'users' => [
                    'name' => 'Utilisateurs',
                    'route' => 'admin.users.index',
                    'icon' => 'fas fa-users fa-chart-area',
                    'power' => UserRole::ADMIN
                ],
            ],

        ],

        'seo' => [

            'title' => 'SEO',
            'routes' => [

            ]
        ],

        'stats' => [
            'title' => 'Statistiques',
            'routes' => [

            ],
        ],

        'others' => [

            'title' => 'Autres',
            'routes' => [

            ],

        ],

    ],

];
