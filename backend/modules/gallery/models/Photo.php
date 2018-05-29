<?php

namespace backend\modules\gallery\models;

use Yii;
use yii\helpers\FileHelper;

/**
 * This is the model class for collection "photo".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $title
 * @property mixed $file
 * @property mixed $gallery_id
 */
class Photo extends \yii\mongodb\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function collectionName() {
        return ['gallery', 'photo'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes() {
        return [
            '_id',
            'title',
            'file',
            'gallery_id',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['title', 'file', 'gallery_id'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            '_id' => 'ID',
            'title' => 'Title',
            'file' => 'File',
            'gallery_id' => 'Gallery ID',
        ];
    }

    public $filePath = '@uploads/photos/';
    public $fileUrl = '/uploads/photos/';

    const noImg = '/uploads/no-image.jpg';

    public function getUploadedFilePath($file) {
        return Yii::getAlias($this->filePath) . '/' . $this->gallery_id . '/' . $this->{$file};
    }

    public function getUploadedFileUrl($file) {
        return $this->fileUrl . '/' . $this->gallery_id . '/' . $this->{$file};
    }

    public function uploads() {
        if ($this->validate()) {

            $pathFile = Yii::getAlias($this->filePath . $this->gallery_id);
            $where = [];

            foreach ($this->file as $key => $is_file) {
                $filename = md5($is_file) . time() . '.' . $is_file->extension;
                $where[] = [
                    'gallery_id' => $this->gallery_id,
                    'file' => $filename
                ];
            }
            foreach ($where as $wh) {
                $model = self::findAll([
                            'gallery_id' => $wh['gallery_id'],
                ]);
                foreach ($model as $ss) {
                    if ($ss->delete()) {
                        FileHelper::removeDirectory($pathFile);
                    }
                }
            }

            #create dir
            FileHelper::createDirectory($pathFile);

            #upload
            foreach ($this->file as $key => $is_file) {
                $filename = md5($is_file) . time() . '.' . $is_file->extension;
                $is_file->saveAs($pathFile . '/' . $filename);
            }

            #save
            foreach ($where as $wh) {
                if (!$model = self::findOne([
                            'gallery_id' => $this->gallery_id,
                        ])) {
                    $model = new self($wh);
                    $model->save();
                }
            }

            return true;
        } else {
            return false;
        }
    }

    public function isImage($filePath) {
        return @is_array(getimagesize($filePath)) ? true : false;
    }

    public function getSize() {
        $isImage = $this->isImage($this->getUploadedFilePath('file'));
        if ($isImage) {
            $size = filesize($this->getUploadedFilePath('file'));
            $labels = ['B', 'KB', 'MB', 'GB'];
            $factor = floor((strlen($size) - 1) / 3);
            return sprintf("%.1f ", $size / pow(1024, $factor)) . $labels[$factor];
        }
    }

    public function getInitialPreview() {
        $isImage = $this->isImage($this->getUploadedFilePath('file'));
        $file = '';
        if ($isImage) {
            $file = Html::img($this->getUploadedFileUrl('file'), ['class' => 'file-preview-image', 'alt' => $this->title, 'title' => $this->title, 'width' => '100%']);
        } else {
//            $file = "<div class='file-preview-other'> " .
//                    "<h2><i class='glyphicon glyphicon-file'></i></h2>" .
//                    "</div>";
            return false;
        }
        return $file;
    }

    public function bindInitialPreview($type = 'file') {
        $initial = [];
        //$files = Json::decode($data);
        //$models = self::findAll(['welfare_request_id' => $this->welfare_request_id, 'welfare_docs_id' => $welfare_doc_id]);
        //foreach ($models as $key => $model) {
        if ($model->getInitialPreview()) {
            $initial[] = $model->getInitialPreview();
        } elseif ($type == 'file') {
            $initial[] = "<div class='file-preview-other'><h2><i class='glyphicon glyphicon-file'></i></h2></div>";
        } elseif ($type == 'config') {
            $initial[] = [
                //'caption' => $value,
                'width' => '120px',
                'url' => Url::to(['/welfare/default/delete-file', 'welfare_request_id' => $this->welfare_request_id, 'welfare_docs_id' => $welfare_doc_id, 'id' => $this->id]),
                'key' => $key
            ];
        }
        // }

        return $initial;
    }

}
