<?php

use common\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'avatar',
                'format' => 'html',
                'label' => 'Avatar',
                'value' => function ($data) {
                    /** @var $data User */

                    return Html::img(User::getFrontImageUrl() . $data->avatar,
                        ['width' => '80px', 'height' => '80px']);
                },
            ],
            'username',
            'email:email',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'message'=>function ($url, $model) {
                        /** @var $model User */
                        $customurl = Yii::$app->getUrlManager()->createUrl([
                            'message/create',
                            'recipient_id' => $model->id,
                        ]);

                        return Html::a('<span class="glyphicon glyphicon-envelope"></span>', $customurl,
                            ['title' => Yii::t('yii', 'send message'), 'data-pjax' => '0']);
                    }
                ],
                'template' => '{message}',
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
