/**
 * Internal dependencies
 */
import './index.css';

const Flag = ( { code } ) => {
	const [ languageCode, countryCode ] = code.split( '-' );

	if ( countryCode ) {
		return (
			<img
				src={ `${ window.PHRASE_ASSETS_URL }/images/flags/${ countryCode }.png` }
				alt=""
				height={ 16 }
				width={ 16 }
				className="phrase-locale-flag"
			/>
		);
	}

	return (
		<span className="phrase-locale-flag-unknown">
			<span className="phrase-locale-flag-unknown__inner">{ languageCode }</span>
		</span>
	);
};

export default Flag;
