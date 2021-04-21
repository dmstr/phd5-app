<?php

namespace app\views\layouts;

use dmstr\modules\pages\models\Tree;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use Yii;

// initialize local variables
$menuItems = [];
$languageItems = [];


// prepare languages
foreach (Yii::$app->urlManager->languages as $language) {
    $languageItems[] = [
        'url' => ['/', Yii::$app->urlManager->languageParam => $language],
        'label' => $language,
    ];
}

// add language items to menu
$menuItems[] = [
    'label' =>  Yii::t('app', '{icon} {language}', [
        'icon' => '<i class="glyphicon glyphicon-globe"></i>',
        'language' => Yii::$app->language
    ]),
    'options' => ['id' => 'link-languages-menu'],
    'items' => $languageItems,
];

// build user menu
if (Yii::$app->hasModule('user')) {
    if (Yii::$app->user->isGuest) {
        // unauthorized users
        //$menuItems[] = ['label' => 'Signup', 'url' => ['/user/registration/register']];
        $menuItems[] = [
            'label' => Yii::t('app', 'Login'),
            'url' => ['/user/security/login'],
            'linkOptions' => ['id' => 'link-login'],
        ];
    } else {
        // logged in users
        $menuItems[] = [
            'label' => Yii::t('app', '{icon} {username}', [
                'icon' => '<i class="glyphicon glyphicon-user"></i>',
                'username' => Yii::$app->user->identity->username
            ]),
            'options' => ['id' => 'link-user-menu'],
            'items' => [
                [
                    'label' => Yii::t('app', '{icon} Profile', [
                        'icon' => '<i class="glyphicon glyphicon-user"></i>'
                    ]),
                    'url' => ['/user/profile/show', 'id' => Yii::$app->user->id],
                ],
                [
                    'label' => Yii::t('app', '{icon} Settings', [
                        'icon' => '<i class="glyphicon glyphicon-cog"></i>'
                    ]),
                    'url' => ['/user/settings/profile'],
                ],
                '<li class="divider"></li>',
                [
                    'label' => Yii::t('app', '{icon} Logout', [
                        'icon' => '<i class="glyphicon glyphicon-log-out"></i>'
                    ]),
                    'url' => ['/user/security/logout'],
                    'linkOptions' => ['data-method' => 'post', 'id' => 'link-logout'],
                ],
            ],
        ];
    }
}

// render navigation
NavBar::begin(
    [
        'brandLabel' => getenv('APP_TITLE'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-default navbar-fixed',
        ],
    ]
);

// render root pages
echo Nav::widget(
    [
        'options' => ['class' => 'navbar-nav'],
        'encodeLabels' => false,
        'items' => Tree::getMenuItems('root'),
    ]
);

// render additional menu items (languages, user)
echo Nav::widget(
    [
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => $menuItems,
    ]
);

NavBar::end();
