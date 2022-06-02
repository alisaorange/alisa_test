<?php

namespace app\models;

use app\models\GeneralModel;

class BookAuthor extends GeneralModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%book_author}}';
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
            [['book_id', 'author_id'], 'integer'],
        ];
    }

    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }


}
