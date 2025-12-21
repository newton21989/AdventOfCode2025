<?php

$file = file_get_contents('./data/day06.txt');
while(str_contains($file, "  ")) {
  $file = str_replace("  ", " ", $file);
}
while(str_contains($file, "\n ")) {
  $file = str_replace("\n ", "\n", $file);
}
while(str_contains($file, " \n")) {
  $file = str_replace(" \n", "\n", $file);
}


$rows = explode("\n", $file);
$data = [];
foreach($rows as $i=>$row) {
  if($row != null) {
    array_push($data, explode(" ", $row));
  }
}

$out1 = 0;
for($i = 0; $i < count($data[0]); $i++) {
  $col = [];
  for($j = 0; $j < count($data); $j++) {
    if($j < count($data) - 1) {
      array_push($col, intval($data[$j][$i]));
    }
    elseif($j == count($data) - 1) {
      if($data[$j][$i] == "+") {
        $out1 += array_sum($col);
      }
      elseif($data[$j][$i] == "*") {
        $out1 += array_product($col);
      }
    }
  }
}

echo("Day 6 part 1: $out1\n");
