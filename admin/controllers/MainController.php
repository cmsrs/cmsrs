<?php
namespace admin\controllers;

use Yii;
//use yii\rest\Controller;
//use common\models\Menus;
//use common\models\Translates;

class MainController extends BaseController{

    public function actionGetconfig(){
        $params =  Yii::$app->params;
        //var_dump( $params );
        //die( 'getConfig' );
        return $params;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'getconfig' => ['get'],
            ],
        ];
        return $behaviors;
    }

}
