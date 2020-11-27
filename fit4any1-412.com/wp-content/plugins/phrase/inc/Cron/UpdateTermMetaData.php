<?php
/**
 * UpdateTermMetaData class.
 */

namespace Phrase\WP\Cron;

use Phrase\WP\PhraseAPI\PhraseAPI;
use function Phrase\WP\Connections\update_locale_term;
use function Phrase\WP\Connections\update_project_term;

/**
 * Class used to update project and locale data in relation taxonomies.
 */
class UpdateTermMetaData {

	/**
	 * The cron job action name.
	 */
	public const ACTION = 'phrase_update_term_meta_data';

	/**
	 * Uses Phrase API to retrieve data.
	 */
	public static function callback() {
		// Get all projects we want to update.
		try {
			$projects = PhraseAPI::get_instance()->get_projects();
		} catch ( \Exception $e ) {
			return;
		}

		foreach ( $projects as $project ) {
			// Update the projects meta data.
			$project_id = $project->getId();
			update_project_term( $project_id );

			// Try to get projects locales.
			try {
				$locales = PhraseAPI::get_instance()->get_locales( $project_id );
			} catch ( \Exception $e ) {
				continue;
			}

			// Update locales meta data.
			foreach ( $locales as $locale ) {
				update_locale_term( $locale->getId(), $project_id );
			}
		}
	}
}
