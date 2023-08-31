# OakBase
[Absol package](https://github.com/CaptSiro/absol) for full abstraction of param binding to database query using PDO.

But there is a risk of adding objects that does not implement `\Oakbase\Param` interface, thus adding vulnerability.

## Note: That this library is not meant for use in multithreading applications and may result in unexpected behavior

## Installation

```shell
absol pickup https://github.com/CaptSiro/oakbase.git
```

### Configuration of database

Before you can use the database you need to provide configuration details via implementation of `\Oakbase\Config` interface or creation of `\Oakbase\BasicConfig`

- usage of `\Oakbase\BasicConfig`

```php
use OakBase\Database;
use OakBase\BasicConfig;

Database::configure(new BasicConfig(
    "localhost",
    "database",
    "root",
    "pass_1234"
    // default port: '3306'
    // default charset: 'UTF8'
));
```

### Parameter creation

Oakbase provides 2 classes for parameters (`PrimitiveParam`, `NamedPrimitiveParam`). You can also use the 
`param($value)` function to create `PrimitiveParam` object and `named_param($name, $value)` for NamedPrimitiveParam
object.

**Important: oakbase supports multiple parameters of *SAME* type. You can not use named and normal params together in single query.**

```php
$primitive = new \OakBase\PrimitiveParam(10);

$named = new \OakBase\NamedPrimitiveParam("id", 10);
```

### Usage of methods for basic communication with database

`fetch(string $sql, string $class = stdClass::class)`

```php
$id = new PrimitiveParam(7);

$result = Database::get()->fetch("
    SELECT *
    FROM users
    WHERE id = $id
");
```

`fetch_all($sql, string $class = stdClass::class)`

```php
$amount = new PrimitiveParam(1000);

$result = Database::get()->fetch_all("
    SELECT *
    FROM users
    LIMIT 1, $amount
");
```

For non returning queries use: `statement($sql): SideEffect`

```php
$title = new PrimitiveParam("insert");
$content = new PrimitiveParam(NULL);
$number = new PrimitiveParam(69);

$side_effect = Database::get()->statement("
    INSERT INTO posts (title, content, likes)
    VALUE ($title, $content, $number)
"));
```

### Creating reusable query

Oakbase provides a Query::build() to create reusable query. This query can be saved for later use or 
change parameter values in query.

**Important: To use `set` function you need to use only named params in query**

```php
$id = \OakBase\named_param("id", 10);

$query = \OakBase\Query::build()
    ->use("SELECT * FROM clanky WHERE id = $id");

// some logic...

$query->set(\OakBase\named_param("id", 5));
```