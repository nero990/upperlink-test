<?php
	function int_array($array = array()) {
		$x = $y = 0; // $x represents odd number while $y represent even number

		foreach($array as $value) {
			if(($value % 2) == 0) { // then its an even number
				$y += $value;
			} else {
				$x += $value;
			}
		}

		return ($x - $y);
	}


	$numbers = array(1, 2, 3, 4, 5);
	echo int_array($numbers);
?>