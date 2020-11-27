/**
 * WordPress dependencies
 */
import { createRegistrySelector } from '@wordpress/data';

/**
 * Internal dependencies
 */
import {
	PROJECT_PROP_KEY,
	LOCALE_PROP_KEY,
	HAS_INITIAL_CONTENT_PUSH_META_KEY,
	SOURCE_POST_PROP_KEY,
} from '../constants';

/**
 * Returns the status.
 *
 * @param {Object} state Global application state.
 * @return {Object} Preferences Object.
 */
export function getStatus( state ) {
	return state.status;
}

/**
 * Returns an array of all projects.
 *
 * @param {Object} state Global application state.
 * @return {Array} An array of all projects.
 */
export function getProjects( state ) {
	return state.projects.results || [];
}

/**
 * Returns an array of all locales of a specific project.
 *
 * @param {Object} state Global application state.
 * @param {string} projectId Project ID.
 * @return {Array} An array of all locales.
 */
export function getLocales( state, projectId ) {
	return state.locales.results?.[ projectId ] || [];
}

/**
 * Returns the project ID of the post currently being edited.
 *
 * @param {Object} state Global application state.
 * @return {string} Project ID.
 */
export const getCurrentProjectId = createRegistrySelector( ( select ) => () => {
	return select( 'core/editor' ).getEditedPostAttribute( PROJECT_PROP_KEY ) || '';
} );

/**
 * Whether the post has a project assigned.
 *
 * @param {Object} state Global application state.
 * @return {boolean} True if the currently edited post has a locale, false otherwise.
 */
export function hasProjectId( state ) {
	return !! getCurrentProjectId( state );
}

/**
 * Returns the locale ID of the post currently being edited.
 *
 * @param {Object} state Global application state.
 * @return {string} Locale ID.
 */
export const getCurrentLocaleId = createRegistrySelector( ( select ) => () => {
	return select( 'core/editor' ).getEditedPostAttribute( LOCALE_PROP_KEY ) || '';
} );

/**
 * Whether the post has a locale assigned.
 *
 * @param {Object} state Global application state.
 * @return {boolean} True if the currently edited post has a locale, false otherwise.
 */
export function hasLocaleId( state ) {
	return !! getCurrentLocaleId( state );
}

/**
 * Whether content is uploading.
 *
 * @param {Object} state Global application state.
 * @return {boolean} True if content is uploading, false otherwise.
 */
export function isPushingContent( state ) {
	return state.isPushingContent;
}

/**
 * Whether translation is uploading.
 *
 * @param {Object} state Global application state.
 * @return {boolean} True if translation is uploading, false otherwise.
 */
export function isPushingTranslation( state ) {
	return state.isPushingTranslation;
}

/**
 * Whether translations are being pulled.
 *
 * @param {Object} state Global application state.
 * @return {boolean} True if translations are being pulled, false otherwise.
 */
export function isPullingTranslations( state ) {
	return state.isPullingTranslations;
}

/**
 * Whether a translation is being pulled.
 *
 * @param {Object} state Global application state.
 * @return {boolean} True if a translation is being pulled, false otherwise.
 */
export function isPullingTranslation( state ) {
	return state.isPullingTranslation;
}

/**
 * Whether the initial content push was done.
 *
 * @param {Object} state Global application state.
 * @return {boolean} True if content push was done, false otherwise.
 */
export const hasInitialContentPush = createRegistrySelector( ( select ) => () => {
	return (
		select( 'core/editor' ).getEditedPostAttribute( 'meta' )[
			HAS_INITIAL_CONTENT_PUSH_META_KEY
		] || false
	);
} );

/**
 * Returns an array of all translations.
 *
 * @param {Object} state Global application state.
 * @return {Array} An array of all projects.
 */
export function getTranslations( state ) {
	return state.translations.results || [];
}

/**
 * Whether the current project is a translation.
 *
 * @param {Object} state Global application state.
 * @return {boolean} True if the currently edited post is a translation, false otherwise.
 */
export const isEditedPostTranslation = createRegistrySelector( ( select ) => () => {
	return !! select( 'core/editor' ).getCurrentPost()[ SOURCE_POST_PROP_KEY ];
} );

/**
 * Returns source post data.
 *
 * @param {Object} state Global application state.
 * @return {Object=} Source post data.
 */
export const getSource = createRegistrySelector( ( select ) => () => {
	return select( 'core/editor' ).getCurrentPost()[ SOURCE_POST_PROP_KEY ] || null;
} );

/**
 * Returns translations pre-condition check results.
 *
 * @param {Object} state Global application state.
 * @return {Object} Translations pre-condition check results.
 */
export function getPullTranslationsPreConditionChecks( state ) {
	return state.pullTranslationsPreConditionChecks.checks || null;
}
/**
 * Returns translations pre-condition check results.
 *
 * @param {Object} state Global application state.
 * @return {number} Number of translations pre-condition check results.
 */
export function getPullTranslationsPreConditionChecksCount( state ) {
	return state.pullTranslationsPreConditionChecks.count || 0;
}

/**
 * Returns the locally persisted preferences.
 *
 * @param {Object} state Global application state.
 * @return {Object} Preferences Object.
 */
export function getPreferences( state ) {
	return state.preferences;
}

/**
 * Returns the last used project preference.
 *
 * @param {Object} state Global application state.
 * @return {string=} Last used project.
 */
export function getLastUsedProject( state ) {
	const preferences = getPreferences( state );
	return preferences.lastUsedProject || null;
}
