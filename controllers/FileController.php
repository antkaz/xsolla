<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use yii\data\ActiveDataProvider;
use app\models\File;

class FileController extends ActiveController
{

    public $modelClass = 'app\models\File';
    public $updateScenario = File::SCENARIO_UPDATE;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['class'] = HttpBearerAuth::className();
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $this->modelClass::find()
                    ->where(['user_id' => Yii::$app->user->id]),
        ]);
        return $dataProvider;
    }

    public function checkAccess($action, $model = null, $params = array())
    {
        if ($action == 'update' || $action == 'delete' || $action == 'view') {
            if ($model->user_id !== Yii::$app->user->id) {
                throw new \yii\web\NotFoundHttpException('The file does not exist');
            }
        }
    }

    /**
     * Returns file metadata
     * 
     * @param int $id File id
     * @return array
     */
    public function actionMeta($id)
    {
        $model = $this->findModel($id);
        return $model->getMeta();
    }

    /**
     * 
     * @param integer $id
     * @return File
     * @throws \yii\web\NotFoundHttpException
     */
    private function findModel($id)
    {
        $modelClass = $this->modelClass;
        $model = $modelClass::findOne(['file_id' => $id, 'user_id' => Yii::$app->user->id]);

        if ($model === null) {
            throw new \yii\web\NotFoundHttpException('The file does not exist');
        }

        return $model;
    }

}
