<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

 $vendorDir = dirname(dirname(__FILE__)); $baseDir = dirname($vendorDir); return array( 'Symfony\\Polyfill\\Php72\\' => array($vendorDir . '/symfony/polyfill-php72'), 'Symfony\\Polyfill\\Intl\\Normalizer\\' => array($vendorDir . '/symfony/polyfill-intl-normalizer'), 'Symfony\\Polyfill\\Intl\\Idn\\' => array($vendorDir . '/symfony/polyfill-intl-idn'), 'ReCaptcha\\' => array($vendorDir . '/google/recaptcha/src/ReCaptcha'), 'Psr\\Http\\Message\\' => array($vendorDir . '/psr/http-message/src'), 'GuzzleHttp\\Psr7\\' => array($vendorDir . '/guzzlehttp/psr7/src'), 'GuzzleHttp\\Promise\\' => array($vendorDir . '/guzzlehttp/promises/src'), 'GuzzleHttp\\' => array($vendorDir . '/guzzlehttp/guzzle/src'), ); 