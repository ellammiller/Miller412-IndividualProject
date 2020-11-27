/**
 * External dependencies
 */
import { find } from 'lodash';

/**
 * WordPress dependencies.
 */
import { ExternalLink } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import { STORE_KEY } from '../../store';
import './index.css';

const SelectedProject = () => {
	const project = useSelect( ( select ) => {
		const { getProjects, getCurrentProjectId } = select( STORE_KEY );

		return find( getProjects(), { id: getCurrentProjectId() } );
	}, [] );

	if ( ! project ) {
		return null;
	}

	return (
		<>
			<span>{ __( 'Project', 'phrase' ) }</span>
			<ExternalLink href={ project.url } className="phrase-selected-project__name">
				{ project.name }
			</ExternalLink>
		</>
	);
};

export default SelectedProject;
