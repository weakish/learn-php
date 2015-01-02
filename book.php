<?php

/* 亚马逊举办图书优惠活动，满100减10，满200减50，满300减80，满400减120，满500减200。
 * tree买了1本书价格是 54.9， noodles买了3本书45.8  36.5  50.2，
 * laker买了5本书21.3 45.6 39.5 62.5 20.5 
 * fen买了8本书 50.6 20.4  36.7  45.6  19.8  60.5 44.3 55.0
 * 70买了10本书  47.8  30.6  15.6  56.8  30.0  29.8 60.8  70.9 69.9  116.7,，
 * 请计算出各位需要付的金额。*/

$tree = ["tree", [54.9]];
$noodles = ["noodles", [45.8, 36.5, 50.2]];
$laker = ["laker", [21.3, 45.6, 39.5, 62.5, 20.5]];
$fen = ["fen", [50.6, 20.4, 36.7, 45.6, 19.8, 60.5, 44.3, 55.0]];
$seventy = ["seventy", [47.8, 30.6, 15.6, 56.8, 30.0, 29.8, 60.8, 70.9, 69.9, 116.7]];

function price($shopping_list) {
  $total = array_sum($shopping_list);
  if ($total > 500) {
    $aftermath = $total - 200;
  }
  elseif ($total > 400) {
    $aftermath = $total - 120;
  }
  elseif ($total > 300) {
    $aftermath = $total -80;
  }
  elseif ($total > 200) {
    $aftermath = $total -50;
  }
  elseif ($total > 100) {
    $aftermath = $total -10;
  }
  else {
    $aftermath = $total;
  }
  return $aftermath;
}


array_map(
  function($sl) {
    echo $sl[0], ' need to pay ', price($sl[1]), "\n";
  },
  [$tree, $noodles, $laker, $fen, $seventy]
);
