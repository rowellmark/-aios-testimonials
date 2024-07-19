<?php
/**
 * Common methods to create input, select, and textarea
 *
 * @return void
 */

if ( !class_exists( 'aios_testimonials_constant' ) ) {

	class aios_testimonials_constant {

		/**
		 * List of State.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @return array
		 */
		public static function languages_spoken(){
			return array(
				'Arabic' 		=> 'Arabic',
				'Bengali' 		=> 'Bengali',
				'Cantonese' 	=> 'Cantonese',
				'Chinese' 		=> 'Chinese',
				'English' 		=> 'English',
				'French' 		=> 'French',
				'German' 		=> 'German',
				'Hindi-Urdu' 	=> 'Hindi-Urdu',
				'Italian' 		=> 'Italian',
				'Japanese' 		=> 'Japanese',
				'Javanese' 		=> 'Javanese',
				'Korean' 		=> 'Korean',
				'Marathi' 		=> 'Marathi',
				'Portuguese' 	=> 'Portuguese',
				'Russian' 		=> 'Russian',
				'Spanish' 		=> 'Spanish',
				'Tamil' 		=> 'Tamil',
				'Telugu' 		=> 'Telugu',
				'Ukrainian' 	=> 'Ukrainian',
				'Wu' 			=> 'Wu'
			);
		}

	}

}