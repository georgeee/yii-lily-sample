<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AuthInitializer
 *
 * @author georgeee
 */
class AuthInstaller extends CConsoleCommand {

    public function actionIndex() {
        $auth = Yii::app()->authManager;
        /* @var $auth CAuthManager */
        $auth->createOperation('listArticles', 'list articles');
        $auth->createOperation('adminArticles', 'admin articles');
        $auth->createOperation('deleteArticle', 'delete article');
        $auth->createOperation('createArticle', 'create article');
        $auth->createOperation('updateArticle', 'update article');
        $auth->createOperation('viewArticle', 'view article');

        $viewer = $auth->createRole('articleViewer', 'article viewer');
        $viewer->addChild('listArticles');
        $viewer->addChild('viewArticle');
        
        $ownRule = 'if(!isset($params["uid"]) && !isset($params["aid"]) && !isset($params["article"])) return false;
                if(!isset($params["uid"])) 
                    $params["uid"] = isset($params["article"])?$params["article"]->uid:Article::model()->findByPk($params["aid"])->uid;
                return $params["uid"]==$params["userId"];';
        $auth->createTask('updateOwnArticle', 'update own article', $ownRule)->addChild('updateArticle');
        $auth->createTask('deleteOwnArticle', 'delete own article', $ownRule)->addChild('deleteArticle');

        $creator = $auth->createRole('articleCreator', 'article creator');
        $creator->addChild('createArticle');
        $creator->addChild('updateOwnArticle');
        $creator->addChild('deleteOwnArticle');
        $creator->addChild('articleViewer');

        $admin = $auth->createRole('articleAdmin', 'article administrator');
        $admin->addChild('adminArticles');
        $admin->addChild('deleteArticle');
        $admin->addChild('updateArticle');
        $admin->addChild('articleCreator');
        
        $auth->getAuthItem('userAuthenticated')->addChild('articleCreator');
        $auth->getAuthItem('userAuthenticated')->addChild('viewUser');
        $auth->getAuthItem('userAuthenticated')->addChild('listUser');
        $auth->getAuthItem('userGuest')->addChild('articleViewer');
        
        
        $auth->save();
    }

    public function actionAssign($user, $role = 'articleAdmin') {
        $auth = Yii::app()->authManager;
        $auth->assign($role, $user);
        $auth->save();
    }
    
    public function actionFlush(){
        $auth = Yii::app()->authManager;
        $auth->clearAll();
        $auth->save();
    }
    
}

