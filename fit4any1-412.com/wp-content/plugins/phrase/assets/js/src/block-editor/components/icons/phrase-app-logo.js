/**
 * WordPress dependencies
 */
import { SVG, Defs, Path, G, LinearGradient, Stop } from '@wordpress/primitives';

const PhraseAppLogo = ( props ) => (
	<SVG width={ 213 } height={ 213 } viewBox="0 0 213 213" { ...props }>
		<Defs>
			<LinearGradient x1="49.853%" y1="57.722%" x2="64.169%" y2="47.863%" id="prefix__a">
				<Stop stopColor="#F60" offset="0%" />
				<Stop stopColor="#FC0" offset="100%" />
			</LinearGradient>
			<LinearGradient x1="43.333%" y1="58.863%" x2="87.393%" y2="-8.116%" id="prefix__b">
				<Stop stopColor="#005082" offset="0%" />
				<Stop stopColor="#1E82C0" offset="60%" />
				<Stop stopColor="#3DB5FF" offset="100%" />
			</LinearGradient>
			<LinearGradient x1="42.027%" y1="93.372%" x2="60.305%" y2="19.936%" id="prefix__c">
				<Stop stopColor="#005082" offset="0%" />
				<Stop stopColor="#1E82C0" offset="60%" />
				<Stop stopColor="#3DB5FF" offset="100%" />
			</LinearGradient>
			<LinearGradient x1="20.687%" y1="75.866%" x2="83.777%" y2="14.483%" id="prefix__d">
				<Stop stopColor="#E6E6E6" offset="0%" />
				<Stop stopColor="#FEFEFE" offset="100%" />
			</LinearGradient>
			<LinearGradient x1="47.697%" y1="50.051%" x2="75.849%" y2="47.279%" id="prefix__e">
				<Stop stopColor="#F60" offset="0%" />
				<Stop stopColor="#FC0" offset="100%" />
			</LinearGradient>
		</Defs>
		<G fill="none" fillRule="evenodd">
			<Path
				d="M138.94 30.88a55.89 55.89 0 1019.41 110.07L138.94 30.88z"
				fill="url(#prefix__a)"
				transform="translate(-1 -1)"
			/>
			<Path
				d="M26.24 56.65A52 52 0 01.99 20.57C20.28 33.03 64.06 9.46 103.72 2.46a108.91 108.91 0 0180.4 18.32l-6 13.06-28.78 32.1-18.49 73c-5.36 19.49-1.48 46.2 35.94 72.4-99.87 17.61-179-70.87-140.54-154.65"
				fill="url(#prefix__b)"
				transform="translate(-1 -1)"
			/>
			<Path
				d="M178.32 33.38l-.2.45-28.78 32.1-18.49 73c-5.34 19.39 5.77 48.2 35.94 72.4-131.38-8.14-145.82-165-30.25-189.2 11.86-2.48 27.5 6.19 41.78 11.27"
				fill="url(#prefix__c)"
				transform="translate(-1 -1)"
			/>
			<Path
				d="M176.32 31.37c.52.35 1.86 1.13 2.37 1.49l-47.84 106c-23.06-4.78-40.38-19.28-45.39-47.7-5.01-28.42 15.84-63 48.07-68.65a59 59 0 0142.79 8.81"
				fill="url(#prefix__d)"
				transform="translate(-1 -1)"
			/>
			<Path
				d="M183.85 20.57c23.517 16.839 34.554 46.201 27.952 74.362-6.603 28.16-29.54 49.557-58.092 54.188 14.11-19.57-30.7-32.06-21.15-55.62 6.07-15 21.4-6.44 27.91-20.47l23.38-52.46z"
				fill="url(#prefix__e)"
				transform="translate(-1 -1)"
			/>
			<Path
				d="M137.27 35.5c-9.389 0-17 7.611-17 17s7.611 17 17 17 17-7.611 17-17-7.611-17-17-17"
				fill="#000"
				fillRule="nonzero"
			/>
			<Path d="M142.02 40.13a6 6 0 100 12 6 6 0 000-12" fill="#FFF" />
		</G>
	</SVG>
);

export default PhraseAppLogo;
