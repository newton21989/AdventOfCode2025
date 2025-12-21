<?php

$file = file_get_contents('./data/day06.txt');
$file2 = $file;

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

$rows2 = explode("\n", $file2);
$numrows2 = count($rows2) - 1;
$cols2 = strlen($rows2[0]);

$data2str = "";
for($i = $cols2 -1; $i >= 0; $i--) {
  for($j = 0; $j < count($rows2); $j++) {
    if($rows2[$j] != null) {
      $data2str .= str_split($rows2[$j])[$i];
    }
  }
  $data2str .= "\n";
}

$lines = explode("\n", $data2str);
$out2 = 0;
$operands = [];
foreach($lines as $l) {
  if(empty(trim($l))) {
    continue;
  }

  $o = substr($l, 0, -1);
  array_push($operands, intval(trim($o)));
  if(substr($l, -1, 1) == "+") {
    $out2 += array_sum($operands);
    $operands = [];
  }
  elseif(substr($l, -1, 1) == "*") {
    $out2 += array_product($operands);
    $operands = [];
  }
}

echo("Day 6 part 2: $out2\n");
