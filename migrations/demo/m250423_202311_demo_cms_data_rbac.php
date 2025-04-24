<?php

use dmstr\rbacMigration\Migration;
use yii\rbac\Item;

class m250423_202311_demo_cms_data_rbac extends Migration
{
    public $defaultFlags = [
        'ensure' => self::PRESENT
    ];
    public $privileges = [
        'access.defaults.updateDelete:Master',
        'access.defaults.updateDelete:null',
        [
            'name' => 'Admin',
            'type' => Item::TYPE_ROLE
        ],
        'app_site',
        [
            'name' => 'AuditMaster',
            'type' => Item::TYPE_ROLE,
            'children' => [
                'audit',
                'audit-module'
            ]
        ],
        [
            'name' => 'BackendEditor',
            'type' => Item::TYPE_ROLE,
            'children' => [
                'backend_cache_flush',
                'backend_default_index'
            ]
        ],
        [
            'name' => 'BackendMaster',
            'type' => Item::TYPE_ROLE,
            'children' => [
                [
                    'name' => 'Admin',
                    'type' => Item::TYPE_ROLE
                ],
                'backend'
            ]
        ],
        'contact',
        'contact_crud_contact-template',
        'contact_default',
        'contact_default_done',
        'contact_default_index',
        [
            'name' => 'ContactEditor',
            'type' => Item::TYPE_ROLE,
            'children' => [
                'contact'
            ]
        ],
        [
            'name' => 'ContactPublic',
            'type' => Item::TYPE_ROLE,
            'children' => [
                'contact_default_done',
                'contact_default_index'
            ]
        ],
        [
            'name' => 'Default',
            'type' => Item::TYPE_ROLE
        ],
        [
            'name' => 'Editor',
            'type' => Item::TYPE_ROLE,
            'children' => [
                [
                    'name' => 'access.defaults.domain:global',
                    'children' => [
                        'access.availableDomains:any'
                    ]
                ],
                'access.defaults.updateDelete:Editor',
                'backend',
                'backend_default_index',
                [
                    'name' => 'BackendEditor',
                    'type' => Item::TYPE_ROLE,
                ],
                [
                    'name' => 'ContactEditor',
                    'type' => Item::TYPE_ROLE,
                ],
                [
                    'name' => 'FileflyDefault',
                    'type' => Item::TYPE_ROLE,
                ],
                [
                    'name' => 'Preview',
                    'type' => Item::TYPE_ROLE,
                    'children' => [
                        'app_site',
                        'contact_default',
                        'filefly_api_download',
                        'filefly_api_stream',
                        'pages_default_page',
                        [
                            'name' => 'ContactPublic',
                            'type' => Item::TYPE_ROLE,
                        ],
                        [
                            'name' => 'PagesPublic',
                            'type' => Item::TYPE_ROLE,
                        ],
                        [
                            'name' => 'PublicationPublic',
                            'type' => Item::TYPE_ROLE,
                        ]
                    ]
                ],
                'prototype',
                [
                    'name' => 'PrototypeEditor',
                    'type' => Item::TYPE_ROLE
                ],
                [
                    'name' => 'PublicationEditor',
                    'type' => Item::TYPE_ROLE,
                    [
                        'name' => 'PublicationEditor',
                        'type' => Item::TYPE_ROLE,
                        'children' => [
                            'lang:de',
                            'publication_crud',
                            'publication_crud_publication-category',
                            'publication_crud_publication-item',
                            'publication_crud_publication-tag',
                            [
                                'name' => 'PublicationPublic',
                                'type' => Item::TYPE_ROLE,
                                'children' => [
                                    'publication_default_detail',
                                    'publication_default_index'
                                ]
                            ],
                        ]
                    ],
                ],
                [
                    'name' => 'RedirectsEditor',
                    'type' => Item::TYPE_ROLE
                ],
                [
                    'name' => 'SettingsEditor',
                    'type' => Item::TYPE_ROLE
                ],
                [
                    'name' => 'TranslatemanagerEditor',
                    'type' => Item::TYPE_ROLE
                ],
                [
                    'name' => 'WidgetEditor',
                    'type' => Item::TYPE_ROLE
                ],
                'translate-module',
                'widgets',
                'widgets-cell-edit'
            ]
        ],

        [
            'name' => 'FileflyMaster',
            'type' => Item::TYPE_ROLE,
            'children' => [
                [
                    'name' => 'FileflyAdmin',
                    'type' => Item::TYPE_ROLE,
                    'children' => [
                        [
                            'name' => 'FileflyDefault',
                            'type' => Item::TYPE_ROLE,
                            'children' => [
                                'filefly'
                            ]
                        ],
                        [
                            'name' => 'FileflyApi',
                            'type' => Item::TYPE_ROLE,
                            'children' => [
                                [
                                    'name' => 'FileflyDefault',
                                    'type' => Item::TYPE_ROLE
                                ]
                            ]
                        ],
                        [
                            'name' => 'FileflyPermissions',
                            'type' => Item::TYPE_ROLE,
                            'children' => [
                                'filefly',
                            ]
                        ]
                    ]
                ],
                [
                    'name' => 'FileflyEditor',
                    'type' => Item::TYPE_ROLE,
                    'children' => [
                        'filefly',
                        [
                            'name' => 'FileflyDefault',
                            'type' => Item::TYPE_ROLE
                        ]
                    ]
                ]
            ]
        ],

        [
            'name' => 'FileflyPublic',
            'type' => Item::TYPE_ROLE,
            'children' => [
                'filefly_api_download',
                'filefly_api_stream',
            ]
        ],
        [
            'name' => 'Guest',
            'type' => Item::TYPE_ROLE,
            'children' => [
                [
                    'name' => 'FileflyPublic',
                    'type' => Item::TYPE_ROLE
                ]
            ]
        ],
        [
            'name' => 'Master',
            'type' => Item::TYPE_ROLE,
            'children' => [
                'access.defaults.updateDelete:Master',
                [
                    'name' => 'Admin',
                    'type' => Item::TYPE_ROLE
                ],
                [
                    'name' => 'AuditMaster',
                    'type' => Item::TYPE_ROLE
                ],
                [
                    'name' => 'BackendMaster',
                    'type' => Item::TYPE_ROLE
                ],
                [
                    'name' => 'Editor',
                    'type' => Item::TYPE_ROLE
                ],
                [
                    'name' => 'FileflyAdmin',
                    'type' => Item::TYPE_ROLE
                ],
                [
                    'name' => 'FileflyMaster',
                    'type' => Item::TYPE_ROLE
                ],
                [
                    'name' => 'QueueMaster',
                    'type' => Item::TYPE_ROLE
                ],
                [
                    'name' => 'ResqueMaster',
                    'type' => Item::TYPE_ROLE
                ],
                [
                    'name' => 'UserMaster',
                    'type' => Item::TYPE_ROLE
                ],
                [
                    'name' => 'WidgetMaster',
                    'type' => Item::TYPE_ROLE
                ],
                'audit-module',
                'contact_crud_contact-template',
                'user-module',
            ]
        ],
        [
            'name' => 'PagesEditor',
            'type' => Item::TYPE_ROLE,
            'children' => [
                'pages'
            ]
        ],
        [
            'name' => 'PagesPublic',
            'type' => Item::TYPE_ROLE,
            'children' => [
                'pages_default_page'
            ]
        ],
        [
            'name' => 'PrototypeEditor',
            'type' => Item::TYPE_ROLE,
            'children' => [
                'prototype'
            ]
        ],
        [
            'name' => 'QueueMaster',
            'type' => Item::TYPE_ROLE,
            'children' => [
                'queue',
                'queuemanager-module',
            ]
        ],
        'redirects',
        [
            'name' => 'RedirectsEditor',
            'type' => Item::TYPE_ROLE,
            'children' => [
                'redirects'
            ]
        ],
        [
            'name' => 'ResqueMaster',
            'type' => Item::TYPE_ROLE,
            'children' => [
                'resque',
            ]
        ],
        [
            'name' => 'SettingsEditor',
            'type' => Item::TYPE_ROLE,
            'children' => [
                'settings',
                'settings-module',
            ]
        ],
        [
            'name' => 'TranslatemanagerEditor',
            'type' => Item::TYPE_ROLE,
            'children' => [
                'translate-module',
                'translatemanager',
            ]
        ],
        [
            'name' => 'UserMaster',
            'type' => Item::TYPE_ROLE,
            'children' => [
                'user',
                'user-module',
            ]
        ],
        [
            'name' => 'WidgetMaster',
            'type' => Item::TYPE_ROLE,
            'children' => [
                'widgets_crud_widget-template',
                'widgets_crud_widget-translation',
                [
                    'name' => 'WidgetEditor',
                    'type' => Item::TYPE_ROLE,
                    'children' => [
                        'frontend.toggle-view-mode',
                        'widgets_crud_widget',
                        'widgets_default_index',
                        'widgets_test',
                        'widgets-cell-edit'
                    ]
                ],
            ]
        ],
    ];
}
