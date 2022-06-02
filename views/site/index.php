<?php

/** @var yii\web\View $this */
/** @var \app\models\Category $categories */

use yii\helpers\Url;

$this->title = 'Книги';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Список категорий</h1>
    </div>

    <div class="container">

        <div class="row">
            <?php foreach($categories as $category): ?>
                <div class="card col-lg-3">
                    <a href="<?= Url::to(["/category/{$category->slug}", 'cat' => $category->id]); ?>" class="card-link">
                        <div class="card-body">
                            <h2><?= $category->cat_name ?></h2>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>
