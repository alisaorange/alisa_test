<?php

namespace app\models;

use app\models\GeneralModel;

class BookCat extends GeneralModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%book_cat}}';
    }

    public function behaviors(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['book_id', 'cat_id'], 'integer'],
        ];
    }

}
