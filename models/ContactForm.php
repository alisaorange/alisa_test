<?php

namespace app\models;

use Yii;
use app\models\GeneralModel;
use yii\behaviors\TimestampBehavior;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends GeneralModel
{
//    public $name;
//    public $email;
//    public $subject;
//    public $phone;
    public $verifyCode;

    public static function tableName(): string
    {
        return '{{%contact_form}}';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email and body are required
            [['name', 'email'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
            [['name', 'email'], 'string', 'max' => 255],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['subject'], 'string'],
            ['phone', 'string', 'min'=>11, 'max' => 18, 'tooLong'  => 'Номер телефона должен содержать 11 цифр.', 'tooShort' => 'Номер телефона должен содержать 11 цифр.'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact()
    {
        $to_email = Yii::$app->settings->get('SiteSettings', 'sendEmailsTo');
        $from_email = Yii::$app->settings->get('SiteSettings', 'smtpUsernameString');
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($to_email)
                ->setFrom($from_email)
                ->setSubject('Письмо с сайта')
                ->setTextBody($this->subject)
                ->send();
            return true;
        }
        return false;
    }
}
