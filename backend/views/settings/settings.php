<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use kartik\file\FileInput;
use vova07\imperavi\Widget;
use yii\helpers\ArrayHelper;

?>

<?php

$this->title = Yii::t('app', 'Settings');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="m-b-15">
    <h3 class="font-weight-bold">
        <?php echo Yii::t('app', 'Settings'); ?>
    </h3>
</div>

<div class="form">
    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'id' => 'site-settings-form',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-lg-3',
                'wrapper' => 'col-lg-9',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]); ?>

    <div class="row">
        <div class="col-md-2">
            <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="#first" data-toggle="tab">Главная</a></li>
                <li><a href="#third" data-toggle="tab">SMTP</a></li>
            </ul>
        </div>
        <div class="col-md-10">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="first">

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            Почта
                        </div>
                        <div class="panel-body">
                            <?php echo $form->field($model, 'sendEmailsTo')->textInput(); ?>
                        </div>
                    </div>


                    <div class="panel panel-success">
                        <div class="panel-heading">
                            Фаил (должен быть в папке uploads)
                        </div>
                        <div class="panel-body">
                            <?php echo $form->field($model, 'file')->textInput(); ?>
                        </div>
                    </div>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            Кол-во книг на странице
                        </div>
                        <div class="panel-body">
                            <?php echo $form->field($model, 'countPage')->textInput(); ?>
                        </div>
                    </div>


                </div>

<!--SMTP-->
                <div role="tabpanel" class="tab-pane" id="third">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            Отправка почты
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-9 col-lg-offset-3">
                                    <div class="alert alert-danger">
                                        Любые изменения могут повлечь сбой при отправке сообщений через обратную связь!
                                    </div>
                                </div>
                            </div>
                            <?php
                            echo $form->field($model, 'smtpHost');
                            echo $form->field($model, 'smtpPort')->textInput([
                                'type' => 'number'
                            ]);
                            echo $form->field($model, 'smtpUsername');
                            echo $form->field($model, 'smtpPassword')->passwordInput();
                            echo $form->field($model, 'smtpSecure')->dropDownList([
                                'ssl' => 'SSL',
                                'tls' => 'TLS'
                            ]);
                            echo $form->field($model, 'fromEmail');
                            ?>
                        </div>
                    </div>
                </div>

            </div>

            <div id="visibleDelivery">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
