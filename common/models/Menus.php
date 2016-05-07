<?php
 
namespace common\models;

use \common\helpers\ArrTools;
use	 \yii\helpers\ArrayHelper;
 
//use \yii\db\ActiveRecord;
use yii\base\ErrorException;

class Menus extends  Base //ActiveRecord
{

	public $_oldPosition;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menus';
    }

	public function rules()
	{
		return [
			[['published', 'position'], 'required'],
		];
	}

	public function  savePositions( $menuId, $menuPosition ){
		$all =  Menus::find()->all();
		//var_dump( $all  );
		foreach( $all as $menu  ){
			$mId = $menu->getAttribute( 'id'  );
			$mPosition = $menu->getAttribute( 'position' );
			if( empty($this->_oldPosition)  &&  ($mId != $menuId) && $mPosition >= $menuPosition ){
				$menu->setAttribute( 'position', $mPosition + 1 );
				$menu->save();
			}
			if( !empty($this->_oldPosition) && ($mId != $menuId) &&  ($mPosition == $menuPosition ) ){
				$menu->setAttribute( 'position',  $this->_oldPosition );
				$menu->save();
			}

		}
	}


	public function getTranslates(){
		return $this->hasMany(   Translates::className(), [ 'menus_id' => 'id' ] );
	}

	public function getPages(){
		return $this->hasMany(   Pages::className(), [ 'menus_id' => 'id' ] );
	}

	public static function deleteMenuById( $id ){
		$objMenu = Menus::findOne($id);
		if( empty($objMenu) ){
			return false;
		}
		foreach( $objMenu->pages as $page  ){
			Images::DeleteImagesPageByPageId( $page->id );
		}

		return $objMenu->delete();
		//return true;
	}

	public function saveData( $data  ){

		if( empty( $data['id'] )  ){
			$objMenu = new Menus();
			$this->_oldPosition = false;
		}else{
			$objMenu = Menus::findOne( $data['id']  );
			$this->_oldPosition =  $objMenu->getAttribute('position');
			if( empty($objMenu) ){
				return false;
			}
		}

		$objMenu->attributes =  $data;
		$objMenu->save();

		return $objMenu;	
	}

	public static  function  getDataList(){

        $arrMenus =  Menus::find()->asArray()->with( 'translates')->all();

        $data = [];

        $i = 0;
        foreach( $arrMenus as $arrMenu  ){
			$translates = [];
            foreach(  $arrMenu as $key => $itemMenu  ){
                if(  'translates' == $key   ){
                    if(  !empty($itemMenu)   ){
                        $translates  = Translates::GetDefaultTranslates( $itemMenu );
                    }
                }else{
                    $data[$i][$key] = $itemMenu;    
                }
            }
			$data[$i] = $data[$i] + $translates;
            $i++;

        }
		$out = ArrTools::sortDataByPosition( $data  );


		return $out;
	}


	public static  function  getDataById( $id  ){
		//$table =  'Menus';
		$arrMenu = Menus::find()->asArray()->where(['id' => $id])->with( 'translates')->one();
		$countItems = Menus::countItems( $id );

		$out = [];
		if( empty($arrMenu)  ){
			$out['menus_count'] =  $countItems; 
			$out['id'] = 0;
			$out['published'] = 0;
//			$out['is_link'] = 0;
			$out['position'] =  $countItems; 
			return $out ;
		}

		$out = Base::transformDataFromDbToHtml( $arrMenu );
		$out['menus_count'] =  $countItems; 

		return $out;
	}

	public static function countItems( $id  ){
		$count =  Menus::find()->count();
		if( empty($id)   ){ //nowy rekord
			$count = $count + 1;
		}
		return $count;
	}


	/**
	* front
	* to cache - todo
	*/
	public static function GetMenusWithRelations( $menuId = null  ){
        $arrMenus =  Menus::find()->orderBy('position')->asArray()->with( 'translates')->all();
		//$arrMenusIndex =   ArrayHelper::index( $arrMenus, 'id');
		
        $out = [];
        foreach( $arrMenus as $arrMenu ){
            $out[ $arrMenu['id'] ] = Base::transformDataFromDbToHtml( $arrMenu );
        }

		if( null === $menuId  ){
			return $out;
		}
		if( empty( $out[$menuId] )  ){
			throw new ErrorException('0x2345435 empty menu for given id');
		}
		return $out[$menuId];
	}



	public static function  FrontCreateMenuByLangAndMenuId( $lang, $menuId = null ){

		//ArrTools::P( $menuId  );
		//$arrMenusSort = ArrTools::sortDataByPosition( $arrMenus  );
		//ArrTools::P( $arrMenusSort   );
		
        //$arrPages =  Pages::find()->asArray()->with( 'translates')->all();
        $arrPages =  Pages::GetPagesWithRelations();
		


		$menusPages = [];
		foreach( $arrPages as $arrPage ){
			$menusPages[ $arrPage['menus_id']][] = $arrPage; 
		}


		//$menuId = 12;
		$arrMenus = Menus::GetMenusWithRelations( $menuId  );
		$arrMenusTmp = !empty($menuId) ?  [ $arrMenus  ] : $arrMenus;

		//ArrTools::P( $arrMenusTmp ); die('ddd'  );


		$itemsMenu = []; 
		foreach( $arrMenusTmp  as  $arrMenu ){

			if( empty( $arrMenu['published'] ) ){
				continue;
			}

			$arrPages =	empty( $menusPages[  $arrMenu['id']] ) ? array() : $menusPages[ $arrMenu['id']];
			//ArrTools::P(  $arrMenus  ); 

			$itemsForMenu = [];
			foreach( $arrPages as $arrPage  ){

				if( empty( $arrPage['published'] ) ){
					continue;
				}

				$itemsForMenu[] = [
						'label' => $arrPage['translates']['page_short_title'][$lang] , 
						'url' => ['cms/page',  'page_id' =>  $arrPage['id'],  'lang' => $lang  ]
				]; 
			}

			if( 1 ==  count( $itemsForMenu ) ){
				$itemsMenu[] = $itemsForMenu[0];
			}else{
				$itemsMenu[] =[
					'label' =>  $arrMenu['translates']['menu_short_title' ][$lang],
					'items' => $itemsForMenu
				];
			}
		}

		return $itemsMenu;
	}



}
