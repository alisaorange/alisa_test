<?php
namespace app\backend\components;

use app\models\User;
use Yii;
use yii\web\Controller;
use \yii\filters\AccessControl;
use app\backend\components\rbac\AccessRule;
use yii\filters\VerbFilter;
use app\backend\assets\AdminAsset;
use app\backend\components\PathBehavior;
use yii\helpers\Url;

class AdminController extends Controller
{
    
    public $layout = 'main';
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'denyCallback' => function ($rule, $action) {
                    if(Yii::$app->user->isGuest) {
                        return $this->redirect('/admin-login');
                    }else {
                        Yii::$app->session->setFlash('warning', 'У вас нет прав на исполнение данных действий');
                        return $this->redirect(Yii::$app->request->referrer ? : ['index']);
                    }
                },
                'except' => ['admin-login'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => [
                            User::ROLE_MODERATOR
                        ],
                    ],
                    [
                        'allow' => true,
                        'roles' => [
                            User::ROLE_ADMIN
                        ],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'path' => [
                'class' => PathBehavior::class,
                'asset_name' => AdminAsset::class
            ],

        ];
    }
}