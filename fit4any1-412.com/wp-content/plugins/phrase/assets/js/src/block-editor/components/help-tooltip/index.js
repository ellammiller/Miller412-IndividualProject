/**
 * WordPress dependencies.
 */
import { Popover } from '@wordpress/components';
import { help, Icon } from '@wordpress/icons';
import { useState } from '@wordpress/element';
import { ENTER } from '@wordpress/keycodes';

/**
 * Internal dependencies
 */
import './index.css';

const HelpTooltip = ( { children } ) => {
	const [ isHover, setHover ] = useState( false );
	return (
		<span
			className="phrase-help-tooltip"
			onClick={ () => setHover( ! isHover ) }
			onMouseEnter={ () => setHover( true ) }
			onMouseLeave={ () => setHover( false ) }
			onKeyDown={ ( event ) => {
				if ( ENTER === event.keyCode ) {
					setHover( ! isHover );
				}
			} }
			role="button"
			tabIndex={ 0 }
		>
			<Icon className="phrase-help-tooltip__icon" icon={ help } />
			{ isHover && (
				<Popover className="phrase-help-tooltip__popover" focusOnMount={ false }>
					{ children }
				</Popover>
			) }
		</span>
	);
};

export default HelpTooltip;
