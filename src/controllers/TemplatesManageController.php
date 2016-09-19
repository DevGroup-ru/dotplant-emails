<?php

namespace DotPlant\Emails\controllers;

use DotPlant\Emails\models\Template;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * TemplatesManageController implements the CRUD actions for Template model.
 */
class TemplatesManageController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return []; // @todo: add permissions
    }

    /**
     * Lists all Template models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider(
            [
                'query' => Template::find(),
            ]
        );
        return $this->render(
            'index',
            [
                'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * Updates an existing Template model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id = null)
    {
        if ($id === null) {
            $model = new Template;
            $model->loadDefaultValues();
        } else {
            $model = $this->findModel($id);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['edit', 'id' => $model->id]);
        } else {
            return $this->render(
                'edit',
                [
                    'model' => $model,
                ]
            );
        }
    }

    /**
     * Deletes an existing Template model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Template model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Template the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Template::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
