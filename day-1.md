PHP语法基础
-----------

如同昨天所说，PHP代码必须用起始标签（`<?php`）和结束标签（`?>`）包起来。有其他简写形式，但是不建议使用，因为简写形式是否能工作，取决于PHP的配置。

`<?php`和`?>`的标签在XML文档中合法，所以XHTML中加入PHP代码，不会破坏XHTML文档的合法性。

而非混写模式下，结束标签通常是省略的。

变量要加上前缀`$`。PHP将换行视作空格，所以需要用分号标明语句的结束。

支持三种格式的注释：`/* */`、`//`和`#`。

0是false。

array大致相当于table。

```php
[
  "foo" => "bar",
  "bar" => "foo",
];
```

注意，如果用浮点数作key，浮点数会被强制转为整数，小数点后的部分将被舍弃！

创建时也可以不指明key，当列表用：

```php
[1, 2, 3]
```

实际上key是自动分配的：

```php
print_r([1, 2, 3])
Array
(
    [0] => 1
    [1] => 2
    [2] => 3
)
```


函数

```php
function myFunction() {
  return function() {
    return 'John Doe';
  }
}
```

谢天谢地，从PHP 5.3开始，函数是一等公民。上面的函数就返回了一个匿名函数。

闭包也是有的，不过需要显式地用`use`声明，好奇怪

```php
function getAdder($x)
{
    return function($y) use ($x)
           {
               return $x + $y;
           };
}
```

习题
----

1. 亚马逊举办图书优惠活动，满100减10，满200减50，满300减80，满400减120，满500减200。写一个函数计算需要付的金额。
2. 将`we're the sfer!`写入`sf.txt`，并将`www.baidu.com`内容追加到`sf.txt`。
3. 获取`<img alt="SegmentFault" src="http://s.segmentfault.com/img/logo.png?13.10.21.1">`里图片名称

同样由 @green_leaves 出题。


Day 0 习题答案
--------------

### 1. 写出第一个hello word

略

### 2. 输出你邮箱的用户名和域名

基本的思路是根据`@`拆分string，使用PHP的`explode`函数

```php
list($user, $domain) = explode('@', 'weakish@gamil.com');
echo $user;
echo $domain;
```

### 3. 匹配出blog.segmentfault.com的主域名segmentfault.com

同样使用`explode`拆分，然后取最末两项：

```php
$domain = explode('.', 'dev.blog.segmentfault.com');
list($main_domain, $top_level_domain) = array_slice($domain, -2);
echo $main_domain, '.', $top_level_domain;
```
