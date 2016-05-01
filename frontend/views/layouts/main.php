<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

use  common\models\Menus;
use  common\models\Translates;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?php 

//$lang = 'en';
//echo "<pre>"; var_dump( Yii::$app->params );  echo "</pre>";  die();

$lang = Yii::$app->params['lang'];
$menuItems = Menus::FrontCreateMenuByLangAndMenuId( $lang  ); 
//var_dump( $menuCmsItems ); 
//die('___');

$menuLangsItems =   Translates::FrontCreateLangMenu();
//echo "<pre>"; print_r( $menuLangsItems  ); echo "</pre>"; die('ppp');

?>

<div class="wrap">
    <?php

/*
	$menuLangsItems = [
		[ 'label' =>  'en', 'url' => ['cms/index']  ],
		[ 'label' =>  'pl', 'url' => ['cms/ix']  ]
	];
*/

    NavBar::begin([
        'brandLabel' => 'cmsRS',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
/*
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
            'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }
*/


    echo Nav::widget([
        'options' => ['class' => 'nav-pills navbar-right', 'role'=>"button"   ],
        'items' => $menuLangsItems,
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-center'],
        'items' => $menuItems,
    ]);
    NavBar::end();

    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?php echo $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
