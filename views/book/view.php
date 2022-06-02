<?php

/** @var yii\web\View $this */
/** @var \app\models\Book $book */

use yii\helpers\Url;

$this->title = 'Книги';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4"><?= $book->title ?></h1>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-5">
                <img class="card-img-top" src="<?= $book->thumbnail ? $book->thumbnail : '/no-image.png' ?>">
            </div>
            <div class="col-lg-5">
                <?php if(!empty($categories)): ?>
                    <ul>
                    <?php foreach($categories as $category): ?>
                        <li><a href="<?= Url::to(["/category/{$category->slug}", 'cat' => $category->id]); ?>"><?= $category->cat_name ?></a></li>
                    <?php endforeach;?>
                    </ul>
                <?php endif; ?>
                <p>ISBN: <?= $book->isbn ?></p>
                <p>Всего страниц: <?= $book->pageCount ?></p>
                <?php if(!empty($book->bookAuthor)): ?>
                    <p>Авторы: </p>
                    <?php foreach($book->bookAuthor as $b_author): ?>
                        <li><?= $b_author->author->author_name ?></li>
                    <?php endforeach; ?>
                    <ul></ul>
                <?php endif; ?>
                <p><?= $book->longDescription ?></p>
            </div>
        </div>

            <?php if(!empty($books_same_cat)): ?>
                <h2 class="mt-5">Вам может быть интересно</h2>
                <div class="row p-3 border" style="background-color: #bfc1c1">
                    <?php foreach($books_same_cat as $bsc): ?>
                        <div class="card col-lg-4">
                            <a href="<?= Url::to(["/book/{$bsc->slug}", 'cat' => $cat_id]); ?>">
                                <img class="card-img-top" src="<?= $bsc->thumbnail ?>" alt="Card image cap">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title"><?= $bsc->title ?></h5>
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            <?php endif; ?>

    </div>
</div>