<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Настройки, хранящиеся в БД
 */
class SiteSettings extends Model
{

    public $sendEmailsTo;
    public $smtpHost;
    public $smtpPort;
    public $smtpAuth;
    public $smtpUsername;
    public $smtpPassword;
    public $smtpSecure;
    public $fromEmail;
    public $file;
    public $countPage;

    public function rules()
    {
        return [

            [
                [
                    'sendEmailsTo',
                    'smtpHost',
                    'smtpUsername',
                    'smtpPassword',
                    'file',
                ],
                'string'
            ],


            [['countPage'], 'integer'],

            [['smtpPort'], 'integer', 'min' => 1, 'max' => 65536],
            [['smtpAuth'], 'in', 'range' => [0, 1]],
            [['smtpSecure'], 'in', 'range' => ['ssl', 'tls']],
            [['fromEmail',], 'string', 'max' => 255],
            [['fromEmail'], 'email'],

        ];
    }

    public function attributeLabels()
    {
        return [

        ];
    }

    public static function getPhoneString($num)
    {
        return preg_replace('/[^0-9]/', '', $num);
    }

    /**
     * Сохранение файла на сервере
     */
    public function saveFile()
    {

        $web = Yii::getAlias('@webroot');

        $dir = '/images/settings/';
        \yii\helpers\BaseFileHelper::createDirectory($web . $dir);

        foreach ($this->attributes as $attr => $value) {

            $uploadFile = \yii\web\UploadedFile::getInstance($this, $attr);

            if (is_object($uploadFile)) {

                $name = $attr . date('m-Y_His');
                $ext = $uploadFile->getExtension();

                $filePath = $dir . $name . '.' . $ext;

                $uploadFile->saveAs($web . $filePath);
                $this->{$attr} = $filePath;
            }
        }
    }


}
