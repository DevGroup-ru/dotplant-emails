<?php

use app\models\BackendMenu;
use DotPlant\Emails\models\Message;
use DotPlant\Emails\models\Template;
use DevGroup\TagDependencyHelper\NamingHelper;
use yii\caching\TagDependency;
use yii\db\Migration;

class m160916_123819_dotplant_emails_init extends Migration
{
    protected function unsignedPrimaryKey($length = null)
    {
        return $this->getDb()->getSchema()->createColumnSchemaBuilder(\yii\db\mysql\Schema::TYPE_UPK, $length);
    }

    public function up()
    {
        $tableOptions = $this->db->driverName === 'mysql'
            ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB'
            : null;
        $this->createTable(
            Template::tableName(),
            [
                'id' => $this->unsignedPrimaryKey(),
                'name' => $this->string(255)->notNull(),
                'subject_view_file' => $this->string(255)->notNull(),
                'body_view_file' => $this->string(255)->notNull(),
                'is_active' => $this->boolean()->notNull()->defaultValue(true),
                'is_deleted' => $this->boolean()->notNull()->defaultValue(false),
                'created_at' => $this->integer(),
                'created_by' => $this->integer(),
                'updated_at' => $this->integer(),
                'updated_by' => $this->integer(),
            ],
            $tableOptions
        );
        $this->createTable(
            Message::tableName(),
            [
                'id' => $this->unsignedPrimaryKey(),
                'email' => $this->string(255)->notNull(),
                'template_id' => $this->integer()->unsigned()->notNull(),
                'packed_json_template_params' => $this->text(),
                'status' => $this->smallInteger()->notNull()->defaultValue(Message::STATUS_NEW),
                'is_deleted' => $this->boolean()->notNull()->defaultValue(false),
                'created_at' => $this->integer(),
                'created_by' => $this->integer(),
                'updated_at' => $this->integer(),
                'updated_by' => $this->integer(),
            ],
            $tableOptions
        );
        $this->addForeignKey(
            'fk-dotplant_emails_message-template_id-template-id',
            Message::tableName(),
            'template_id',
            Template::tableName(),
            'id',
            'CASCADE',
            'CASCADE'
        );
        // backend menu
        $this->insert(
            BackendMenu::tableName(),
            [
                'parent_id' => 0,
                'name' => 'Emails',
                'icon' => 'fa fa-envelope',
                'sort_order' => 100,
                'rbac_check' => 'backend-view',
                'css_class' => '',
                'route' => '',
                'translation_category' => 'dotplant.emails',
                'added_by_ext' => 'emails',
            ]
        );
        $menuId = $this->db->getLastInsertID();
        $this->batchInsert(
            BackendMenu::tableName(),
            [
                'parent_id',
                'name',
                'icon',
                'sort_order',
                'rbac_check',
                'css_class',
                'route',
                'translation_category',
                'added_by_ext',
            ],
            [
                [
                    $menuId,
                    'Messages',
                    'fa fa-send',
                    0,
                    'backend-view',
                    '',
                    '/emails/messages-manage',
                    'dotplant.emails',
                    'emails',
                ],
                [
                    $menuId,
                    'Templates',
                    'fa fa-list-alt',
                    0,
                    'backend-view',
                    '',
                    '/emails/templates-manage',
                    'dotplant.emails',
                    'emails',
                ],
            ]
        );
        TagDependency::invalidate(Yii::$app->cache, NamingHelper::getCommonTag(BackendMenu::class));
    }

    public function down()
    {
        $this->delete(BackendMenu::tableName(), ['added_by_ext' => 'emails']);
        $this->dropTable(Message::tableName());
        $this->dropTable(Template::tableName());
    }
}
