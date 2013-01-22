<?php
/* @var $user LUser */
/* @var $pieces MergeHistoryPiece[] */
/* @var $this Controller */

$this->pageTitle = Yii::t('ls', '{appName} - Merge history', array('{appName}' => Yii::app()->name));

Yii::app()->clientScript->registerCoreScript('jquery');
$appAssetsUrl = Yii::app()->assetManager->publish(Yii::app()->basePath . DIRECTORY_SEPARATOR . 'assets', false, -1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($appAssetsUrl . "/jslib/jit.js", CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile($appAssetsUrl . "/js/mh.js", CClientScript::POS_END);
$themeAssetsUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . DIRECTORY_SEPARATOR . 'assets', false, -1, YII_DEBUG);
Yii::app()->clientScript->registerCssFile($themeAssetsUrl . "/css/mh.css");

$counter = 1;
$userNodes = array();
foreach ($pieces as $piece) {
    $time = CHtml::encode(Yii::app()->locale->dateFormatter->formatDateTime($piece->time));
    $donor = Profile::model()->find('uid=:id', array(':id' => $piece->donor_id));
    $acceptor = Profile::model()->find('uid=:id', array(':id' => $piece->acceptor_id));
    /* @var $donor Profile */
    /* @var $acceptor Profile */
    if (!isset($userNodes[$donor->uid]))
        $userNodes[$donor->uid] = (object) array(
                    'id' => $counter++,
                    'name' => "(id: $donor->uid)",
                    'data' => array(
                        'uid' => $donor->uid,
                        'name' => $donor->name,
                        'username' => $donor->username,
                        'about' => str_replace("\n", "<br>", CHtml::encode($donor->about)),
                    ),
                    'children' => array()
        );
    if (!isset($userNodes[$acceptor->uid]))
        $userNodes[$acceptor->uid] = (object) array(
                    'id' => $counter++,
                    'name' => "(id: $acceptor->uid)",
                    'data' => array(
                        'uid' => $acceptor->uid,
                        'name' => $acceptor->name,
                        'username' => $acceptor->username,
                        'about' => str_replace("\n", "<br>", CHtml::encode($acceptor->about)),
                    ),
                    'children' => array()
        );
    $userNodes[$acceptor->uid] = (object) array(
                'id' => $counter++,
                'name' => "(id: $acceptor->uid)",
                'data' => array(
                    'uid' => $acceptor->uid,
                    'name' => CHtml::encode($acceptor->name),
                    'username' => CHtml::encode($acceptor->username),
                    'about' => str_replace("\n", "<br>", CHtml::encode($acceptor->about)),
                ),
                'children' => array($userNodes[$acceptor->uid], $userNodes[$donor->uid])
    );
}
if(!isset($userNodes[$user->uid])){
    $profile = $user->profile;
    $userNodes[$user->uid] = (object) array(
                'id' => $counter++,
                'name' => "(id: $profile->uid)",
                'data' => array(
                    'uid' => $profile->uid,
                    'name' => CHtml::encode($profile->name),
                    'username' => CHtml::encode($profile->username),
                    'about' => str_replace("\n", "<br>", CHtml::encode($profile->about)),
                ),
                'children' => array()
    );
}
Yii::app()->clientScript->registerScript('mhData', 'mhData = ' . json_encode($userNodes[$user->uid]), CClientScript::POS_HEAD);
?>
<h1><?php echo Yii::t('ls', 'Merge history of user {userName}', array('{userName}'=>$user->name));?></h1>
<div id="infovis"></div>
<div id="info">
    <dl>
        <dt><?php echo CHtml::encode(Yii::t('ls', 'User id')); ?></dt>
        <dd class="uid"></dd>
        <dt><?php echo CHtml::encode(Yii::t('ls', 'Name')); ?></dt>
        <dd class="name"></dd>
        <dt><?php echo CHtml::encode(Yii::t('ls', 'Username')); ?></dt>
        <dd class="username"></dd>
        <dt><?php echo CHtml::encode(Yii::t('ls', 'About')); ?></dt>
        <dd class="about"></dd>
    </dl>
</div>