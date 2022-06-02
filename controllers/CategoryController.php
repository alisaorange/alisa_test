<?php

namespace app\controllers;

use app\models\Book;
use app\models\BookCat;
use app\models\Category;
use app\backend\components\FrontController;
use Yii;
use yii\data\Pagination;

class CategoryController extends FrontController
{

    public function actionView($slug)
    {
      $model = Category::findBySlug($slug);
      $categories = Category::findAll(['parent_cat_id' => $model->id]);
        $query = Book::find()
          ->joinWith('bookCat')
          ->where(['book_cat.cat_id' => $model->id]);


        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $books = $query->offset($pages->offset)
            ->limit((int)Yii::$app->settings->get('SiteSettings', 'countPage'))
            ->all();

      if(!empty($categories) || !empty($books)){
          return $this->render('view', compact('model','books', 'categories', 'pages'));
      }else{
          return false;
      }

    }
}
