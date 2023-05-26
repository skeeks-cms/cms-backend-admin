<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 25.03.2015
 */
/* @var $this yii\web\View */
/* @var $model \skeeks\cms\models\forms\LoginFormUsernameOrEmail */

use skeeks\cms\base\widgets\ActiveFormAjaxSubmit as ActiveForm;
use skeeks\cms\helpers\UrlHelper;

$this->registerCss(<<<CSS
.auth-clients {
    padding-left: 0px;
}
CSS
);
?>


<section class="sx-auth-section">
    <div class="container g-py-100">
        <div class="row justify-content-center">
            <div class="col-sm-8 col-lg-5">
                <div class="sx-auth-wrapper u-shadow-v21 sx-bg-auth rounded g-py-40 g-px-30 sx-bg-block">
                    <header class="text-center mb-4">
                        <h1 class="h2">Авторизация</h1>
                    </header>
                    <?php echo \skeeks\cms\themes\unify\widgets\auth\AuthWidget::widget(); ?>
                </div>
            </div>
        </div>
    </div>
</section>







