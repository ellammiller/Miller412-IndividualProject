/**
 * External dependencies
 */
import { find } from 'lodash';

/**
 * WordPress dependencies.
 */
import { __ } from '@wordpress/i18n';
import { SelectControl, ExternalLink } from '@wordpress/components';
import { useSelect, useDispatch } from '@wordpress/data';
import { useEntityProp } from '@wordpress/core-data';
import { useEffect } from '@wordpress/element';

/**
 * Internal dependencies
 */
import { PROJECT_PROP_KEY } from '../../constants';
import { STORE_KEY } from '../../store';

const ProjectSelector = () => {
	const { updateLastUsedProject } = useDispatch( STORE_KEY );
	const { projects, lastUsedProject } = useSelect( ( select ) => {
		const { getProjects, getLastUsedProject } = select( STORE_KEY );
		return { projects: getProjects(), lastUsedProject: getLastUsedProject() };
	} );
	const postType = useSelect( ( select ) => select( 'core/editor' ).getCurrentPostType(), [] );
	const [ projectId, setProjectId ] = useEntityProp( 'postType', postType, PROJECT_PROP_KEY );

	const options = [ { value: '', label: __( '— Select —', 'phrase' ) } ];
	projects.forEach( ( project ) => options.push( { value: project.id, label: project.name } ) );
	const selectedProject = projectId ? find( projects, { id: projectId } ) : null;

	// Set initial project to last used project.
	useEffect( () => {
		if ( projectId !== lastUsedProject ) {
			setProjectId( lastUsedProject );
		}
	}, [] );

	// Sync project to local preferences.
	useEffect( () => {
		if ( projectId !== lastUsedProject ) {
			updateLastUsedProject( projectId || null );
		}
	}, [ projectId ] );

	return (
		<>
			<SelectControl
				label={ __( 'Select the project:', 'phrase' ) }
				value={ projectId }
				onChange={ ( value ) => setProjectId( value ) }
				options={ options }
			/>
			{ selectedProject && (
				<p>
					<ExternalLink href={ selectedProject.url }>
						{ __( 'Open project in Phrase', 'phrase' ) }
					</ExternalLink>
				</p>
			) }
		</>
	);
};

export default ProjectSelector;
