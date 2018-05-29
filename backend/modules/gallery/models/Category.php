<?php

namespace backend\modules\gallery\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for collection "category".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $title
 * @property mixed $detail
 * @property mixed $pid
 */
class Category extends \yii\mongodb\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function collectionName() {
        return ['gallery', 'category'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes() {
        return [
            '_id',
            'title',
            'detail',
            'pid',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['title', 'detail', 'pid'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            '_id' => 'ID',
            'title' => 'Title',
            'detail' => 'Detail',
            'pid' => 'Pid',
        ];
    }

    public static function getList($cliend = '') {
        return ArrayHelper::map(self::find()->andWhere(['pid' => $cliend])->all(), function($model) {
                    return (string) $model->_id;
                }, 'title');
    }

    public static function getListAll($cliend = '') {
        $models = self::find()->all();
        $data = [];
        foreach ($models as $model) {
//            if ($child = self::getListAll((string) $model->_id)) {
//                $data[] = $child;
//            }
            $data[] = ['id' => (string) $model->_id, 'title' => $model->path ? $model->path . ' / ' . $model->title : $model->title];
        }
        return ArrayHelper::map($data, 'id', 'title');
    }

    public function getParent() {
        return $this->hasOne(self::className(), ['pid' => '_id']);
    }

    public static function getChild($pid = '') {
        $models = self::find()->where(['pid' => $pid])->all();
        $data = array();
        foreach ($models as $model) {
            $id = (string) $model->_id;
            $sub = self::getChild($id);
            $data[$id] = [
                'id' => $id, 'title' => $model->title
            ];
            if ($sub)
                $data[$id]['sub'] = $sub;
        }
        return $data;
    }

    public static function getParents($id = null) {
        $models = self::find()->where(['_id' => $id])->all();
        $data = array();
        foreach ($models as $model) {
            $pid = $model->pid ? $model->pid : 0;
            $parent = self::getParents($pid);
            $data[] = $model->_id;
            if ($parent) {
                $data[] = $parent;
            }
        }
        return implode(',', $data);
    }

    public function getPath() {
        $data = self::getParents($this->pid);
        $models = self::find()->where(['_id' => explode(',', $data)])->all();
        $models = ArrayHelper::getColumn($models, 'title');
        return implode(' / ', $models);
    }

}
