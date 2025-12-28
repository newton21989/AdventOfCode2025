<?php

class vec3 {
  public $x, $y, $z;

  function __construct($x, $y, $z) {
    [$this->x, $this->y, $this->z] = [$x, $y, $z];
  }

  static function sqDist(vec3 $a, vec3 $b) {
    [$dx, $dy, $dz] = [$b->x - $a->x, $b->y - $a->y, $b->z - $a->z];
    return $dx**2 + $dy**2 + $dz**2;
  }

  static function dist(vec3 $a, vec3 $b) {
    return sqrt(self::sqDist($a, $b));
  }

  function sqDistTo(vec3 $b) {
    return self::sqDist($this, $b);
  }

  function distTo(vec3 $b) {
    return self::dist($this, $b);
  }

  function toString() {
    return $this->x . ", " . $this->y . ", " . $this->z;
  }
}

function findCktRoot($node, &$parent) {
  if(!isset($parent[$node])) {
    $parent[$node] = $node;
  }

  $root = $node;

  while($parent[$root] !== $root) {
    $root = $parent[$root];
  }

  // $cur = $node;
  // while($cur !== $root) {
  //   $next = $parent[$cur];
  //   $parent[$cur] = $root;
  //   $cur = $next;
  // }

  return $root;
}

function joinCkts($a, $b, &$parent, &$rank) {
  $rootA = findCktRoot($a, $parent);
  $rootB = findCktRoot($b, $parent);

  if($rootA === $rootB) {
    return;
  }

  if(!isset($rank[$rootA])) {
    $rank[$rootA] = 0;
  }
  if(!isset($rank[$rootB])) {
    $rank[$rootB] = 0;
  }

  if($rank[$rootA] < $rank[$rootB]) {
    $parent[$rootA] = $rootB;
  }
  else {
    $parent[$rootB] = $rootA;
    if($rank[$rootA] === $rank[$rootB]) {
      $rank[$rootA] = ($rank[$rootA] ?? 0) + 1;
    }
  }
}

$file = file_get_contents('./data/day08.txt');
$lines = explode("\n", $file);

$nodes = [];
foreach($lines as $l) {
  if($l != "") {
    [$x, $y, $z] = explode(",", $l);
    array_push($nodes, new vec3($x, $y, $z));
  }
}
usort($nodes, function($a, $b) { // sort nodes, callback function to compare $a and $b
  return $a->x <=> $b->x  // -1 if $a->x is smaller, 1 if larger, next line if equal
      ?: $a->y <=> $b->y  // in short, sort by $a ASC, then $y, then $z
      ?: $a->z <=> $b->z;
});

$distances = [];
for($i = 0; $i < count($nodes); $i++) {
  for($j = $i+1; $j < count($nodes); $j++) {
    $distances[$i . "," . $j] = $nodes[$i]->sqDistTo($nodes[$j]);
  }
}
array_multisort($distances);

$nodeCkts = [];
$parentCkts = [];
$rank = [];
$i = 0;
$lastA = $lastB = null;
foreach($distances as $k=>$v) {
  // if($i >= 1000) {
  //   break;
  // }
  
  [$a, $b] = explode(",", $k);

  if($i == 0) {
    $nodeCkts[$a] = $a;
    $nodeCkts[$b] = $a;
    $i++;
    continue;
  }

  if(isset($nodeCkts[$a]) && isset($nodeCkts[$b])) {
    if($nodeCkts[$a] != $nodeCkts[$b]) {
      joinCkts($nodeCkts[$a], $nodeCkts[$b], $parentCkts, $rank);
    }
    $i++;
    continue;
  }
  elseif(isset($nodeCkts[$a])) {
    $nodeCkts[$b] = $nodeCkts[$a];
  }
  elseif(isset($nodeCkts[$b])) {
    $nodeCkts[$a] = $nodeCkts[$b];
  }
  else {
    $nodeCkts[$a] = $a;
    $nodeCkts[$b] = $a;
  }

  $i++;

  $cktSize = [];
  foreach($nodeCkts as $n) {
    $root = findCktRoot($n, $parentCkts);
    $cktSize[$root] = ($cktSize[$root] ?? 0) + 1;
    if($cktSize[$root] == 20) {
      $lastA = $nodes[$a];
      $lastB = $nodes[$b];
    }
  }
}

$out2 = $lastA->x * $lastB->x;

// $cktSize = [];
// foreach($nodeCkts as $n) {
//   $root = findCktRoot($n, $parentCkts);
//   $cktSize[$root] = ($cktSize[$root] ?? 0) + 1;
// }
// rsort($cktSize);

// $out1 = 0;
// for($i = 0; $i < 3; $i++) {
//   if($i == 0) {
//     $out1 = $cktSize[$i];
//     continue;
//   }
//   $out1 *= $cktSize[$i];
// }

// echo("Day 8 part 1: $out1\n");

echo("Day 8 part 2: $out2\n");

