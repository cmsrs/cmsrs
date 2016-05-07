<?php
namespace admin\controllers;
//namespace \common\models;

use Yii;
use yii\rest\Controller;


class BaseController extends Controller{


	public function getPostData( $field = null  ){
		$post = Yii::$app->request->post('data');

		//var_dump( $post  ); die('__post__');
        $arrPost = is_array( $post ) ? $post : json_decode( $post, true ); //post potrzebny do testow przez cli
		if( !empty($arrPost[$field])  ){
			return $arrPost[$field];
		}

		return $arrPost;
	}

}
