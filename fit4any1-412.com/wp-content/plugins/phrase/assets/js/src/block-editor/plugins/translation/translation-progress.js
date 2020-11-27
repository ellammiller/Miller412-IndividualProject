/**
 * External dependencies
 */
import { find } from 'lodash';

/**
 * WordPress dependencies.
 */
import { registerPlugin } from '@wordpress/plugins';
import { PanelRow, Button } from '@wordpress/components';
import { useSelect, useDispatch } from '@wordpress/data';
import { __, _x } from '@wordpress/i18n';
import { upload, chevronRight } from '@wordpress/icons';

/**
 * Internal dependencies
 */
import { PhrasePluginSidebarContentTranslation } from '../plugin-sidebar-content';
import DateTime from '../../components/date-time';
import download from '../../components/icons/download';
import { Completed, InProgress, NotStarted } from '../../components/status';
import SelectedProject from '../../components/selected-project';
import Flag from '../../components/flag';
import { STORE_KEY } from '../../store';
import './translation-progress.css';

const SourceContent = () => {
	const source = useSelect( ( select ) => select( STORE_KEY ).getSource() );
	if ( ! source ) {
		return null;
	}

	return (
		<>
			<span>{ __( 'Source content', 'phrase' ) }</span>
			<table className="phrase-translation-progress__table">
				<thead>
					<tr>
						<th className="phrase-translation-progress__table-column--title">
							{ __( 'Title', 'phrase' ) }
						</th>
						<th className="phrase-translation-progress__table-column--update">
							{ __( 'Last update', 'phrase' ) }
						</th>
						<th className="phrase-translation-progress__table-column--edit"></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td className="phrase-translation-progress__table-column--title">
							<a href={ source.post_edit_url }>{ source.title }</a>
						</td>
						<td className="phrase-translation-progress__table-column--update">
							<DateTime fromNow>{ source.last_updated }</DateTime>
						</td>
						<td className="phrase-translation-progress__table-column--edit">
							<Button
								label={ __( 'Edit source', 'phrase' ) }
								showTooltip
								href={ source.post_edit_url }
								icon={ chevronRight }
							/>
						</td>
					</tr>
				</tbody>
			</table>
		</>
	);
};

const TranslationPullPushButtons = () => {
	const { pullTranslation, pushTranslation } = useDispatch( STORE_KEY );
	const { isPushing, isPulling } = useSelect( ( select ) => {
		const { isPushingTranslation, isPullingTranslation } = select( STORE_KEY );

		return {
			isPushing: isPushingTranslation(),
			isPulling: isPullingTranslation(),
		};
	}, [] );
	return (
		<>
			<Button
				icon={ download }
				isBusy={ isPulling }
				disabled={ isPushing || isPulling }
				onClick={ pullTranslation }
				isTertiary
				className="phrase-button--align-left"
			>
				{ _x( 'Pull', 'pull translation', 'phrase' ) }
			</Button>
			<Button
				icon={ upload }
				isBusy={ isPushing }
				disabled={ isPushing || isPulling }
				onClick={ pushTranslation }
				isSecondary
				className="phrase-button--extra-padding"
			>
				{ _x( 'Push', 'push translation', 'phrase' ) }
			</Button>
		</>
	);
};

const TranslationProgress = () => {
	const translation = useSelect( ( select ) => {
		const { getTranslations, getCurrentLocaleId } = select( STORE_KEY );

		return find( getTranslations(), { id: getCurrentLocaleId() } ) || null;
	}, [] );

	if ( ! translation ) {
		return null;
	}

	const {
		name: localeName,
		code: localeCode,
		percent_translated: percentTranslated,
		last_updated: lastUpdated,
	} = translation;

	return (
		<>
			<span className="phrase-translation-progress__title">
				{ __( 'Translation', 'phrase' ) }
			</span>
			<table className="phrase-translation-progress__table">
				<thead>
					<tr>
						<th className="phrase-translation-progress__table-column--locale">
							{ __( 'Language', 'phrase' ) }
						</th>
						<th className="phrase-translation-progress__table-column--status">
							{ __( 'Status', 'phrase' ) }
						</th>
						<th className="phrase-translation-progress__table-column--update">
							{ __( 'Last update', 'phrase' ) }
						</th>
						<th className="phrase-translation-progress__table-column--edit"></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td className="phrase-translation-progress__table-column--locale">
							<span className="phrase-locale-name-with-flag">
								<Flag code={ localeCode } />
								<span className="phrase-locale-name">{ localeName }</span>
							</span>
						</td>
						<td className="phrase-translation-progress__table-column--status">
							{ 0 === percentTranslated && <NotStarted /> }
							{ percentTranslated > 0 && percentTranslated < 100 && <InProgress /> }
							{ 100 === percentTranslated && <Completed /> }
						</td>
						<td className="phrase-translation-progress__table-column--update">
							{ lastUpdated ? (
								<DateTime fromNow>{ lastUpdated }</DateTime>
							) : (
								__( 'Never', 'phrase' )
							) }
						</td>
						<td className="phrase-translation-progress__table-column--edit"></td>
					</tr>
				</tbody>
			</table>
		</>
	);
};

registerPlugin( 'phrase-translation-progress', {
	render: () => (
		<PhrasePluginSidebarContentTranslation>
			<PanelRow className="phrase-selected-project">
				<SelectedProject />
			</PanelRow>
			<PanelRow className="phrase-source-content">
				<SourceContent />
			</PanelRow>
			<PanelRow className="phrase-translation-progress">
				<TranslationProgress />
			</PanelRow>
			<PanelRow className="phrase-pull-push-translation">
				<TranslationPullPushButtons />
			</PanelRow>
		</PhrasePluginSidebarContentTranslation>
	),
} );
