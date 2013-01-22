<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="span-5 last">
    <div id="sidebar">

        <?php
        if (Yii::app()->user->isGuest) {
            $this->menu [] = array('label' => Yii::t('ls', 'Login'), 'url' => array('/' . LilyModule::route('user/login')));
        } else {
            $this->beginWidget('zii.widgets.CPortlet', array(
                'title' => 'User menu',
            ));
            $um_items = array();
            $uid = Yii::app()->user->id;
            if (Yii::app()->user->checkAccess('viewUser', array('uid' => $uid)))
                $um_items[] = array('label' => Yii::t('ls', 'Profile'), 'url' => array('/' . LilyModule::route('user/view')));
            if (Yii::app()->user->checkAccess('listUser'))
                $um_items[] = array('label' => Yii::t('ls', 'Users'), 'url' => array('/' . LilyModule::route('user/list')));
            $route = Yii::app()->urlManager->parseUrl(Yii::app()->request);
            if (preg_match('~^' . preg_quote(LilyModule::route('account'), '~') . '~', $route))
                $um_items [] = array('label' => Yii::t('ls', 'Bind account'), 'url' => array('/' . LilyModule::route('account/bind')));
            $um_items [] = array('label' => Yii::t('ls', 'Logout'), 'url' => array('/' . LilyModule::route('user/logout')));
            $this->widget('zii.widgets.CMenu', array(
                'items' => $um_items,
                'htmlOptions' => array('class' => 'operations'),
            ));
            $this->endWidget();
        }
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => 'Operations',
        ));
        $this->widget('zii.widgets.CMenu', array(
            'items' => $this->menu,
            'htmlOptions' => array('class' => 'operations'),
        ));
        $this->endWidget();
        ?>
    </div><!-- sidebar -->
</div>
<div class="span-19">
    <div id="content">
        <?php echo $content; ?>
    </div><!-- content -->
</div>
<?php $this->endContent(); ?>