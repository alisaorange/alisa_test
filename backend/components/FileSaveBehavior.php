<?php

namespace app\backend\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use Yii;

class FileSaveBehavior extends Behavior
{
  public $fields = ['image'];
  //public $attr = 'thumbnail';
  public $resize = 0;
  public $dirName = 'images';
  public $delete = true;

  public function events()
  {
    $arr = [
      ActiveRecord::EVENT_BEFORE_INSERT => 'saveFile',
      ActiveRecord::EVENT_BEFORE_UPDATE => 'saveFile',
      ];

    if ($this->delete) {
      $arr[ActiveRecord::EVENT_BEFORE_DELETE] = 'deleteFile';
    }

    return $arr;
  }

  /**
   * Сохранение файла на сервере
   */
  public function saveFile($event)
  {

    $nameArr = explode('\\', get_class($this->owner));

    $classname = array_pop($nameArr);

    $foldername = strtolower($classname);

    $web = Yii::getAlias('@webroot');

    $dir = '/' . 'uploads/' .$this->dirName. '/' .$foldername . '/' . date('d') . '/';
    \yii\helpers\BaseFileHelper::createDirectory($web . $dir);

    foreach ($this->fields as $attr) {

      $uploadFile = \yii\web\UploadedFile::getInstance($this->owner, $attr);

      if(is_object($uploadFile)){

        if (!empty($this->owner->{$attr})) {

          $this->delete($this->owner->{$attr});
        }

        $name = 'file_' . date('m-Y_His');

        $ext = $uploadFile->getExtension();

        for($i = 1, $filePath = $dir . $name . '.' . $ext; file_exists($web . $filePath); $i++) {
          $filePath = $dir . $name . "_$i." . $ext;
        }

        copy($uploadFile->tempName, $web . $filePath);


        if ($this->resize) {
          $wh = getimagesize($web . $filePath);
          if ($wh[0] > 1920) {
            $newHeight = (int) ($wh[0]/$wh[1]*1920);
            \yii\imagine\Image::thumbnail($web . $filePath, 1920, $newHeight)
              ->save($web . $filePath);
          }

        }

        $this->owner->{$attr} = $filePath;
      }
    }
  }

  public function deleteFile()
  {
    foreach ($this->fields as $attr) {
      if ($this->owner->{$attr}) {

        $this->delete($this->owner->{$attr});

      }
    }
  }

  private function delete($path)
  {
    $path = Yii::getAlias('@webroot') . $path;

    if(is_file($path)){

      unlink($path);

    }
  }


}