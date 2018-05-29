<?php

use yii\helpers\Url;
use yii\bootstrap\Html;
use backend\modules\gallery\models\Photo;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$rout = Yii::$app->request->get('pid') ? Url::to(['/gallery/default/index', "GallerySearch[cate_id]" => (string) $model->_id]) : Url::to(['index', "pid" => (string) $model->_id]);
?>

<div class="col-sm-3">
    <?=
    Html::a(
            Html::img(Photo::noImg, ['width' => '100%']) . '<br/>' .
            $model->title
            , $rout, ['class' => 'btn btn-default btn-xl btn-block'])
    ?>
</div>
