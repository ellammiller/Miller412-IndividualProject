/**
 * WordPress dependencies
 */
import { apiFetch, dispatch, select } from '@wordpress/data-controls';

/**
 * Internal dependencies
 */
import { STORE_KEY } from './';
import {
	GET_LOCALES_NOTICE_ID,
	GET_PROJECTS_NOTICE_ID,
	GET_TRANSLATIONS_NOTICE_ID,
} from '../constants';
import {
	getNotificationArgumentsForLocalesFail,
	getNotificationArgumentsForProjectsFail,
	getNotificationArgumentsForTranslationsFail,
} from './utils/notice-builder';

/**
 * Requests status from the REST API.
 */
export function* getStatus() {
	try {
		const status = yield apiFetch( { path: '/phrase/v1/status' } );
		yield dispatch( STORE_KEY, 'setStatus', status );
	} catch {}
}

/**
 * Requests projects from the REST API.
 */
export function* getProjects() {
	yield dispatch( STORE_KEY, 'fetchProjects' );
	yield dispatch( 'core/notices', 'removeNotice', GET_PROJECTS_NOTICE_ID );

	try {
		const projects = yield apiFetch( { path: '/phrase/v1/projects' } );

		yield dispatch( STORE_KEY, 'receiveProjects', projects );
	} catch ( error ) {
		yield dispatch(
			'core/notices',
			'createErrorNotice',
			...getNotificationArgumentsForProjectsFail( { error } )
		);
		yield dispatch( STORE_KEY, 'fetchProjectsFailure', error );
	}
}

/**
 * Requests locales from the REST API.
 *
 * @param {string} projectId Project ID
 */
export function* getLocales( projectId ) {
	yield dispatch( STORE_KEY, 'fetchLocales' );
	yield dispatch( 'core/notices', 'removeNotice', GET_LOCALES_NOTICE_ID );

	try {
		const locales = yield apiFetch( { path: `/phrase/v1/locales?project_id=${ projectId }` } );

		yield dispatch( STORE_KEY, 'receiveLocales', projectId, locales );
	} catch ( error ) {
		yield dispatch(
			'core/notices',
			'createErrorNotice',
			...getNotificationArgumentsForLocalesFail( { error } )
		);
		yield dispatch( STORE_KEY, 'fetchLocalesFailure', projectId, error );
	}
}

/**
 * Requests translations from the REST API.
 */
export function* getTranslations() {
	yield dispatch( STORE_KEY, 'fetchTranslations' );
	yield dispatch( 'core/notices', 'removeNotice', GET_TRANSLATIONS_NOTICE_ID );

	const postId = yield select( 'core/editor', 'getCurrentPostId' );

	try {
		const translations = yield apiFetch( { path: `/phrase/v1/translations/${ postId }` } );

		yield dispatch( STORE_KEY, 'receiveTranslations', translations );
	} catch ( error ) {
		yield dispatch(
			'core/notices',
			'createErrorNotice',
			...getNotificationArgumentsForTranslationsFail( { error } )
		);
		yield dispatch( STORE_KEY, 'fetchLocalesFailure', error );
	}
}
