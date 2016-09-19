<?php

use DevGroup\AdminUtils\columns\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var yii\web\View $this
 */

$this->title = Yii::t('dotplant.emails', 'Messages');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="box">
    <div class="box-body">
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                'email:email',
                'template_id',
                'status',
                ['class' => ActionColumn::class],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
