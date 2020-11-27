<?php
/**
 * Plugin Name: Phrase
 * Plugin URI: https://phrase.com/lp/wordpress/
 * Description: Sync your WordPress posts and pages with Phrase to translate and publish them in multiple languages.
 * Version: 1.0.0
 * Author: Phrase
 * Author URI: https://phrase.com
 * License: LGPLv3
 * License URI: https://www.gnu.org/licenses/lgpl-3.0.html
 * Requires at least: 5.5
 * Requires PHP: 7.2
 *
 * Copyright (c) 2011-2020 Dynport GmbH (email: info@phrase.com)
 */

namespace Phrase\WP;

use WP_Requirements_Check;

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

const VERSION     = '1.0.0';
const PLUGIN_DIR  = __DIR__;
const PLUGIN_FILE = __FILE__;

$phrase_requirements_check = new WP_Requirements_Check(
	[
		'title' => 'Phrase',
		'php'   => '7.2',
		'wp'    => '5.5',
		'file'  => PLUGIN_FILE,
		'i18n'  => [
			/* translators: 1: plugin name. 2: minimum PHP version. */
			'php' => __( '&#8220;%1$s&#8221; requires PHP %2$s or higher. Please upgrade.', 'phrase' ),
			/* translators: 1: plugin name. 2: minimum WordPress version. */
			'wp'  => __( '&#8220;%1$s&#8221; requires WordPress %2$s or higher. Please upgrade.', 'phrase' ),
		],
	]
);

if ( $phrase_requirements_check->passes() ) {
	bootstrap();
}
unset( $phrase_requirements_check );
