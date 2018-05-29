<?php

namespace backend\modules\gallery\controllers;

use Yii;
use backend\modules\gallery\models\Gallery;
use backend\modules\gallery\models\GallerySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\gallery\models\Photo;
use yii\web\UploadedFile;

/**
 * DefaultController implements the CRUD actions for Gallery model.
 */
class DefaultController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Gallery models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new GallerySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Gallery model.
     * @param integer $_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Gallery model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Gallery();
        $modelPhoto = new Photo();

        if ($model->load(Yii::$app->request->post())) {


            $modelPhoto->file = UploadedFile::getInstances($modelPhoto, "file");
            if ($model->save()) {
                $modelPhoto->gallery_id = (string) $model->_id;
                $modelPhoto->uploads();
                return $this->redirect(['view', 'id' => (string) $model->_id]);
            }
        }

        return $this->render('create', [
                    'model' => $model,
                    'modelPhoto' => $modelPhoto,
        ]);
    }

    /**
     * Updates an existing Gallery model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => (string) $model->_id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Gallery model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Gallery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Gallery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Gallery::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

//    
//    private function uploadFile($model, $modelAttach) {
//        $request = Yii::$app->request;
//        $post = $request->post();
//        $err = [];
//        $success = [];
//
//
//        foreach ($modelAttach as $attach) {
//            $doc_id = $attach['doc']->welfare_docs_id;
//            //$images = UploadedFile::getInstance($attach['model'], "[{$doc_id}]file");
//            $modelAttach = $attach['model'];
//            //$images = UploadedFile::getInstances($attach['model'], "[{$doc_id}]file");
//            //print_r($images);
//            //foreach ($images as $key => $file) {
//            //$newModelAttach = new WelfareRequestAttach(['scenario' => 'insert']);
//            //$newModelAttach->scenario = 'insert';
//            $modelAttach->load(["WelfareRequestAttach" => $post['WelfareRequestAttach'][$doc_id]]);
//            //$modelAttach->attributes = $modelAttach->attributes;
//            $modelAttach->file = UploadedFile::getInstances($modelAttach, "[{$doc_id}]file");
//            if (!$modelAttach->uploads()) {
//                $err[] = $modelAttach->getErrors();
//            }
//            //}
//        }
//        if ($err) {
//            echo "<pre>";
//            print_r($err);
//            exit();
//        }
//
//
//
//        return true;
//    }
}
