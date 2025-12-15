<?php

function array_max($arr) {
  $arr1 = $arr;
  array_multisort($arr1);
  return $arr1[count($arr1) - 1];
}

$file = file_get_contents('./data/day03.txt');
$batteries = explode("\n", $file);

$out1 = 0;

foreach($batteries as $batt) {
  if($batt == "") {
    continue;
  }

  $cells = str_split($batt);

  $max1 = array_max($cells);
  $max1i = array_search($max1, $cells);

  if($max1i < count($cells) - 1) {
    $cells2 = array_slice($cells, $max1i + 1);
    $max2 = array_max($cells2);

    $out = $max1 . $max2;
  }
  elseif($max1i == count($cells) - 1) {
    $cells2 = array_slice($cells, 0, $max1i);
    $max2 = array_max($cells2);

    $out = $max2 . $max1;
  }
  echo("$out\n");
  $out1 += intval($out);
}

echo("Day 3 part 1: $out1\n");
