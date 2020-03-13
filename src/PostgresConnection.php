<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace Hyperf\Database\Postgres;

use Doctrine\DBAL\Driver\PDOPgSql\Driver as DoctrineDriver;
use Hyperf\Database\Connection;
use Hyperf\Database\Postgres\Query\Processors\PostgresProcessor as PostgresQueryProcessor;
use Hyperf\Database\Postgres\Schema\Grammars\PostgresGrammar as PostgresSchemaGrammar;
use Hyperf\Database\Postgres\Query\Grammars\PostgresGrammar as PostgresQueryGrammar;
use Hyperf\Database\Postgres\Schema\PostgresBuilder as PostgresSchemaBuilder;
use PDO;

class PostgresConnection extends Connection
{
    /**
     * Get a schema builder instance for the connection.
     */
    public function getSchemaBuilder(): PostgresSchemaBuilder
    {
        if ($this->schemaGrammar === null) {
            $this->useDefaultSchemaGrammar();
        }

        return new PostgresSchemaBuilder($this);
    }

    /**
     * Bind values to their parameters in the given statement.
     */
    public function bindValues(\PDOStatement $statement, array $bindings): void
    {
        foreach ($bindings as $key => $value) {
            $statement->bindValue(
                is_string($key) ? $key : $key + 1,
                $value,
                is_int($value) || is_float($value) ? PDO::PARAM_INT : PDO::PARAM_STR
            );
        }
    }

    /**
     * Get the default query grammar instance.
     *
     * @return Query\Grammars\PostgresGrammar
     */
    protected function getDefaultQueryGrammar()
    {
        return $this->withTablePrefix(new PostgresQueryGrammar());
    }

    /**
     * Get the default schema grammar instance.
     *
     * @return PostgresSchemaGrammar
     */
    protected function getDefaultSchemaGrammar()
    {
        return $this->withTablePrefix(new PostgresSchemaGrammar());
    }

    /**
     * Get the default post processor instance.
     *
     * @return PostgresQueryProcessor
     */
    protected function getDefaultPostProcessor()
    {
        return new PostgresQueryProcessor();
    }

    /**
     * Get the Doctrine DBAL driver.
     *
     * @return \Doctrine\DBAL\Driver\PDOPgSql\Driver
     */
    protected function getDoctrineDriver()
    {
        return new DoctrineDriver();
    }
}
