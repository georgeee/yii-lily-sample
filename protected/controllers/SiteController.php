<?php

class SiteController extends Controller {
/**
     * Declares filters for the controller
     * @return array filters
     */
    public function filters() {
        return array(
            'accessControl'
        );
    }

    /**
     * Declares access rules for the controller
     * @return array access rules
     */
    public function accessRules() {
        return array(
            array('deny',
                'actions' => array('mergeHistory'),
                'users' => array('?'),
            ),
        );
    }
    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actionMergeHistory($uid = null) {
        if(!isset($uid)) $uid = Yii::app()->user->id;
        $user = LUser::model()->findByPk($uid);
        if (!isset($user))
            throw new CHttpException(404);
        if (!Yii::app()->user->checkAccess('viewUser', array('uid' => $uid)))
            throw new CHttpException(403);
        if ($user->state > LUser::ACTIVE_STATE) //User is appended to some other user
            $this->redirect(array('/site/mergeHistory', 'uid' => $user->state));
        else {
            $criteria = new CDbCriteria();
            $criteria->condition = 'owner_id=:id';
            $criteria->params = array(':id' => $uid);
            $criteria->order = 'time ASC';
            $pieces = MergeHistoryPiece::model()->findAll($criteria);
            $this->render('mh', array('user' => $user, 'pieces' => $pieces));
        }
    }

}