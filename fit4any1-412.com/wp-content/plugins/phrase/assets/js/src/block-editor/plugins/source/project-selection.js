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
import ProjectSelector from '../../components/project-selector';
import './project-selection.css';

registerPlugin( 'phrase-project-selection', {
	render: () => (
		<ContentPushCheck>
			<PhrasePluginSidebarContentSource>
				<PanelRow className="phrase-project-selection">
					<ProjectSelector />
				</PanelRow>
			</PhrasePluginSidebarContentSource>
		</ContentPushCheck>
	),
} );
