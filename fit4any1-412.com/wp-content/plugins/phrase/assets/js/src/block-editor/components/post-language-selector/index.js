/**
 * External dependencies.
 */
import { find } from 'lodash';

/**
 * WordPress dependencies.
 */
import { __ } from '@wordpress/i18n';
import { SelectControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { useEntityProp } from '@wordpress/core-data';
import { useEffect } from '@wordpress/element';

/**
 * Internal dependencies
 */
import { PROJECT_PROP_KEY, LOCALE_PROP_KEY } from '../../constants';
import { STORE_KEY } from '../../store';

const PostLanguageSelector = () => {
	const postType = useSelect( ( select ) => select( 'core/editor' ).getCurrentPostType(), [] );
	const [ localeId, setLocaleId ] = useEntityProp( 'postType', postType, LOCALE_PROP_KEY );
	const [ projectId ] = useEntityProp( 'postType', postType, PROJECT_PROP_KEY );
	const locales = useSelect(
		( select ) => {
			return projectId ? select( STORE_KEY ).getLocales( projectId ) : [];
		},
		[ projectId ]
	);
	const defaultLocaleId = find( locales, { default: true } )?.id || '';
	useEffect( () => {
		if ( ! localeId && defaultLocaleId ) {
			setLocaleId( defaultLocaleId );
		}
	}, [ localeId, defaultLocaleId ] );

	const options = locales.length
		? locales.map( ( locale ) => {
				return { value: locale.id, label: locale.name };
		  } )
		: [ { value: null, label: '' } ];

	return (
		<>
			<SelectControl
				label={ __( 'My post is written in:', 'phrase' ) }
				value={ localeId }
				onChange={ ( value ) => setLocaleId( value ) }
				options={ options }
				disabled={ ! projectId || ! locales.length }
			/>
		</>
	);
};

export default PostLanguageSelector;
