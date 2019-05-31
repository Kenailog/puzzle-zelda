<?php

$empty_puzzle = "/zelda/images/empty.jpg";
$missing_puzzle = "/zelda/images/zelda_02.jpg";

$solved = array(
	'A' => "/zelda/images/zelda_01.jpg", 'B' => "/zelda/images/empty.jpg",
	'C' => "/zelda/images/zelda_03.jpg", 'D' => "/zelda/images/zelda_04.jpg",
	'E' => "/zelda/images/zelda_05.jpg", 'F' => "/zelda/images/zelda_06.jpg",
	'G' => "/zelda/images/zelda_07.jpg", 'H' => "/zelda/images/zelda_08.jpg",
	'I' => "/zelda/images/zelda_09.jpg", 'J' => "/zelda/images/zelda_10.jpg",
	'K' => "/zelda/images/zelda_11.jpg", 'L' => "/zelda/images/zelda_12.jpg",
	'M' => "/zelda/images/zelda_13.jpg", 'N' => "/zelda/images/zelda_14.jpg",
	'O' => "/zelda/images/zelda_15.jpg", 'P' =>  "/zelda/images/zelda_16.jpg"
);

$puzzles = empty($_POST) ? $solved
	: array(
		'A' => $_POST['puzzles_order'][0], 'B' => $_POST['puzzles_order'][1],
		'C' => $_POST['puzzles_order'][2], 'D' => $_POST['puzzles_order'][3],
		'E' => $_POST['puzzles_order'][4], 'F' => $_POST['puzzles_order'][5],
		'G' => $_POST['puzzles_order'][6], 'H' => $_POST['puzzles_order'][7],
		'I' => $_POST['puzzles_order'][8], 'J' => $_POST['puzzles_order'][9],
		'K' => $_POST['puzzles_order'][10], 'L' => $_POST['puzzles_order'][11],
		'M' => $_POST['puzzles_order'][12], 'N' => $_POST['puzzles_order'][13],
		'O' => $_POST['puzzles_order'][14], 'P' => $_POST['puzzles_order'][15]
	);

if (empty($_POST)) {
	shuffle_array($puzzles);
}

$empty_key = array_search($empty_puzzle, $puzzles);
$selected_puzzle = array_keys($_POST)[1][0];

// Z dowolnego miejsca
// swap_puzzles($selected_puzzle, $empty_key);

// Tylko puzzle sąsiadujące
foreach (get_surrounding_puzzles($selected_puzzle) as $puzzle) {
	if ($puzzle == $empty_key) {
		swap_puzzles($selected_puzzle, $empty_key);
	}
}

?>
<div style="margin: 0; position: absolute; top: 50%; left: 50%; -ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%);">
	<form action="Zelda.php" method="post">
		<?php
		if (is_solved() && !empty($_POST)) {
			$solved['B'] = $missing_puzzle;
			show_puzzles($solved);
		} else {
			show_puzzles($puzzles);
		}
		?>
	</form>
</div>
<?php

function swap_puzzles($empty_puzzle_key, $second_puzzle_key)
{
	global $puzzles;
	global $empty_puzzle;
	$tmp_puzzle = $puzzles[$empty_puzzle_key];
	$puzzles[$empty_puzzle_key] = $empty_puzzle;
	$puzzles[$second_puzzle_key] = $tmp_puzzle;
}

function shuffle_array(&$array)
{
	$values = array_values($array);
	shuffle($values);
	$array = array_combine(array_keys($array), $values);
}

function is_solved()
{
	return $GLOBALS['puzzles'] === $GLOBALS['solved'];
}

function show_puzzles($puzzles)
{
	foreach ($puzzles as $key => $value) {
		$key == 'D' || $key == 'H' || $key == 'L' ? print('<input type="image" name="' . $key . '" src=' . $value . '></br>')
			: print('<input type="image" name="' . $key . '" src=' . $value . '>');
		echo '<input type="hidden" name="puzzles_order[]" value="' . $value . '">';
	}
}

function get_surrounding_puzzles($key)
{
	$surrounding_puzzles = array();
	switch ($key) {
		case 'A':
			array_push($surrounding_puzzles, 'B', 'E');
			break;
		case 'B':
			array_push($surrounding_puzzles, 'A', 'C', 'F');
			break;
		case 'C':
			array_push($surrounding_puzzles, 'B', 'D', 'G');
			break;
		case 'D':
			array_push($surrounding_puzzles, 'C', 'H');
			break;
		case 'E':
			array_push($surrounding_puzzles, 'A', 'F', 'I');
			break;
		case 'F':
			array_push($surrounding_puzzles, 'B', 'E', 'G', 'J');
			break;
		case 'G':
			array_push($surrounding_puzzles, 'C', 'F', 'H', 'K');
			break;
		case 'H':
			array_push($surrounding_puzzles, 'D', 'G', 'L');
			break;
		case 'I':
			array_push($surrounding_puzzles, 'E', 'J', 'M');
			break;
		case 'J':
			array_push($surrounding_puzzles, 'F', 'I', 'K', 'N');
			break;
		case 'K':
			array_push($surrounding_puzzles, 'G', 'J', 'L', 'O');
			break;
		case 'L':
			array_push($surrounding_puzzles, 'H', 'K', 'P');
			break;
		case 'M':
			array_push($surrounding_puzzles, 'I', 'N');
			break;
		case 'N':
			array_push($surrounding_puzzles, 'J', 'M', 'O');
			break;
		case 'O':
			array_push($surrounding_puzzles, 'K', 'N', 'P');
			break;
		case 'P':
			array_push($surrounding_puzzles, 'L', 'O');
			break;
	}
	return $surrounding_puzzles;
}

// foreach ($puzzles as $key => $value) {
// 	echo "$key => $value </br>";
// }
