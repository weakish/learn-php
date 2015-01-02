最新版
------

Debian Wheezy下的PHP是`5.4`的，[day0]时说图方便就装了`5.4`。但是看文档是`5.5`的，所以琢磨着还是用最新版算了。

[day0]: http://blog.segmentfault.com/weakish/1190000000351939

Debian Wheezy有[dotdeb.org](http://www.dotdeb.org)提供`php-5.5`。安装很方便。

将下列内容加入`/etc/apt/sources.list`:

```
deb http://packages.dotdeb.org wheezy all
deb-src http://packages.dotdeb.org wheezy all
deb http://packages.dotdeb.org wheezy-php55 all
deb-src http://packages.dotdeb.org wheezy-php55 all
```

添加GPG key：

```sh
wget http://www.dotdeb.org/dotdeb.gpg
sudo apt-key add dotdeb.gpg
```

好了，可以安装了：

```sh
sudo apt-get update
sudo apt-get install php5-cli
```

REPL
----

[day0][] 我推荐了`phpsh`，后来 @samoay 推荐了 [Boris][]，用下来比 `phpsh` 好用，而且 Boris 也是用 PHP 实现的。用一个 Python 实现的 PHP REPL 总是感觉怪怪的。

[Boris]: http://segmentfault.com/a/1190000000353069

包管理
------

试用了 [Composer](http://segmentfault.com/a/1190000000353129)，新一代的 PHP 包管理器，感觉不错。

习题
----

有一个`city.txt`文件，内容包括各地的邮编：

```
代码

    名称

110000

北京市

110100

市辖区

110101

    东城区

110102

    西城区

110103

    崇文区

110104

    宣武区

110105

    朝阳区

110106

    丰台区
```

（后略）

现在需要将邮编全部剔除，生成一个新文件 `area.txt`，只包括地名。

依然是 @Green_leaves 出的题。

Day 1 习题答案
--------------

[习题见Day 1](http://blog.segmentfault.com/weakish/1190000000352902)

### 1.  图书优惠活动，计算需要付的金额。

基本的条件语句。短路的运用让代码更简短。

```php
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
```

### 2. 文件读写

PHP函数有Flag，`FILE_APPEND`表示追加，`LOCK_EX`锁定文件，避免别的进程同时读写。

```php

# 将we're the sfer!写入sf.txt
 
$to_write_file = "sf.txt";
$to_write_content = "we're the sfer!";
file_put_contents($to_write_file, $to_write_content);
 
# 将www.baidu.com内容追加sf.txt
file_put_contents($to_write_file, 'www.baidu.com', FILE_APPEND | LOCK_EX);
```

### 3. 匹配图片名称

PHP里的正则使用 `preg` 系列函数，让我感到诧异的是居然正则表达式要用 `/` 包起来…… 人家语法层面原生支持正则表达式的语言这么做还有道理，你都用函数了[何必如此](http://segmentfault.com/q/1010000000354019)？

```php
 
# 获取<img alt="SegmentFault" src="http://s.segmentfault.com/img/logo.png?13.10.21.1">里图片名称
 
$URL = '<img alt="SegmentFault" src="http://s.segmentfault.com/img/logo.png?13.10.21.1">';
 
function get_image_name($url) {
  preg_match('/(img\/)([a-z0-9]+\.[a-z]+)/', $url, $image_name);
  return $image_name[2];
}
 
echo get_image_name($URL);
```
