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

}
