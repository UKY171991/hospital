<?php

/**
 * Front controller fallback for shared hosting.
 *
 * If Apache/Nginx is not configured to use the /public directory as the
 * document root (or ignores rewrite rules), this file keeps the app
 * accessible by forwarding requests to Laravel's standard public entry point.
 */

require __DIR__ . '/public/index.php';
