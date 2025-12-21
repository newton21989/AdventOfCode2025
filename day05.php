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
