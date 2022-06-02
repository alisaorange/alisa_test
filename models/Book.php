<?php

namespace app\models;

use app\models\GeneralModel;
use Yii;
use yii\behaviors\TimestampBehavior;


class Book extends GeneralModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%book}}';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
            'slug' => [
                'class' => 'app\backend\components\SlugBehavior',
                'in_attribute' => 'title'
            ],
            'saveFile' => [
                'class' => '\app\backend\components\FileSaveBehavior',
                'fields' => ['thumbnail']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'status' => Yii::t('app', 'status'),
            'isbn' => Yii::t('app', 'isbn'),
            'pageCount' => Yii::t('app', 'page Count'),
            'publishedDate' => Yii::t('app', 'published Date'),
            'shortDescription' => Yii::t('app', 'short Description'),
            'longDescription' => Yii::t('app', 'long Description'),
            'thumbnail' => Yii::t('app', 'Image'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At')
        ];
    }

    public function getBookCat()
    {
        return $this->hasMany(BookCat::class, ['book_id' => 'id']);
    }

    public function getBookAuthor()
    {
        return $this->hasMany(BookAuthor::class, ['book_id' => 'id']);
    }


}
