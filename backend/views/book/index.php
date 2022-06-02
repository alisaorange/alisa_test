<?php

use app\models\Book;
use himiklab\thumbnail\EasyThumbnailImage;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'title',
//            'slug',
            'isbn',
//            'pageCount',
            //'publishedDate',
//            'thumbnail',
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
            //'shortDescription:ntext',
            //'longDescription:ntext',
            'status',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Book $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
