<?php
/**
 * @var \yii\widgets\ActiveForm $form
 * @var \yii\db\ActiveRecord $model
 * @var \yii\web\View $this
 */
?>

<div class="row">
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Yii::t('dotplant.emails', 'Common settings') ?></h3>
            </div>
            <div class="panel-body">
                <?= $form->field($model, 'transport')->dropDownList(\DotPlant\Emails\Module::getTransports()) ?>
                <?= $form->field($model, 'senderEmail')->textInput() ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Yii::t('dotplant.emails', 'SMTP settings') ?></h3>
            </div>
            <div class="panel-body">
                <?= $form->field($model, 'smtpHost')->textInput() ?>
                <?= $form->field($model, 'smtpPort')->textInput() ?>
                <?=
                $form->field($model, 'smtpEncryption')
                    ->dropDownList(
                        [
                            '' => '',
                            'tls' => 'TLS',
                            'ssl' => 'SSL',
                        ]
                    )
                ?>
                <?= $form->field($model, 'smtpUsername')->textInput() ?>
                <?= $form->field($model, 'smtpPassword')->passwordInput() ?>
            </div>
        </div>
    </div>
</div>