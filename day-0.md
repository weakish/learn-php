记录一下学习的轨迹。

入门资料
-------

对我而言好的入门资料要符合两个要求：

- 能够切实帮助以比较正的方式入门
- 薄

真没找到什么好的入门资料。没有《Dive into PHP》，没有《Learn PHP the hard way》，连《a byte of PHP》都没有。（《Higher Order PHP》？别做梦了！）

官网上也没有推荐，然后书籍是直接链接到亚马逊的搜索页面……

问了身边的PHPer，说是直接看官网上的文档……

可以用 [PHP The right way](http://www.phptherightway.com/) 凑合下，不过这个怎么看也不像入门书就是了。

起步
----

PHP The right way 推荐用最新的 `5.5`。不过我用的是 `5.4`。因为用的是 Debian Wheezy，懒得另外装 `5.5` 了。

### 内建服务器


    php -S localhost:8000

这年头大部分语言都支持这一出了。PHP 5.4开始也支持了。

很遗憾，如果没有`index.html`之类的页面，就直接404：

    Not Found

    The requested resource / was not found on this server.

也不给个目录列表啥的。

### phpsh

交互式的环境学习方便，推荐下 facebook 家的 [phpsh](http://phpsh.org/)（是用python写的）。

### Hello World

写个 Hello world 应该很容易吧？

phpsh下确实很容易。

    php> echo "hello world"
    hello world

写到文件里试试：

```php
#!/usr/bin/env php                                            echo "hello world"
```

保存成 `test php`，然后 `chmod a+x`一下，结果：

    ./test.php                                                                                                                                  

    echo "hello world"

咋啦？难道是没加分号，赶紧修改下：

    ./test.php                                                                                                                                  

    echo "hello world";

还是不行……

原来必须加上 `<?php`和`?>`才行。

```php
#!/usr/bin/env php
<?php                                                                 
echo "hello world"
?>
```

结尾可以省略，然后`<?php`可以简写成`<?`，于是上面的可以简写成

```php
#!/usr/bin/env php
<?                                                                                                                          
echo "hello world"
```

当然像这种一行的，用`php -r`也成：

    php -r 'echo "hello world";'

练习题
------

感谢Green_leaves出题

1. 搭好php环境，写出第一个hello word。
2. 输出你邮箱的用户名和域名
3. 匹配出blog.segmentfault.com的主域名segmentfault.com
