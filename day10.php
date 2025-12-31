<?php

@ini_set('memory_limit', "8G");

$file = file_get_contents('./data/day10.txt');
$machines = explode("\n", $file);

function btnCombos($buttons, $length, $start = 0, $chosen = []): Generator {
  if(count($chosen) == $length) {
    yield $chosen;
    return;
  }

  for($i = $start; $i < count($buttons); $i++) {
    $chosen[] = $buttons[$i];
    yield from btnCombos($buttons, $length, $i + 1, $chosen);
    array_pop($chosen);
  }
}

function btnPress($numIndicators, $combo) {
  $testIndicators = array_fill(0, $numIndicators, ".");
  foreach($combo as $c) {
    foreach($c as $d) {
      if($testIndicators[$d] == ".") {
        $testIndicators[$d] = "#";
      }
      elseif($testIndicators[$d] == "#") {
        $testIndicators[$d] = ".";
      }
    }
  }
  return $testIndicators;
}

function baseMaxPlusOne($num, &$target) {
  $out = 0;
  $mul = 1;
  foreach($num as $k=>$v) {
    $out += $v * $mul;
    $mul *= $target[$k] + 1;
  }
  return $out;
}

$out1 = 0;
foreach($machines as $m) {
  $a = $b = [];
  preg_match("/\[(.*)\]/", $m, $a);
  $target = str_split($a[1]);

  preg_match_all("/\(([\d,]+)\)/", $m, $b);
  $buttons = $b[1];
  $buttons = array_map(
    fn($b) => explode(",", $b),
    $buttons
  );

  for($i = 1; $i <= count($buttons); $i++) {
    foreach(btnCombos($buttons, $i) as $combo) {
      $testOut = btnPress(count($target), $combo);
      if($testOut == $target) {
        $out1 += count($combo);
        break 2;
      }
    }
  }
}

echo("Day 10 part 1: $out1\n");

function btnJoltage(&$target, &$buttons, $test = [], $depth = 0) {
  if(!count($test)) {
    $test = array_fill(0, count($target), 0);
  }
  else {
    $isValid = true;
    foreach($buttons[$depth] as $b) {
      $test[$b] += 1;
      if($test[$b] > $target[$b]) {
        $isValid = false;
      }
    }

    if(!$isValid) {
      foreach($buttons[$depth] as $b) {
        $test[$b] -= 1;
      }
      $depth += 1;
    }

    if($test == $target) {
      return [$buttons[$depth]];
    }
  }

  for($i = $depth; $i < count($buttons); $i++) {
    $result = btnJoltage($target, $buttons, $test, $i);
    if($result !== null) {
      $result[] = $buttons[$i];
      return $result;
    }
  }
}

$out2 = 0;
foreach($machines as $m) {
  $a = $b = [];
  preg_match("/\{(.*)\}/", $m, $a);
  $target = explode(",", $a[1]);

  preg_match_all("/\(([\d,]+)\)/", $m, $b);
  $buttons = $b[1];
  $buttons = array_map(
    fn($b) => explode(",", $b),
    $buttons
  );

  $out2 += count(btnJoltage($target, $buttons));
}

echo("Day 10 part 2: $out2\n");
