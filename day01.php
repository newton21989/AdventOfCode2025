<?php

class Safe {
  private $position;
  private $timesAtZero;

  function __construct($startPos) {
    $this->position = $startPos;
    $this->timesAtZero = 0;
  }

  function turnDial($line) {
    $direction = substr($line,0,1);
    $ticks = intval(substr($line,1));

    if($direction == "L") {
      for($i = 0; $i < $ticks; $i++) {
        $this->position--;
        if($this->position < 0) {
          $this->position += 100;
        }
        if($this->position == 0) {
          $this->timesAtZero++;
        }
      }
    }
    elseif($direction == "R") {
      for($i = 0; $i < $ticks; $i++) {
        $this->position++;
        if($this->position >= 100) {
          $this->position -= 100;
        }
        if($this->position == 0) {
          $this->timesAtZero++;
        }
      }
    }
    else {
      throw new Exception("Invalid direction: $direction");
    }
    return $this->position;
  }

  function getTimesPastZero() {
    return $this->timesAtZero;
  }
}

$safe = new Safe(50);
$count = 0;

$data = file_get_contents("./data/day01.txt");
$lines = explode("\n", $data);
$i = 0;
foreach($lines as $line) {
  if($line == null) {
    break;
  }
  $result = $safe->turnDial($line);
  $count = $safe->getTimesPastZero();
}

echo("Day 1 Part 2: $count\n");
