<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use app\models\Login;

class SiteController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        if ($this->action->id == 'index' || $this->action->id == 'doc') {
            unset($behaviors['contentNegotiator']);
        }

        return $behaviors;
    }

    protected function verbs()
    {
        return [
            'login' => ['post'],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionDoc()
    {
        return $this->render('doc');
    }

    public function actionLogin()
    {
        $model = new Login();
        $model->load(Yii::$app->request->bodyParams, '');
        $token = $model->auth();
        if ($token !== null) {
            return $token;
        } else {
            return $model;
        }
    }

}
