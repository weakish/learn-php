<?php

# 将we're the sfer!写入sf.txt

$to_write_file = "sf.txt";
$to_write_content = "we're the sfer!";
file_put_contents($to_write_file, $to_write_content);

# 将www.baidu.com内容追加sf.txt
file_put_contents($to_write_file, 'www.baidu.com', FILE_APPEND | LOCK_EX);
