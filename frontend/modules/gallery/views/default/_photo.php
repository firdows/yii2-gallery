<?php

use yii\helpers\Html;
use gillz\imageViewer\AssetBundle;
use backend\modules\gallery\assets\fengyuanchenViewer\FengyuanchenViewerAsset;

//AssetBundle::register($this);
FengyuanchenViewerAsset::register($this);

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <?= Html::tag('h5', 'Photo', ['class' => 'panel-title']) ?>
    </div>
    <div class="panel-body">
        <div class="row docs-pictures mailbox-attachments clearfix">

            <?php
            $model = $model->photos;
            foreach ($model as $attach):
                if (file_exists($attach->getUploadedFilePath('file'))):
                    ?>      

                    <div class="col-sm-3">
                        <span class="mailbox-attachment-icon has-img">                    
                            <?php
                            echo Html::img($attach->getUploadedFileUrl('file'), [
                                'alt' => $attach->getUploadedFileUrl('file'),
                                'class' => 'img-thumbnail gallery-items',
                                //'style' => 'max-width:120px;'
                            ]);
                            ?>                    

                        </span>
                        <div class="mailbox-attachment-info">
                            <a href="#" class="mailbox-attachment-name">
                                <i class="fa fa-clip"></i> <?= Html::tag('label', $attach->title . ' #' . $attach->_id) ?>
                            </a>
                            <span class="mailbox-attachment-size">
                                <?= $attach->size ?>
                                <a href="#" class="btn btn-default btn-xs pull-right">
                                    <i class="fa fa-file-text"></i>
                                </a>
                            </span>
                        </div>
                    </div>

                    <?php
                endif;
            endforeach;
            ?>


        </div>
    </div>
</div>

<?php
$js[] = <<< JS
   $(function () {
    var viewer = ImageViewer();
    $('.gallery-items').click(function () {
        var imgSrc = this.src,
            highResolutionImage = $(this).data('high-res-img');
 
        viewer.show(imgSrc, highResolutionImage);
    });
        
   $('.iv-image-view').click(function(){
        viewer.hide();
    });
        
});
JS;

//$this->registerJs(implode("\n", $js));
