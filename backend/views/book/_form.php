<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pageCount')->textInput() ?>

    <?= $form->field($model, 'publishedDate')->textInput() ?>

    <?= $form->field($model, 'thumbnail')->widget(\kartik\file\FileInput::class, [
        'options' => [
            'accept' => 'image/*',
            //'readonly' => true,
        ],
        'pluginOptions' => [
            'showCaption' => false,
            'showUpload' => false,
            'showClose' => false,
            'deleteUrl' => \yii\helpers\Url::toRoute(['/admin/ajax/delete-image?model=Book&field=thumbnail']),
            //'initialPreview' => ($model->thumbnail) ? Yii::getAlias('@webroot') . $model->thumbnail : false,// версия для сервера
            'initialPreview' => ($model->thumbnail) ? : false,
            'initialPreviewConfig' => [['key' => $model->thumbnail]],
            'initialPreviewAsData' => true,
            'allowedFileExtensions' => ['jpg', 'jpeg', 'png'],
        ],
    ]); ?>

    <?= $form->field($model, 'shortDescription')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'longDescription')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
