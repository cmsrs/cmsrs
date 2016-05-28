<?php
namespace admin\controllers;

use Yii;
use yii\base\ErrorException;
//use yii\rest\Controller;
use common\models\Base;
//use common\models\Translates;

class UsersController extends BaseController{

    public function actionLogin(){
		$arrPost = $this->getPostData();

		$params =  Base::GetConfigBySection( Base::PARAM_SECTION_PRIV  );
		if( empty($params['auth'])  ){
			throw new ErrorException('0x5656 params wrong');
		}
        $conf = $params['auth'];
		//var_dump( $conf  ); die('ddd');

		if( empty(  $arrPost["username"]) or  empty(  $arrPost["password"]) ){
			throw new ErrorException('0x56567 wrong data');
		}

		if( ( $conf['username'] ==  $arrPost["username"]) and (  $conf['password']  ==  $arrPost["password"]) ){
			return true;

		}
		throw new ErrorException('0x234234 not auth', 403 );
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'login' => ['post'],
            ],
        ];
        return $behaviors;
    }
}
