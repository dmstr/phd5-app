<?php

use yii\rbac\Item;

/**
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2025 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class m250416_101010_rbac extends \dmstr\rbacMigration\Migration
{

    // copied from godzilla, modified for new filemanager
    public $defaultFlags = [
        'ensure' => self::PRESENT
    ];

    public $privileges = [
        [
            'name'        => 'FilemanagerPublic',
            'description' => 'Allows you to stream and download images or files',
            'type'        => Item::TYPE_ROLE,
            'children'    => [
                [
                    'name'        => 'filemanager_api_stream',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'View images or files'
                ],
                [
                    'name'        => 'filemanager_api_download',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'Download images or files'
                ]
            ]
        ],
        [
            'name'        => 'FilemanagerEditor',
            'description' => 'Allows you to upload, rename and delete images or files',
            'type'        => Item::TYPE_ROLE,
            'children'    => [
                [
                    'name'        => 'filemanager',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'Access Filemanager module'
                ],
                [
                    'name'        => 'FilemanagerDefault',
                    'type'        => Item::TYPE_ROLE,
                    'description' => 'Access Filemanager actions'
                ],
            ]
        ],
        [
            'name'     => 'FilemanagerMaster',
            'type'     => Item::TYPE_ROLE,
            'description' => 'Master Role for filemanager module',
            'children' => [
                [
                    'name'   => 'FilemanagerEditor',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ],
                [
                    'name'        => 'FilemanagerPermissions',
                    'type'        => Item::TYPE_ROLE,
                    'description' => 'Allows you to set Filemanager permissions'
                ]
            ]
        ],
        [
            'name'        => 'WidgetEditor',
            'description' => 'Allows create and change widgets',
            'type'        => Item::TYPE_ROLE,
            'children'    => [
                [
                    'name'        => 'widgets-cell-edit',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'Allows frontend editing of widget content'
                ],
                [
                    'name'        => 'frontend.toggle-view-mode',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'Hide and show widget cell edit items'
                ],
                [
                    'name'        => 'widgets_default_index',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'Access widgets overview page'
                ],
                [
                    'name'        => 'widgets_test',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'Access widgets test page'
                ],
                [
                    'name'        => 'widgets_crud_widget',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'Access widgets content pages'
                ],
            ]
        ],
        [
            'name'        => 'WidgetMaster',
            'description' => 'Allows create and change widgets and templates',
            'type'        => Item::TYPE_ROLE,
            'children'    => [
                [
                    'name'   => 'WidgetEditor',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ],
                [
                    'name'        => 'widgets_crud_widget-template',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'Access widgets template pages'
                ],
                [
                    'name'        => 'widgets_crud_widget-translation',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'Access widgets translation pages'
                ]
            ]
        ],
        [
            'name'        => 'UserMaster',
            'type'        => Item::TYPE_ROLE,
            'description' => 'Allows access to the user module',
            'children'    => [
                [
                    'name'        => 'user-module',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'Access user module',
                    'children'    => [
                        [
                            'name'        => 'user',
                            'type'        => Item::TYPE_PERMISSION,
                            'description' => 'Access user pages'
                        ],
                    ]
                ]
            ]
        ],
        [
            'name'        => 'PagesPublic',
            'type'        => Item::TYPE_ROLE,
            'description' => 'Allow access to pages page',
            'children'    => [
                [
                    'name'        => 'pages_default_page',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'Access any pages page'
                ]
            ]
        ],
        [
            'name'        => 'PagesEditor',
            'type'        => Item::TYPE_ROLE,
            'description' => 'Allow access to pages admin interface',
            'children'    => [
                [
                    'name'        => 'pages',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'Access pages crud page'
                ]
            ]
        ],
        [
            'name'        => 'SettingsEditor',
            'type'        => Item::TYPE_ROLE,
            'description' => 'Allow access to settings page',
            'children'    => [
                [
                    'name'        => 'settings-module',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'Access settings module'
                ],
                [
                    'name'        => 'settings',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'Access settings pages'
                ]
            ]
        ],
        [
            'name'        => 'BackendEditor',
            'type'        => Item::TYPE_ROLE,
            'description' => 'Allow access to backend',
            'children'    => [
                [
                    'name'        => 'backend_default_index',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'Access backend overview page'
                ],
                [
                    'name'        => 'backend_cache_flush',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'Allow cache flush'
                ]
            ]
        ],
        [
            'name'        => 'BackendMaster',
            'type'        => Item::TYPE_ROLE,
            'description' => 'Allow access to backend and config pages',
            'children'    => [
                [
                    'name'        => 'backend',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'Access backend overview page'
                ],
                [
                    'name'        => 'Admin',
                    'type'        => Item::TYPE_ROLE,
                    'description' => 'Show config pages in backend module'
                ]
            ]
        ],
        [
            'name'        => 'AuditMaster',
            'type'        => Item::TYPE_ROLE,
            'description' => 'Allow access to audit page',
            'children'    => [
                [
                    'name'        => 'audit',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'Allow access to audit pages'
                ],
                [
                    'name'        => 'audit-module',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'Allow access to audit module'
                ]
            ]
        ],
        [
            'name'        => 'ContactPublic',
            'type'        => Item::TYPE_ROLE,
            'description' => 'Access contact form and done page',
            'children'    => [
                [
                    'name' => 'contact_default_index',
                    'type' => Item::TYPE_PERMISSION
                ],
                [
                    'name' => 'contact_default_done',
                    'type' => Item::TYPE_PERMISSION
                ]
            ]
        ],
        [
            'name'        => 'ContactEditor',
            'type'        => Item::TYPE_ROLE,
            'description' => 'Access contact crud pages',
            'children'    => [
                [
                    'name' => 'contact',
                    'type' => Item::TYPE_PERMISSION
                ]
            ]
        ],
        [
            'name'        => 'PublicationPublic',
            'type'        => Item::TYPE_ROLE,
            'description' => 'Access publication index and detail page',
            'children'    => [
                [
                    'name' => 'publication_default_index',
                    'type' => Item::TYPE_PERMISSION
                ],
                [
                    'name' => 'publication_default_detail',
                    'type' => Item::TYPE_PERMISSION
                ]
            ]
        ],
        [
            'name'        => 'PublicationEditor',
            'type'        => Item::TYPE_ROLE,
            'description' => 'Access publication pages',
            'children'    => [
                [
                    'name'   => 'PublicationPublic',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ],
                [
                    'name' => 'publication_crud',
                    'type' => Item::TYPE_PERMISSION
                ],
                [
                    'name' => 'publication_crud_publication-category',
                    'type' => Item::TYPE_PERMISSION
                ],
                [
                    'name' => 'publication_crud_publication-item',
                    'type' => Item::TYPE_PERMISSION
                ],
                [
                    'name' => 'publication_crud_publication-tag',
                    'type' => Item::TYPE_PERMISSION
                ],
                [
                    'name'        => 'lang:de',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'Allow access to "de" items'
                ]
            ]
        ],
        [
            'name'        => 'RedirectsEditor',
            'type'        => Item::TYPE_ROLE,
            'description' => 'Access redirect pages',
            'children'    => [
                [
                    'name' => 'redirects',
                    'type' => Item::TYPE_PERMISSION
                ]
            ]
        ],
        [
            'name'        => 'PrototypeEditor',
            'type'        => Item::TYPE_ROLE,
            'description' => 'Access prototype pages',
            'children'    => [
                [
                    'name' => 'prototype',
                    'type' => Item::TYPE_PERMISSION
                ]
            ]
        ],
        [
            'name'        => 'QueueMaster',
            'type'        => Item::TYPE_ROLE,
            'description' => 'Access queue pages',
            'children'    => [
                [
                    'name' => 'queue',
                    'type' => Item::TYPE_PERMISSION
                ],
                [
                    'name' => 'queuemanager-module',
                    'type' => Item::TYPE_PERMISSION
                ]
            ]
        ],
        [
            'name'        => 'ResqueMaster',
            'type'        => Item::TYPE_ROLE,
            'description' => 'Access resque pages',
            'children'    => [
                [
                    'name' => 'resque',
                    'type' => Item::TYPE_PERMISSION
                ]
            ]
        ],
        [
            'name'        => 'TranslatemanagerEditor',
            'type'        => Item::TYPE_ROLE,
            'description' => 'Access translatemanager pages',
            'children'    => [
                [
                    'name' => 'translatemanager',
                    'type' => Item::TYPE_PERMISSION
                ],
                [
                    'name' => 'translate-module',
                    'type' => Item::TYPE_PERMISSION
                ]
            ]
        ],
        [
            'name'        => 'Guest',
            'type'        => Item::TYPE_ROLE,
            'description' => 'Automatically assigned to any user who is not logged in',
            'children'    => [
                [
                    'name'   => 'FilemanagerPublic',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ]
            ]
        ],
        [
            'name'        => 'Preview',
            'type'        => Item::TYPE_ROLE,
            'description' => 'Contains all needed privileges. Assign this role to Guest open it for everyone',
            'children'    => [
                [
                    'name'        => 'app_site',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'Access the home page'
                ],
                [
                    'name'   => 'ContactPublic',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ],
                [
                    'name'   => 'PagesPublic',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ],
                [
                    'name'   => 'PublicationPublic',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ]
            ]
        ],
        [
            'name'        => 'Editor',
            'type'        => Item::TYPE_ROLE,
            'description' => 'CMS users to maintain site content',
            'children'    => [
                [
                    'name'   => 'Preview',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ],
                [
                    'name'        => 'access.defaults.updateDelete:Editor',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'Automatically set role for update and delete to Editor'
                ],
                [
                    'name'        => 'docs',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'Access docs page'
                ],
                [
                    'name'   => 'BackendEditor',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ],
                [
                    'name'   => 'FilemanagerEditor',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ],
                [
                    'name'   => 'WidgetEditor',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ],
                [
                    'name'   => 'PagesEditor',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ],
                [
                    'name'   => 'SettingsEditor',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ],
                [
                    'name'   => 'ContactEditor',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ],
                [
                    'name'   => 'PublicationPublic',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ],
                [
                    'name'   => 'RedirectsEditor',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ],
                [
                    'name'   => 'PrototypeEditor',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ],
                [
                    'name'   => 'TranslatemanagerEditor',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ],
                [
                    'name'   => 'PublicationEditor',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ]
            ]
        ],
        [
            'name'        => 'Master',
            'type'        => Item::TYPE_ROLE,
            'description' => 'Can perform almost all CMS tasks',
            'children'    => [
                [
                    'name'   => 'Editor',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ],
                [
                    'name'   => 'BackendMaster',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ],
                [
                    'name'        => 'access.defaults.updateDelete:Master',
                    'type'        => Item::TYPE_PERMISSION,
                    'description' => 'Automatically set role for update and delete to Editor'
                ],
                [
                    'name'   => 'FilemanagerMaster',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ],
                [
                    'name'   => 'WidgetMaster',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ],
                [
                    'name'   => 'UserMaster',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ],
                [
                    'name'   => 'AuditMaster',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ],
                [
                    'name'   => 'QueueMaster',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ],
                [
                    'name'   => 'ResqueMaster',
                    'type'   => Item::TYPE_ROLE,
                    'ensure' => self::MUST_EXIST
                ]
            ]
        ]
    ];


}