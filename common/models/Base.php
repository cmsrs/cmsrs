<?php

namespace common\models;

use \yii\db\ActiveRecord;
//use yii\base\ErrorException;
//use \yii\helpers\ArrayHelper;
//use \common\helpers\ArrTools;

abstract class Base extends ActiveRecord{

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


}
