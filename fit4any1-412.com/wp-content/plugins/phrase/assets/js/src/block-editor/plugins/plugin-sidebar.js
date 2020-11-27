/**
 * WordPress dependencies.
 */
import { registerPlugin } from '@wordpress/plugins';
import { PluginSidebar, PluginSidebarMoreMenuItem } from '@wordpress/edit-post';
import { createSlotFill, PanelBody, ExternalLink } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { createInterpolateElement } from '@wordpress/element';

/**
 * Internal dependencies
 */
import PhraseAppLogo from '../components/icons/phrase-app-logo';
import './plugin-sidebar.css';

const { Fill, Slot } = createSlotFill( 'PhrasePluginSidebar' );

export { Fill as default };

registerPlugin( 'phrase-plugin-sidebar', {
	render: () => (
		<Slot>
			{ ( fills ) => {
				if ( ! fills.length ) {
					return null;
				}

				return (
					<>
						<PluginSidebarMoreMenuItem
							target="phrase"
							icon={
								<PhraseAppLogo
									className="phrase-app-logo"
									height={ 24 }
									width={ 24 }
								/>
							}
						>
							Phrase
						</PluginSidebarMoreMenuItem>
						<PluginSidebar
							name="phrase"
							icon={
								<PhraseAppLogo
									className="phrase-app-logo"
									height={ 24 }
									width={ 24 }
								/>
							}
							title="Phrase"
							className="phrase-plugin-sidebar"
						>
							<div className="phrase-plugin-sidebar__content">
								<PanelBody initialOpen={ true }>{ fills }</PanelBody>
							</div>
							<div className="phrase-plugin-sidebar__footer">
								<p>
									{ createInterpolateElement(
										__(
											'<Logo /> Powered by <PhraseLink>Phrase</PhraseLink> · <PhraseSupportLink>Help & Support</PhraseSupportLink>',
											'phrase'
										),
										{
											Logo: <PhraseAppLogo height={ 12 } width={ 12 } />,
											PhraseLink: <ExternalLink href="https://phrase.com/" />,
											PhraseSupportLink: (
												<ExternalLink href="https://help.phrase.com/help/wordpress-plugin" />
											),
										}
									) }
								</p>
							</div>
						</PluginSidebar>
					</>
				);
			} }
		</Slot>
	),
} );
