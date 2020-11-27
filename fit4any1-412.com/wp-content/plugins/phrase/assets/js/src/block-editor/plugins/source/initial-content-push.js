/**
 * WordPress dependencies.
 */
import { registerPlugin } from '@wordpress/plugins';
import { PanelRow } from '@wordpress/components';

/**
 * Internal dependencies
 */
import { PhrasePluginSidebarContentSource } from '../plugin-sidebar-content';
import ContentPushButton from '../../components/content-push-button';
import ContentPushCheck from '../../components/content-push-check';
import './initial-content-push.css';

registerPlugin( 'phrase-initial-content-push', {
	render: () => (
		<ContentPushCheck>
			<PhrasePluginSidebarContentSource>
				<PanelRow className="phrase-initial-content-push">
					<ContentPushButton />
				</PanelRow>
			</PhrasePluginSidebarContentSource>
		</ContentPushCheck>
	),
} );
