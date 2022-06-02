<?php

/** @var yii\web\View $this */
/** @var \app\models\Category $model */

use yii\helpers\Url;

$this->title = 'Книги';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Категория "<?= $model->cat_name ?>"</h1>
    </div>

    <div class="body-content">

        <div class="row">
            <?php if(!empty($categories)): ?>
                <?php foreach($categories as $category): ?>
                    <div class="card col-lg-3">
                        <a href="<?= Url::to(["/category/{$category->slug}", 'cat' => $category->id]); ?>" class="card-link">
                            <div class="card-body">
                                <h2><?= $category->cat_name ?></h2>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="row">
            <?php if(!empty($books)): ?>
                <?php foreach($books as $book): ?>
                    <div class="card col-lg-4">
                        <img class="card-img-top" src="<?= $book->thumbnail ? $book->thumbnail : '/no-image.png' ?>" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"><?= $book->title ?></h5>
                            <p class="card-text"><?= !empty($book->shortDescription) ? substr($book->shortDescription, 0, 100).'...' : '' ?></p>
                            <a href="<?= Url::to(["/book/{$book->slug}", 'cat' => $model->id]); ?>" class="btn btn-primary">Подробнее</a>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="col-12">
                    <?= $this->render('/templates/_pagination', ['button' => true, 'pages' => $pages]); ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>