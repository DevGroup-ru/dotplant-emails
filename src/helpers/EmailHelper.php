<?php

namespace DotPlant\Emails\helpers;

use DevGroup\DeferredTasks\helpers\DeferredHelper;
use DotPlant\Emails\models\Message;
use DotPlant\Emails\Module;
use DevGroup\ExtensionsManager\helpers\ExtensionDataHelper;
use Yii;
use yii\helpers\Json;
use yii\web\ServerErrorHttpException;

/**
 * Class EmailHelper
 * @package DotPlant\Emails\helpers
 */
class EmailHelper
{
    /**
     * Create and run a new deferred task
     * @param string[] $command
     * @param string $groupName
     * @throws ServerErrorHttpException
     */
    public static function runTask($command, $groupName)
    {
        $task = ExtensionDataHelper::buildTask($command, $groupName);
        if ($task->registerTask()) {
            DeferredHelper::runImmediateTask($task->model()->id);
        } else {
            throw new ServerErrorHttpException("Unable to start task");
        }
    }

    /**
     * Create a new message and send it via deferred tasks
     * @param string $email email addresses list separated by comma
     * @param int $templateId the template id form
     * @param array $templateParams
     */
    public static function sendNewMessage($email, $templateId, $templateParams = [])
    {
        $email = explode(',', $email);
        foreach ((array) $email as $singleEmail) {
            $message = new Message;
            $message->attributes = [
                'email' => trim($singleEmail),
                'template_id' => $templateId,
                'packed_json_template_params' => Json::encode($templateParams),
                'status' => Message::STATUS_NEW,
            ];
            if ($message->save()) {
                static::runTask(
                    [
                        realpath(Yii::getAlias('@app') . '/yii'),
                        'emails/send',
                        $message->id,
                    ],
                    Module::DEFERRED_TASK_GROUP_MESSAGE_SEND
                );
            }
        }
    }
}
