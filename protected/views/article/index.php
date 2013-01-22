<?php
/* @var $this ArticleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Articles',
);

$this->menu=array(
	array('label'=>'Create Article', 'url'=>array('create'), 'visible' => Yii::app()->user->checkAccess('createArticle')),
	array('label'=>'Manage Article', 'url'=>array('admin'), 'visible' => Yii::app()->user->checkAccess('adminArticles')),
);

$appAssetsUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . DIRECTORY_SEPARATOR . 'assets', false, -1, YII_DEBUG);
Yii::app()->clientScript->registerCssFile($appAssetsUrl . "/css/article.css");
?>

<h1>Articles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
