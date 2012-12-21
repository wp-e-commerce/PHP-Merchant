<?php
/**
 * Substitutes the keys of an array with those of a second array if the
 * value of the second array matches the key of the first array.
 * 
 * @param $from_arary Array arbitrary associated array.
 * @param $keys Array An array of $key => $value pairs where the $value represents a key to match in the $from_array
 * @param $return_type String Whether to return the newly created array as an Array (default) or object. 
 */
function phpme_map( $from_array, $keys, $return_type = 'Array' ) {
	$return = array();

	foreach ( $keys as $to_key => $from_key )
		if ( isset( $from_array[$from_key] ) )
			$return[$to_key] = $from_array[$from_key];

	if ( $return_type == 'Object' )
		$return = (Object) $return;

	return $return;
}
?>