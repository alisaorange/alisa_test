<?php

namespace app\controllers;

use app\models\Author;
use app\models\Book;
use app\models\BookAuthor;
use app\models\Category;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\JsonParser;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;

class SiteController extends Controller
{

    public function beforeAction($action)
    {
        if ($action->id == 'search') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $categories = Category::find()->all();
        return $this->render('index', compact('categories'));
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->contact(); //на локалке не работает отправка писем
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionSearch(){

        $text = Yii::$app->request->get('text');
        $all_words = explode(' ', $text);
        $books = [];

        if(!empty($all_words)){
            foreach($all_words as $word){
                if(strlen($word) > 0){
                    $books = Book::find()->where(['like', 'title', $word])->orWhere(['like', 'status', $word])->all();
                    if(!empty($book)){
                        foreach($books as $book){
                            array_push($books, $book);
                        }
                    }

                    $sql = "SELECT * 
                                FROM `book`
                                   LEFT JOIN `book_author` ON (book_author.book_id = book.id )
                                   LEFT JOIN `author` ON author.id = book_author.author_id
                                   WHERE `author`.`author_name` LIKE :word
                                   ";
                    $book_author = Yii::$app->db->createCommand($sql, [':word' => '%'.$word.'%'])->queryAll();
                    if(!empty($book_author)){
                        foreach($book_author as $b_author){
                            $book = Book::find()->where(['id' => $b_author["id"]])->one();
                            if(!empty($book)){
                                array_push($books, $book);
                            }
                        }
                    }
                }
            }
        }

        return $this->render('search', compact('books','text'));
    }

    public function actionSuper() {
        $model = User::find()->where(['username' => 'admin'])->one();
        if (empty($model)) {
            $user = new User();
            $user->username = 'admin';
            $user->email = 'admin@test.ru';
            $user->setPassword('admin');
            $user->status = 30;
            $user->generateAuthKey();
            if ($user->save()) {
                echo 'good';
            }
        }
    }

}
