<?php
// i. Declare associative array
$ages = array("Harry" => 21, "Alice" => 20, "Megha" => 22, "Bob" => 19);

// ii. Modify Megha’s value to 28
$ages["Megha"] = 28;

// iii. Sort array by values (ascending), maintaining key-value pairs
asort($ages);
echo "Sorted Array (by values):<br>";
foreach ($ages as $key => $value) {
    echo "$key : $value<br>";
}

// iv. Print entry for "Alice"
echo "<br>Alice's Age: " . $ages["Alice"];
?>
