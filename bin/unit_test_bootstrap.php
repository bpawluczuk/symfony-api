<?php

$testDbPath = __DIR__ . '/../var/test.db';
if (!file_exists($testDbPath)) {
    touch($testDbPath);
}

exec('php bin\console doctrine:schema:drop --env=test --force --no-interaction');
exec('php bin\console doctrine:schema:update --env=test --force --no-interaction');

require __DIR__.'/../vendor/autoload.php';