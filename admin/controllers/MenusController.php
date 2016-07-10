<?php
namespace admin\controllers;

use Yii;
//use yii\rest\Controller;
use common\models\Menus;
use common\models\Images;
use common\models\Translates;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\AccessControl;


class MenusController extends BaseController{

/*
	private function dataList(){
		$data = Menus::getDataList();
		return  $data; 
	}
*/

	public function actionIndex(){
		$data =   Menus::getDataList();  //$this->dataList();
		//$data['access_token'] = Yii::$app->user->identity->getAuthKey();
		return  $this->respond(  $data );
	}

	public function actionGet( $id = null ){
		$out =  Menus::getDataById( $id );
		return $this->respond(  $out );
	}


	/**
	* potrzebne do testow
	*/
	public function actionDeleteall(){ 
		Images::DeleteAllImgFiles();

		$out =  Menus::deleteAll();

		return $this->respond(  $out );
	}

	public function actionDelete( $id =null ){
		$isDel = Menus::deleteMenuById( $id  );
		return   $this->respond(  $isDel );
	}

	public function actionSave(){
		$arrPost = $this->getPostData();

		$dataTranslate = [];
		if( !empty( $arrPost['translates'] )  ){
			$dataTranslate =  $arrPost['translates'];    //Translates::transformArrFromHtmlToDb(  $arrPost['translates'] );
			unset($arrPost['translates']);
		}

		$menu = new Menus;
		$objMenu =   $menu->saveData( $arrPost  );
		$menuId = $objMenu->getAttribute('id');

		$menu->savePositions( $menuId, $objMenu->getAttribute('position') );

		$arrObjTranslates = $objMenu->translates;

		Translates::saveData( $dataTranslate, [ 'menus_id' => $menuId ],  $arrObjTranslates );

		return   $this->respond( $menuId );
	}

	public function behaviors()
	{
		$behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                //HttpBasicAuth::className(),
                HttpBearerAuth::className(),
                //QueryParamAuth::className(),
            ],
        ];

/*
		$behaviors['access'] = [
			'class' => AccessControl::className(),
			//'only' => ['index'],
			'rules' => [
				[
					'actions' => ['index'],
					'allow' => true,
					'roles' => ['@'],
				],
				[
//					'actions' => ['get'],
                    'allow' => true,
					'roles' => ['?']
                ],



			],
		];
*/


		$behaviors['verbs'] = [
			'class' => \yii\filters\VerbFilter::className(),
			'actions' => [
				'index' => ['get'],
				//'create' => ['post'],
				'save' => ['post'],
				'get' => ['get'],
				'delete' => ['delete'],
				'deleteall' => ['delete'],
			],
		];
		return $behaviors;
	}


}
