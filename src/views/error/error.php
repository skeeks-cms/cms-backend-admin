<?php

use skeeks\cms\backend\widgets\BackendSurfaceWidget;

/** @var yii\web\View $this */
/** @var string $message */
/** @var int|null $code */

$titles = [
    403 => 'Доступ запрещён',
    404 => 'Страница не найдена',
];
$this->title = $titles[$code] ?? 'Ошибка';
?>

<?= BackendSurfaceWidget::widget([
    'title'   => $this->title,
    'content' => $message,
]); ?>
