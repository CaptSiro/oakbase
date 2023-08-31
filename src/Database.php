<?php

namespace OakBase;

use PDO;
use PDOStatement;
use retval\Exc\Exc;
use retval\Exc\IllegalArgumentExc;
use retval\Result;
use stdClass;
use function retval\fail;
use function retval\success;

require_once __DIR__ . "/../absol/import.php";

import("retval");

require_once __DIR__ . "/buffer/ParamBuffer.php";
require_once __DIR__ . "/exceptions/CreationException.php";
require_once __DIR__ . "/SideEffect.php";



class Database {
    private static Config $config;
    private static Database $instance;
    private PDO $connection;



    /**
     * @throws CreationException
     */
    public function __construct() {
        if (!isset(self::$config)) {
            throw new CreationException("Must set config object before creating connection to database. Use Database::configure() with custom object that implements Config or use BasicConfig class.");
        }

        $connectionString = "mysql:host=" . self::$config->host()
            . ";port=" . self::$config->port()
            . ";dbname=" . self::$config->database_name()
            . ";charset=" . self::$config->charset();
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // errors from MySQL will appear as PHP Exceptions
            PDO::MYSQL_ATTR_MULTI_STATEMENTS => false, // SQL injection
        ];
        $this->connection = new PDO($connectionString, self::$config->user(), self::$config->password(), $opt);
    }



    public static function configure(Config $config): void {
        self::$config = $config;
    }



    public function connection() {
        return $this->connection;
    }



    /**
     * Run a query that does not return any rows such as UPDATE, DELETE, INSERT or TRUNCATE.
     *
     * @param string|Query $query
     * @return Result<SideEffect>
     */
    public function statement(Query|string $query): Result {
        $stmt = $this->connection->prepare(self::get_string($query));
        $res = self::bind_params($stmt, $query);

        if ($res->isFailure()) {
            return $res;
        }

        $stmt->execute();

        return success(
            new SideEffect(
                $this->last_inserted_ID(),
                $stmt->rowCount()
            )
        );
    }



    private static function get_string(Query|string $query): string {
        if ($query instanceof Query) {
            return $query->string();
        }

        return $query;
    }



    private static function bind_params(PDOStatement $statement, Query|string $query): Result {
        $index = 1;
        $indexationType = "--initial--";

        $iteration = 0;
        $count = self::count_params(self::get_string($query));
        $buf = self::get_buffer($query);

        while ($iteration < $count && !$buf->is_empty()) {
            $param = $buf->shift();
            $name = $param->name() ?? $index++;

            if ($indexationType !== gettype($name) && $indexationType !== "--initial--") {
                return fail(new IllegalArgumentExc("Can not use named param logic as well as indexed param logic. Got index: " . $name));
            }

            $indexationType = gettype($name);

            $statement->bindValue($name, $param->value(), $param->type());
            $iteration++;
        }

        return success($statement);
    }



    private static function count_params(string $sql): int {
        $no_string_literals = "";

        $in_string = false;
        for ($i = 0; $i < strlen($sql); $i++) {
            if (in_array($sql[$i], ["'", '"'])) {
                $in_string = !$in_string;
                continue;
            }

            if ($in_string === true) {
                continue;
            }

            $no_string_literals .= $sql[$i];
        }

        return intval(preg_match_all("/([:?])/", $no_string_literals));
    }



    private static function get_buffer(Query|string $query): Buffer {
        if ($query instanceof Query) {
            return $query->params();
        }

        return ParamBuffer::get();
    }



    public static function get(): Database {
        if (!isset($instance)) {
            self::$instance = new Database();
        }

        return self::$instance;
    }



    public function last_inserted_ID(): bool|string {
        return $this->connection->lastInsertId();
    }



    /**
     * Fetch a single row.
     *
     * @param string|Query $query
     * @param string $class
     * @return mixed
     */
    public function fetch(Query|string $query, string $class = stdClass::class): Result {
        $stmt = $this->connection->prepare(self::get_string($query));

        $res = self::bind_params($stmt, $query);

        if ($res->isFailure()) {
            return $res;
        }

        if (!$stmt->execute()) {
            return fail(new Exc("Failed to execute statement"));
        }

        $stmt->setFetchMode(PDO::FETCH_CLASS, $class);

        $data = $stmt->fetch();

        if ($data === false) {
            return fail(new Exc("Failed to fetch statement"));
        }

        return success($data);
    }



    /**
     * Fetch multiple rows.
     *
     * @param string|Query $query
     * @param string $class
     * @return Result
     */
    public function fetch_all(Query|string $query, string $class = stdClass::class): Result {
        $stmt = $this->connection->prepare(self::get_string($query));

        $res = self::bind_params($stmt, $query);

        if ($res->isFailure()) {
            return $res;
        }

        if (!$stmt->execute()) {
            return fail(new Exc("Failed to execute statement"));
        }

        $stmt->setFetchMode(PDO::FETCH_CLASS, $class);

        $data = $stmt->fetchAll();

        if ($data === false) {
            return fail(new Exc("Failed to fetch statement"));
        }

        return success($data);
    }
}