<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

 $issues = array(); if (!(PHP_VERSION_ID >= 70100)) { $issues[] = 'Your Composer dependencies require a PHP version ">= 7.1.0". You are running ' . PHP_VERSION . '.'; } $missingExtensions = array(); extension_loaded('json') || $missingExtensions[] = 'json'; if ($missingExtensions) { $issues[] = 'Your Composer dependencies require the following PHP extensions to be installed: ' . implode(', ', $missingExtensions); } if ($issues) { echo 'Composer detected issues in your platform:' . "\n\n" . implode("\n", $issues); exit(104); } 