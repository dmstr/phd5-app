<?php

use dmstr\cookieconsent\widgets\CookieConsent;

?>

<!--<style>
    .cookie-consent-popup {
        animation-name: show;
        animation-duration: 1s;
        animation-timing-function: ease;
        display: none;
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        z-index: 999999;
    }

    .cookie-consent-popup.open {
        display: block;
        opacity: 1;
        animation-name: show;
        animation-duration: 1s;
        animation-timing-function: ease;
    }

    .cookie-consent-controls {
        max-height: 0;
        overflow: hidden;
        -webkit-transition: max-height 0.5s ease-out;
        -moz-transition: max-height 0.5s ease-out;
        transition: max-height 0.5s ease-out;
    }

    .cookie-consent-controls.open {
        margin: 0 0 30px 0;
        max-height: 600px;
    }

    .cookie-consent-details {
        max-height: 0;
        overflow: hidden;
        -webkit-transition: max-height 0.5s ease-out;
        -moz-transition: max-height 0.5s ease-out;
        transition: max-height 0.5s ease-out;
    }

    .cookie-consent-details.open {
        max-height: 600px;
    }

    @keyframes show {
        from {opacity: 0;}
        to {opacity: 1;}
    }

    @keyframes hide {
        from {opacity: 1;}
        to {opacity: 0;}
    }
</style>-->

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
        'link' => '/de/test/privacy',
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
