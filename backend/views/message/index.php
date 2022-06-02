<?php

use app\models\ContactForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contact Forms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-form-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{items}\n{pager}\n{summary}",
            'rowOptions' => function ($model, $key, $index, $grid) {
                return ['data-sortable-id' => $model->id, 'class' => ($model->status) ? '' : 'info'];
            },
            'columns' => [
                [
                    'attribute' => 'status',
                    'value' => function ($model) {
                        $s = Html::beginForm(Url::base(), 'post', ['data-pjax' => 1]);
                        $s .= Html::hiddenInput('id', $model->id);
                        $s .= $model->status ? Html::submitButton('<i class="glyphicon glyphicon-ok"></i>', ['class' => 'seen-remove btn btn-default btn-xs view']) :
                            Html::submitButton('<i class="glyphicon glyphicon-unchecked"></i>', ['class' => 'seen-add btn btn-default btn-xs view']);
                        $s .= Html::endForm();
                        return $s;
                    },
                    'format' => 'raw',
                ],

                'name',
                'email:email',
                'phone',
                'subject:ntext',
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, ContactForm $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                     }
                ],
            ],
        ]); ?>
    <?php Pjax::end(); ?>


</div>
