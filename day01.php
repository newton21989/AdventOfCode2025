<?php

class Safe {
  private $position;

  function __construct($startPos) {
    $this->position = $startPos;
  }

  function turnDial($line) {
    $direction = substr($line,0,1);
    $ticks = intval(substr($line,1));

    if($direction == "L") {
      $this->position -= $ticks;
      if($this->position < 0) {
        $this->position += 100;
      }
    }
    elseif($direction == "R") {
      $this->position += $ticks;
      if($this->position > 99) {
        $this->position -= 100;
      }
    }
    else {
      throw new Exception("Invalid direction: $direction");
    }
    return $this->position;
  }
}

$safe = new Safe(50);
$count = 0;

$data = file_get_contents("./data/day01.txt");
$lines = explode("\n", $data);
foreach($lines as $line) {
  if($line == null) {
    break;
  }
  $result = $safe->turnDial($line);
  if($result === 0) {
    $count++;
  }
}

echo("Day 1 Part 1: $count\n");
