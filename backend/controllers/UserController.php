<?php

namespace app\backend\controllers;

use app\models\LoginForm;
use Yii;
use app\models\User;
//use app\models\search\UserSearch;
use app\backend\components\AdminController as BaseController;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseController
{

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        var_dump(Yii::$app->request->queryParams);die;
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (isset($_POST['apply']))
                return $this->redirect(['update', 'id' => $model->id]);
            elseif(isset($_POST['new']))
                return $this->redirect(['create']);
            else
                return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (isset($_POST['apply']))
                return $this->redirect(['update', 'id' => $model->id]);
            elseif(isset($_POST['new']))
                return $this->redirect(['create']);
            else
                return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Updates identity
     */
    public function actionUpdateProfile()
    {
        $model = Yii::$app->user->identity;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Информация успешно обновлена');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Updates password
     */
//    public function actionUpdatePassword()
//    {
//        $user = Yii::$app->user->identity;
//        $user->setScenario(User::SCENARIO_PASSWORD);
//        $model = new User();
//        $model->setScenario(User::SCENARIO_PASSWORD);
//        if ($model->load(Yii::$app->request->post())) {
//            if ($user->validatePassword($model->password_old)) {
//                if ($user->load(Yii::$app->request->post()) && $user->save()) {
//                    Yii::$app->session->setFlash('success', 'Пароль изменен успешно');
//                    return $this->refresh();
//                }
//            } else {
//                Yii::$app->session->setFlash('warning' , 'Старый пароль неверный');
//            }
//        }
//
//        return $this->render('updatePassword', [
//            'model' => $user,
//        ]);
//    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(Yii::$app->request->referrer ? : '/admin');
    }

    public function actionAdminLogin()
    {
        $this->layout = 'login';
        if (Yii::$app->user->isGuest) {
            return $this->redirect('login');
        }else{
            $user = User::findOne(['id' => Yii::$app->user->id]);
            if($user->status == 30){
                return $this->redirect('admin/settings');
            }else{
                var_dump('Войдите как администратор'); die;
            }
        }


    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['admin/login']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
