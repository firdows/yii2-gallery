<?php

namespace frontend\modules\gallery\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use backend\modules\gallery\models\Gallery;
use backend\modules\gallery\models\GallerySearch;

/**
 * Default controller for the `gallery` module
 */
class DefaultController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {

        $searchModel = new GallerySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        $model = $this->findModel($id);
//        print_r($model->photos);
//        exit();
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id) {
        if (($model = Gallery::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
