<?php

$file = file_get_contents('./data/day02.txt');
$ranges = explode(',', $file);

$out2 = 0;

foreach($ranges as $range) {
  $bounds = explode('-', $range);
  for($i = $bounds[0]; $i <= $bounds[1]; $i++) { //ID to test
    $isInvalid = false;  //assume the ID is valid to start
    for($j = 1; $j <= strlen($i)/2; $j++) {  //loop through chunk sizes, increasing progressively
      if(strlen($i) % $j != 0) { //ignore invalid chunk size
        continue;
      }

      $p = str_split($i, $j); //split ID into chuncks of size $j
      $match = true; //assume chunk matches pattern
      foreach($p as $k=>$q) {
        if($k == 0) {  //first chunk is the one we're comparing against, so it has nothing to compare to on first pass
          continue;
        }
        if($q != $p[0]) {
          $match = false; //if any chunk fails, stop checking
          break;
        }
      }

      if($match) {
        $isInvalid = true; //if we made it this far and all chunks matched, the ID is invalid
        break;
      }

    }
    if($isInvalid) {
      echo($i . "\n");
      $out2 += $i;
      continue;
    }
  }
}

echo("Day 2 part 2: $out2\n");
