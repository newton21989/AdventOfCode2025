<?php

$file = file_get_contents('./test_data/day05.txt');
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

$dbpath = './test_data/day05.db';

if(file_exists($dbpath)) {
  unlink($dbpath);
}

$db2 = new SQLite3($dbpath);
$result = $db2->query("CREATE TABLE fresh_ingredients(id INTEGER)");
if(!$result) {
  die("Problem with SQL: " . $db2->lastErrorMsg() . "\n");
}

foreach($db as $range) {
  for($i = $range[0]; $i <= $range[1]; $i++) {
    $result = $db2->query("INSERT INTO fresh_ingredients ('id') VALUES ($i)");
    if(!$result) {
      die("Problem with SQL: " . $db2->lastErrorMsg() . "\n");
    }
  }
}

$result = $db2->query("SELECT DISTINCT(id) FROM fresh_ingredients");
if($result) {
  $resultsarr = [];
  while($j = $result->fetchArray(SQLITE3_NUM)) {
    array_push($resultsarr, $j[0]);
  }
  $out2 = count($resultsarr);
  echo("Day 5 part 2: $out2\n");
}
else {
  die("Problem with SQL query: " . $db2->lastErrorMsg() . "\n");
}
