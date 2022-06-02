<?php

use yii\widgets\LinkPager; ?>
    <nav>
    <?= LinkPager::widget([
        'options' => ['class' => 'pagination'],
        'pagination' => $pages,
        'disabledListItemSubTagOptions' => ['tag' => 'a'],
        'prevPageLabel' => 'Назад',
        'nextPageLabel' => 'Вперед',
    ]); ?>
    </nav>
