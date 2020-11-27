<?php
 namespace ReCaptcha\RequestMethod; use ReCaptcha\ReCaptcha; use ReCaptcha\RequestMethod; use ReCaptcha\RequestParameters; class Post implements RequestMethod { private $siteVerifyUrl; public function __construct($siteVerifyUrl = null) { $this->siteVerifyUrl = (is_null($siteVerifyUrl)) ? ReCaptcha::SITE_VERIFY_URL : $siteVerifyUrl; } public function submit(RequestParameters $params) { $options = array( 'http' => array( 'header' => "Content-type: application/x-www-form-urlencoded\r\n", 'method' => 'POST', 'content' => $params->toQueryString(), 'verify_peer' => true, ), ); $context = stream_context_create($options); $response = file_get_contents($this->siteVerifyUrl, false, $context); if ($response !== false) { return $response; } return '{"success": false, "error-codes": ["'.ReCaptcha::E_CONNECTION_FAILED.'"]}'; } } 