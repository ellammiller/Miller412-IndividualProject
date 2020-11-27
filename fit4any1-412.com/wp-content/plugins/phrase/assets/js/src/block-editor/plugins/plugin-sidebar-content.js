/**
 * WordPress dependencies.
 */
import { registerPlugin } from '@wordpress/plugins';
import { createSlotFill, PanelRow, Tip } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import PhrasePluginSidebar from './plugin-sidebar';
import { STORE_KEY } from '../store';

const {
	Fill: PhrasePluginSidebarContentSourceFill,
	Slot: PhrasePluginSidebarContentSourceSlot,
} = createSlotFill( 'PhrasePluginSidebarContentSource' );
const {
	Fill: PhrasePluginSidebarContentTranslationFill,
	Slot: PhrasePluginSidebarContentTranslationSlot,
} = createSlotFill( 'PhrasePluginSidebarContentTranslation' );

export { PhrasePluginSidebarContentSourceFill as PhrasePluginSidebarContentSource };
export { PhrasePluginSidebarContentTranslationFill as PhrasePluginSidebarContentTranslation };

const PluginSidebarContent = () => {
	const { hasApiToken, isTranslations } = useSelect( ( select ) => {
		const { getStatus, isEditedPostTranslation } = select( STORE_KEY );

		return {
			hasApiToken: getStatus()?.has_key || false,
			isTranslations: isEditedPostTranslation(),
		};
	} );

	if ( ! hasApiToken ) {
		return (
			<PhrasePluginSidebar>
				<PanelRow className="phrase-missing-key">
					<Tip>
						{ __(
							'To use Phrase please enter an API access token in the settings.',
							'phrase'
						) }
					</Tip>
				</PanelRow>
			</PhrasePluginSidebar>
		);
	}

	return (
		<>
			{ isTranslations ? (
				<PhrasePluginSidebarContentTranslationSlot>
					{ ( fills ) => {
						if ( ! fills.length ) {
							return null;
						}

						return <PhrasePluginSidebar>{ fills }</PhrasePluginSidebar>;
					} }
				</PhrasePluginSidebarContentTranslationSlot>
			) : (
				<PhrasePluginSidebarContentSourceSlot>
					{ ( fills ) => {
						if ( ! fills.length ) {
							return null;
						}

						return <PhrasePluginSidebar>{ fills }</PhrasePluginSidebar>;
					} }
				</PhrasePluginSidebarContentSourceSlot>
			) }
		</>
	);
};

registerPlugin( 'phrase-plugin-sidebar-content', {
	render: () => <PluginSidebarContent />,
} );
