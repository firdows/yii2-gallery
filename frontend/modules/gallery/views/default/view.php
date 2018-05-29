<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\gallery\models\Gallery */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Galleries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-view">

    <h1><?= Html::encode($this->title) ?></h1>
   

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'_id',
            'title',
            [
                'attribute' => 'cate_id',
                'value' => function($model) {
                    return $model->path;
                }
            ,],
            //'files',
            'detail',
        ],
    ])
    ?>


    <?php
    echo $this->render('_photo', ['model' => $model]);
    ?>

</div>
