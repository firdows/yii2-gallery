<?php

use yii\helpers\Url;
use yii\bootstrap\Html;
use backend\modules\gallery\models\Photo;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="col-sm-3">
    <?=
    Html::a(
            Html::img(Photo::noImg, ['width' => '100%']) . '<br/>' .
            $model->title
            , Url::to(['/gallery/default/index', "GallerySearch[cate_id]" => (string) $model->_id]), ['class' => 'btn btn-default btn-xl btn-block'])
    ?>
</div>
