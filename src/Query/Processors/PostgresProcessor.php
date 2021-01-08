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

namespace Hyperf\Database\Postgres\Query\Processors;

use Hyperf\Database\Query\Processors\Processor;
use Hyperf\Database\Query\Builder;

class PostgresProcessor extends Processor
{
    /**
     * Process an "insert get ID" query.
     *
     * @param  Builder  $query
     * @param  string  $sql
     * @param  array  $values
     * @param  string|null  $sequence
     * @return int
     */
    public function processInsertGetId(Builder $query, $sql, $values, $sequence = null)
    {
        $connection = $query->getConnection();

        $connection->recordsHaveBeenModified();

        $result = $connection->selectFromWriteConnection($sql, $values)[0];

        $sequence = $sequence ?: 'id';

        $id = is_object($result) ? $result->{$sequence} : $result[$sequence];

        return is_numeric($id) ? (int) $id : $id;
    }

    /**
     * Process the results of a column listing query.
     *
     * @param array $results
     * @return array
     */
    public function processColumnListing(array $results): array
    {
        return array_map(static fn($result) => ((object) $result)->column_name, $results);
    }

    /**
     * Process the results of a column type listing query.
     *
     * @param array $results
     * @return array
     */
    public function processListing(array $results): array
    {
        return array_map(static fn($result) => (array) $result, $results);
    }
}
