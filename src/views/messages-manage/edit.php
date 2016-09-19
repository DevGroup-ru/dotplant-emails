<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var DotPlant\Emails\models\Message $model
 * @var yii\web\View $this
 */

$this->title = Yii::t('dotplant.emails', 'Update');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('dotplant.emails', 'Messages'), 'url' => ['index']],
    Yii::t('dotplant.emails', 'Update'),
];

?>
<?php $form = ActiveForm::begin(); ?>
<div class="box">
    <div class="box-body">
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>
                <?= $form->field($model, 'template_id')->textInput(['readonly' => 'readonly']) ?>
                <?= $form->field($model, 'packed_json_template_params')->textarea(['rows' => 6, 'readonly' => 'readonly']) ?>
                <?= $form->field($model, 'status')->textInput(['readonly' => 'readonly']) ?>
            </div>
            <div class="col-xs-12 col-md-4">
                <?= $form->field($model, 'created_at')->textInput(['readonly' => 'readonly']) ?>
                <?= $form->field($model, 'created_by')->textInput(['readonly' => 'readonly']) ?>
                <?= $form->field($model, 'updated_at')->textInput(['readonly' => 'readonly']) ?>
                <?= $form->field($model, 'updated_by')->textInput(['readonly' => 'readonly']) ?>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <div class="pull-right">
            <?=
            Html::submitButton(
                Yii::t('dotplant.emails', 'Update'),
                ['class' => 'btn btn-primary']
            )
            ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
