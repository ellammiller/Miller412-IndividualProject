/**
 * External dependencies
 */
import { find } from 'lodash';

/**
 * WordPress dependencies.
 */
import { registerPlugin } from '@wordpress/plugins';
import { __, sprintf } from '@wordpress/i18n';
import { useEffect, renderToString } from '@wordpress/element';
import { useSelect, useDispatch } from '@wordpress/data';

/**
 * Internal dependencies
 */
import { STORE_KEY } from '../../store';
import Flag from '../../components/flag';

const StatusCheck = ( { children } ) => {
	const { hasApiToken, hasContentPush } = useSelect( ( select ) => {
		const { getStatus, hasInitialContentPush } = select( STORE_KEY );

		return {
			hasApiToken: getStatus()?.has_key || false,
			hasContentPush: hasInitialContentPush(),
		};
	} );

	if ( ! hasApiToken || ! hasContentPush ) {
		return null;
	}

	return children;
};

const InfoNotice = () => {
	const { locale } = useSelect( ( select ) => {
		const { getLocales, getCurrentLocaleId, getCurrentProjectId } = select( STORE_KEY );

		return {
			locale:
				find( getLocales( getCurrentProjectId() ), { id: getCurrentLocaleId() } ) || null,
		};
	}, [] );
	const { createInfoNotice } = useDispatch( 'core/notices' );

	useEffect( () => {
		if ( ! locale ) {
			return;
		}

		const flag = renderToString( <Flag code={ locale.code } /> );

		createInfoNotice(
			sprintf(
				// translators: 1: Locale name, 2: Locale icon.
				__( '%1$s %2$s - source content', 'phrase' ),
				flag,
				locale?.name || __( 'Loading…', 'phrase' )
			),
			{
				id: 'phrase-source-info-notice',
				speak: false,
				__unstableHTML: true,
				isDismissible: false,
			}
		);
	}, [ locale ] );

	return null;
};

registerPlugin( 'phrase-source-info-notice', {
	render: () => (
		<StatusCheck>
			<InfoNotice />
		</StatusCheck>
	),
} );
