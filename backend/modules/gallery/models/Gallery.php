<?php

namespace backend\modules\gallery\models;

use Yii;

/**
 * This is the model class for collection "gallery".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $title
 * @property mixed $files
 * @property mixed $detail
 * @property mixed $cate_id
 */
class Gallery extends \yii\mongodb\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return ['gallery', 'gallery'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
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
    public function rules()
    {
        return [
            [['title', 'files', 'detail', 'cate_id'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'title' => 'Title',
            'files' => 'Files',
            'detail' => 'Detail',
            'cate_id' => 'Cate ID',
        ];
    }
}
