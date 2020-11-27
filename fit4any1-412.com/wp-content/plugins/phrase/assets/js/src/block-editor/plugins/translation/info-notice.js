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
	const { hasApiToken, isTranslations } = useSelect( ( select ) => {
		const { getStatus, isEditedPostTranslation } = select( STORE_KEY );

		return {
			hasApiToken: getStatus()?.has_key || false,
			isTranslations: isEditedPostTranslation(),
		};
	} );

	if ( ! hasApiToken || ! isTranslations ) {
		return null;
	}

	return children;
};

const InfoNotice = () => {
	const { locale, source } = useSelect( ( select ) => {
		const { getLocales, getCurrentLocaleId, getCurrentProjectId, getSource } = select(
			STORE_KEY
		);

		return {
			locale:
				find( getLocales( getCurrentProjectId() ), { id: getCurrentLocaleId() } ) || null,
			source: getSource(),
		};
	}, [] );
	const { createInfoNotice } = useDispatch( 'core/notices' );

	useEffect( () => {
		if ( ! source || ! locale ) {
			return;
		}

		const flag = renderToString( <Flag code={ locale.code } /> );

		createInfoNotice(
			sprintf(
				// translators: 1: Locale name, 2: Locale icon, 3: Title and edit link of source.
				__( '%1$s %2$s - Translation of %3$s', 'phrase' ),
				flag,
				locale?.name || __( 'Loading…', 'phrase' ),
				`<a href="${ source.post_edit_url }">${ source.title }</a>`
			),
			{
				id: 'phrase-translation-info-notice',
				speak: false,
				__unstableHTML: true,
				isDismissible: false,
			}
		);
	}, [ source, locale ] );

	return null;
};

registerPlugin( 'phrase-translation-info-notice', {
	render: () => (
		<StatusCheck>
			<InfoNotice />
		</StatusCheck>
	),
} );
