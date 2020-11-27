/**
 * WordPress dependencies
 */
import { __, sprintf } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import {
	GET_LOCALES_NOTICE_ID,
	GET_PROJECTS_NOTICE_ID,
	GET_TRANSLATIONS_NOTICE_ID,
	PUSH_CONTENT_NOTICE_ID,
	PULL_TRANSLATIONS_NOTICE_ID,
	PULL_TRANSLATION_NOTICE_ID,
	PUSH_TRANSLATION_NOTICE_ID,
} from '../../constants';

/**
 * Builds a default message argument for failed notifications.
 *
 * @param {Object} error         Error object.
 * @param {string=} messagePrefix Message prefix.
 * @return {string} Notification message.
 */
function getNotificationMessageArgument( error, messagePrefix = '%s' ) {
	let noticeMessage;
	switch ( error.code ) {
		case 'argument_error':
			noticeMessage = sprintf(
				messagePrefix,
				sprintf(
					// translators: %s: Failure reason. */
					__( 'An internal argument error occurred ("%s").', 'phrase' ),
					error.message
				)
			);
			break;
		default:
			noticeMessage = sprintf( messagePrefix, error.message );
	}

	return noticeMessage;
}

/**
 * Builds the locales fail notification arguments for dispatch.
 *
 * @param {Object} data Incoming data to build the arguments with.
 * @return {Array} Arguments for dispatch. An empty array signals no
 *                 notification should be sent.
 */
export function getNotificationArgumentsForLocalesFail( data ) {
	const { error } = data;

	return [
		getNotificationMessageArgument(
			error,
			// translators: %s: Failure reason. */
			__( 'Retrieving locales failed: %s', 'phrase' )
		),
		{
			id: GET_LOCALES_NOTICE_ID,
		},
	];
}

/**
 * Builds the projects fail notification arguments for dispatch.
 *
 * @param {Object} data Incoming data to build the arguments with.
 * @return {Array} Arguments for dispatch. An empty array signals no
 *                 notification should be sent.
 */
export function getNotificationArgumentsForProjectsFail( data ) {
	const { error } = data;

	return [
		getNotificationMessageArgument(
			error,
			// translators: %s: Failure reason. */
			__( 'Retrieving projects failed: %s', 'phrase' )
		),
		{
			id: GET_PROJECTS_NOTICE_ID,
		},
	];
}

/**
 * Builds the translations fail notification arguments for dispatch.
 *
 * @param {Object} data Incoming data to build the arguments with.
 * @return {Array} Arguments for dispatch. An empty array signals no
 *                 notification should be sent.
 */
export function getNotificationArgumentsForTranslationsFail( data ) {
	const { error } = data;

	return [
		getNotificationMessageArgument(
			error,
			// translators: %s: Failure reason. */
			__( 'Retrieving translations failed: %s', 'phrase' )
		),
		{
			id: GET_TRANSLATIONS_NOTICE_ID,
		},
	];
}

/**
 * Builds the push content fail notification arguments for dispatch.
 *
 * @param {Object} data Incoming data to build the arguments with.
 * @return {Array} Arguments for dispatch. An empty array signals no
 *                 notification should be sent.
 */
export function getNotificationArgumentsForPushContentFail( data ) {
	const { error } = data;

	return [
		getNotificationMessageArgument(
			error,
			// translators: %s: Failure reason. */
			__( 'Pushing content failed: %s', 'phrase' )
		),
		{
			id: PUSH_CONTENT_NOTICE_ID,
		},
	];
}

/**
 * Builds the pull translations fail notification arguments for dispatch.
 *
 * @param {Object} data Incoming data to build the arguments with.
 * @return {Array} Arguments for dispatch. An empty array signals no
 *                 notification should be sent.
 */
export function getNotificationArgumentsForPullTranslationsFail( data ) {
	const { error } = data;

	return [
		getNotificationMessageArgument(
			error,
			// translators: %s: Failure reason. */
			__( 'Pulling translations failed: %s', 'phrase' )
		),
		{
			id: PULL_TRANSLATIONS_NOTICE_ID,
		},
	];
}

/**
 * Builds the pull translation fail notification arguments for dispatch.
 *
 * @param {Object} data Incoming data to build the arguments with.
 * @return {Array} Arguments for dispatch. An empty array signals no
 *                 notification should be sent.
 */
export function getNotificationArgumentsForPullTranslationFail( data ) {
	const { error } = data;

	return [
		getNotificationMessageArgument(
			error,
			// translators: %s: Failure reason. */
			__( 'Pulling translation failed: %s', 'phrase' )
		),
		{
			id: PULL_TRANSLATION_NOTICE_ID,
		},
	];
}

/**
 * Builds the push translation fail notification arguments for dispatch.
 *
 * @param {Object} data Incoming data to build the arguments with.
 * @return {Array} Arguments for dispatch. An empty array signals no
 *                 notification should be sent.
 */
export function getNotificationArgumentsForPushTranslationFail( data ) {
	const { error } = data;

	return [
		getNotificationMessageArgument(
			error,
			// translators: %s: Failure reason. */
			__( 'Pushing translation failed: %s', 'phrase' )
		),
		{
			id: PUSH_TRANSLATION_NOTICE_ID,
		},
	];
}
