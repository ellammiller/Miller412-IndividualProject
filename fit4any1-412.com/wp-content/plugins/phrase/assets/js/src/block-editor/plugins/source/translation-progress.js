/**
 * External dependencies
 */
import { find, reduce } from 'lodash';

/**
 * WordPress dependencies.
 */
import { registerPlugin } from '@wordpress/plugins';
import { PanelRow, Button, CheckboxControl, Modal } from '@wordpress/components';
import { useSelect, useDispatch } from '@wordpress/data';
import { __, _n, _x, sprintf } from '@wordpress/i18n';
import { upload, chevronRight, info, Icon } from '@wordpress/icons';
import { useState } from '@wordpress/element';
import { useEntityProp } from '@wordpress/core-data';

/**
 * Internal dependencies
 */
import { PhrasePluginSidebarContentSource } from '../plugin-sidebar-content';
import ContentPushCheck from '../../components/content-push-check';
import DateTime from '../../components/date-time';
import download from '../../components/icons/download';
import SelectedProject from '../../components/selected-project';
import Flag from '../../components/flag';
import HelpTooltip from '../../components/help-tooltip';
import { Completed, InProgress, NotStarted } from '../../components/status';
import { STORE_KEY } from '../../store';
import { LAST_UPDATED_PROP_KEY } from '../../constants';
import './translation-progress.css';

const SourceContent = () => {
	const postType = useSelect( ( select ) => select( 'core/editor' ).getCurrentPostType(), [] );
	const [ lastUpdated ] = useEntityProp( 'postType', postType, LAST_UPDATED_PROP_KEY );
	const locale = useSelect( ( select ) => {
		const { getLocales, getCurrentLocaleId, getCurrentProjectId } = select( STORE_KEY );

		return find( getLocales( getCurrentProjectId() ), { id: getCurrentLocaleId() } );
	}, [] );

	if ( ! locale ) {
		return null;
	}

	return (
		<>
			<span>{ __( 'Source content', 'phrase' ) }</span>
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
								<Flag code={ locale.code } />
								<span className="phrase-locale-name">{ locale.name }</span>
							</span>
						</td>
						<td className="phrase-translation-progress__table-column--status">
							<Completed />
						</td>
						<td className="phrase-translation-progress__table-column--update">
							<DateTime fromNow>{ lastUpdated }</DateTime>
						</td>
						<td className="phrase-translation-progress__table-column--edit"></td>
					</tr>
				</tbody>
			</table>
		</>
	);
};

const SourcePullPushButtons = () => {
	const [ skipUnverification, setSkipUnverification ] = useState( false );
	const { pushContent, pullTranslation } = useDispatch( STORE_KEY );
	const { isPushing, isPulling } = useSelect( ( select ) => {
		const { isPushingContent, isPullingTranslation } = select( STORE_KEY );

		return {
			isPushing: isPushingContent(),
			isPulling: isPullingTranslation(),
		};
	}, [] );

	return (
		<>
			<div className="phrase-checkbox-skip-unverification">
				<CheckboxControl
					className="phrase-checkbox-control--small"
					label={ __( 'Skip unverification', 'phrase' ) }
					checked={ skipUnverification }
					onChange={ () => setSkipUnverification( ! skipUnverification ) }
				/>
				<HelpTooltip>
					{ __(
						'This prevents the need to verify non-main language translations again when pushing content.',
						'phrase'
					) }
				</HelpTooltip>
			</div>
			<Button
				icon={ download }
				isBusy={ isPulling }
				disabled={ isPulling || isPushing }
				onClick={ pullTranslation }
				isTertiary
				className="phrase-button--align-left"
			>
				{ _x( 'Pull', 'pull content', 'phrase' ) }
			</Button>
			<Button
				icon={ upload }
				isBusy={ isPushing }
				disabled={ isPulling || isPushing }
				onClick={ () => pushContent( { skipUnverification } ) }
				isSecondary
				className="phrase-button--extra-padding"
			>
				{ _x( 'Push', 'push content', 'phrase' ) }
			</Button>
		</>
	);
};

const PreConditionsModal = ( {
	selectedLocales,
	translations,
	preConditionChecks,
	selectLocale,
	unselectLocale,
} ) => {
	const [ selectedLocalesCopy ] = useState( selectedLocales );
	const preConditionChecksCount = useSelect(
		( select ) => select( STORE_KEY ).getPullTranslationsPreConditionChecksCount(),
		[]
	);
	const { pullTranslations, clearPullTranslationsPreConditionChecks } = useDispatch( STORE_KEY );

	if ( ! preConditionChecks ) {
		return null;
	}

	return (
		<Modal
			title={ sprintf(
				// translators: %d: Number of warnings.
				_n( '%d warning', '%d warnings', preConditionChecksCount, 'phrase' ),
				preConditionChecksCount
			) }
			shouldCloseOnEsc={ false }
			shouldCloseOnClickOutside={ false }
			focusOnMount={ true }
			onRequestClose={ clearPullTranslationsPreConditionChecks }
			className="phrase-pre-conditions-modal"
		>
			<div className="phrase-pre-conditions-modal__content">
				<p>
					{ __(
						'Verify and confirm pulling translations for the following languages:',
						'phrase'
					) }
				</p>
				<div className="phrase-pre-conditions-checks">
					{ selectedLocalesCopy.map( ( locale ) => {
						const translation = find( translations, { id: locale } );
						const checks = preConditionChecks[ locale ] || [];
						const hasErrors = checks.length > 0;

						const messages = checks.map( ( check ) => {
							switch ( check ) {
								case 'modified':
									return __(
										'Post modified since last pull. If you pull, content may be lost.',
										'phrase'
									);
								case 'published':
									return __(
										'Post already published. Pulled content will be immediately live.',
										'phrase'
									);
								default:
									return __( 'Unknown error.', 'phrase' );
							}
						} );

						return (
							<div key={ locale } className="phrase-pre-conditions-check">
								<CheckboxControl
									className="phrase-pre-conditions-check__locale"
									key={ locale }
									label={
										<>
											<Flag code={ translation.code } /> { translation.name }
										</>
									}
									checked={ selectedLocales.includes( locale ) }
									onChange={ ( checked ) =>
										checked ? selectLocale( locale ) : unselectLocale( locale )
									}
								/>
								<div className="phrase-pre-conditions-check__message">
									{ hasErrors ? (
										<>
											{ messages.map( ( message ) => (
												<p key={ message }>
													<Icon
														className="phrase-pre-conditions-check-icon"
														icon={ info }
													/>
													{ message }
												</p>
											) ) }
										</>
									) : (
										<>&ndash;</>
									) }
								</div>
							</div>
						);
					} ) }
				</div>
			</div>
			<div className="phrase-pre-conditions-modal__buttons">
				<Button isSecondary onClick={ clearPullTranslationsPreConditionChecks }>
					{ __( 'Cancel', 'phrase' ) }
				</Button>
				<Button
					icon={ download }
					isPrimary
					disabled={ 0 === selectedLocales.length }
					onClick={ () => pullTranslations( selectedLocales, true ) }
				>
					{ selectedLocales.length > 0
						? sprintf(
								// translators: %s: Number of selected languages.
								__( 'Confirm and pull translations (%s)', 'phrase' ),
								selectedLocales.length
						  )
						: __( 'Confirm and pull translations', 'phrase' ) }
				</Button>
			</div>
		</Modal>
	);
};

const TranslationProgress = () => {
	const { pullTranslations } = useDispatch( STORE_KEY );
	const [ selectedLocales, setSelectedLocales ] = useState( [] );
	const { translations, isPulling, preConditionChecks } = useSelect( ( select ) => {
		const {
			isPullingTranslations,
			getCurrentLocaleId,
			getTranslations,
			getPullTranslationsPreConditionChecks,
		} = select( STORE_KEY );
		const currentLocaleId = getCurrentLocaleId();

		return {
			isPulling: isPullingTranslations(),
			translations: reduce(
				getTranslations(),
				( result, translation ) => {
					if ( translation.id !== currentLocaleId ) {
						result.push( translation );
					}
					return result;
				},
				[]
			),
			preConditionChecks: getPullTranslationsPreConditionChecks(),
		};
	}, [] );

	const selectLocale = ( localeToAdd ) => {
		setSelectedLocales( [ ...selectedLocales, localeToAdd ] );
	};
	const selectAllLocales = () => {
		setSelectedLocales( [ ...translations.map( ( locale ) => locale.id ) ] );
	};
	const unselectLocale = ( localeToRemove ) => {
		setSelectedLocales( selectedLocales.filter( ( locale ) => locale !== localeToRemove ) );
	};
	const unselectAllLocales = () => setSelectedLocales( [] );

	if ( ! translations?.length ) {
		return null;
	}

	return (
		<>
			{ !! preConditionChecks && (
				<PreConditionsModal
					translations={ translations }
					selectedLocales={ selectedLocales }
					selectLocale={ selectLocale }
					unselectLocale={ unselectLocale }
					preConditionChecks={ preConditionChecks }
				/>
			) }
			<span className="phrase-translation-progress__title">
				{ __( 'Translations', 'phrase' ) }
				<CheckboxControl
					className="phrase-checkbox-control--small"
					label={ __( 'Select all', 'phrase' ) }
					checked={ translations.length === selectedLocales.length }
					onChange={ ( checked ) =>
						checked ? selectAllLocales() : unselectAllLocales()
					}
				/>
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
						<th className="phrase-translation-progress__table-column--edit-link"></th>
					</tr>
				</thead>
				<tbody>
					{ translations.map(
						( {
							id,
							name: localeName,
							code: localeCode,
							percent_translated: percentTranslated,
							last_updated: lastUpdated,
							post_edit_url: editUrl,
						} ) => (
							<tr key={ id }>
								<td className="phrase-translation-progress__table-column--locale">
									<CheckboxControl
										className="phrase-checkbox-control--small phrase-checkbox-control--with-flag"
										label={
											<span className="phrase-locale-name-with-flag">
												<Flag code={ localeCode } />
												<span className="phrase-locale-name">
													{ localeName }
												</span>
											</span>
										}
										checked={ selectedLocales.includes( id ) }
										onChange={ ( checked ) =>
											checked ? selectLocale( id ) : unselectLocale( id )
										}
									/>
								</td>
								<td className="phrase-translation-progress__table-column--status">
									{ 0 === percentTranslated && <NotStarted /> }
									{ percentTranslated > 0 && percentTranslated < 100 && (
										<InProgress />
									) }
									{ 100 === percentTranslated && <Completed /> }
								</td>
								<td className="phrase-translation-progress__table-column--update">
									{ lastUpdated ? (
										<DateTime fromNow>{ lastUpdated }</DateTime>
									) : (
										__( 'Never', 'phrase' )
									) }
								</td>
								<td className="phrase-translation-progress__table-column--edit">
									{ editUrl && (
										<Button
											label={ __( 'Edit translation', 'phrase' ) }
											showTooltip
											href={ editUrl }
											icon={ chevronRight }
										/>
									) }
								</td>
							</tr>
						)
					) }
				</tbody>
			</table>
			<Button
				icon={ download }
				isPrimary
				disabled={ 0 === selectedLocales.length || isPulling }
				isBusy={ isPulling }
				onClick={ () => pullTranslations( selectedLocales ) }
				className="phrase-pull-translation"
			>
				{ selectedLocales.length > 0
					? sprintf(
							// translators: %s: Number of selected languages.
							__( 'Pull translations (%s)', 'phrase' ),
							selectedLocales.length
					  )
					: __( 'Pull translations', 'phrase' ) }
			</Button>
		</>
	);
};

registerPlugin( 'phrase-source-translation-progress', {
	render: () => (
		<ContentPushCheck isPushed>
			<PhrasePluginSidebarContentSource>
				<PanelRow className="phrase-selected-project">
					<SelectedProject />
				</PanelRow>
				<PanelRow className="phrase-source-content">
					<SourceContent />
				</PanelRow>
				<PanelRow className="phrase-pull-push-source">
					<SourcePullPushButtons />
				</PanelRow>
				<PanelRow className="phrase-translation-progress">
					<TranslationProgress />
				</PanelRow>
			</PhrasePluginSidebarContentSource>
		</ContentPushCheck>
	),
} );
