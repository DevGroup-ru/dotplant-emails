<?php

namespace DotPlant\Emails;

/**
 * Class Module
 * @package DotPlant\Emails
 */
class Module extends \yii\base\Module
{
    const DEFERRED_TASK_GROUP_MESSAGE_SEND = 'dotplant_emails_message_send';
    const TRANSPORT_MAIL = 'Swift_MailTransport';
    const TRANSPORT_SMTP = 'Swift_SmtpTransport';

    // Common settings
    /**
     * @var string transport type
     */
    public $transport = Module::TRANSPORT_MAIL;

    /**
     * @var string the amail of sender
     */
    public $senderEmail = 'no-reply@dotplant.ru';

    // SMTP settings
    /**
     * @var string the smtp host name
     */
    public $smtpHost = 'localhost';

    /**
     * @var int the smtp port
     */
    public $smtpPort = 465;

    /**
     * @var string the smtp username (usually it equals `senderEmail`)
     */
    public $smtpUsername = 'no-reply@dotplant.ru';

    /**
     * @var string the smpt password for username
     */
    public $smtpPassword = 'us3r-w1th0ut-p@ssword';

    /**
     * @var string the security type. `ssl` or `tls` or ``
     */
    public $smtpEncryption = 'ssl';

    /**
     * @return array
     */
    public static function getTransports()
    {
        return [
            self::TRANSPORT_MAIL => \Yii::t('dotplant.emails', 'Mail'),
            self::TRANSPORT_SMTP => \Yii::t('dotplant.emails', 'SMTP'),
        ];
    }

    /**
     * @return self Module instance in application
     */
    public static function module()
    {
        $module = \Yii::$app->getModule('emails');
        if ($module === null) {
            $module = \Yii::createObject(self::class, ['emails']);
        }
        return $module;
    }
}
