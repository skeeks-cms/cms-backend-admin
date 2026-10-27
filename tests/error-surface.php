<?php

$errorAction = file_get_contents(__DIR__.'/../src/actions/ErrorAction.php');
$errorView = file_get_contents(__DIR__.'/../src/views/error/unauthorized-403.php');
$staffView = file_get_contents(__DIR__.'/../src/views/error/error.php');

$checks = [
    'unauthorized layout uses package alias' => strpos($errorAction, "@skeeks/cms/admin/views/layouts/unauthorized") !== false,
    'unauthorized view uses package alias' => strpos($errorAction, "@skeeks/cms/admin/views/error/unauthorized-403") !== false,
    'error surface uses semantic auth card' => strpos($errorView, 'sx-auth-card') !== false,
    'error surface uses semantic surface token' => strpos($errorView, 'sx-surface') !== false,
    'staff error falls back to package view' => strpos($errorAction, "@skeeks/cms/admin/views/error/error") !== false,
    'project error view is used only when present' => strpos($errorAction, 'file_exists(Yii::getAlias($view)') !== false,
    'staff error view uses canonical surface' => strpos($staffView, 'BackendSurfaceWidget') !== false,
];

$failed = array_keys(array_filter($checks, static fn($passed) => !$passed));
if ($failed) {
    fwrite(STDERR, "Failed checks:\n- ".implode("\n- ", $failed)."\n");
    exit(1);
}

echo "All error surface checks passed.\n";
