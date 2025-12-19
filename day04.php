<?php

const PAPER = "@";
const OPEN = ".";

$file = file_get_contents('./data/day04.txt');
$rows = explode("\n", $file);

$data = [];

function countAdjacent($data, $row, $col) {
  $count = 0;

  if($row > 0) {
    if($col > 0) {
      if($data[$row - 1][$col - 1] == PAPER) {
        $count++;
      }
    }
    if($col < count($data[$row]) - 1) {
      if($data[$row - 1][$col + 1] == PAPER) {
        $count++;
      }
    }
    if($data[$row - 1][$col] == PAPER) {
      $count++;
    }
  }
  if($row < count($data) - 1) {
    if($col > 0) {
      if($data[$row + 1][$col - 1] == PAPER) {
        $count++;
      }
    }
    if($col < count($data[$row]) - 1) {
      if($data[$row + 1][$col + 1] == PAPER) {
        $count++;
      }
    }
    if($data[$row + 1][$col] == PAPER) {
      $count++;
    }
  }
  if($col > 0) {
    if($data[$row][$col - 1] == PAPER) {
      $count++;
    }
  }
  if($col < count($data[$row]) - 1) {
    if($data[$row][$col + 1] == PAPER) {
      $count++;
    }
  }
  return $count;
}

foreach($rows as $r) {
  array_push($data, str_split($r));
}

$out1 = 0;

for($i = 0; $i < count($data); $i++) {
  for($j = 0; $j < count($data[$i]); $j++) {
    if($data[$i][$j] == PAPER) {
      $count = countAdjacent($data, $i, $j);
      if($count < 4) {
        $out1++;
      }
    }
  }
}


$movedRolls = 0;

while(true) {
  $continue = false;
  for($i = 0; $i < count($data); $i++) {
    for($j = 0; $j < count($data[$i]); $j++) {
      if($data[$i][$j] == PAPER) {
        $count = countAdjacent($data, $i, $j);
        if($count < 4) {
          $data[$i][$j] = "x";
          $continue = true;
          $movedRolls++;
        }
      }
    }
  }
  if(!$continue) {
    break;
  }
}

echo("Day 4 part 1: $out1\n");
echo("Day 4 part 2: $movedRolls\n");
