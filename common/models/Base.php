<?php

namespace common\models;

use \yii\db\ActiveRecord;
//use yii\base\ErrorException;
//use \yii\helpers\ArrayHelper;
//use \common\helpers\ArrTools;

abstract class Base extends ActiveRecord{

	const PARAM_SECTION_PUBLIC = 'public';
	const PARAM_SECTION_PRIV = 'priv';

    /**
    * use in front and adin
    */
    public static function transformDataFromDbToHtml( $arrPage  ){
        $out = [];
        foreach(  $arrPage  as  $key => $item ){
            if(  'translates' == $key   ){
                $out['translates'] =   Translates::transformArrFromDbToHtml( $item );
            }elseif(  'contents' == $key   ){
                $out['contents'] =  Contents::transformArrFromDbToHtml( $item );
            }else{
                $out[$key] = $item;
            }
        }

        return $out;
    }

	public static function GetConfigBySection(  $section = Base::PARAM_SECTION_PUBLIC  ){
		$params = \Yii::$app->params;
		
        if( empty($params[ $section  ])  ){
            throw new \Exception('0x34234443 param section is empty');
        }

		return $params[$section];
	}

}
