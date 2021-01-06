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

class PostgresProcessor extends Processor
{
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
