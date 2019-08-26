<?php

namespace frontend\controllers;

use Yii;
use common\models\Message;
use frontend\models\MessageSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Message models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $recipient_id
     * @return mixed
     */
    public function actionCreate($recipient_id)
    {
        $model = new Message();
        $model->recipient_id = $recipient_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['/message/index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Message model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $message = $this->findModel($id);

        if ($message->recipient_id == Yii::$app->user->id) {
            $message->status = Message::STATUS_READ;
            $message->save();
        }

        return $this->render('view', [
            'model' => $message,
        ]);
    }

    /**
     * Finds the Message model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Message the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Message::find()
            ->where(['id' => $id])
            ->andWhere([
                'OR',
                'sender_id' => Yii::$app->user->id,
                'recipient_id' => Yii::$app->user->id,
            ])
            ->one();

        if ($model !== null) {

            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
