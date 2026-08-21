<?php

$errorAction = file_get_contents(__DIR__.'/../src/actions/ErrorAction.php');
$errorView = file_get_contents(__DIR__.'/../src/views/error/unauthorized-403.php');

$checks = [
    'unauthorized layout uses package alias' => strpos($errorAction, "@skeeks/cms/admin/views/layouts/unauthorized") !== false,
    'unauthorized view uses package alias' => strpos($errorAction, "@skeeks/cms/admin/views/error/unauthorized-403") !== false,
    'error surface uses semantic auth card' => strpos($errorView, 'sx-auth-card') !== false,
    'error surface uses semantic surface token' => strpos($errorView, 'sx-surface') !== false,
];

$failed = array_keys(array_filter($checks, static fn($passed) => !$passed));
if ($failed) {
    fwrite(STDERR, "Failed checks:\n- ".implode("\n- ", $failed)."\n");
    exit(1);
}

echo "All error surface checks passed.\n";
