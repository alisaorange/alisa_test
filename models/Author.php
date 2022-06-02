<?php

namespace app\models;

use app\models\GeneralModel;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "slide".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $link
 * @property string|null $image_desktop
 * @property string|null $image_mobile
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Author extends GeneralModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%author}}';
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
            [['author_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'author_name' => Yii::t('app', 'Title'),
        ];
    }

    public function getBookAuthor()
    {
        return $this->hasMany(BookAuthor::class, ['author_id' => 'id']);
    }
}
