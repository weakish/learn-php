扫下手册的语言参考。（函数以前）


类型
----

有`boolean`、`integer`、`float`、`string`、`array`等类型。

可以通过`gettype`函数查看类型，如果要同时查看变量的值，则使用`var_dump`。

### Boolean

以下值为FALSE:

- FALSE
- 0
- 0.0
- "" 和 "0"
- []
- 不包括任何成员变量的对象
- NULL （包括尚未赋值的变量）
- 从没有任何tags的 XML 文档生成的 SimpleXML 对象

大致上，0和空都是假的。

### 字符串

支持单引号、双引号、Heredoc和Nowdoc。

字符串可以当成字符组成的数组用，即可以用整数作index。

字符串可以参与算术！

```php
$foo = 1 + "10.5"; // $foo is float (11.5)
$foo = 1 + "10 Small Pigs"; // $foo is integer (11)
```

操作文本的函数对于字符串编码的假定非常混乱！请参考手册。

### 类型强制转换

上面字符串参与算术的例子就是类型自动转换。下面是一个强制转换的例子。

```php
$foo = 10;   // $foo is an integer
$bar = (bool) $foo;   // $bar is a boolean
```

允许的强制转换有 `int` `bool` `float` `string` `array` `object` `unset` `binary`。


变量
----

默认赋值是传递变量的值，添加`&`符号为引用赋值。

用`global`声明全局变量，用`static`声明静态变量（仅在函数第一次调用时初始化）。

支持变量的值作为变量名，例如：

```php
$a = 'hello';
$$a = 'world';
```

这将导致如下语句等效：

```php
echo "$a ${$a}";
echo "$a $hello";
```

支持一些来自PHP外部的变量，例如`_GET` `_POST` `_COOKIE`。

常量
----

PHP的常量通过`define()`函数或者`const`关键字来定义。前面没有美元符号。

PHP的常量很弱，只能包含`boolen`、`integer`、`float`和`string`。

算术
----

除法运算符总是返回浮点数，除非是用于能够整除的整数。

比较
----

`==`和`===`的区别是是否自动类型转换。
用于数组时，`===`还要求顺序相同。

错误控制
--------

`@`置于表达式前时，忽略该表达式产生的错误信息。

运行外部程序
------------

使用反引号，效果等同于函数`shell_exec`。

```php
$output = `ls -al`;
```

递增、递减
----------

支持C风格的奇技淫巧：`++$a` `$a++` `--$a` `$a--`

逻辑运算符
----------

支持`xor`、`!`，同时支持`and`、`or`和`&&`、`||`(优先级略有差异)。

字符串
------

用`.`连接字符串，用`.=`将右边的参数附加到左边参数之后。

联合数组
--------

使用`+`，把右边的数组元素附加到左边的数组后面，两个数组中都有的键名，则只用左边数组中的，右边的被忽略。

流程控制
--------

`do while`在循环结束后判断，所以至少运行一次！

`for`的用法和python不一样，和C类似。和python的`for`相似的是`foreach`：Python下的`for i in l`和`for k,v in d`，PHP下写成`foreach ($l as $i)` 和 `foreach ($d as $k => $v)`。注意，通过引用赋值可以方便地修改数组中的元素。

```
$arr = array(1, 2, 3, 4);
foreach ($arr as &$value) {
    $value = $value * 2;
}
```

`break`可以接受数字参数决定跳出几重循环。

`switch`比较奇怪，如果`case`的语句段不加`break`，会继续执行下一个`case`中的语句（即使下一个`case`不满足条件）。当然这也意味着某些时候可以缩短代码：

```php
switch ($_SESSION['lang']) {
case 'en':
case 'es':
case 'zh-tw':
case 'zh-cn':
    $lang_file = 'lang.'.$_SESSION['lang'].'.php';
    break;

default:
    $lang_file = 'lang.en.php';
}
```

不过其实如果`switch`的`case`支持一般表达式的话，完全可以写得更简单的：

```php
switch ($_SESSION['lang']) {
  case ('en' | 'es' | 'zh-tw' | 'zh-cn'):
    $lang_file = 'lang.'.$_SESSION['lang'].'.php';
    break;
  default:
    $lang_file = 'lang.en.php';
}
```

可惜的是上面的php是非法的，因为 `case` 表达式只能是数字或字符串！

require
-------

`require`和`include`类似，包含的文件继承了所在行的变量范围。若未给出路径，优先在`include_path`中查找，没找到的情况下才在调用脚本所在目录和当前工作目录下查找。

文件未找到时，`require`给出错误，而`include`仅仅给出警告。

`require_onec`和`include_once`确保文件只被包含一次。

goto
----

目标位置用目标名称加上冒号标记，必须位于同一文件和作用域。

----

习题答案
--------

基本的文件读写和正则。

```php

const FILE_NAME = 'city.txt';
const NEW_FILE = 'area.txt';

$city_list = explode("\n", file_get_contents(FILE_NAME));
 
$result = implode("\n", preg_grep("/[0-9]/", $city_list, PREG_GREP_INVERT));
 
file_put_contents(NEW_FILE, $result);
```
