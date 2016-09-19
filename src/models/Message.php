<?php

namespace DotPlant\Emails\models;

use DevGroup\Entity\traits\BaseActionsInfoTrait;
use DevGroup\Entity\traits\EntityTrait;
use DevGroup\Entity\traits\SoftDeleteTrait;
use Yii;

/**
 * This is the model class for table "{{%dotplant_emails_message}}".
 *
 * @property integer $id
 * @property string $email
 * @property integer $template_id
 * @property string $packed_json_template_params
 * @property integer $status
 *
 * @property Template $template
 */
class Message extends \yii\db\ActiveRecord
{
    use BaseActionsInfoTrait;
    use EntityTrait;
    use SoftDeleteTrait;

    const STATUS_FATAL_ERROR = -2;
    const STATUS_ERROR = -1;
    const STATUS_NEW = 0;
    const STATUS_SUCCESS = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dotplant_emails_message}}';
    }

    /**
     * @inheritdoc
     */
    public function getRules()
    {
        return [
            [['email', 'template_id'], 'required'],
            [['template_id', 'status'], 'integer'],
            [['packed_json_template_params'], 'string'],
            [['email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getAttributeLabels()
    {
        return [
            'id' => Yii::t('dotplant.emails', 'ID'),
            'email' => Yii::t('dotplant.emails', 'Email'),
            'template_id' => Yii::t('dotplant.emails', 'Template'),
            'packed_json_template_params' => Yii::t('dotplant.emails', 'Template params'),
            'status' => Yii::t('dotplant.emails', 'Status'),
        ];
    }

    /**
     * Get template model
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::class, ['id' => 'template_id']);
    }
}
