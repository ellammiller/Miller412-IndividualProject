/**
 * Admin functions
 */
import './index.css';

/**
 * Change access token link.
 */
const changeAccessTokenButton = document.querySelector( '.change-access-token' );
if ( changeAccessTokenButton ) {
	changeAccessTokenButton.addEventListener( 'click', () => {
		changeAccessTokenButton.style.display = 'none';

		const input = document.querySelector( '.access-token-input input' );
		input.disabled = false;
		input.value = '';
		input.focus();

		const description = document.querySelector( '.access-token-input .description' );
		description.hidden = false;
	} );
}
