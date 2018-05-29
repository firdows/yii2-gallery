<?php

use yii\helpers\Url;
use yii\bootstrap\Html;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="col-sm-3">
    <?= Html::beginTag('a', ['href' => Url::to(['view', 'id' => (string) $model->_id])]) ?>
    <?= $model->getPhotoImg('auto;'); ?><br/>
    <?= Html::label($model->title) ?>
    <?php Html::endTag('a'); ?>
</div>
