<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;

#$this->beginContent('@app/modules/request/views/layouts/menu_bar.php');
$this->beginContent('@app/views/layouts/main.php');
?>


<!--<div class="row">
    <div class="col-sm-12">
<?php #= $this->render('_menubar') ?>
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><?php #= $this->title   ?></h3>
            </div>
            <div class="box-body">
<?php #= $content ?>
            </div>
             /.box-body 
        </div>
    </div>
     /.tab-content 
</div>-->

<div class="panel">
    <?= $this->render('_menubar') ?>
    <div class="panel-body">
        <?= $content ?>
    </div>
    <!-- /.tab-content -->
</div>




<?php
$this->endContent();
?>