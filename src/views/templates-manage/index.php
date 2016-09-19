<?php

/**
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var yii\web\View $this
 */

use DevGroup\AdminUtils\columns\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = Yii::t('dotplant.emails', 'Templates');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="box">
    <div class="box-body">
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                'name',
                'subject_view_file',
                'body_view_file',
                'is_active',
                ['class' => ActionColumn::class],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
    <div class="box-footer">
        <div class="pull-right">
            <?= Html::a(Yii::t('dotplant.emails', 'Create'), ['edit'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>
