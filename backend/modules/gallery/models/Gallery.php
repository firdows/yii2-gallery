<?php

namespace backend\modules\gallery\models;

use Yii;
use yii\bootstrap\Html;

/**
 * This is the model class for collection "gallery".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $title
 * @property mixed $files
 * @property mixed $detail
 * @property mixed $cate_id
 */
class Gallery extends \yii\mongodb\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function collectionName() {
        return ['gallery', 'gallery'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes() {
        return [
            '_id',
            'title',
            'files',
            'detail',
            'cate_id',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['title', 'files', 'detail', 'cate_id'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            '_id' => 'ID',
            'title' => 'Title',
            'files' => 'Files',
            'detail' => 'Detail',
            'cate_id' => 'Cate ID',
        ];
    }

    public function getPhoto() {
        $models = Photo::find()->where(['gallery_id' => (string) $this->_id])->one();
        return $models;
    }

    public function getPhotoImg($maxWidth = '120px;') {
        $photo = $this->photo;
        if ($photo) {
            return Html::img($photo->getUploadedFileUrl('file'), [
                        'class' => 'img-thumbnail gallery-items',
                        'style' => "max-width:{$maxWidth}"
            ]);
        } else {
            return Html::img(Photo::noImg, [
                        'class' => 'img-thumbnail gallery-items',
                        'style' => "max-width:{$maxWidth}"
            ]);
        }
    }

    public function getPhotos() {
        $models = Photo::find()->where(['gallery_id' => (string) $this->_id])->all();
//print_r($models);
        return $models;
        return $this->hasMany(Photo::className(), ['gallery_id' => '_id']);
    }

    public function getCate() {
        return Category::find()->where(['_id' => $this->cate_id])->one();
    }

    public function getPath() {
        $data[] = $this->cate->path;
        $data[] = $this->cate->title;
        $data = array_filter($data);
        return implode(' / ', $data);
    }

}
