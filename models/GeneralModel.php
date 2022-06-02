<?php

namespace app\models;

use himiklab\thumbnail\EasyThumbnailImage;
use Imagine\Exception\RuntimeException;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\BaseArrayHelper;
use yii\web\HttpException;

/**
 * General class
 */
class GeneralModel extends ActiveRecord
{
    const HIDDEN = 0;
    const VISIBLE = 1;

    const DELETED = -1;
    const UNDELETED = 0;


    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'slug' => [
                'class' => 'app\backend\components\SlugBehavior',
            ],
        ];
    }

    /**
     * Метод, возвращающий список объектов массивом вида ключ - значение
     * return array
     */
    public static function getList($id = 'id', $title = 'title')
    {
        //$all = self::findAll(['deleted' => self::UNDELETED]);
        $all = self::find()->all();
        return BaseArrayHelper::map($all, $id, $title);
    }

    /**
     * Поиск объекта по ссылке
     */
    public static function findBySlug($slug)
    {
        $model = self::findOne(['slug' => $slug]);
        if ($model) {
            return $model;
        } else {
            throw new HttpException(404, 'Страница не найдена');
        }
    }

    public static function getVisibleOptions()
    {
        return [
            self::VISIBLE => 'Видимый',
            self::HIDDEN => 'Скрытый',
        ];
    }

    public static function getDeleteOptions()
    {
        return [
            self::UNDELETED => 'Активный',
            self::DELETED => 'Удаленный',
        ];
    }

    public static function resize($w, $h, $path)
    {

        if ($path) {
            $file = Yii::getAlias('@webroot') . $path;
            $stopList = ['svg'];

            if (!file_exists($file)) {
                $file = Yii::getAlias('@webroot') . '/no-image.png';
            } elseif (in_array(pathinfo($file, PATHINFO_EXTENSION), $stopList)) {
                return $path;
            }
            try {
                return EasyThumbnailImage::thumbnailFileUrl(
                    $file,
                    $w,
                    $h,
                    EasyThumbnailImage::THUMBNAIL_OUTBOUND,
                    90);
            } catch (RuntimeException $e) {
                return $path;
            }
        }

        return false;

    }

    public static function getSlugs()
    {
        $all = self::find()->all();

        return BaseArrayHelper::map($all, 'slug', 'title');
    }

}