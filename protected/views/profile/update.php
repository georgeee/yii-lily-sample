<?php
/* @var $this ProfileController */
/* @var $model Profile */

$this->breadcrumbs = array(
    'User '. $model->name => array(''.LilyModule::route('user/view'), 'uid' => $model->uid),
    'Update profile',
);

$this->menu = array(
    array('label' => 'Create Profile', 'url' => array('create')),
);
?>

<h1>Update Profile <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>