/**
 * WordPress dependencies.
 */
import { useSelect } from '@wordpress/data';

/**
 * Internal dependencies
 */
import { STORE_KEY } from '../../store';

const ContentPushCheck = ( { children, isPushed = false } ) => {
	const hasInitialContentPush = useSelect(
		( select ) => select( STORE_KEY ).hasInitialContentPush(),
		[]
	);

	if ( hasInitialContentPush !== isPushed ) {
		return null;
	}

	return children;
};

export default ContentPushCheck;
