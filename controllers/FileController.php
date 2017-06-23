<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use yii\data\ActiveDataProvider;

class FileController extends ActiveController
{
    public $modelClass = 'app\models\File';

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
        return Yii::createObject([
                    'class' => ActiveDataProvider::className(),
                    'query' => $this->modelClass::find()->where(['user_id' => Yii::$app->user->id]),
        ]);
    }

}
