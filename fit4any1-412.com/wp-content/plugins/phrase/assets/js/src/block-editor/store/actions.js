/**
 * WordPress dependencies
 */
import { select, dispatch, apiFetch } from '@wordpress/data-controls';
import { __, _n, sprintf } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import {
	HAS_INITIAL_CONTENT_PUSH_META_KEY,
	PUSH_CONTENT_NOTICE_ID,
	PULL_TRANSLATIONS_NOTICE_ID,
	PUSH_TRANSLATION_NOTICE_ID,
	PULL_TRANSLATION_NOTICE_ID,
} from '../constants';
import { STORE_KEY } from './';
import {
	getNotificationArgumentsForPushContentFail,
	getNotificationArgumentsForPullTranslationsFail,
	getNotificationArgumentsForPullTranslationFail,
	getNotificationArgumentsForPushTranslationFail,
} from './utils/notice-builder';

/**
 * Returns an action object used to fetch status from the REST API into the store.
 *
 * @param {Object} status Status object.
 * @return {Object} Action object.
 */
export function setStatus( status ) {
	return {
		type: 'SET_STATUS',
		status,
	};
}

/**
 * Returns an action object used to fetch projects from the REST API into the store.
 *
 * @return {Object} Action object.
 */
export function fetchProjects() {
	return {
		type: 'FETCH_PROJECTS',
	};
}

/**
 * Returns an action object used to receive projects from the REST API into the store.
 *
 * @param {Array} projects
 * @return {Object} Action object.
 */
export function receiveProjects( projects ) {
	return {
		type: 'RECEIVE_PROJECTS',
		projects,
	};
}

/**
 * Returns an action object used to receive projects from the REST API into the store.
 *
 * @param {Object} error
 * @return {Object} Action object.
 */
export function fetchProjectsFailure( error ) {
	return {
		type: 'FETCH_PROJECTS_FAILURE',
		error,
	};
}

/**
 * Returns an action object used to fetch locales from the REST API into the store.
 *
 * @param {string} projectId Project ID.
 * @return {Object} Action object.
 */
export function fetchLocales( projectId ) {
	return {
		type: 'FETCH_LOCALES',
		projectId,
	};
}

/**
 * Returns an action object used to receive locales from the REST API into the store.
 *
 * @param {string} projectId Project ID.
 * @param {Array} locales
 * @return {Object} Action object.
 */
export function receiveLocales( projectId, locales ) {
	return {
		type: 'RECEIVE_LOCALES',
		projectId,
		locales,
	};
}

/**
 * Returns an action object used to receive projects from the REST API into the store.
 *
 * @param {Object} error
 * @return {Object} Action object.
 */
export function fetchLocalesFailure( error ) {
	return {
		type: 'FETCH_LOCALES_FAILURE',
		error,
	};
}

/**
 * Returns an action object used to fetch translations from the REST API into the store.
 *
 * @return {Object} Action object.
 */
export function fetchTranslations() {
	return {
		type: 'FETCH_TRANSLATIONS',
	};
}

/**
 * Returns an action object used to receive translations from the REST API into the store.
 *
 * @param {Array} translations
 * @return {Object} Action object.
 */
export function receiveTranslations( translations ) {
	return {
		type: 'RECEIVE_TRANSLATIONS',
		translations,
	};
}

/**
 * Returns an action object used to receive locales from the REST API into the store.
 *
 * @param {string} projectId Project ID.
 * @param {Object} error
 * @return {Object} Action object.
 */
export function fetchTranslationsFailure( projectId, error ) {
	return {
		type: 'FETCH_TRANSLATIONS_FAILURE',
		projectId,
		error,
	};
}

/**
 * Returns an action object used to set translation pre-conditions checks state into the store.
 *
 * @param {Object} checks Checks object.
 * @param {number} count Number of total checks.
 * @return {Object} Action object.
 */
export function pullTranslationsPreConditionChecks( checks, count ) {
	return {
		type: 'SET_TRANSLATIONS_PRE_CONDITION_CHECKS',
		checks,
		count,
	};
}

/**
 * Returns an action object used to clear translation pre-conditions checks state into the store.
 *
 * @return {Object} Action object.
 */
export function clearPullTranslationsPreConditionChecks() {
	return {
		type: 'CLEAR_TRANSLATIONS_PRE_CONDITION_CHECKS',
	};
}

/**
 * Returns an action object used in signalling that an upload has begun.
 *
 * @return {Object} Action object.
 */
export function startPushingContent() {
	return {
		type: 'START_PUSHING_CONTENT',
	};
}

/**
 * Returns an action object used in signalling that an upload has stopped.
 *
 * @return {Object} Action object.
 */
export function stopPushingContent() {
	return {
		type: 'STOP_PUSHING_CONTENT',
	};
}

/**
 * Yields action objects used for pushing content to Phrase.
 *
 * @param {Object}  args
 * @param {boolean} args.skipUnverification Whether the upload should unverify updated translations.
 */
export function* pushContent( { skipUnverification = false } ) {
	yield dispatch( STORE_KEY, 'startPushingContent' );
	yield dispatch( 'core/notices', 'removeNotice', PUSH_CONTENT_NOTICE_ID );

	const isPostDirty = yield select( 'core/editor', 'isEditedPostDirty' );

	// Save current changes.
	if ( isPostDirty ) {
		yield dispatch( 'core/editor', 'savePost' );
		yield dispatch( 'core/notices', 'removeNotice', 'SAVE_POST_NOTICE_ID' );
	}

	const postId = yield select( 'core/editor', 'getCurrentPostId' );
	const projectId = yield select( STORE_KEY, 'getCurrentProjectId' );
	const localeId = yield select( STORE_KEY, 'getCurrentLocaleId' );
	const isUpdate = yield select( STORE_KEY, 'hasInitialContentPush' );

	let uploadId;
	let uploadStatus;
	let translationsCreated;
	let translationsUpdated;
	let appEditorUrl;
	let appUploadUrl;
	try {
		const response = yield apiFetch( {
			path: '/phrase/v1/push-content',
			method: 'POST',
			data: {
				post_id: postId,
				project_id: projectId,
				locale_id: localeId,
				skip_unverification: skipUnverification,
			},
		} );
		uploadId = response.id;
		uploadStatus = response.state;
		translationsCreated = response.translation_created;
		translationsUpdated = response.translation_updated;
		appEditorUrl = response.app_editor_url;
		appUploadUrl = response.app_upload_url;
	} catch ( error ) {
		yield dispatch(
			'core/notices',
			'createErrorNotice',
			...getNotificationArgumentsForPushContentFail( { error } )
		);
		yield dispatch( STORE_KEY, 'stopPushingContent' );

		return;
	}

	// Check for status until upload is completed. State will be 'success' or 'error'.
	while ( 'initialized' === uploadStatus || 'processing' === uploadStatus ) {
		// TODO: Add interval? Limit to x requests?
		try {
			const response = yield apiFetch( {
				path: `/phrase/v1/push-content/${ uploadId }?project_id=${ projectId }`,
			} );
			uploadStatus = response.state;
			translationsCreated = response.translation_created;
			translationsUpdated = response.translation_updated;
			appEditorUrl = response.app_editor_url;
			appUploadUrl = response.app_upload_url;
		} catch ( error ) {
			yield dispatch(
				'core/notices',
				'createErrorNotice',
				...getNotificationArgumentsForPushContentFail( { error } )
			);
			yield dispatch( STORE_KEY, 'stopPushingContent' );

			return;
		}
	}

	// Save meta flag that this post has been initially uploaded.
	if ( ! isUpdate ) {
		yield dispatch( 'core/editor', 'editPost', {
			meta: { [ HAS_INITIAL_CONTENT_PUSH_META_KEY ]: true },
		} );
	}

	// Save changes and reload post.
	yield dispatch( 'core/editor', 'savePost' );
	yield dispatch( 'core/notices', 'removeNotice', 'SAVE_POST_NOTICE_ID' );

	// Dispatch success notice.
	let message = '';

	if ( translationsCreated ) {
		message +=
			' ' +
			sprintf(
				// translators: %d: Number of created translations.
				_n(
					'%d translation created.',
					'%d translations created.',
					translationsCreated,
					'phrase'
				),
				translationsCreated
			);
	}

	if ( translationsUpdated ) {
		message +=
			' ' +
			sprintf(
				// translators: %d: Number of created translations.
				_n(
					'%d translation updated.',
					'%d translations updated.',
					translationsUpdated,
					'phrase'
				),
				translationsUpdated
			);
	}

	message = message.trim();

	if ( ! message ) {
		message = __( 'Upload done without changes.', 'phrase' );
	}

	const actions = [];
	if ( appUploadUrl ) {
		actions.push( {
			url: appUploadUrl,
			label: __( 'Create a job', 'phrase' ),
			className: 'phrase-push-content-notice-action',
		} );
	}
	if ( appEditorUrl ) {
		actions.push( {
			url: appEditorUrl,
			label: __( 'Open in Phrase', 'phrase' ),
			className: 'phrase-push-content-notice-action is-secondary',
			noDefaultClasses: true,
		} );
	}

	yield dispatch( 'core/notices', 'createSuccessNotice', message, {
		id: PUSH_CONTENT_NOTICE_ID,
		actions,
	} );

	yield dispatch( STORE_KEY, 'stopPushingContent' );
}

/**
 * Returns an action object used in signalling that a pull task has begun.
 *
 * @return {Object} Action object.
 */
export function startPullingTranslations() {
	return {
		type: 'START_PULLING_TRANSLATIONS',
	};
}

/**
 * Returns an action object used in signalling that a pull task has stopped.
 *
 * @return {Object} Action object.
 */
export function stopPullingTranslations() {
	return {
		type: 'STOP_PULLING_TRANSLATIONS',
	};
}

/**
 * Yields action objects used for pulling translations.
 *
 * @param {Array}   localeIds Locale IDs to pull translations for.
 * @param {boolean} force     Skip pre-conditions.
 */
export function* pullTranslations( localeIds, force = false ) {
	yield dispatch( STORE_KEY, 'startPullingTranslations' );
	yield dispatch( 'core/notices', 'removeNotice', PULL_TRANSLATIONS_NOTICE_ID );

	const postId = yield select( 'core/editor', 'getCurrentPostId' );

	try {
		const translations = yield apiFetch( {
			path: `/phrase/v1/translations/${ postId }`,
			method: 'POST',
			data: {
				locales: localeIds,
				force,
			},
		} );
		yield dispatch( STORE_KEY, 'receiveTranslations', translations );
	} catch ( error ) {
		if ( 'pre_conditions_failed' === error.code ) {
			yield dispatch(
				STORE_KEY,
				'pullTranslationsPreConditionChecks',
				error.data.checks,
				error.data.count
			);
		} else {
			yield dispatch(
				'core/notices',
				'createErrorNotice',
				...getNotificationArgumentsForPullTranslationsFail( { error } )
			);
		}
	}

	yield dispatch(
		'core/notices',
		'createSuccessNotice',
		__( 'Pulled translations successfully.', 'phrase' ),
		{
			id: PULL_TRANSLATIONS_NOTICE_ID,
		}
	);

	yield dispatch( STORE_KEY, 'stopPullingTranslations' );
}

/**
 * Returns an action object used in signalling that a pull task has begun.
 *
 * @return {Object} Action object.
 */
export function startPullingTranslation() {
	return {
		type: 'START_PULLING_TRANSLATION',
	};
}

/**
 * Returns an action object used in signalling that a pull task has stopped.
 *
 * @return {Object} Action object.
 */
export function stopPullingTranslation() {
	return {
		type: 'STOP_PULLING_TRANSLATION',
	};
}

/**
 * Yields action objects used for pulling current translation.
 */
export function* pullTranslation() {
	yield dispatch( STORE_KEY, 'startPullingTranslation' );
	yield dispatch( 'core/notices', 'removeNotice', PULL_TRANSLATION_NOTICE_ID );

	const postId = yield select( 'core/editor', 'getCurrentPostId' );
	const localeId = yield select( STORE_KEY, 'getCurrentLocaleId' );

	yield dispatch( 'core/editor', 'savePost' );
	yield dispatch( 'core/notices', 'removeNotice', 'SAVE_POST_NOTICE_ID' );

	try {
		const translations = yield apiFetch( {
			path: `/phrase/v1/translations/${ postId }`,
			method: 'POST',
			data: {
				locales: [ localeId ],
				force: true,
			},
		} );
		yield dispatch( STORE_KEY, 'receiveTranslations', translations );
	} catch ( error ) {
		yield dispatch(
			'core/notices',
			'createErrorNotice',
			...getNotificationArgumentsForPullTranslationFail( { error } )
		);
		yield dispatch( STORE_KEY, 'stopPullingTranslation' );

		return;
	}

	yield dispatch(
		'core/notices',
		'createSuccessNotice',
		__( 'Pulled translation successfully. Reloading the post…', 'phrase' ),
		{
			id: PULL_TRANSLATION_NOTICE_ID,
		}
	);

	// TODO: Show modal to confirm reload or show overlay?
	window.location.reload();
}

/**
 * Returns an action object used in signalling that a push task has begun.
 *
 * @return {Object} Action object.
 */
export function startPushingTranslation() {
	return {
		type: 'START_PUSHING_TRANSLATION',
	};
}

/**
 * Returns an action object used in signalling that a push task has stopped.
 *
 * @return {Object} Action object.
 */
export function stopPushingTranslation() {
	return {
		type: 'STOP_PUSHING_TRANSLATION',
	};
}

/**
 * Yields action objects used for pushing translation to Phrase.
 */
export function* pushTranslation() {
	yield dispatch( STORE_KEY, 'startPushingTranslation' );
	yield dispatch( 'core/notices', 'removeNotice', PUSH_TRANSLATION_NOTICE_ID );

	const isPostDirty = yield select( 'core/editor', 'isEditedPostDirty' );

	// Save current changes.
	if ( isPostDirty ) {
		yield dispatch( 'core/editor', 'savePost' );
		yield dispatch( 'core/notices', 'removeNotice', 'SAVE_POST_NOTICE_ID' );
	}

	const postId = yield select( 'core/editor', 'getCurrentPostId' );

	let uploadId;
	let uploadStatus;
	let translationsCreated;
	let translationsUpdated;
	let appEditorUrl;
	try {
		const response = yield apiFetch( {
			path: '/phrase/v1/push-translation',
			method: 'POST',
			data: {
				post_id: postId,
			},
		} );
		uploadId = response.id;
		uploadStatus = response.state;
		translationsCreated = response.translation_created;
		translationsUpdated = response.translation_updated;
		appEditorUrl = response.app_editor_url;
	} catch ( error ) {
		yield dispatch(
			'core/notices',
			'createErrorNotice',
			...getNotificationArgumentsForPushTranslationFail( { error } )
		);
		yield dispatch( STORE_KEY, 'stopPushingTranslation' );

		return;
	}

	// Check for status until upload is completed. State will be 'success' or 'error'.
	while ( 'initialized' === uploadStatus || 'processing' === uploadStatus ) {
		// TODO: Add interval? Limit to x requests?
		try {
			const response = yield apiFetch( {
				path: `/phrase/v1/push-translation/${ uploadId }?post_id=${ postId }`,
			} );
			uploadStatus = response.state;
			translationsCreated = response.translation_created;
			translationsUpdated = response.translation_updated;
			appEditorUrl = response.app_editor_url;
		} catch ( error ) {
			yield dispatch(
				'core/notices',
				'createErrorNotice',
				...getNotificationArgumentsForPushTranslationFail( { error } )
			);
			yield dispatch( STORE_KEY, 'stopPushingTranslation' );

			return;
		}
	}

	// Dispatch success notice.
	let message = '';

	if ( translationsCreated ) {
		message += sprintf(
			// translators: %d: Number of created translations.
			_n(
				'%d translation created.',
				'%d translations created.',
				translationsCreated,
				'phrase'
			),
			translationsCreated
		);
	}

	if ( translationsUpdated ) {
		message +=
			' ' +
			sprintf(
				// translators: %d: Number of created translations.
				_n(
					'%d translation updated.',
					'%d translations updated.',
					translationsUpdated,
					'phrase'
				),
				translationsUpdated
			);
	}

	message = message.trim();

	const actions = [];

	if ( ! message ) {
		message = __( 'Upload done without changes.', 'phrase' );
	} else if ( appEditorUrl ) {
		actions.push( {
			url: appEditorUrl,
			label: __( 'Open in Phrase', 'phrase' ),
			className: 'phrase-push-content-notice-action is-secondary',
			noDefaultClasses: true,
		} );
	}

	yield dispatch( 'core/notices', 'createSuccessNotice', message, {
		id: PUSH_CONTENT_NOTICE_ID,
		actions,
	} );

	yield dispatch( STORE_KEY, 'stopPushingTranslation' );
}

/**
 * Returns an action object used in signalling that the last used project
 * should be updated.
 *
 * @param {string} id The project ID.
 * @return {Object} Action object.
 */
export function updateLastUsedProject( id ) {
	return {
		type: 'UPDATE_LAST_USED_PROJECT',
		id,
	};
}
