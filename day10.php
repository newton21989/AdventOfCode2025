<?php

$file = file_get_contents('./test_data/day10.txt');
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

  $queue = [];
  $visited = [];
  $test = array_fill(0, count($target), 0);
  foreach($buttons as $b) {
    $cur = $test;
    foreach($b as $c) {
      $cur[$c] += 1;
    }
    $queue[] = ['state'=>$cur, 'level'=>1];
    $visited[implode(",", $cur)] = true;
  }

  while($start = array_shift($queue)) {
    foreach($buttons as $b) {
      $cur = $start['state'];
      $level = $start['level'] + 1;
      foreach($b as $c) {
        $cur[$c] += 1;
      }

      if(!isset($visited[implode(",", $cur)])) {
        if($cur == $target) {
          $out2 += $level;
          break 2;
        }

        $queue[] = ['state'=>$cur, 'level'=>$level];
        $visited[implode(",", $cur)] = true;
      }
    }
  }
}

echo("Day 10 part 2: $out2\n");
