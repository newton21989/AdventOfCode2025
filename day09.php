<?php

$file = file_get_contents('./data/day09.txt');
$vertices = explode("\n", $file);

$maxArea = 0;
for($i = 0; $i < count($vertices) - 1; $i++) {
  [$v1x, $v1y] = explode(",", $vertices[$i]);
  for($j = $i + 1; $j < count($vertices); $j++) {
    if($vertices[$j] == "") {
      continue;
    }

    [$v2x, $v2y] = explode(",", $vertices[$j]);
    $dx = abs($v1x - $v2x) + 1;
    $dy = abs($v1y - $v2y) + 1;
    $maxArea = max($dx * $dy, $maxArea);
  }
}

echo("Day 9 part 1: $maxArea\n");

$vEdges = [];
$hEdges = [];
for($i = 0; $i < count($vertices); $i++) {
  if(!isset($vertices[$i+1]) || $vertices[$i+1] == "") {
    $j = 0;
  }
  else {
    $j = $i + 1;
  }

  [$v1x, $v1y] = explode(",", $vertices[$i]);
  [$v2x, $v2y] = explode(",", $vertices[$j]);
  if($v1x == $v2x) {
    array_push($hEdges, ['x'=>$v1x, 'y1'=>min($v1y, $v2y), 'y2'=>max($v1y, $v2y)]);
  }
  elseif($v1y == $v2y) {
    array_push($vEdges, ['y'=>$v1y, 'x1'=>min($v1x, $v2x), 'x2'=>max($v1x, $v2x)]);
  }
  else {
    die("Polygon is not rectilinear along edge ($v1x, $v1y), ($v2x, $v2y) at lines " . $i+1 . "-" . $j+1 . " of input\n");
  }
}

$maxArea2 = 0;
for($i = 0; $i < count($vertices) - 1; $i++) {
  [$v1x, $v1y] = explode(",", $vertices[$i]);
  for($j = $i + 1; $j < count($vertices); $j++) {
    if($vertices[$j] == "") {
      continue;
    }

    $intersects = false;
    [$v2x, $v2y] = explode(",", $vertices[$j]);
    foreach($hEdges as $e) {
      if($e['x'] > min($v1x, $v2x) && $e['x'] < max($v1x, $v2x)) {
        if($e['y1'] < max($v1y, $v2y) && $e['y2'] > min($v1y, $v2y) ) {
          $intersects = true;
          break;
        }
      }
    }
    if($intersects) {
      continue;
    }

    foreach($vEdges as $e) {
      if($e['y'] > min($v1y, $v2y) && $e['y'] < max($v1y, $v2y)) {
        if($e['x1'] < max($v1x, $v2x) && $e['x2'] > min($v1x, $v2x) ) {
          $intersects = true;
          break;
        }
      }
    }
    if($intersects) {
      continue;
    }
    
    $dx = abs($v1x - $v2x) + 1;
    $dy = abs($v1y - $v2y) + 1;
    $maxArea2 = max($dx * $dy, $maxArea2);
  }
}

echo("Day 9 part 2: $maxArea2\n");
