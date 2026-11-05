<?php

function normalizeUrlPath(string $path): string
{
    $path = str_replace('\\', '/', $path);
    $path = trim($path, '/');

    return $path === '' ? '/' : '/' . $path;
}

function removeBasePath(string $path, string $basePath): string
{
    if (
        $basePath !== '/' &&
        ($path === $basePath ||
         str_starts_with($path, $basePath . '/'))
    ) {
        $path = substr($path, strlen($basePath));
    }

    return normalizeUrlPath($path);
}


// Base Path

$scriptDirectory = dirname(
    str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/')
);

$GLOBALS['basePath'] = normalizeUrlPath($scriptDirectory);


// Request URL

$requestPath = parse_url(
    $_SERVER['REQUEST_URI'] ?? '/',
    PHP_URL_PATH
) ?: '/';

$requestPath = normalizeUrlPath($requestPath);

$GLOBALS['requestUrl'] = removeBasePath(
    $requestPath,
    $GLOBALS['basePath']
);


// Previous URL

$refererPath = parse_url(
    $_SERVER['HTTP_REFERER'] ?? '/',
    PHP_URL_PATH
) ?: '/';

$refererPath = normalizeUrlPath($refererPath);

$GLOBALS['previousUrl'] = removeBasePath(
    $refererPath,
    $GLOBALS['basePath']
);

