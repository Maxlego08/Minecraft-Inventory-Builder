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
                'inventories' => [
                    'name' => 'Inventaires',
                    'route' => 'admin.inventories.index',
                    'icon' => 'fas fa-folder',
                    'power' => UserRole::MODERATOR
                ],
                'folders' => [
                    'name' => 'Dossiers',
                    'route' => 'admin.inventories.folders.index',
                    'icon' => 'fas fa-folder-open',
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
                'gifts' => [
                    'name' => "Codes cadeaux",
                    'route' => 'admin.gift.index',
                    'icon' => 'fas fa-gifts',
                    'power' => UserRole::ADMIN
                ],
                'addons' => [
                    'name' => "Addons",
                    'route' => 'admin.addons.index',
                    'icon' => 'fas fa-plug',
                    'power' => UserRole::ADMIN
                ],
                'actions' => [
                    'name' => "Actions",
                    'route' => 'admin.actions.index',
                    'icon' => 'fas fa-bolt',
                    'power' => UserRole::ADMIN
                ],
                'buttons' => [
                    'name' => "Boutons",
                    'route' => 'admin.buttons.index',
                    'icon' => 'fas fa-map-marker-alt',
                    'power' => UserRole::ADMIN
                ],
                'statistics' => [
                    'name' => "Statistiques",
                    'route' => 'admin.statistics',
                    'icon' => 'fas fa-chart-line',
                    'power' => UserRole::ADMIN
                ],
                'videos' => [
                    'name' => "Vidéos",
                    'route'=> 'admin.videos.index',
                    'icon' => 'fas fa-video',
                    'power' => UserRole::ADMIN
                ],
                'heads' => [
                    'name' => 'Têtes',
                    'route' => 'admin.heads.index',
                    'icon' => 'fas fa-skull',
                    'power' => UserRole::ADMIN
                ]
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
