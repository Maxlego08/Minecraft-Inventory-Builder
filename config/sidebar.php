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
                'resources' => [
                    'name' => 'Ressources',
                    'route' => 'admin.resources.index',
                    'icon' => 'fas fa-puzzle-piece',
                    'power' => UserRole::MODERATOR
                ],
                'resources_pending' => [
                    'name' => 'Ressources en attente',
                    'route' => 'admin.resources.pending',
                    'icon' => 'fas fa-pause-circle',
                    'power' => UserRole::MODERATOR
                ],
                'payments' => [
                    'name' => 'Payments',
                    'route' => 'admin.payments.index',
                    'icon' => 'fas fa-dollar-sign fa-chart-area',
                    'power' => UserRole::ADMIN
                ],
                'conversations' => [
                    'name' => "Conversations",
                    'route' => 'admin.conversations.index',
                    'icon' => 'fas fa-comments',
                    'power' => UserRole::MODERATOR
                ],
                'reports' => [
                    'name' => "Signalement",
                    'route' => 'admin.reports.index',
                    'icon' => 'fas fa-exclamation-triangle',
                    'power' => UserRole::MODERATOR
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
                'logs' => [
                    'name' => 'Logs',
                    'route' => 'admin.logs.index',
                    'icon' => 'fas fa-fw fa-history',
                    'power' => UserRole::MODERATOR
                ],
            ],

        ],

    ],

];
