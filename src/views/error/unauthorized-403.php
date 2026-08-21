<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var string $message */

$this->title = 'Ошибка';
?>

<div class="sx-auth-card sx-surface sx-surface--elevated">
    <div class="sx-auth-card__body">
        <h1 class="sx-auth-card__title"><?= Html::encode($this->title); ?></h1>
        <div class="sx-auth-card__message"><?= $message; ?></div>
    </div>
</div>
