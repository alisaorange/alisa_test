<?php

namespace app\commands;


use app\models\Author;
use app\models\Book;
use app\models\BookAuthor;
use app\models\BookCat;
use app\models\Category;
use Yii;
use yii\console\Controller;
use yii\web\JsonParser;

class BookController extends Controller
{

    public function actionParsing()
    {
        $file_name = Yii::$app->settings->get('SiteSettings', 'file');
        if(empty($file_name)){
            var_dump('Заполните данные в админке');
            exit();
        }
        $path = Yii::getAlias('@web').'/uploads/'.$file_name;
//        $path = Yii::getAlias('@web').'/uploads/books.json';
        $json = file_get_contents($path);

        $jsonParser = new JsonParser();
        $json_books = $jsonParser->parse($json, true);

        $category = Category::findOne(['cat_name' => 'Новинки']);
        if(empty($category)){
            $category = new Category;
            $category->cat_name = 'Новинки';
            $category->save();
        }

        foreach($json_books as $json_book){
            var_dump($json_book['isbn']);
            if(empty($json_book['isbn'])){ //без isbn не сохраняю
                continue;
            }
            $book = Book::findOne(['isbn' => $json_book['isbn']]);
            if(!isset($book)){
                $book = new Book;
            }
            $book->title = $json_book['title'];
            $book->isbn = $json_book['isbn'];
            $book->pageCount = (int)$json_book['pageCount'] ?? '';

            if(!empty($json_book['publishedDate']['$date'])){
                $timestamp = Yii::$app->formatter->asTimestamp(strtotime($json_book['publishedDate']['$date'])) ?? '';
            }
            $book->publishedDate = $timestamp;

            if(!empty($json_book['thumbnailUrl'])){
                try{
                    file_put_contents( Yii::getAlias('@web').'/uploads/images/img_'.(int)$json_book['isbn'].'.jpg', file_get_contents($json_book['thumbnailUrl']));
                    $book->thumbnail = '/uploads/images/img_'.(int)$json_book['isbn'].'.jpg';
                }catch (\Exception $e) {
                    continue;
                }
            }else{
                $book->thumbnail = '';
            }

            $book->status = $json_book['status'] ?? '';
            $book->shortDescription = $json_book['shortDescription'] ?? '';
            $book->longDescription = $json_book['longDescription'] ?? '';
            if($book->save()){
                if(!empty($json_book['authors'])){
                    $authors = $json_book['authors'];
                    foreach($authors as $author_name){
                        if(strlen($author_name) > 0){
                            //сохраняем авторов
                            $author = Author::findOne(['author_name' => $author_name]);
                            if(empty($author)){
                                $author = new Author;
                                $author->author_name = $author_name;
                                $author->save();
                            }
                            //создаем связку
                            $book_author = BookAuthor::findOne(['book_id' => $book->id, 'author_id' => $author->id]);
                            if(empty($book_author)){
                                $book_author = new BookAuthor;
                                $book_author->book_id = $book->id;
                                $book_author->author_id = $author->id;
                                $book_author->save();
                            }
                        }
                    }
                }

                if(!empty($json_book['categories'])){
                    $categories = $json_book['categories'];
                    foreach($categories as $categorie_name){
                        if(strlen($categorie_name) > 0){
                            $category = Category::findOne(['cat_name' => $categorie_name]);
                            if(empty($category)){
                                $category = new Category;
                                $category->cat_name = $categorie_name;
                                $category->save();
                            }

                            $book_cat = BookCat::findOne(['book_id' => $book->id, 'cat_id' => $category->id]);
                            if(empty($book_cat)){
                                $book_cat = new BookCat;
                                $book_cat->book_id = $book->id;
                                $book_cat->cat_id = $category->id;
                                $book_cat->save();
                            }

                        }
                    }
                }else{
                    //Если у товара нет категории, добавлять товар в категорию Новинки
                    $category = Category::findOne(['cat_name' => 'Новинки']);
                    $book_cat = BookCat::findOne(['book_id' => $book->id, 'cat_id' => $category->id]);
                    if(empty($book_cat)){
                        $book_cat = new BookCat;
                        $book_cat->book_id = $book->id;
                        $book_cat->cat_id = $category->id;
                        $book_cat->save();
                    }
                }
            }else{
                var_dump($book->getErrors());
            }
        }
    }

}