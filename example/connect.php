<?php

/**
 * This file is part of the cvtrust/aetna-sutter-eligibility.
 * (c) 2018-2018 California's Valued Trust <itdept@cvtrust.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace CVTrust\SutterHealthAetna\Eligibility;

use Hyperf\Database\Postgres\Connectors\PostgresConnector;
use Hyperf\Database\Postgres\PostgresConnection;
use Swoole\Event;

\error_reporting(E_ALL & ~E_NOTICE);
\chdir(\dirname(__DIR__));

require 'vendor/autoload.php';

//\Swoole\Runtime::enableCoroutine();

\Swoole\Coroutine\run(function () {
    $config = [
        'host' => 'db',
        'port' => 5432,
        'database' => 'postgres',
        'username' => 'postgres',
        'password' => 'postgres'
    ];
    extract($config, EXTR_SKIP);

    $now = microtime(true);

    go(function () use($config) {
        extract($config, EXTR_SKIP);
        $pg = new \Swoole\Coroutine\PostgreSQL();
        $conn = $pg->connect("host={$host};port={$port};dbname={$database};user={$username};password={$password}");
        $now = microtime(true);
        $result = $pg->query('SELECT pg_sleep(2);');
        if (!$result) {
            var_dump($pg->error);
            return;
        }
        $arr = $pg->fetchAll($result);
        var_dump(microtime(true) - $now);
        var_dump($arr);
    });

    go(function () use($config) {
        extract($config, EXTR_SKIP);
        $pg = new \Swoole\Coroutine\PostgreSQL();
        $conn = $pg->connect("host={$host};port={$port};dbname={$database};user={$username};password={$password}");
        $now = microtime(true);
        $result2 = $pg->query('SELECT pg_sleep(2);');
        if (!$result2) {
            var_dump($pg->error);
            return;
        }
        $arr2 = $pg->fetchAll($result2);
        var_dump(microtime(true) - $now);
        var_dump($arr2);
    });

    var_dump(microtime(true) - $now);
});

Event::wait();

