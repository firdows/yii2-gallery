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


    <div class="row">
        <?= Html::label($model->getAttributeLabel('cate_id'), '', ['class' => 'form-group col-sm-12']) ?>
    </div>
    <div class="row">
        <?=
                $form->field($model, 'cate_id', ['options' => ['class' => 'form-group col-sm-3']])
                ->dropDownList(Category::getList(), ['prompt' => 'Select', 'size' => 4, 'class' => 'form-control pid-main'])
                ->label(false);
        ?>      
        <span class="child_area"></span>

    </div>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'detail') ?>



    <?= $this->render('_photo', ['model' => $model]) ?>

    <?=
    $form->field($modelPhoto, "file[]", [
            //'options' => ['class' => 'form-group col-sm-4']
    ])->widget(FileInput::className(), [
        'pluginOptions' => [
//            'initialPreview' => $modelPhoto->bindInitialPreview(),
//            'initialPreviewConfig' => $modelPhoto->bindInitialPreview('config'),
            'showCaption' => false,
            'showRemove' => false,
            'showUpload' => false,
            'removeLabel' => '',
            //'showPreview' => false,
            'browseClass' => 'btn btn-primary btn-block',
        // 'browseIcon' => $cate['icon'],
        //'browseLabel' => '<br/>' . $doc->title,
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

<?php
$dataCate = json_encode(Category::getChild());
$pidInput = Html::getInputId($model, 'cate_id');
$pidName = Html::getInputName($model, 'cate_id');
//$urlAjax = Url::to('')
$js[] = <<< JS
   
    var dataTopic = $dataCate;
    var topic = 'topic';
    var selectVal = {};
    var subIndex = 0;
    console.log(dataTopic);
        var firstElement ;
    $(document).ready(function () {
        
        console.log(dataTopic);
        $('select#$pidInput').on('change', function () {
            var id = $(this).find('option:selected').val();
        //alert(id);
            if (id != "undefined") {
                $('.child_area .pid-sub').remove();
                $('#dynamic-form').empty();

                selectVal[$(this).attr('id')] = id;
                bindInput(id, subIndex);
            }
        });
    });

    function bindInput(id, subIndex) {
        //console.log(id);
        //alert(id);
        var child = getObjects(dataTopic, 'id', id);
        if (child['0'].sub) {
            console.log('child');
            var subData = child['0'].sub;
            console.log(subData);
            var tagId = topic + id;
            var tagDiv = $('<div class="form-group col-sm-3 field-category-pid pid-sub"></div>');
            var tagSelect = $('<select class="form-control" data-item="' + subIndex + '" size="4" id="' + tagId + '"></select>');
            //$(tagSelect).append('<option>— Select —</option>');
            $.each(subData, function (i, v) {
                option = $('<option></option>').val(v.id).text(v.title);
                $(tagSelect).append(option);
            });
            tagDiv = $(tagDiv).append(tagSelect);
            $('.child_area').append(tagDiv);

            $("#" + tagId).on('change click', function () {
                inputId = $(this).attr('id');

                changeInputName(inputId);
                var id = $(this).find('option:selected').val();
                sortArea($(this));
                bindInput(id, (subIndex + 1));
            });

        }
        console.log(selectVal);
    }

    function sortArea(input) {
        var sub = $(input).attr('data-item');
        $('.child_area select.sub').each(function (index) {
            if ($(this).attr('data-item') > sub) {
                $(this).remove();
            }
        });
    }

    function changeInputName(inputId) {
        $('select[name="$pidName"]').removeAttr('name');
        $('select#' + inputId).attr('name', '$pidName');
    }

    function getObjects(obj, key, val) {
        var objects = [];
        for (var i in obj) {
            if (!obj.hasOwnProperty(i))
                continue;
            if (typeof obj[i] == 'object') {
                objects = objects.concat(getObjects(obj[i], key, val));
            } else if (i == key && obj[key] == val) {
                objects.push(obj);
            }
        }
        return objects;
    }
        
JS;

$this->registerJs(implode('\n', $js));
