函数
----

函数具有全局作用域，可以定义在一个函数之内而在该函数之外调用。

```php

function foo()
{
  function bar()
  {
    echo "I don't exist until foo() is called.\n";
  }
}

/* 现在还不能调用bar()函数，因为它还不存在 */

foo();

/* 现在可以调用bar()函数了，因为foo()函数
   的执行使得bar()函数变为已定义的函数 */

bar();
```

如果要保证定义在函数内部的函数外部不可用，需要使用匿名函数：

```php

function foo() {
  $bar = function() {
    echo "inside";
  };
}
```

函数无法重载，无法取消和重定义。如果有此需要，同样要使用匿名函数。

以上两点可以总结为：函数对应于常量，匿名函数对应于变量。

递归函数调用过百可能会使堆栈崩溃。

函数的默认参数只能用常量表达式定义，不能是变量、函数调用！

函数不能返回多个值。

从函数返回引用时，必须在函数声明和指派返回值时都使用引用运算符：

```php
function &returns_reference()
{
    return $someref;
}

$newref =& returns_reference();
```

匿名函数访问闭包内的变量需要用`use ($var)`声明，只读访问。

PHP也支持类似`Perl`和`sh`的函数定义，在定义时不指定参数，通过`func_num_args()`、`func_get_arg()`和`func_get_args()`处理应用函数时传入的参数。

函数的参数可以指定类型，例如对象（指定类的名字）、接口、数组、或者callable，但是不能是数字或字符串，Traits也不允许。（[据说SVN里有支持数字、字符串的一个实现](http://stackoverflow.com/a/3112831/222893)，但是最后PHP是否会支持这一特性仍然未定。）

匿名函数生成Closure类的实例:

```
boris> $lambda = function() { echo 'hi'; };
 → object(Closure)(

)
```

类
--

`class`声明通过`extends`表明继承关系，不支持多重继承。

可以通过`parent::`访问被覆盖的方法或属性。

父类定义方法时声明`final`，则不可覆盖。（`final`还可用于声明类，`final`类不能被继承。）

覆盖方法时，参数必须保持一致，否则会抛出`E_STRICT`警告。

使用`ClassName::class`可以获取类的完全名称，对使用了命名空间的类尤其有用。

类的属性只能初始化为定值！

```php
{
   // 错误的属性声明
   public $var1 = 'hello ' . 'world';
   public $var2 = <<<EOD
hello world
EOD;
   public $var3 = 1+2;
   public $var4 = self::myStaticMethod();
   public $var5 = $myVar;

   // 正确的属性声明
   public $var6 = myConstant;
   public $var7 = array(true, false);

   //在 PHP 5.3.0 及之后，下面的声明也正确
   public $var8 = <<<'EOD'
hello world
EOD;
}
```

类中可以定义`__construct()`，用于建立对象时的初始化工作。显式地销毁某个对象，或者对某个对象的所有引用都没删除时，会执行`__destruct()`。

属性必须被定义为`public`、`protected`(子类、父类可见)、`private`之一。

类中的方法同理，但是默认`public`。

声明属性或方法为`static`，就可以不实例化而直接访问，例如通过`::`。静态属性不能通过对象来访问（但静态方法可以）。

`abstract`类不能被实例化。一旦有一个方法被声明为`abstract`，类就必须被声明为`abstract`。继承抽象类的时候，子类必须定义父类中的所有抽象方法，并且这些方法的访问控制不能比父类严格。

```php
abstract class AbstractClass
{
 // 强制要求子类定义这些方法
    abstract protected function getValue();
    abstract protected function prefixValue($prefix);

    // 普通方法（非抽象方法）
    public function printOut() {
        print $this->getValue() . "\n";
    }
}
```

和抽象类相似的概念是接口，接口的特性是接口中定义的所有方法都必须是公有的。

```php
interface a
{
    public function foo();
}

interface b extends a
{
    public function baz(Baz $baz);
}


class c implements b
{
    public function foo()
    {
    }

    public function baz(Baz $baz)
    {
    }
}
```

实现接口的类必须实现接口中定义的所有方法。

类可以实现多个接口，用逗号来分隔多个接口的名称。（实现多个接口时，接口中的方法不能有重名。）

接口中定义的常量不能被子类或子接口所覆盖。

使用`trait`可以水平组合功能：

```php
trait Hello {
    public function sayHello() {
        echo 'Hello ';
    }
}

trait World {
    public function sayWorld() {
        echo 'World';
    }
}

class MyHelloWorld {
    use Hello, World;
    public function sayExclamationMark() {
        echo '!';
    }
}
```

`trait`不能实例化，优先级比类当前成员低，但比继承的成员高。

多个`trait`冲突时，使用`insteadof`指明使用哪一个方法，`as`将方法以其他名称引入。

```php
class Aliased_Talker {
    use A, B {
        B::smallTalk insteadof A;
        A::bigTalk insteadof B;
        B::bigTalk as talk;
    }
}
```

`as`还可用于修改访问控制：

```php
class MyClass1 {
    use HelloWorld { sayHello as protected; }
}
class MyClass2 {
    use HelloWorld { sayHello as private myPrivateHello; }
}
```

`trait`可以互相引用：

```php
trait HelloWorld {
    use Hello, World;
}
```

`trait`同样支持抽象方法：

```php
trait Hello {
    public function sayHelloWorld() {
        echo 'Hello'.$this->getWorld();
    }
    abstract public function getWorld();
}
```

`trait`不能定义`static` 变量，`trait`定义的静态方法，使用`trait`的类可以用。

`trait`定义了属性之后，类不能定义同样名称的属性。

PHP的重载和别的语言不一样，它指动态地创建属性和方法。

属性：

- 在给不可访问属性赋值时，`__set()`会被调用。
- 读取不可访问属性的值时，`__get()`会被调用。
- 当对不可访问属性调用 `isset()` 或 `empty()` 时，`__isset()`会被调用。
- 当对不可访问属性调用 `unset()` 时，`__unset()` 会被调用。

方法：

- 在对象中调用一个不可访问方法时，`__call()` 会被调用。
- 用静态方式中调用一个不可访问方法时，`__callStatic()` 会被调用。

`foreach`可以遍历对象的所有可见属性。可以通过实现`Iterator`或`IteratorAggregate`接口来指明如何遍历。

`Traversable`是一个抽象接口，可以用来检查是否可以被`foreach`遍历：

```php
if( !is_array( $items ) && !$items instanceof Traversable )
        //Throw exception here
```

使用`clone`关键字可以复制一个对象，对象的所有属性是浅复制。如果定义了`__clone()`方法，那么复制完成会调用该方法，可用于修改属性的值。

`==`属性、属性值、类均同。`===`同一对象。

PHP 5.3.0 起支持了 `late static bindings`，绑定的方法会调用运行时(late)首先调用该方法的类，复用了`static`关键字。

```php
class A {
    public static function who() {
        echo __CLASS__;
    }
    public static function test() {
        static::who(); // Here comes Late Static Bindings
    }
}

class B extends A {
    public static function who() {
        echo __CLASS__;
    }
}

B::test(); //  B
```

对象变量保存一个标识符来访问真正的对象内容,当对象作为参数传递，作为结果返回，或者赋值给另外一个变量，另外一个变量跟原来的不是引用的关系，只是他们都保存着同一个标识符的拷贝，这个标识符指向同一个对象的真正内容。


所有php里面的值都可以使用函数`serialize()`来返回一个字符串表示。 `unserialize()`函数能够重新把字符串变回php原来的值。序列化一个对象将会保存对象的所有变量，但是不会保存对象的方法，只会保存类的名字。

魔术方法以`__`开头，除了上面提到的以外，还有：

- `__sleep()`和`__wakeup()`，分别对应于`serialize()`和`unserialize()`，一个常用于提交未提交的数据，一个常用于执行初始化操作。
- `__toString()` 方法用于一个类被当成字符串时应怎样回应。
- `__invoke()` 当尝试以调用函数的方式调用一个对象时调用此方法。
- `__set_state()`，用于 `var_export()` 导出类时。

如果类实现了`Serializable`接口，那么这个类就不再支持`__sleep()`和`__wakeup()`。

命名空间
--------

类、函数、常量受命名空间的影响。

通过`namespace`声明，必须在所有代码（除declare编码语句）之前（包括非PHP代码）。

同一个命名空间的内容可以分割存放在不同文件中。

命名空间可以分层定义：

```php
namespace MyProject\Sub\Level;
```

可以在同一文件中定义多个命名空间，但是不推荐。如果实在要这么做，建议用大括号括起不同的命名空间。将全局的非命名空间代码和命名空间的代码组合时，必须加大括号。全局代码用不带名称的`namespace`语句声明。

常量`__NAMESPACE__`的值是包含当前命名空间名称的字符串。关键字`namespace`可用来显式访问当前命名空间或子命名空间中的元素。它等价于类中的 `self` 操作符。

命名空间名称或类名称可以使用别名：

```php
namespace foo;
use My\Full\Classname as Another;
```

命名空间内部，用 `\` 表示该名称是全局空间中的名称。

异常处理
--------

使用`throw`、`catch`、`try`语句。

```php
function inverse($x) {
    if (!$x) {
        throw new Exception('Division by zero.');
    }
    else return 1/$x;
}

try {
    echo inverse(5) . "\n";
    echo inverse(0) . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// Continue execution
echo 'Hello World';
```

Exception 类

```
Exception {
  /* 属性 */
  protected string $message ;
  protected int $code ;
  protected string $file ;
  protected int $line ;
  /* 方法 */
  public __construct ([ string $message = "" [, int $code = 0 [, Exception $previous = NULL ]]] )
  final public string getMessage ( void )
  final public Exception getPrevious ( void )
  final public int getCode ( void )
  final public string getFile ( void )
  final public int getLine ( void )
  final public array getTrace ( void )
  final public string getTraceAsString ( void )
  public string __toString ( void )
  final private void __clone ( void )
```


生成器
------

通常只需用`yield`取代`return`。

例如，用生成器重新实现低内存占用的`range()`函数：

```php
function xrange($start, $limit, $step = 1) {
    if ($start < $limit) {
        if ($step <= 0) {
            throw new LogicException('Step must be +ve');
        }

        for ($i = $start; $i <= $limit; $i += $step) {
            yield $i;
        }
    } else {
        if ($step >= 0) {
            throw new LogicException('Step must be -ve');
        }

        for ($i = $start; $i >= $limit; $i += $step) {
            yield $i;
        }
    }
}
```

`yield`可以返回键值对：

```php
function input_parser($input) {
    foreach (explode("\n", $input) as $line) {
        $fields = explode(';', $line);
        $id = array_shift($fields);

        yield $id => $fields;
    }
}
```

生成器函数第一次调用时，会返回一个内部的Generator类（无法使用`new`实例化的类)的对象。类似于`Iterator`接口，但是多了一个`send()`方法。

`Generator::send()`允许迭代的时候插入值。插入的值会被`yield`语句返回，并且可以在生成器函数中使用。

相比实现一个`Iterator`类，生成器要简单地多，往往能提升代码可读性。


超全局变量
----------

在一个脚本的全部作用域中都可用。

- `$GLOBALS`
- `$_SERVER`
- `$_GET`
- `$_POST`
- `$_FILES`
- `$_COOKIE`
- `$_SESSION`
- `$_SESSION`
- `$_REQUEST`
- `$_ENV`

其他预定义变量
--------------

- `$php_errormsg` （仅在 php.ini 文件中的 `track_errors` 配置项开启的情况下可用。默认关闭。）
- `$argc`
- `$argv`

ArrayAccess接口
---------------

实现了这一接口的类可以当数组用。

```
ArrayAccess {
  /* Methods */
  abstract public boolean offsetExists ( mixed $offset )
  abstract public mixed offsetGet ( mixed $offset )
  abstract public void offsetSet ( mixed $offset , mixed $value )
  abstract public void offsetUnset ( mixed $offset )
}
```


