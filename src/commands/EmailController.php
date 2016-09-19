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
     * Send test message
     * @param string $email the email address
     */
    public function actionTest($email)
    {
        EmailHelper::sendNewMessage($email, 1, []);
    }

    /**
     * Send the message
     * @param int $id the message id
     */
    public function actionSend($id)
    {
        $message = Message::findOne($id);
        if ($message !== null) {
            try {
                $widget = new Widget;
                $templateParams = Json::decode($message->packed_json_template_params);
                \Yii::$app->mailer
                    ->compose($message->template->body_view_file, $templateParams)
                    ->setFrom(Module::module()->senderEmail)
                    ->setTo($message->email)
                    ->setSubject(
                        $widget->render($message->template->subject_view_file, $templateParams)
                    )
                    ->send();
                $message->status = Message::STATUS_SUCCESS;
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
}
