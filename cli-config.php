<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
$loader = require __DIR__.'/vendor/autoload.php';

require_once __DIR__.'/bootstrap/config.php';
require_once __DIR__.'/bootstrap/database.php';

// replace with mechanism to retrieve EntityManager in your app
$entityManager = $app['orm.em'];

return ConsoleRunner::createHelperSet($entityManager);
