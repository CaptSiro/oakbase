# oakbase
A library for full abstraction of param binding to database query using PDO.

But there is a risk of adding objects that does not implement `\Oakbase\Param` interface, thus adding vulnerability

## Note: That this library is not meant for use in multithreading applications and may result in unexpected behavior

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