<?php

namespace DotPlant\Emails\models;

use DevGroup\Entity\traits\BaseActionsInfoTrait;
use DevGroup\Entity\traits\EntityTrait;
use DevGroup\Entity\traits\SoftDeleteTrait;
use Yii;

/**
 * This is the model class for table "{{%dotplant_emails_template}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $subject_view_file
 * @property string $body_view_file
 * @property integer $is_active
 */
class Template extends \yii\db\ActiveRecord
{
    use BaseActionsInfoTrait;
    use EntityTrait;
    use SoftDeleteTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dotplant_emails_template}}';
    }

    /**
     * @inheritdoc
     */
    public function getRules()
    {
        return [
            [['name', 'subject_view_file', 'body_view_file'], 'required'],
            [['is_active'], 'integer'],
            [['name', 'subject_view_file', 'body_view_file'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getAttributeLabels()
    {
        return [
            'id' => Yii::t('dotplant.emails', 'ID'),
            'name' => Yii::t('dotplant.emails', 'Name'),
            'subject_view_file' => Yii::t('dotplant.emails', 'Subject view file'),
            'body_view_file' => Yii::t('dotplant.emails', 'Body view file'),
            'is_active' => Yii::t('dotplant.emails', 'Is active'),
        ];
    }
}
