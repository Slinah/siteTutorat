<?php
require(__DIR__ . '/vendor/autoload.php');
// require_once __DIR__ . '/vendor/sentry/sentry/src/SentrySdk.php';
// use function Sentry\init;

init(['dsn' => 'https://f6abc5be082f4c52ac8a34b788e4b618@o469219.ingest.sentry.io/5498360' ]);

throw new Exception("My first Sentry error!");