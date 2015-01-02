<?php

const FILE_NAME = 'city.txt';

$city_list = explode("\n", file_get_contents(FILE_NAME));

$result = implode("\n", preg_grep("/[0-9]/", $city_list, PREG_GREP_INVERT));

file_put_contents(FILE_NAME, $result);
