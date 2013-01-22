<?php
/* @var $this ArticleController */
/* @var $model Article */

$this->breadcrumbs=array(
	'Articles'=>array('index'),
	$model->title=>array('view','id'=>$model->aid),
	'Update',
);
?>

<h1>Update Article <?php echo $model->aid; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>