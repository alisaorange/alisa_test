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
class Category extends GeneralModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%category}}';
    }

    public function behaviors(): array
    {
        return [
            'slug' => [
                'class' => 'app\backend\components\SlugBehavior',
                'in_attribute' => 'cat_name'
            ],];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['cat_name', 'slug'], 'string', 'max' => 255],
            [['parent_cat_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cat_name' => Yii::t('app', 'Title'),
            'parent_cat_id' => Yii::t('app', 'Parent cat'),
        ];
    }

    public function getCatBook()
    {
        return $this->hasMany(BookCat::class, ['cat_id' => 'id']);
    }

}
