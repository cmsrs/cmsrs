<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\helpers\Url;

$lang = Yii::$app->params['lang'];
$this->title =   $page['translates']['page_short_title'][$lang];
$this->params['breadcrumbs'][] =  $menu['translates']['menu_short_title'][$lang];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">
    <?php
//        echo "<pre>";  print_r( $page  ); echo "</pre>";
//        print_r( $menu  );
//        echo "<pre>";  print_r( $leftMenu  ); echo "</pre>";
    ?>

	<div class="row">
	<?php  if( !empty($page['is_left_menu'])  &&   !empty($leftMenu['items'])  ) {  //dla jedenj wartosci nic siennie wyswietli ?>
		<div class="menu-left  col-md-3">
		<?php
			echo Nav::widget([
				'options' => ['class' => 'nav nav-pills nav-stacked'],
				//'items' => empty($leftMenu['items']) ? $leftMenu['url'] :  $leftMenu['items'],
				'items' => $leftMenu['items'],
			]);
		?>
		</div>
	<?php } ?>

		<div class="content   col-md-9">
			<?php
				if( !empty( $page['images'] && is_array( $page['images'] )  )  ){
					foreach(  $page['images'] as $arrImg  ){
						//echo  "<pre>";   print_r(  $arrImg['id']  ); echo "</pre>";
						$linkToImg = Url::to(['cms/image', 'image_id' => $arrImg['id']  ]);
						echo "<img style='margin: 10px'  src='".$linkToImg."'  class='img-thumbnail'  >";
						//echo "</br>";
						//echo "</br>";
					}
				}

			?>
			<div  class="container-fluid" >
			<?php echo $page['contents'][$lang];  ?>
			</div>
		</div>
	</div>

</div>
