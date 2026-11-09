<?php

function normalizeUrlPath(string $path): string
{
    $path = str_replace('\\', '/', $path);

    return '/' . trim($path, '/');
}


// Base Path

$scriptName = str_replace(
    '\\',
    '/',
    $_SERVER['SCRIPT_NAME'] ?? '/'
);

$scriptDirectory = dirname($scriptName);

$GLOBALS['basePath'] = $scriptDirectory === '/'
    ? ''
    : rtrim($scriptDirectory, '/');


// Request URL

$requestPath = parse_url(
    $_SERVER['REQUEST_URI'] ?? '/',
    PHP_URL_PATH
) ?: '/';

$requestPath = normalizeUrlPath($requestPath);

$basePath = $GLOBALS['basePath'];

if (
    $basePath !== '' &&
    ($requestPath === $basePath ||
     str_starts_with($requestPath, $basePath . '/'))
) {
    $requestPath = substr($requestPath, strlen($basePath));
}

$GLOBALS['requestUrl'] = normalizeUrlPath($requestPath);


// Previous URL

$refererPath = parse_url(
    $_SERVER['HTTP_REFERER'] ?? '/',
    PHP_URL_PATH
) ?: '/';

$refererPath = normalizeUrlPath($refererPath);

if (
    $basePath !== '' &&
    ($refererPath === $basePath ||
     str_starts_with($refererPath, $basePath . '/'))
) {
    $refererPath = substr($refererPath, strlen($basePath));
}

$GLOBALS['previousUrl'] = normalizeUrlPath($refererPath);

