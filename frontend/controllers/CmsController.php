<?php
namespace frontend\controllers;

use Yii;
use common\models\Translates;
//use frontend\models\PasswordResetRequestForm;
//use frontend\models\ResetPasswordForm;
//use frontend\models\SignupForm;
//use frontend\models\ContactForm;
//use yii\base\InvalidParamException;
//use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\base\ErrorException;
use common\models\Pages;
use common\models\Menus;
//use yii\filters\VerbFilter;
//use yii\filters\AccessControl;

/**
 * Site controller
 */
class CmsController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            //'captcha' => [
            //    'class' => 'yii\captcha\CaptchaAction',
            //    'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            //],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
		$urlParams =  Yii::$app->request->get();
		$lang = empty( $urlParams['lang'] ) ? Translates::GetDefaultLang() : $urlParams['lang'];
		Translates::FrontValidLang( $lang  );
		Yii::$app->params['lang'] = $lang;

		$pagesWithIntroText = Pages::FrontGetPagesWithIntroText();
		
		//echo "<pre>"; var_dump( $pagesWithIntroText ); echo "</pre>";

        return $this->render( 'index', ['introPages' => $pagesWithIntroText ] );
    }

    public function actionPage(){
		$urlParams =  Yii::$app->request->get();

		if(  empty( $urlParams['lang'] ) ||  empty( $urlParams['page_id'] )   ){
			throw new ErrorException('0x2343299 empty lang or page_id');
		}

		$lang =  $urlParams['lang']; 
		Translates::FrontValidLang( $lang );
		Yii::$app->params['lang'] = $lang;

		$arrPage =  Pages::GetPagesWithRelations( $urlParams['page_id'] );
		if( empty(  $arrPage["menus_id"]  )  ){
			throw new ErrorException('0x2343299 empty empty menu for page_id='.$urlParams['page_id']  );
		}



		$menuId =  $arrPage["menus_id"];
		$arrMenu = Menus::GetMenusWithRelations( $menuId  );



		$leftMenu = Menus::FrontCreateMenuByLangAndMenuId( $lang, $menuId );

		//die('__');

		if( empty($leftMenu[0])  ){
			throw new ErrorException('0x23432 no left menu'  );
		}


        return $this->render( 'page', [ 'page' => $arrPage, 'menu' => $arrMenu, 'leftMenu' => $leftMenu[0] ] );
	}

}
