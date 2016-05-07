<?php
use common\models\Pages;

/* @var $this yii\web\View */

$this->title = 'My cmsRS Application';
$lang = Yii::$app->params['lang'];
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Congratulations!</h1>
        <p class="lead">You have successfully created your cmsRS application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.cmsrs.pl">Get started</a></p>
    </div>

    <div class="body-content">

        <div class="row">


		<?php foreach(  $introPages as  $arrHtml ){ 
			$url = Pages::CreateUrlByHtmlArrAndLang( $arrHtml, $lang );
			$pageShortTitle = $arrHtml['translates']['page_short_title'][$lang];
			$pageIntroText  = $arrHtml['translates']['page_intro_text'][$lang];
		?>
            <div class="col-lg-4">
                <h2><?php echo $pageShortTitle; ?></h2>

                <p><?php echo $pageIntroText; ?></p>

                <p><a class="btn btn-default" href="<?php echo $url; ?>"><?php echo $pageShortTitle; ?>&raquo;</a></p>
            </div>
		<?php } ?>

        </div>

    </div>
</div>
