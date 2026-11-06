<?php

declare(strict_types=1);

require __DIR__ . '/../autoloader.php';
require __DIR__ . '/../config/config.php';

use Controllers\FrontController;

FrontController::main();

