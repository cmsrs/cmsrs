<?php
namespace admin\controllers;

use Yii;
//use yii\rest\Controller;
use common\models\Menus;
use common\models\Translates;

class MenusController extends BaseController{

/*
	private function dataList(){
		$data = Menus::getDataList();
		return  $data; 
	}
*/

	public function actionIndex(){
		$data =   Menus::getDataList();  //$this->dataList();
		return $data;
	}

	public function actionGet( $id = null ){
		$out =  Menus::getDataById( $id );
		return $out;
	}


	/**
	* potrzebne do testow
	*/
	public function actionDeleteall(){ 
		Menus::deleteAll();
	}

	public function actionDelete( $id =null ){
		$isDel = Menus::deleteMenuById( $id  );
		return  $isDel;
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

		return $menuId;
	}

	public function behaviors()
	{
		$behaviors = parent::behaviors();
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
