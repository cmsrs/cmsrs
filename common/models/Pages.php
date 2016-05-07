<?php
 
namespace common\models;
//use \common\helpers\ArrTools;
 
//use \yii\db\ActiveRecord;
use yii\base\ErrorException;
use yii\helpers\Url;
//use \yii\helpers\ArrayHelper;

class Pages extends  Base //ActiveRecord
{

	public $_oldPosition;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pages';
    }

	public function rules()
	{
		return [
			[['published', 'is_left_menu', 'is_intro_text',	'is_deleted', 'menus_id'  ], 'required'],
			//[['id_type', 'is_active', 'picture'], 'default'],
		];
	}


	public function getTranslates(){
		return $this->hasMany(   Translates::className(), [ 'pages_id' => 'id' ] );
	}

	public function getContents(){
		return $this->hasMany( Contents::className(), [ 'pages_id' => 'id' ] );
	}

	public function getImages(){
		return $this->hasMany( Images::className(), [ 'pages_id' => 'id' ] );
	}

    public function getMenus(){
		return $this->hasOne( Menus::className(), ['id' => 'menus_id']);
	}


	public static function deletePageById( $id ){
		$objPage = Pages::findOne($id);
		if( empty($objPage) ){
			return false;
		}
		return $objPage->delete();
		//return true;
	}

	/**
	* valid menus_id
	*/
	private static function GetMenuObjByData( $data ){
		if(  empty($data['menus_id'])  ){
			throw new ErrorException('0x2343 empty menus_id');
		}

		$objMenu =  Menus::findOne( $data['menus_id']  );
		return $objMenu;	
	}

	public function saveData( $data  ){

		if( empty( $data['id'] ) ){
			$objPage = new Pages();
		}else{
			$objPage = Pages::findOne( $data['id']  );
			if( empty($objPage) ){
				return false;
			}
		}

		$objMenu = Pages::GetMenuObjByData( $data );
		if(empty($objMenu)  ){
			throw new ErrorException('0x2343234345 empty menus');
		}

		$objPage->attributes =  $data;
		$objPage->save();

		return $objPage;	
	}

	public static  function  getDataList(){

        $arrPages =  Pages::find()->asArray()->with( 'translates' )->all();
		//var_dump( $arrPages );
		//die('=============');

        $data = [];

        $i = 0;
        foreach( $arrPages as $arrPage  ){
			$translates = [];
            foreach(  $arrPage as $key => $itemPage  ){
                if(  'translates' == $key   ){
                    if(  !empty($itemPage)   ){
                        $translates  = Translates::GetDefaultTranslates( $itemPage );
                    }
                }else{
                    $data[$i][$key] = $itemPage;    
                }
            }
			$data[$i] = $data[$i] + $translates;
            $i++;

        }
		//$out = ArrTools::sortDataByPosition( $data  );//brak pozycji


		//echo "<pre>";
		//print_r( $data  ); 
		//echo "</pre>";
		//die('___');



		return $data;
	}

	/**
	* use in front and adin
	*/
/*
	public static function transformPageFromDbToHtml( $arrPage  ){
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
*/

	public static  function  getDataById( $id  ){
		//$table =  'Menus';
		$arrPage = Pages::find()->asArray()->where(['id' => $id])->with( 'translates', 'contents' )->one();

		$out = [];
		if( empty($arrPage)  ){
			$out['id'] = 0;
			$out['published'] = 0;
			$out['is_left_menu'] = 0;
			$out['is_intro_text'] = 0;
			$out['is_deleted'] = 1; 
			return $out ;
		}

		$out = Base::transformDataFromDbToHtml( $arrPage );

/*
		foreach(  $arrPage  as  $key => $item ){
			if(  'translates' == $key   ){
				$out['translates'] =   Translates::transformArrFromDbToHtml( $item );
			}elseif(  'contents' == $key   ){
				$out['contents'] =  Contents::transformArrFromDbToHtml( $item );
			}else{
				$out[$key] = $item;
			}
		}
*/
		//var_dump( $arrMenu );
		return $out;
	}

	public static function FrontGetPagesWithIntroText(){
		$out = [];
		$arrPages = Pages::GetPagesWithRelations();
		foreach( $arrPages as $arrPage  ){
			if( $arrPage['is_intro_text']  ){
				$out[] = $arrPage;
			}
		}
		return $out;
	}


	/**
	* frony
	* to cache - todo
	*/
    public static function GetPagesWithRelations( $pageId = null  ){
        $arrPages =  Pages::find()->asArray()->with( 'translates', 'contents', 'images' )->all();
		//$arrPagesIndex =   ArrayHelper::index( $arrPages, 'id');

		$out = [];
		foreach( $arrPages as $arrPage ){
			$out[ $arrPage['id'] ] = Base::transformDataFromDbToHtml( $arrPage );
		}

		if( null === $pageId  ){
			return $out;
		}

		if( empty( $out[$pageId] ) ){
			throw new ErrorException('0x2344324323 empty page for given id');
		}
		//echo "<pre>"; var_dump(  $arrPagesIndex  ); echo "<pre>";  die('==');

        return  $out[$pageId];
    }

	public static function CreateUrlByHtmlArrAndLang( $arrHtml, $lang ){
		$arrUrl =  ['cms/page',  'page_id' =>  $arrHtml['id'],  'lang' => $lang ];
		return Url::to( $arrUrl );
	}

}
