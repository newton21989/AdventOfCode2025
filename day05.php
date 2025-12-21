<?php

$file = file_get_contents('./data/day05.txt');
$split1 = explode("\n\n", $file);

$dbstr = explode("\n", $split1[0]);
$ingredients = explode("\n", $split1[1]);

$db = [];
foreach($dbstr as $dbln) {
  array_push($db, explode("-", $dbln));
}

$numfresh = 0;
foreach($ingredients as $ingredient) {
  $isFresh = false;
  foreach($db as $range) {
    if($ingredient >= $range[0] && $ingredient <= $range[1]) {
      $isFresh = true;
      break;
    }
  }

  if($isFresh) {
    $numfresh++;
  }
}

echo("Day 5 part 1: $numfresh\n");

array_multisort($db);

$min = 0;
$max = 0;
$deduped = [];
foreach($db as $i=>$range) {
  if($i == 0) {
    $min = $range[0];
    $max = $range[1];
    continue;
  }

  if(($range[0] >= $min && $range[0] <= $max + 1) && $range[1] > $max) {
    $max = $range[1];
  }
  elseif($range[0] > $max) {
    array_push($deduped, [$min, $max]);
    $min = $range[0];
    $max = $range[1];
  }

  if($i == count($db) - 1) {
    array_push($deduped, [$min, $max]);
  }
}

$out2 = 0;
foreach($deduped as $d) {
  $out2 += $d[1] - $d[0] + 1;
}

echo("Day 5 part 2: $out2\n");
