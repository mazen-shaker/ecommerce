<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

require_once './config/rootPath.php';

require_once './routes/web.php';

require_once './core/routing/Main.php';

require_once './core/routing/router.php';
