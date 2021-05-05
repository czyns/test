<?php

/* 
Made by Czyns in May, 2021
see working example here: 
http://letimnedorogo.ru/lt/test/vaimo.php
*/

// stage zero, fetching the data

$id = '1qqGBnzUQ-jbyymh4-Sh60EbJzEijaSBFl4Pg78wc968';
$gid = '585422958';
 
$csv = file_get_contents('https://docs.google.com/spreadsheets/d/' . $id . '/export?format=csv&gid=' . $gid);
$csv = explode("\r\n", $csv);

$array = array_map('str_getcsv', $csv);

// first, let's group products by product category/full name
for($i=1; $i < count($array); $i++) 
   { 
     if ($array[$i][7] != 0) {
     $total[$i] = $array[$i][7];
     $category [$i] = $array[$i][9];
     }
   } 

$fields = array_map(null, $total, $category);

// second, let's caculate value of items and sum 'em by product category
$output = array();
foreach($fields as $value){
    if(!isset($output[$value['1']])) $output[$value['1']] = 0; 
    $output[$value['1']] += $value['0']; 
}

// and third, let's take top 3 product categories 
asort ($output);
$output = array_slice($output, 0, 3);

//and output the result
echo "<h3>Top3 Product categories, where products have the most negative forecasted quantity.</h3>
<table border=0 cellpadding=5><tr><td><b>Category</b></td><td><b>Forecasted Quantity</b></td></tr>";
foreach($output as $key => $value){
    echo "<tr><td>".$key."</td><td>".$value."</td></tr>";
}
echo "</table>";

// bingo? I hope so.
?>
