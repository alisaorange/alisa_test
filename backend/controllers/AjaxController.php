<?php

namespace app\backend\controllers;

use Yii;
use app\backend\components\AdminController;

/**
 * Default controller for the `backend` module
 */
class AjaxController extends AdminController
{

    public function actions()
    {
        return [
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadFileAction',
                'url' => \yii\helpers\Url::home(true) . 'images/editor', // Directory URL address, where files are stored.
                'path' => '@webroot/images/editor', // Or absolute path to directory where files are stored.
                'uploadOnlyImage' => true, // For any kind of files uploading.
                'unique' => false,
                'replace' => true, // By default it throw an excepiton instead.
                'translit' => true,//translit its name
                    
            ],
        ];
    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionDeleteImage()
    {
        $model = 'app\\models\\'.Yii::$app->request->get('model');
        $field = Yii::$app->request->get('field');
        $file = Yii::$app->request->post('key');
        if ($file) {
            $path = Yii::getAlias('@webroot' . $file);
            if (is_file($path)) {
                unlink($path);
                $elem = $model::findOne([$field => $file]);
                if ($elem) $elem->{$field} = null;
                $elem->updateAttributes([$field]);
            }
            return true;
        }
        return false;
    }



}