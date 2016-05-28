<?php
 
namespace common\models;
 
//use yii\helpers\VarDumper;
use \yii\db\ActiveRecord;
use yii\base\ErrorException;

class  Translates  extends ActiveRecord
{

	//const TRANSLATES_PREFIX = 'translates_';

    public static function tableName(){
        return 'translates';
    }

	
	public static function GetLangs(){
		//$params = \Yii::$app->params;

		$params =  Base::GetConfigBySection( Base::PARAM_SECTION_PUBLIC  );
		if( empty($params['langs'])  ){
			throw new \Exception('0x342343 param lang is empty');
		}

		if( !is_array($params['langs'])  ){
			throw new \Exception('x342343  lang is not arr');
		}

		return $params['langs'];
	}

	public static function GetDefaultLang(){
		$langs = Translates::GetLangs();

		if( empty($langs[0])  ){
			throw new \Exception('0x34236743 default lang is empty');
		}

		return $langs[0];
	}

	/**
	* to rules ?? 
	*/
	public static function FrontValidLang( $lang  ){
		$arrLangs = Translates::GetLangs();
		//echo $lang."<pre>"; var_dump( $arrLangs ); echo "</pre>"; die('========');

		if( !in_array( $lang, $arrLangs  ) ){
			throw new ErrorException('0x2343234345 wrong lang');
		}
		return true;
	}

	public static function   FrontCreateLangMenu(){
		$arrLangs =  Translates::GetLangs();
		$menuLang = [];
		$i = 0;
		foreach( $arrLangs as $lang ){
			//if( 0 == $i  ){
			//	$menuLang[] = [ 'label' =>  $lang,  'url' => ['/' ] ];
			//}else{
			$menuLang[] = [ 'label' =>  $lang,  'url' => ['cms/index', 'lang' => $lang ] ];
			//}

			$i++;
		}

		return  $menuLang;
	}

/*
    $langs = [
        [ 'label' =>  'en', 'url' => ['/site/index']  ],
        [ 'label' =>  'pl', 'url' => ['/site/ix']  ]
    ];
*/



	public static  function GetDefaultTranslates( $arrDb ){
		//$params = \Yii::$app->params['langs'];
		$defaultLang =  Translates::GetDefaultLang();
		$out = [];
		foreach(  $arrDb as $arrItem  ){
			if( $arrItem['lang'] == $defaultLang   ){
				$out[ $arrItem['type']  ] = $arrItem['value'];
			}
		}

		//echo "<pre>";  
		//print_r( $arrDb );
		//print_r( $defaultLang );
		//print_r( $out );
		//echo "</pre>";  
		//die('__dd__');
		return $out;
	}
	
	public static  function transformArrFromDbToHtml( $arrDb ){
		$arrHtml = [];
		foreach( $arrDb as $arrItem  ){
			$arrHtml[$arrItem['type']][$arrItem['lang']] = $arrItem['value'];
		}
		return $arrHtml;
	}

	public static  function __________transformArrFromHtmlToDb( $arrHtml ){
		$arrDb = [];

		$i = 0;
		foreach( $arrHtml as $type=>$arrVal ){
			foreach( $arrVal as $lang => $value ){
				$arrDb[$i]['lang'] = $lang;
				$arrDb[$i]['type'] = $type;
				$arrDb[$i]['value'] = $value;
				$i++;
			}

		}
		return $arrDb;
	}

	public static function saveData(  $arrHtml, $arrFk, $arrObjT  ){

		$arrDb = [];

		foreach( $arrHtml as $type=>$arrVal ){
			foreach( $arrVal as $lang => $value ){

				if( empty( $arrObjT )  ){
					$arrDb['lang'] = $lang;
					$arrDb['type'] = $type;
					$arrDb['value'] = $value;
					$arrDb = array_merge( $arrDb, $arrFk );

					$objTranslates = new Translates();
					$objTranslates->attributes = $arrDb;
					$objTranslates->save();
					//var_dump( $arrDb );  die( '___'  );
				}else{
					foreach( $arrObjT as $objT ){
						if( ($lang ==  $objT->getAttribute('lang')) && ( $type ==  $objT->getAttribute('type') ) ){
							$objT->setAttribute( 'value',  $value );
							$objT->save();
						}
					}
				}
			}

		}
		return $arrDb;
	}

	public static function ________saveData( $arrData, $arrFk, $arrObjT  ){
		foreach( $arrData as $data  ){
			$dataToSave =  array_merge( $data, $arrFk  );
			if( empty($arrObjT)  ){
				$objTranslates = new Translates();
				$objTranslates->attributes = $dataToSave;
				$objTranslates->save();
			}else{
				//var_dump( $dataToSave  );
				foreach( $arrObjT as $objT   ){
					if( $dataToSave[ 'lang'  ] ==  $objT->getAttribute( 'lang'  )){ //brak id dla T dlatego taka rzezba
						$objT->attributes = $dataToSave;
						$objT->save();
					}
				}
			}
		}
	}


 
    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [['lang', 'type', 'value'], 'required'],
            [['pages_id', 'menus_id', 'images_id'], 'default'],
        ];
    }

}
