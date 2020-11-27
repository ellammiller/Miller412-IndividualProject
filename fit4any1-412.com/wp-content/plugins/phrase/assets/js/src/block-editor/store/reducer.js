import { omit } from 'lodash';

/**
 * WordPress dependencies
 */
import { combineReducers } from '@wordpress/data';

/**
 * Reducer returning the next projects state.
 *
 * @param {Object} state  Current state.
 * @param {Object} action Dispatched action.
 * @return {Object} Updated state.
 */
export function projects(
	state = {
		isFetching: false,
		results: [],
		error: null,
	},
	action
) {
	switch ( action.type ) {
		case 'RECEIVE_PROJECTS':
			return {
				...state,
				results: action.projects,
				isFetching: false,
			};

		case 'FETCH_PROJECTS':
			return {
				...state,
				isFetching: true,
				error: null,
			};

		case 'FETCH_PROJECTS_FAILURE':
			return {
				...state,
				isFetching: false,
				error: action.error,
			};

		default:
			return state;
	}
}

/**
 * Reducer returning the next locales state.
 *
 * @param {Object} state  Current state.
 * @param {Object} action Dispatched action.
 * @return {Object} Updated state.
 */
export function locales(
	state = {
		isFetching: {},
		results: {},
	},
	action
) {
	switch ( action.type ) {
		case 'RECEIVE_LOCALES':
			return {
				...state,
				results: {
					...state.results,
					[ action.projectId ]: action.locales,
				},
				isFetching: omit( state.isFetching, action.projectId ),
			};

		case 'FETCH_LOCALES':
			return {
				...state,
				isFetching: {
					...state.isFetching,
					[ action.projectId ]: true,
				},
				error: omit( state.error, action.projectId ),
			};

		case 'FETCH_LOCALES_FAILURE':
			return {
				...state,
				isFetching: omit( state.isFetching, action.projectId ),
				error: {
					...state.error,
					[ action.projectId ]: action.error,
				},
			};

		default:
			return state;
	}
}

/**
 * Reducer returning the next translations state.
 *
 * @param {Object} state  Current state.
 * @param {Object} action Dispatched action.
 * @return {Object} Updated state.
 */
export function translations(
	state = {
		isFetching: false,
		results: [],
	},
	action
) {
	switch ( action.type ) {
		case 'RECEIVE_TRANSLATIONS':
			return {
				...state,
				results: action.translations,
				isFetching: false,
			};

		case 'FETCH_TRANSLATIONS':
			return {
				...state,
				isFetching: true,
			};

		case 'FETCH_TRANSLATIONS_FAILURE':
			return {
				...state,
				isFetching: false,
			};

		default:
			return state;
	}
}

/**
 * Reducer returning content pushing state.
 *
 * @param {boolean} state  Current state.
 * @param {Object}  action Dispatched action.
 * @return {boolean} Updated state.
 */
export function isPushingContent( state = false, action ) {
	switch ( action.type ) {
		case 'START_PUSHING_CONTENT':
			return true;

		case 'STOP_PUSHING_CONTENT':
			return false;
	}

	return state;
}

/**
 * Reducer returning translation pushing state.
 *
 * @param {boolean} state  Current state.
 * @param {Object}  action Dispatched action.
 * @return {boolean} Updated state.
 */
export function isPushingTranslation( state = false, action ) {
	switch ( action.type ) {
		case 'START_PUSHING_TRANSLATION':
			return true;

		case 'STOP_PUSHING_TRANSLATION':
			return false;
	}

	return state;
}

/**
 * Reducer returning translations pulling state.
 *
 * @param {boolean} state  Current state.
 * @param {Object}  action Dispatched action.
 * @return {boolean} Updated state.
 */
export function isPullingTranslations( state = false, action ) {
	switch ( action.type ) {
		case 'START_PULLING_TRANSLATIONS':
			return true;

		case 'STOP_PULLING_TRANSLATIONS':
			return false;
	}

	return state;
}

/**
 * Reducer returning translation pulling state.
 *
 * @param {boolean} state  Current state.
 * @param {Object}  action Dispatched action.
 * @return {boolean} Updated state.
 */
export function isPullingTranslation( state = false, action ) {
	switch ( action.type ) {
		case 'START_PULLING_TRANSLATION':
			return true;

		case 'STOP_PULLING_TRANSLATION':
			return false;
	}

	return state;
}

/**
 * Reducer returning translation pulling checks state.
 *
 * @param {boolean} state  Current state.
 * @param {Object}  action Dispatched action.
 * @return {Object} Updated state.
 */
export function pullTranslationsPreConditionChecks(
	state = {
		count: 0,
		checks: null,
	},
	action
) {
	switch ( action.type ) {
		case 'START_PULLING_TRANSLATIONS':
		case 'CLEAR_TRANSLATIONS_PRE_CONDITION_CHECKS':
			return {
				count: 0,
				checks: null,
			};

		case 'SET_TRANSLATIONS_PRE_CONDITION_CHECKS':
			return {
				count: action.count,
				checks: action.checks,
			};
	}

	return state;
}

/**
 * Reducer that tracks the last used project.
 *
 * @param {boolean} state Current state.
 * @param {Object} action Dispatched action.
 * @return {string=} Updated state.
 */
export function lastUsedProject( state = null, action ) {
	switch ( action.type ) {
		case 'UPDATE_LAST_USED_PROJECT':
			return action.id;
	}

	return state;
}

const preferences = combineReducers( { lastUsedProject } );

/**
 * Reducer that tracks the setup status.
 *
 * @param {Object} state Current state.
 * @param {Object} action Dispatched action.
 * @return {Object} Updated state.
 */
export function status( state = {}, action ) {
	switch ( action.type ) {
		case 'SET_STATUS':
			return action.status;
	}

	return state;
}

export default combineReducers( {
	status,
	preferences,
	projects,
	locales,
	translations,
	isPushingContent,
	isPushingTranslation,
	isPullingTranslations,
	isPullingTranslation,
	pullTranslationsPreConditionChecks,
} );
