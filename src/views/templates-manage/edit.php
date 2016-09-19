<?php

/**
 * @var DotPlant\Emails\models\Template $model
 * @var yii\web\View $this
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = $model->isNewRecord ? 'Create' : 'Update';
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('dotplant.emails', 'Templates'), 'url' => ['index']],
    $model->isNewRecord ? 'Create' : 'Update',
];

?>
<?php $form = ActiveForm::begin(); ?>
<div class="box">
    <div class="box-body">
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'subject_view_file')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'body_view_file')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'is_active')->widget(\kartik\switchinput\SwitchInput::class) ?>
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
                Yii::t('dotplant.emails', $model->isNewRecord ? 'Create' : 'Update'),
                ['class' => 'btn btn-primary']
            )
            ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
