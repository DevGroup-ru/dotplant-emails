<?php

namespace DotPlant\Emails\commands;

use DotPlant\Emails\helpers\EmailHelper;
use DotPlant\Emails\models\Message;
use DotPlant\Emails\Module;
use yii\base\Widget;
use yii\console\Controller;
use yii\helpers\Json;

/**
 * Class EmailController
 * @package DotPlant\Emails\commands
 */
class EmailController extends Controller
{
    /**
     * Send the message via swift mailer
     * @param Message $message
     * @return bool
     */
    private function send($message)
    {
        $widget = new Widget;
        $templateParams = Json::decode($message->packed_json_template_params);
        return \Yii::$app->mailer
            ->compose($message->template->body_view_file, $templateParams)
            ->setFrom(Module::module()->senderEmail)
            ->setTo($message->email)
            ->setSubject(
                $widget->render($message->template->subject_view_file, $templateParams)
            )
            ->send();
    }

    /**
     * Send test message
     * @param string $email the email address
     */
    public function actionTest($email)
    {
        EmailHelper::sendNewMessage($email, 1, []);
    }

    /**
     * Send the message by id
     * @param int $id the message id
     */
    public function actionSend($id)
    {
        $message = Message::findOne($id);
        if ($message !== null) {
            try {
                $message->status = $this->send($message) > 0 ? Message::STATUS_SUCCESS : Message::STATUS_ERROR;
                $message->save(true, ['status']);
            } catch (\Exception $e) {
                $message->status = Message::STATUS_ERROR;
                $message->save(true, ['status']);
                $this->stderr($e->getMessage());
            }
        } else {
            $this->stdout("Message not found\n");
            exit(1);
        }
    }

    /**
     * Send failed messages
     */
    public function sendFailed()
    {
        $messages = Message::findAll(['status' => Message::STATUS_ERROR]);
        foreach ($messages as $message) {
            try {
                $message->status = $this->send($message) > 0 ? Message::STATUS_SUCCESS : Message::STATUS_ERROR;
                $message->save(true, ['status']);
            } catch (\Exception $e) {
                $message->status = Message::STATUS_FATAL_ERROR;
                $message->save(true, ['status']);
                $this->stderr($e->getMessage());
            }
        }
    }
}
