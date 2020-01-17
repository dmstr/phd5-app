<?php

use dmstr\cookieconsent\widgets\CookieConsent;

?>

<div class="site-consent">

    <button class="cookie-consent-toggle">cookie consent toggle</button>

    <ul class="consents">
        <?php if (\Yii::$app->cookieConsentHelper->hasConsent('necessary')): ?>
            <li class="necessary-cookies-enabled">necessary cookies enabled</li>
        <?php endif; ?>
        <?php if (\Yii::$app->cookieConsentHelper->hasConsent('statistics')): ?>
            <li class="statistics-cookies-enabled">statistics cookies enabled</li>
        <?php endif; ?>
    </ul>

    <?= CookieConsent::widget([
        'name' => 'cookie_consent_status',
        'path' => '/',
        'domain' => '',
        'expiryDays' => 365,
        'message' => Yii::t('cookie-consent', 'We use cookies to ensure the proper functioning of our website. For an improved visit experience we use analysis products. These are used when you agree with "Statistics".'),
        'save' => Yii::t('cookie-consent', 'Save'),
        'acceptAll' => Yii::t('cookie-consent', 'Accept all'),
        'controlsOpen' => Yii::t('cookie-consent', 'Change'),
        'detailsOpen' => Yii::t('cookie-consent', 'Cookie Details'),
        'learnMore' => Yii::t('cookie-consent', 'Privacy statement'),
        'visibleControls' => false,
        'visibleDetails' => false,
        'link' => \yii\helpers\Url::to('privacy'),
        'consent' => [
            'necessary' => [
                'label' => Yii::t('cookie-consent', 'Necessary'),
                'checked' => true,
                'disabled' => true,
                'details' => [
                    [
                        'title' => Yii::t('cookie-consent', 'PHPSESSID'),
                        'description' => Yii::t('cookie-consent', 'PHPSESSID')

                    ],
                    [
                        'title' => Yii::t('cookie-consent', '_csrf'),
                        'description' => Yii::t('cookie-consent', '_csrf')

                    ],
                    [
                        'title' => Yii::t('cookie-consent', '_language'),
                        'description' => Yii::t('cookie-consent', '_language')

                    ]
                ]
            ],
            'statistics' => [
                'label' => Yii::t('cookie-consent', 'Statistics'),
                'cookies' => [
                    ['name' => '_ga'],
                    ['name' => '_gat', 'domain' => '', 'path' => '/'],
                    ['name' => '_gid', 'domain' => '', 'path' => '/']
                ]
            ]
        ]
    ]) ?>
</div>
