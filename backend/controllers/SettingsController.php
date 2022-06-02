<?php

namespace app\backend\controllers;

use app\backend\components\AdminController;
use app\models\SiteSettings;
use Yii;
use yii2mod\settings\actions\SettingsAction;

/**
 * NewsController implements the CRUD actions for News model.
 */
class SettingsController extends AdminController
{
    
function actions(){
        return [
            'index' => [
                'class' => SettingsAction::className(),
                'modelClass' => SiteSettings::className(),
                'successMessage' => 'Настройки успешно обновлены',
                'saveSettings' => function($model) {
                    $model->saveFile();
                    foreach ($model->toArray() as $key => $value) {
                        if ($value === '' && $key != 'logo' && $key != 'sliderImg' && $key != 'precent')
                            Yii::$app->settings->remove('SiteSettings', $key);
                        else
                            Yii::$app->settings->set('SiteSettings', $key, $value);
                    }
                }
            ],
        ];
}
    

}
