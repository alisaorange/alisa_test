<?php

use yii\helpers\Url;

$this->title = 'Результат поиска';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Результат поиска</h1>
    </div>

    <div class="container">

        <div class="row">
            <?php if(!empty($books)): ?>
                    <?php foreach($books as $book): ?>
                        <?php if(!empty($book)): ?>
                            <div class="card col-lg-3" >
                                <img class="card-img-top" src="<?= $book->thumbnail; ?>" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $book->title; ?></h5>
                                    <p class="card-text"><?= !empty($book->shortDescription) ? substr($book->shortDescription, 0, 100).'...' : '' ?></p>
                                    <a href="<?= Url::to(["/book/{$book->slug}"]); ?>" class="btn btn-primary">Подробнее</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>
</div>