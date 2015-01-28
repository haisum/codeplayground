<?php

namespace app\controllers;

use yii\web\Controller;

class SiteController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionExecute(){
        \Yii::$app->response->format = 'json';
        $code = \Yii::$app->request->post("code");
        $language = \Yii::$app->request->post("language");
        if($code && $language){
            $shell = new \app\docker\Shell;
            $response = $shell->execute($language, $code);
            return $response;
        }
        else{
            return new \stdClass;
        }
    }
}
