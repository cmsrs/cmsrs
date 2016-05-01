<?php
 
namespace common\models;
 
//use yii\helpers\VarDumper;
use \yii\db\ActiveRecord;
class  Contents  extends ActiveRecord
{

	//const TRANSLATES_PREFIX = 'translates_';

    public static function tableName(){
        return 'contents';
    }


    public static  function transformArrFromDbToHtml( $arrDb ){
        $arrHtml = [];
        foreach( $arrDb as $arrItem  ){
            $arrHtml[$arrItem['lang']] = $arrItem['content'];
        }
        return $arrHtml;
    }
	


	public static function saveData(  $arrHtml, $pageId, $arrObj  ){

		$arrDb = [];

		foreach( $arrHtml as $lang=>$content ){

			if( empty( $arrObj )  ){
				$arrDb['lang'] = $lang;
				$arrDb['content'] = $content;
				$arrDb['pages_id'] = $pageId;

				$objContents = new Contents();
				$objContents->attributes = $arrDb;
				$objContents->save();
			}else{
				foreach( $arrObj as $obj ){
					if( ($lang ==  $obj->getAttribute('lang')) && ( $pageId == $obj->getAttribute('pages_id') ) ){
						$obj->setAttribute( 'content',  $content );
						$obj->save();
					}
				}
			}

		}
		return  true;  //$arrDb;
	}


    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [[ 'content', 'lang', 'pages_id'], 'required'],
            //[['pages_id', 'menus_id', 'images_id'], 'default'],
        ];
    }

}
