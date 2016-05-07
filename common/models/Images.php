<?php
 
namespace common\models;

use Yii;

//use \common\helpers\ArrTools;
use	 \yii\helpers\ArrayHelper;
 
//use \yii\db\ActiveRecord;
use yii\base\ErrorException;

use yii\base\Model;
use yii\web\UploadedFile;

class Images extends  Base //ActiveRecord
{
	const DIR_IMAGE = 'images';


    /**
     * @var UploadedFile
     */
/*
    public $imageFile;


    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }
*/


	public static function displayImgById( $id ){
        $arrImg  = Images::GetImagesWithRelations( $id  );
        $pathImg =  Images::GetPathToImageByPageId( $arrImg['pages_id'], $arrImg['name'], $arrImg['id'],  false  );
        //die( $pathImg  );

		if (file_exists(  $pathImg   )){

			header('Content-Type: image/jpeg');
			header('Content-Length: ' . filesize(  $pathImg  ));
			readfile( $pathImg );

		}else{
			return "";
		}

	}

	public static function DeleteAllImgFiles(){
		$dir = Images::GetDirToImages();
		$strExec = "cd ".$dir."; rm -rf *";
		exec( $strExec );
	}

    /**
    * frony
    * to cache - todo
    */
    public static function GetImagesWithRelations( $imgId = null  ){
		//$out =  Images::find()->asArray()->with( 'translates' )->all();
		$arrImg =  Images::find()->asArray()->all();
		$out = ArrayHelper::index($arrImg, 'id');
		
        //echo "<pre>"; var_dump(  $out  ); echo "<pre>";  die('==');

        if( null === $imgId  ){
            return $out;
        }

        if( empty( $out[$imgId] ) ){
            throw new ErrorException('0x234432423432323 empty img for given id');
        }


        return  $out[$imgId];


	}



	//public static function DeleteFiles($dir) { 
	//  foreach(glob($dir . '/*') as $file) { 
	//	if(is_dir($file))  Images::DeleteFiles($file); else unlink($file); 
	//  } rmdir($dir); 
	//}


	public static function GetDirToImages(){
		return  Yii::getAlias('@common'). DIRECTORY_SEPARATOR. Images::DIR_IMAGE;
	}

	public static function GetDirToImageByPageId( $pageId ){
		$dirImg = Images::GetDirToImages();
		return $dirImg.DIRECTORY_SEPARATOR. $pageId; 
	} 

	public static function DeleteImagesPageByPageId( $pageId ){
		if( empty($pageId)  ){
			throw new ErrorException('0x234345433 empty page_id in DeleteImagesPageByPageId');
		}
		$dirImg = Images::GetDirToImageByPageId( $pageId );
		Images::DeleteDir($dirImg);
	}

public static function DeleteDir($dirPath) {
    if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            self::DeleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
}


    public static function deleteImageById( $id ){
        $objImage = Images::findOne($id);
        if( empty($objImage) ){
            return false;
        }

		//print_r( $objImage );
		$objImage->deleteImgFromFs();
		
		//die('_delete__');

        return $objImage->delete();
        //return true;
    }

	public function deleteImgFromFs(){

		$pathImg = Images::GetPathToImageByPageId( $this->pages_id, $this->name, $this->id,   false );
		if( file_exists( $pathImg )  ){
			unlink(  $pathImg  );
			return true;
		}
		//var_dump( $pathImg  );
		return false;
	}

	


	public static function GetPathToImageByPageId( $pageId, $nameFile, $imageId,  $createDir = true  ){
		$dirImgPage = Images::GetDirToImageByPageId( $pageId );

		if (!file_exists(  $dirImgPage  ) && ($createDir == true)  ) {
			if(!mkdir( $dirImgPage, 0777, true)){
				die( '0x23434232423 problem with create dir:'.$dirImgPage  );
			}
		}

		return $dirImgPage.DIRECTORY_SEPARATOR.$imageId."_".trim($nameFile);
	}

    
    public function upload( $pageId )
    {

		//die('========'.Images::GetDirToImages()  );
		if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {

			$fileName =  $_FILES["file"]["name"];

			$objImages = new Images();
			$objImages->name = $fileName; 
			$objImages->no = 1; //to do
			$objImages->pages_id = $pageId;
			$objImages->save();


			$outFile = Images::GetPathToImageByPageId( $pageId, $fileName,  $objImages->id );
			//die(  $outFile  );

			//$newfilename = substr(md5(time()), 0, 10) . '.' . end($temp);
			if(  !move_uploaded_file($_FILES['file']['tmp_name'],   $outFile  ) ){
				return false;
			}

			//return   $outFile;
			return $objImages->id;
		}
		return false;

		//die('ppppppppp');



/*
        if ($this->validate()) {

            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
			echo "<pre>"; print_r( $this ); echo "</pre>";
			die('___ooo___');
            return false;
        }
    }
*/
	}

}
