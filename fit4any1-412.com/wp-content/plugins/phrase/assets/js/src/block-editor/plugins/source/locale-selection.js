/**
 * WordPress dependencies.
 */
import { registerPlugin } from '@wordpress/plugins';
import { PanelRow } from '@wordpress/components';

/**
 * Internal dependencies
 */
import { PhrasePluginSidebarContentSource } from '../plugin-sidebar-content';
import ContentPushCheck from '../../components/content-push-check';
import PostLanguageSelector from '../../components/post-language-selector';
import './locale-selection.css';

registerPlugin( 'phrase-locale-selection', {
	render: () => (
		<ContentPushCheck>
			<PhrasePluginSidebarContentSource>
				<PanelRow className="phrase-locale-selection">
					<PostLanguageSelector />
				</PanelRow>
			</PhrasePluginSidebarContentSource>
		</ContentPushCheck>
	),
} );
