/**
 * WordPress dependencies.
 */
import { Tooltip } from '@wordpress/components';
import { _x } from '@wordpress/i18n';
import { Icon, check } from '@wordpress/icons';

/**
 * Internal dependencies
 */
import './index.css';

export const NotStarted = () => {
	return (
		<Tooltip text={ _x( 'Not started', 'translation progress', 'phrase' ) }>
			<span className="phrase-status-not-started">&ndash;</span>
		</Tooltip>
	);
};

export const InProgress = () => {
	return (
		<Tooltip text={ _x( 'In progress', 'translation progress', 'phrase' ) }>
			<span className="phrase-status-in-progress"></span>
		</Tooltip>
	);
};

export const Completed = () => {
	return (
		<Tooltip text={ _x( 'Completed', 'translation progress', 'phrase' ) }>
			<span className="phrase-status-completed">
				<Icon icon={ check } />
			</span>
		</Tooltip>
	);
};
