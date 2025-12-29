<?php

$file = file_get_contents('./data/day09.txt');
$vertices = explode("\n", $file);

$maxArea = 0;
for($i = 0; $i < count($vertices) - 1; $i++) {
  [$v1x, $v1y] = explode(",", $vertices[$i]);
  for($j = $i + 1; $j < count($vertices); $j++) {
    if($vertices[$j] == "") {
      continue;
    }

    [$v2x, $v2y] = explode(",", $vertices[$j]);
    $dx = abs($v1x - $v2x) + 1;
    $dy = abs($v1y - $v2y) + 1;
    $maxArea = max($dx * $dy, $maxArea);
  }
}

echo("Day 9 part 1: $maxArea\n");
