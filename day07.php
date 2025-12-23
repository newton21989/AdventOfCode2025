<?php

class Tachyon {
  private $position;

  function __construct($pos)
  {
    $this->position = $pos;
  }

  function move($data) {
    $nextToken = $data[$this->position[0]][$this->position[1]];
    if($nextToken == ".") {
      return [new self($this->position += [1, 0])];
    }
    elseif($nextToken == "^") {
      return [new self($this->position += [1, -1]), new self($this->position += [1, 1])];
    }
  }
}

$file = file_get_contents('./data/day07.txt');

function str2grid($str) {
  $rows = explode("\n", $str);
  $grid = [];
  foreach($rows as $r) {
    array_push($grid, str_split($r));
  }
  return $grid;
}

function grid2str($grid) {
  $out = "";
  foreach($grid as $r) {
    $out .= implode("", $r) . "\n";
  }
  return $out;
}

$data = str2grid($file);

$s = array_search("S", $data[0]);
$tachyons = [[1, $s]];
$ends = 0;
while([$r, $c] = array_shift($tachyons)) {
  if($r + 1 < count($data)) {
    if($data[$r+1][$c] == ".") {
      array_push($tachyons, [$r+1, $c]);
    }
    elseif($data[$r+1][$c] == "^") {
      array_push($tachyons, [$r+1, $c-1]);
      array_push($tachyons, [$r+1, $c+1]);
    }
  }
  else {
    $ends++;
  }
}

$splits = 0;
for($i = 0; $i < count($data) - 1; $i++) {
  if($i == 0) {
    $data[$i+1][$s] = "|";
    continue;
  }
  for($j = 0; $j < count($data[$i]); $j++) {
    $c = $data[$i][$j];
    if($c == "|") {
      if($data[$i+1][$j] == ".") {
        $data[$i+1][$j] = "|";
      }
      elseif($data[$i+1][$j] == "^") {
        $data[$i+1][$j-1] = "|";
        $data[$i+1][$j+1] = "|";
        $splits++;
      }
    }
  }
}


//var_dump(grid2str($data));

echo("Day 7 part 1: $splits\n");
echo("Day 7 part 1: $ends\n");
