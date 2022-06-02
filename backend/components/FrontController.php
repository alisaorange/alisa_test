<?php

namespace app\backend\components;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class FrontController extends Controller {

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['login', 'logout', 'registration'],
                'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['login', 'registration','after-registration','verify-email','reset-password','reset-password-form','waiting-for-confirmation','agent-blocked','registration-agency','after-registration-agency'],
                            'roles' => ['?'],
                        ],
                        [
                            'allow' => true,
                            //'actions' => ['index'],
                            'roles' => ['@'], //Знак @ — это специальный символ, обозначающий авторизованного пользователя
                        ],
                ],
            ],
        ];

    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
}