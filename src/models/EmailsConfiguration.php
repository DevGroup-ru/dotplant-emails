<?php

namespace DotPlant\Emails\models;

use DotPlant\Emails\commands\EmailController;
use DotPlant\Emails\Module;
use DevGroup\ExtensionsManager\models\BaseConfigurationModel;

class EmailsConfiguration extends BaseConfigurationModel
{
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
     * @inheritdoc
     */
    public function getModuleClassName()
    {
        return Module::className();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transport', 'senderEmail'], 'required'],
            [['smtpPort'], 'integer', 'min' => 0],
            [['transport', 'senderEmail', 'smtpHost', 'smtpEncryption', 'smtpUsername', 'smtpPassword'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'transport' => \Yii::t('dotplant.emails', 'Transport'),
            'senderEmail' => \Yii::t('dotplant.emails', 'Sender e-mail'),
            'smtpHost' => \Yii::t('dotplant.emails', 'Host'),
            'smtpPort' => \Yii::t('dotplant.emails', 'Port'),
            'smtpEncryption' => \Yii::t('dotplant.emails', 'Security'),
            'smtpUsername' => \Yii::t('dotplant.emails', 'Username'),
            'smtpPassword' => \Yii::t('dotplant.emails', 'Password'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function webApplicationAttributes()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function consoleApplicationAttributes()
    {
        return [
            'controllerMap' => [
                'emails' => EmailController::class,
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function commonApplicationAttributes()
    {
        return [
            'components' => [
                'i18n' => [
                    'translations' => [
                        'dotplant.emails' => [
                            'class' => 'yii\i18n\PhpMessageSource',
                            'basePath' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'messages',
                        ]
                    ]
                ],
                'mailer' => [
                    'useFileTransport' => false,
                    'transport' => $this->buildTransportConfig(),
                ],
            ],
            'modules' => [
                'emails' => [
                    'class' => Module::class,
                    'layout' => '@app/views/layouts/admin',
                    'senderEmail' => $this->senderEmail,
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function appParams()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function aliases()
    {
        return [
            '@DotPlant/Emails' => realpath(dirname(__DIR__)),
        ];
    }

    /**
     * Build transport configurations by transport type
     * @return array
     */
    protected function buildTransportConfig()
    {
        switch ($this->transport) {
            case Module::TRANSPORT_SMTP: {
                return [
                    'class' => 'Swift_SmtpTransport',
                    'host' => $this->smtpHost,
                    'username' => $this->smtpUsername,
                    'password' => $this->smtpPassword,
                    'port' => $this->smtpPort,
                    'encryption' => $this->smtpEncryption,
                ];
            }
            default:
                return [
                    'class' => 'Swift_MailTransport',
                ];
        }
    }
}
