<?php

class Safe {
  private $position;
  private $timesPastZero;

  function __construct($startPos) {
    $this->position = $startPos;
    $this->timesPastZero = 0;
  }

  function turnDial($line) {
    $this->timesPastZero = 0;
    $direction = substr($line,0,1);
    $ticks = intval(substr($line,1));

    if($direction == "L") {
      $this->position -= $ticks;
      while($this->position < 0) {
        $this->position += 100;
        $this->timesPastZero++;
      }
    }
    elseif($direction == "R") {
      $this->position += $ticks;
      while($this->position > 99) {
        $this->position -= 100;
        $this->timesPastZero++;
      }
    }
    else {
      throw new Exception("Invalid direction: $direction");
    }
    return $this->position;
  }

  function getTimesPastZero() {
    return $this->timesPastZero;
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
  $count += $safe->getTimesPastZero();
}

echo("Day 1 Part 2: $count\n");
