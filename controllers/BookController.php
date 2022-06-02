<?php

namespace app\controllers;

use app\models\Book;
use app\models\BookCat;
use app\models\Category;
use app\backend\components\FrontController;
use Yii;

class BookController extends FrontController
{

    public function actionView($slug)
    {
        $book = Book::findBySlug($slug);
        $categories = Category::find()
            ->joinWith('catBook')
            ->where(['book_cat.book_id' => $book->id])
            ->all();

        if(!isset(Yii::$app->request->get()["cat"])){
            //Если понадобится выводить книги и тех же категорий что и у данной книги
            $categories_ids = implode(',', array_column($categories, 'id'));
            $books_same_cat = Book::find()
                ->joinWith('bookCat')
                ->where(['book_cat.cat_id' => $categories_ids])
                ->andWhere(['not', ['book_cat.book_id' => $book->id]])
                ->all();
            return $this->render('view', compact('book','categories', 'books_same_cat'));
        }else{
            $cat_id = Yii::$app->request->get()["cat"];
            //Книги из текущей категории(если имеются такие)
            $books_same_cat = Book::find()
                ->joinWith('bookCat')
                ->where(['book_cat.cat_id' => $cat_id])
                ->andWhere(['not', ['book_cat.book_id' => $book->id]])
                ->all();
            return $this->render('view', compact('book','categories', 'books_same_cat','cat_id'));
        }



    }
}
