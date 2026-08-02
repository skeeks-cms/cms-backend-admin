<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 */

use skeeks\cms\admin\widgets\auth\AuthWidget;

/* @var $this yii\web\View */
/* @var $model \skeeks\cms\models\forms\LoginFormUsernameOrEmail */
?>
<section class="sx-auth-page">
    <div class="sx-auth-card">
        <h1 class="sx-auth-card__title"><?= \Yii::t('skeeks/cms', 'Authorization') ?></h1>
        <?= AuthWidget::widget() ?>
    </div>
</section>
