/**
 * WordPress dependencies
 */
import { SVG, Path } from '@wordpress/primitives';

const download = (
	<SVG xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
		<Path fillRule="evenodd" clipRule="evenodd" d="M18.5 15v5H20v-5h-1.5zM4 15v5h1.5v-5H4z" />
		<Path fillRule="evenodd" clipRule="evenodd" d="M4 20h16v-1.5H4V20z" />
		<Path
			fillRule="evenodd"
			clipRule="evenodd"
			d="M17.743 12.78l-5.757 5.757-6.28-5.733 1.012-1.108 4.494 4.104V4.003h1.5v11.686l3.97-3.97 1.06 1.061z"
		/>
	</SVG>
);

export default download;
