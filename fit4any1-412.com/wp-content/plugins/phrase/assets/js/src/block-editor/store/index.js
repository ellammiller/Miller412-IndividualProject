/**
 * WordPress dependencies
 */
import { controls } from '@wordpress/data-controls';
import { registerStore } from '@wordpress/data';

/**
 * Internal dependencies
 */
import reducer from './reducer';
import * as resolvers from './resolvers';
import * as selectors from './selectors';
import * as actions from './actions';

export const STORE_KEY = 'phrase/data';

export const storeConfig = {
	reducer,
	controls,
	selectors,
	resolvers,
	actions,
	persist: [ 'preferences' ],
};

const store = registerStore( STORE_KEY, storeConfig );

export default store;
