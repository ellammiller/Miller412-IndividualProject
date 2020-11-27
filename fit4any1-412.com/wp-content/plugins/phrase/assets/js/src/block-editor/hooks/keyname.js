import { v4 as uuidv4 } from 'uuid';

/**
 * WordPress dependencies
 */
import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { useEffect } from '@wordpress/element';
import { InspectorAdvancedControls } from '@wordpress/block-editor';
import { TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

/**
 * Adds advanced control for key name.
 *
 * @param {Object} props Component props.
 * @param {Object} props.attributes Block attributes.
 * @param {Function} props.setAttributes Set block attributes
 * @param {string} props.name Block name.
 * @param {boolean} props.isSelected Whether the block is selected.
 * @return {WPComponent} Wrapped component.
 */
const AdvancedControlKeyName = ( { attributes, setAttributes, name, isSelected } ) => {
	useEffect( () => {
		// Set default attribute value if not set.
		if ( ! attributes.phraseKeyName ) {
			setAttributes( {
				phraseKeyName: `${ name }.${ uuidv4() }`,
			} );
		}
	}, [ attributes.phraseKeyName, setAttributes, name ] );

	// Show key name as read-only field in advanced controls.
	if ( isSelected ) {
		return (
			<InspectorAdvancedControls>
				<TextControl
					className="html-anchor-control"
					label={ __( 'Phrase key name', 'phrase' ) }
					value={ attributes.phraseKeyName || '' }
					readOnly
				/>
			</InspectorAdvancedControls>
		);
	}

	return null;
};

/**
 * Adds advanced control for key name.
 *
 * @param {WPComponent} BlockEdit Original component.
 * @return {WPComponent} Wrapped component.
 */
export const withAdvancedControlKeyName = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		return (
			<>
				<BlockEdit { ...props } />
				<AdvancedControlKeyName { ...props } />
			</>
		);
	};
}, 'withAdvancedControlKeyName' );

/**
 * Extends block attributes with phraseKeyName.
 *
 * @param {Object} settings Original block settings.
 * @return {Object} Filtered block settings.
 */
export function addAttribute( settings ) {
	settings.attributes = {
		...settings.attributes,
		phraseKeyName: {
			type: 'string',
			default: '',
		},
	};

	return settings;
}

addFilter( 'blocks.registerBlockType', 'phrase/keyname/attribute', addAttribute );
addFilter( 'editor.BlockEdit', 'phrase/keyname/set-attribute', withAdvancedControlKeyName );
