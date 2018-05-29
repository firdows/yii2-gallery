<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use backend\modules\gallery\models\Category;

/* @var $this yii\web\View */
/* @var $model backend\modules\gallery\models\Gallery */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gallery-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'detail') ?>

    <?= $form->field($model, 'cate_id')->dropDownList(Category::getList()) ?>


    <?=
    $form->field($modelPhoto, "file[]", [
            //'options' => ['class' => 'form-group col-sm-4']
    ])->widget(FileInput::className(), [
        'pluginOptions' => [
            //'initialPreview' => $model->bindInitialPreview($doc->welfare_docs_id),
            //'initialPreviewConfig' => $model->bindInitialPreview($doc->welfare_docs_id, 'config'),
            'showCaption' => false,
            'showRemove' => false,
            'showUpload' => false,
            'removeLabel' => '',
            //'showPreview' => false,
            'browseClass' => 'btn btn-primary btn-block',
            // 'browseIcon' => $cate['icon'],
            'browseLabel' => '<br/>' . $doc->welfareDocs->title,
        //'elCaptionText' => '#customCaption1'
        ],
        'options' => [
            'accept' => 'image/*',
            'multiple' => true
        ]
    ])
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
