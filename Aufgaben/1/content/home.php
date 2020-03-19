<h1>Home</h1>
Some content

<h2>Ausgabe Beispiele</h2>

<h3>echo</h3>

<?php

$list = ['one', 'two', 'three'];

echo "<ul>";

foreach ($list as $word) {
    echo "<li>$word</li>";
}

echo '</ul>'

?>

<h3>printf</h3>

<?php

$format = "Irgendein String mit %d Zeichen";
printf($format, strlen($format));

$price = 9.9512313413243;
$format2 = "&euro; %.2f ,-";
printf($format2, $price);

$format3 = "%.4f ,-";
printf($format3, $price);

?>

<h2>Debug Beispiele</h2>

<h3>print_r</h3>

<?php
$list = ['one', 'two', 'three'];
print_r($list);
?>

<h3>var_dump</h3>

<?php
$list = ['one', 'two', 'three'];
var_dump($list);
?>