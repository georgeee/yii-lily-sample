<?php

class ProfileController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Profile;

        $this->performAjaxValidation($model);
        if (!isset($model->name) && isset(LilyModule::instance()->session->data->name))
            $model->name = LilyModule::instance()->session->data->name;
        if (!isset($model->username) && isset(LilyModule::instance()->session->data->username) && preg_match(Profile::USERNAME_PATTERN, LilyModule::instance()->session->data->username))
            $model->username = LilyModule::instance()->session->data->username;
        if (isset($_POST['Profile'])) {
            $model->attributes = $_POST['Profile'];
            $model->uid = Yii::app()->user->id;
            $model->merged = 0;
            if ($model->save()) {
                //If this page was shown because of initialization process, we should take user to the next step after model saving
                if (LilyModule::instance()->userIniter->isStarted) {
                    LilyModule::instance()->userIniter->nextStep();
                }
                $this->redirect(array('/'.LilyModule::route('user/view'), 'uid' => $model->uid));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model);

        if (isset($_POST['Profile'])) {
            $model->attributes = $_POST['Profile'];
            if ($model->save())
                $this->redirect(array('/'.LilyModule::route('user/view'), 'uid' => $model->uid));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Profile the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Profile::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Profile $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'profile-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
