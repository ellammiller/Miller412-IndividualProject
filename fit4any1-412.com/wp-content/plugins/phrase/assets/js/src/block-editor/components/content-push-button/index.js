/**
 * WordPress dependencies.
 */
import { __ } from '@wordpress/i18n';
import { Button, Tip } from '@wordpress/components';
import { upload } from '@wordpress/icons';
import { useSelect, useDispatch } from '@wordpress/data';

/**
 * Internal dependencies
 */
import { STORE_KEY } from '../../store';

const ContentPushButton = () => {
	const { pushContent } = useDispatch( STORE_KEY );
	const { isPostSaveable, isPostSaving } = useSelect( ( select ) => {
		const { isEditedPostSaveable, isSavingPost } = select( 'core/editor' );

		return {
			isPostSaveable: isEditedPostSaveable(),
			isPostSaving: isSavingPost(),
		};
	}, [] );
	const { hasProject, hasLocale, isProcessing } = useSelect( ( select ) => {
		const { hasProjectId, hasLocaleId, isPushingContent } = select( STORE_KEY );
		return {
			hasProject: hasProjectId(),
			hasLocale: hasLocaleId(),
			isProcessing: isPushingContent(),
		};
	}, [] );

	return (
		<>
			<Button
				icon={ upload }
				isPrimary
				isBusy={ isProcessing }
				onClick={ pushContent }
				className="phrase-push-content"
				disabled={ ! hasProject || ! hasLocale || isProcessing || ! isPostSaveable }
			>
				{ __( 'Push content', 'phrase' ) }
			</Button>
			{ ( ! hasProject || ! hasLocale || ! isPostSaveable ) && ! isPostSaving && (
				<Tip>
					{ __(
						"To get started please select a project, set the language and don't forget to write some content.",
						'phrase'
					) }
				</Tip>
			) }
		</>
	);
};

export default ContentPushButton;
