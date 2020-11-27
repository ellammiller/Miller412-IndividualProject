/**
 * External dependencies
 */
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import updateLocale from 'dayjs/plugin/updateLocale';
import utc from 'dayjs/plugin/utc';

/**
 * WordPress dependencies.
 */
import { useEffect, useState } from '@wordpress/element';
import { _x } from '@wordpress/i18n';

dayjs.extend( utc );

const relativeTimeThresholds = [
	{ l: 's', r: 1 },
	{ l: 'ss', r: 59, d: 'second' },
	{ l: 'm', r: 1 },
	{ l: 'mm', r: 59, d: 'minute' },
	{ l: 'h', r: 1 },
	{ l: 'hh', r: 23, d: 'hour' },
	{ l: 'd', r: 1 },
	{ l: 'dd', r: 29, d: 'day' },
	{ l: 'M', r: 1 },
	{ l: 'MM', r: 11, d: 'month' },
	{ l: 'y' },
	{ l: 'yy', d: 'year' },
];

dayjs.extend( relativeTime, { thresholds: relativeTimeThresholds } );
dayjs.extend( updateLocale );

dayjs.updateLocale( 'en', {
	relativeTime: {
		// translators: %s: Human-readable time difference.
		future: _x( 'in %s', 'relative time', 'phrase' ),
		// translators: %s: Human-readable time difference.
		past: _x( '%s ago', 'relative time', 'phrase' ),
		// translators: Time difference between two dates, in seconds.
		s: _x( '1 sec', 'relative time', 'phrase' ),
		// translators: Time difference between two dates, in seconds. %d: Number of seconds.
		ss: _x( '%d sec', 'relative time', 'phrase' ),
		// translators: Time difference between two dates, in minutes.
		m: _x( '1 min', 'relative time', 'phrase' ),
		// translators: Time difference between two dates, in minutes. %d: Number of minutes.
		mm: _x( '%d min', 'relative time', 'phrase' ),
		// translators: Time difference between two dates, in hours.
		h: _x( '1 hour', 'relative time', 'phrase' ),
		// translators: Time difference between two dates, in hours. %d: Number of hours.
		hh: _x( '%d hours', 'relative time', 'phrase' ),
		// translators: Time difference between two dates, in days.
		d: _x( '1 day', 'relative time', 'phrase' ),
		// translators: Time difference between two dates, in days. %d: Number of days.
		dd: _x( '%d days', 'relative time', 'phrase' ),
		// translators: Time difference between two dates, in months.
		M: _x( '1 month', 'relative time', 'phrase' ),
		// translators: Time difference between two dates, in months. %d: Number of months.
		MM: _x( '%d months', 'relative time', 'phrase' ),
		// translators: Time difference between two dates, in years.
		y: _x( 'a year', 'relative time', 'phrase' ),
		// translators: Time difference between two dates, in years. %d: Number of years.
		yy: _x( '%d years', 'relative time', 'phrase' ),
	},
} );

const REFRESH_INTERVAL = 60 * 1000;

const DateTime = ( { as: Component = 'time', format, fromNow, children, ...rest } ) => {
	const [ lastUpdate, setLastUpdate ] = useState( new Date() );
	const [ value, setValue ] = useState( '' );

	useEffect( () => {
		if ( ! fromNow ) {
			return;
		}

		const handler = () => setLastUpdate( new Date() );
		const id = setInterval( handler, REFRESH_INTERVAL );
		return () => clearInterval( id );
	}, [ fromNow ] );

	useEffect( () => {
		const dayjsDate = children ? dayjs.utc( children ) : dayjs.utc();

		if ( format ) {
			return setValue( dayjsDate.local().format( format ) );
		}

		if ( fromNow ) {
			const fromDate = dayjs.utc();
			const diff = fromDate.diff( dayjsDate, 'second', true );
			if ( diff < 15 ) {
				return setValue( _x( 'now', 'relative time', 'phrase' ) );
			}
			return setValue( dayjs.utc().to( dayjsDate ) );
		}

		return setValue( dayjsDate.format() );
	}, [ children, format, fromNow, lastUpdate ] );

	return <Component { ...rest }>{ value }</Component>;
};

export default DateTime;
