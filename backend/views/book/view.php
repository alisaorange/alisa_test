<?php

use himiklab\thumbnail\EasyThumbnailImage;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Book */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'slug',
            'isbn',
            'pageCount',
            'publishedDate',
            [
                'attribute' => 'thumbnail',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->thumbnail)
                        return EasyThumbnailImage::thumbnailImg(
                            '@webroot' . $model->thumbnail,
                            100,
                            150,
                            EasyThumbnailImage::THUMBNAIL_OUTBOUND
                        );
                },
            ],
            'shortDescription:ntext',
            'longDescription:ntext',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
