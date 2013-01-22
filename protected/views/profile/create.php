<?php
/* @var $this ProfileController */
/* @var $model Profile */

$this->breadcrumbs = array(
    'Profiles' => array('index'),
    'Create',
);
?>

<h1>Create Profile</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>