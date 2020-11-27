<?php
/**
 * Plugin settings page functions.
 */

namespace Phrase\WP\Admin;

/**
 * Plugin Settings.
 */
class Settings {

	/**
	 * The access token option key.
	 *
	 * @var string
	 */
	private const ACCESS_TOKEN_OPTION_NAME = 'phrase_api_access_token';

	/**
	 * Initialize settings hooks and filters.
	 *
	 * @return void
	 */
	public static function init(): void {
		self::register_settings();
		self::add_sections();
		self::add_fields();
	}

	/**
	 * Register the admin menu page.
	 *
	 * @return void
	 */
	public static function admin_menu(): void {
		add_menu_page(
			__( 'Phrase Settings', 'phrase' ),
			__( 'Phrase', 'phrase' ),
			'manage_options',
			'phrase',
			[ self::class, 'render' ],
			'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB3aWR0aD0iMjEyLjciIGhlaWdodD0iMjEyLjU2IiB2aWV3Qm94PSIwIDAgMjEyLjcgMjEyLjU2Ij48ZGVmcz48bGluZWFyR3JhZGllbnQgaWQ9ImIiIHgxPSIzMDIuMDkiIHkxPSIxNDUuMjEiIHgyPSIzMjguNjkiIHkyPSIxMzQuMjYiIGdyYWRpZW50VW5pdHM9InVzZXJTcGFjZU9uVXNlIj48c3RvcCBvZmZzZXQ9IjAiIHN0b3AtY29sb3I9IiNmNjAiIC8+PHN0b3Agb2Zmc2V0PSIxIiBzdG9wLWNvbG9yPSIjZmMwIiAvPjwvbGluZWFyR3JhZGllbnQ+PGxpbmVhckdyYWRpZW50IGlkPSJhIiB4MT0iMjUzLjMxIiB5MT0iMTc2LjM2IiB4Mj0iMzYyLjA2IiB5Mj0iMzMuOTYiIGdyYWRpZW50VW5pdHM9InVzZXJTcGFjZU9uVXNlIj48c3RvcCBvZmZzZXQ9IjAiIHN0b3AtY29sb3I9IiMwMDUwODIiIC8+PHN0b3Agb2Zmc2V0PSIuNiIgc3RvcC1jb2xvcj0iIzFlODJjMCIgLz48c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiMzZGI1ZmYiIC8+PC9saW5lYXJHcmFkaWVudD48bGluZWFyR3JhZGllbnQgaWQ9ImMiIHgxPSIyNzEuNjMiIHkxPSIyNDguOTgiIHgyPSIzMjYuNCIgeTI9IjEwOS43MiIgeGxpbms6aHJlZj0iI2EiIC8+PGxpbmVhckdyYWRpZW50IGlkPSJkIiB4MT0iMjY2LjAyIiB5MT0iMTYwLjc4IiB4Mj0iMzU4LjM0IiB5Mj0iODguOCIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiPjxzdG9wIG9mZnNldD0iMCIgc3RvcC1jb2xvcj0iI2U2ZTZlNiIgLz48c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiNmZWZlZmUiIC8+PC9saW5lYXJHcmFkaWVudD48bGluZWFyR3JhZGllbnQgaWQ9ImUiIHgxPSIzNDUuNDYiIHkxPSIxMzQuODciIHgyPSI0MDEuODEiIHkyPSIxMzAuNTMiIGdyYWRpZW50VHJhbnNmb3JtPSJyb3RhdGUoLjc5IDMyNi4zOCAxMDUuMSkiIHhsaW5rOmhyZWY9IiNiIiAvPjwvZGVmcz48cGF0aCBkPSJNMzE2LjE1IDgxLjFhNTUuODkgNTUuODkgMCAxIDAgMTkuNDEgMTEwLjA3eiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTE3OC4yMSAtNTEuMjIpIiBmaWxsPSJ1cmwoI2IpIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiIC8+PHBhdGggZD0iTTIwMy40NSAxMDYuODdhNTIgNTIgMCAwIDEtMjUuMjUtMzYuMDhjMTkuMjkgMTIuNDYgNjMuMDctMTEuMTEgMTAyLjczLTE4LjExQTEwOC45MSAxMDguOTEgMCAwIDEgMzYxLjMzIDcxbC02IDEzLjA2LTI4Ljc4IDMyLjEtMTguNDkgNzNjLTUuMzYgMTkuNDktMS40OCA0Ni4yIDM1Ljk0IDcyLjQtOTkuODcgMTcuNjEtMTc5LTcwLjg3LTE0MC41NC0xNTQuNjUiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0xNzguMjEgLTUxLjIyKSIgZmlsbD0idXJsKCNhKSIgZmlsbC1ydWxlPSJldmVub2RkIiAvPjxwYXRoIGQ9Ik0zNTUuNTMgODMuNmwtLjIuNDUtMjguNzggMzIuMS0xOC40OSA3M2MtNS4zNCAxOS4zOSA1Ljc3IDQ4LjIgMzUuOTQgNzIuNC0xMzEuMzgtOC4xNC0xNDUuODItMTY1LTMwLjI1LTE4OS4yIDExLjg2LTIuNDggMjcuNSA2LjE5IDQxLjc4IDExLjI3IiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMTc4LjIxIC01MS4yMikiIGZpbGw9InVybCgjYykiIGZpbGwtcnVsZT0iZXZlbm9kZCIgLz48cGF0aCBkPSJNMzUzLjUzIDgxLjU5Yy41Mi4zNSAxLjg2IDEuMTMgMi4zNyAxLjQ5bC00Ny44NCAxMDZjLTIzLjA2LTQuNzgtNDAuMzgtMTkuMjgtNDUuMzktNDcuN3MxNS44NC02MyA0OC4wNy02OC42NWE1OSA1OSAwIDAgMSA0Mi43OSA4LjgxIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMTc4LjIxIC01MS4yMikiIGZpbGw9InVybCgjZCkiIGZpbGwtcnVsZT0iZXZlbm9kZCIgLz48cGF0aCBkPSJNMzYxLjA2IDcwLjc5YTcxLjQxIDcxLjQxIDAgMCAxLTMwLjE0IDEyOC41NWMxNC4xMS0xOS41Ny0zMC43LTMyLjA2LTIxLjE1LTU1LjYyIDYuMDctMTUgMjEuNC02LjQ0IDI3LjkxLTIwLjQ3eiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTE3OC4yMSAtNTEuMjIpIiBmaWxsPSJ1cmwoI2UpIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiIC8+PHBhdGggZD0iTTEzNy4yNyAzNS41YTE3IDE3IDAgMSAwIDE3IDE3IDE3IDE3IDAgMCAwLTE3LTE3IiBmaWxsLXJ1bGU9ImV2ZW5vZGQiIC8+PHBhdGggZD0iTTE0Mi4wMiA0MC4xM2E2IDYgMCAxIDAgNiA2IDYgNiAwIDAgMC02LTYiIGZpbGw9IiNmZmYiIGZpbGwtcnVsZT0iZXZlbm9kZCIgLz48L3N2Zz4K'
		);
	}

	/**
	 * Register plugin settings.
	 *
	 * @return void
	 */
	private static function register_settings(): void {
		register_setting(
			'phrase',
			self::ACCESS_TOKEN_OPTION_NAME,
			[
				'type'              => 'string',
				'sanitize_callback' => [ self::class, 'sanitize_access_token' ],
				'default'           => '',
			]
		);
	}

	/**
	 * Sanitize the access token. Set the existing option if field was not submitted (it probably was disabled).
	 *
	 * @param string|null $token The form input.
	 * @return string The sanitized token.
	 */
	public static function sanitize_access_token( $token ): string {
		if ( null === $token ) {
			return get_option( self::ACCESS_TOKEN_OPTION_NAME );
		}

		return sanitize_text_field( $token );
	}

	/**
	 * Add setting sections.
	 *
	 * @return void
	 */
	private static function add_sections(): void {
		// Register a new section in the "phrase" page.
		add_settings_section(
			'phrase_section_api',
			__( 'Authentication', 'phrase' ),
			[ self::class, 'render_section_api' ],
			'phrase'
		);

	}

	/**
	 * Add settings fields.
	 *
	 * @return void
	 */
	private static function add_fields(): void {
		add_settings_field(
			self::ACCESS_TOKEN_OPTION_NAME,
			__( 'API Access Token', 'phrase' ),
			[ self::class, 'render_field_api_token' ],
			'phrase',
			'phrase_section_api',
			[
				'label_for' => self::ACCESS_TOKEN_OPTION_NAME,
			]
		);
	}

	/**
	 * API section description render.
	 *
	 * @param array $args The arguments.
	 * @return void
	 */
	public static function render_section_api( $args ): void {
		?>
		<p id="<?php echo esc_attr( $args['id'] ); ?>">
			<?php esc_html_e( 'Please provide a Phrase API Access Token to connect WordPress to your Phrase account.', 'phrase' ); ?>
		</p>
		<?php
	}

	/**
	 * Render the api token field.
	 *
	 * @param array $args The arguments.
	 * @return void
	 */
	public static function render_field_api_token( $args ): void {
		$token = get_option( self::ACCESS_TOKEN_OPTION_NAME );
		?>
		<div class="access-token-input">
			<input
				type="text"
				id="<?php echo esc_attr( $args['label_for'] ); ?>"
				class="regular-text"
				name="<?php echo esc_attr( $args['label_for'] ); ?>"
				value="<?php echo $token ? esc_attr( str_repeat( '*', 30 ) . substr( $token, -8 ) ) : ''; ?>"
				<?php echo $token ? 'disabled' : ''; ?>
			/>

			<?php if ( $token ) : ?>
				<button type="button" class="button change-access-token"><?php esc_html_e( 'Change', 'phrase' ); ?></button>
			<?php endif; ?>

			<p class="description" <?php echo $token ? 'hidden' : ''; ?>>
				<?php
				printf(
					/* translators: Placeholders are used for link (<a></a>) markup. */
					esc_html__( 'Go to %1$syour Phrase Access Token settings%2$s, generate an Access Token, copy and paste it here.', 'phrase' ),
					'<a href="https://app.phrase.com/settings/oauth_access_tokens" target="_blank" rel="noopener noreferrer">',
					'</a>'
				);
				?>
			</p>
		</div>
		<?php
	}

	/**
	 * Renders the settings page markup.
	 *
	 * @return void
	 */
	public static function render(): void {
		// Check user capabilities.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Add error/update messages.

		// Check if the user have submitted the settings.
		// WordPress will add the "settings-updated" $_GET parameter to the url.
		if ( isset( $_GET['settings-updated'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			// Add settings saved message with the class of "updated".
			add_settings_error(
				'phrase_messages',
				'phrase_message',
				__( 'Settings saved.', 'phrase' ),
				'updated'
			);
		}

		// Show error/update messages.
		settings_errors( 'phrase_messages' );
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form action="options.php" method="post">
				<?php
				// Output security fields for the registered settings.
				settings_fields( 'phrase' );

				// Output setting sections and their fields.
				do_settings_sections( 'phrase' );

				// Output save settings button.
				submit_button( __( 'Save Settings', 'phrase' ) );
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Get the phrase access token.
	 *
	 * @return string The token or false.
	 */
	public static function get_access_token(): string {
		$access_token = get_option( self::ACCESS_TOKEN_OPTION_NAME );

		if ( ! $access_token ) {
			return '';
		}

		return $access_token;
	}
}
