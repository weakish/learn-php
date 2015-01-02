<?php

# 获取<img alt="SegmentFault" src="http://s.segmentfault.com/img/logo.png?13.10.21.1">里图片名称

$URL = '<img alt="SegmentFault" src="http://s.segmentfault.com/img/logo.png?13.10.21.1">';

function get_image_name($url) {
  preg_match('/(img\/)([a-z0-9]+\.[a-z]+)/', $url, $image_name);
  return $image_name[2];
}

echo get_image_name($URL);
