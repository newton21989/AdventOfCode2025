<?php

$file = file_get_contents('./data/day02.txt');
$ranges = explode(',', $file);

$out1 = 0;

foreach($ranges as $range) {
  $bounds = explode('-', $range);
  for($i = $bounds[0]; $i <= $bounds[1]; $i++) {
    if(strlen($i) % 2 != 0) {
      continue;
    }

    $p1 = substr($i, 0, strlen($i)/2);
    $p2 = substr($i, strlen($i)/2);

    if($p1 == $p2) {
      echo($i . "\n");
      $out1 += $i;
    }
  }
}

echo("Day 2 part 1: $out1\n");
