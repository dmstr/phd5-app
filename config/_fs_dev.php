<?php

/**
 * dev config for the new eluhr/yii2-flysystem-rest-api
 */


/**
 * This is a sample dev config for eluhr/yii2-flysystem package development
 *
 * To include this config in your app, you'll have to:
 * - add this config and the migration path in your local.env
 *   ```
 *   APP_CONFIG_FILE=@root/config/_fs_dev.php
 *   APP_MIGRATION_LOOKUP=@vendor/eluhr/yii2-flysystem-rest-api/src/migrations
 *   ```
 * - add host-volume in your dev docker-compose file(s) with permissions, so that the webserver can write in
 *   example:
 *   ```
 *   # fs dev local fs
 *   - ./_host-volumes/storage/fs-local:/mnt/storage/fs-local:delegated
 *   ```
 */

use eluhr\flysystemRestApi\plugins\AvPlugin;
use eluhr\flysystemRestApi\plugins\ClipBoardValuesPlugin;
use eluhr\flysystemRestApi\plugins\FileExtensionPlugin;
use eluhr\flysystemRestApi\plugins\FilePreviewPlugin;
use eluhr\flysystemRestApi\plugins\MimeTypePlugin;
use eluhr\flysystemRestApi\plugins\ThumbnailPlugin;
use yii\helpers\Url;

return [
    'components' => [
        // this is the component for one filesystem
        'fsLocal' => [
            'class' => \eluhr\flysystemRestApi\components\FileStorage::class,
            'storageId' => 'fsLocal',
            # overwrite defaultRootNodePermission options, see: \eluhr\flysystemRestApi\components\FileStorage::$_defaultRootNodePermissions
            'rootNodePermissions' => [
                'permission_group_name' => 'FilemanagerEditor'
            ],
            # should owner be inherited from parent(s)? default is true
            'inheritOwner' => true,
            # if set, users in this role will be granted all permissions without any check (like 'root' on unix), so handle with care!
            'adminRole' => 'FilemanagerMaster',
            'canSetPermissionRole' => 'FilemanagerPermissions',
            'adapter' => function () {
                $path = getenv('FILEMANAGER_FS_LOCAL_ROOT') ? rtrim(getenv('FILEMANAGER_FS_LOCAL_ROOT'), '/') : '/mnt/storage';
                return new League\Flysystem\Local\LocalFilesystemAdapter(
                    $path,
                    lazyRootCreation: true
                );
            },
            // these are examples for 'storage plugins'
            'storageItemPlugins' => [
               MimeTypePlugin::class,
                FileExtensionPlugin::class,
                [
                    'class' => ClipBoardValuesPlugin::class,
                    'callbacks' => [

                        'url' => function ($item) {
                            if ($item->type === 'file') {
                                $route = '/img/download';
                                if (in_array(pathinfo($item->name, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg'])) {
                                    $route = '/img/stream';
                                }
                                return Url::to(
                                    [
                                        $route,
                                        'path' => implode(DIRECTORY_SEPARATOR, array_filter([$item->path, $item->name]))
                                    ]
                                );
                            }
                            return null;
                        },
                        'url2' => function ($item) {
                            if ($item->type === 'file') {
                                $route = '/img/download';
                                if (in_array(pathinfo($item->name, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg'])) {
                                    $route = '/img/stream';
                                }
                                return Url::to(
                                    [
                                        $route,
                                        'path' => implode(DIRECTORY_SEPARATOR, array_filter([$item->path, $item->name]))
                                    ]
                                );
                            }
                            return null;
                        },
                        'url3' => function ($item) {
                            if ($item->type === 'dir') {
                                return implode(DIRECTORY_SEPARATOR, array_filter([$item->path, $item->name]));
                            }
                            return null;
                        }
                    ]
                ],
                [
                    'class' => FilePreviewPlugin::class,
                    'urlCallback' => function ($item) {
                        if ($item->type === 'file') {
                            return Url::to(['/img/stream', 'path' => implode(DIRECTORY_SEPARATOR, array_filter([$item->path, $item->name]))]);
                        }
                        return null;
                    }
                ],
                [
                    'class' => ThumbnailPlugin::class,
                    'urlCallback' => function ($item) {
                        if ($item->type === 'file' && in_array(pathinfo($item->name, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg', 'gif'])) {
                            return Url::to(['/img/stream', 'path' => implode(DIRECTORY_SEPARATOR, array_filter([$item->path, $item->name]))]);
                        }
                        return null;
                    }
                ],
                'class' => AvPlugin::class,
            ],
        ],
        'urlManager' => [
            'rules' => [
                'img/stream' => 'filemanager/api/stream',
                'img/download' => 'filemanager/api/download',
                'filemanager/backend' => 'filemanager-backend',
            ],
            'ignoreLanguageUrlPatterns' => [
                '#^img/stream#' => '#^img/stream#',
                '#^img/download#' => '#^img/download#',
                '#filemanager/api#' => '#filemanager/api#'
            ],
        ],
    ],
    'modules' => [
        // this is the rest-api module, which requires a valid flysystemRestApi\components\FileStorage id
        // for dev we have a simple backend controller inside this module, but this should be splitted...
        'filemanager' => [
            'class' => eluhr\flysystemRestApi\Module::class,
            'fileStorage' => 'fsLocal',
            'jwtComponent' => 'jwtSystem'
        ],
    ],
];
