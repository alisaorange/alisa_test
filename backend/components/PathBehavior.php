<?php
namespace app\backend\components;

use yii;
use yii\base\Behavior;
use yii\web\Controller;


class PathBehavior extends Behavior
{
    protected $_asset_path;

    public $asset_name;

    public function events(){
        return Yii::$app->request->isAjax ? [] : [
            Controller::EVENT_BEFORE_ACTION => 'getAssetPath',
        ];
    }

    public function getAssetPath(){
        if(empty($this->_asset_path)){
            $this->_asset_path = (new $this->asset_name)->register($this->owner->view)->baseUrl;
        }
        return $this->_asset_path;
    }
}