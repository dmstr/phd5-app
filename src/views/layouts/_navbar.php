<?php

namespace app\views\layouts;

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

// initialize local variables
$menuItems = [];
$languageItems = [];


// prepare languages
foreach (\Yii::$app->urlManager->languages as $language) {
    $languageItems[] = [
        'url' => ['/', \Yii::$app->urlManager->languageParam => $language],
        'label' => $language,
    ];
}

// add language items to menu
$menuItems[] = [
    'label' => '<i class="glyphicon glyphicon-globe"></i> '.\Yii::$app->language,
    'options' => ['id' => 'link-languages-menu'],
    'items' => $languageItems,
];

// build user menu
if (\Yii::$app->hasModule('user')) {
    if (\Yii::$app->user->isGuest) {
        // unauthorized users
        //$menuItems[] = ['label' => 'Signup', 'url' => ['/user/registration/register']];
        $menuItems[] = [
            'label' => 'Login',
            'url' => ['/user/security/login'],
            'linkOptions' => ['id' => 'link-login'],
        ];
    } else {
        // logged in users
        $menuItems[] = [
            'label' => '<i class="glyphicon glyphicon-user"></i> '.\Yii::$app->user->identity->username,
            'options' => ['id' => 'link-user-menu'],
            'items' => [
                [
                    'label' => '<i class="glyphicon glyphicon-user"></i> Profile',
                    'url' => ['/user/profile/show', 'id' => \Yii::$app->user->id],
                ],
                [
                    'label' => '<i class="glyphicon glyphicon-cog"></i> Settings',
                    'url' => ['/user/settings/profile'],
                ],
                '<li class="divider"></li>',
                [
                    'label' => '<i class="glyphicon glyphicon-log-out"></i> Logout',
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
        'brandUrl' => \Yii::$app->homeUrl,
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
        'items' => \dmstr\modules\pages\models\Tree::getMenuItems('root'),
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
