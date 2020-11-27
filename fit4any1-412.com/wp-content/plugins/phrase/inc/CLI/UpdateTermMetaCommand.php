<?php
/**
 * UpdateTermMetaCommand class.
 */

namespace Phrase\WP\CLI;

use WP_CLI;
use WP_CLI_Command;

/**
 * CLI command to update relation taxonomy meta data.
 */
class UpdateTermMetaCommand extends WP_CLI_Command {

	/**
	 * Update term meta.
	 */
	public function __invoke() {
		\Phrase\WP\Cron\UpdateTermMetaData::callback();

		WP_CLI::line( __( 'Done', 'phrase' ) );
	}
}
