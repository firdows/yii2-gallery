<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\gallery\models\Category;

/* @var $this yii\web\View */
/* @var $model backend\modules\gallery\models\GallerySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gallery-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
    ]);
    ?>

    <div class="panel-body">
        <div class="row">
            <label class="form-group col-sm-2 text-right">Search : </label>
            <?= $form->field($model, 'title', ['options' => ['class' => 'col-sm-3']])->textInput(['placeholder' => 'Title album'])->label(false) ?>

            <?= $form->field($model, 'cate_id', ['options' => ['class' => 'col-sm-3']])->label(false)->dropDownList(Category::getList(), ['prompt' => '-- Select --']) ?>

            <div class="fcol-sm-3">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            </div>

        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
