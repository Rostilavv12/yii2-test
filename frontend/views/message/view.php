<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Message */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="message-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'sender.email',
            'recipient.email',
            'subject',
            'body:ntext',
            'nameStatus',
        ],
    ]) ?>

    <?php if ($model->sender_id != Yii::$app->user->id) : ?>
        <?= Html::a('Ответить', ['message/create', 'recipient_id' => $model->sender_id], ['class' => 'btn btn-primary']) ?>
    <?php endif; ?>
</div>
