<?php
/* @var $this ArticleController */
/* @var $model Article */

$this->breadcrumbs=array(
	'Articles'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Article', 'url'=>array('index'), 'visible' => Yii::app()->user->checkAccess('listArticles')),
	array('label'=>'Create Article', 'url'=>array('create'), 'visible' => Yii::app()->user->checkAccess('createArticle')),
	array('label'=>'Update Article', 'url'=>array('update', 'id'=>$model->aid), 'visible' => Yii::app()->user->checkAccess('updateArticle', array('uid'=>$model->uid))),
	array('label'=>'Delete Article', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->aid),'confirm'=>'Are you sure you want to delete this item?'), 
            'visible' => Yii::app()->user->checkAccess('deleteArticle', array('uid'=>$model->uid))),
	array('label'=>'Manage Article', 'url'=>array('admin'), 'visible' => Yii::app()->user->checkAccess('adminArticles')),
);
$appAssetsUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . DIRECTORY_SEPARATOR . 'assets', false, -1, YII_DEBUG);
Yii::app()->clientScript->registerCssFile($appAssetsUrl . "/css/article.css");
?>

<h1>View Article #<?php echo $model->aid; ?></h1>

<?php echo $this->renderPartial('_view', array('data'=>$model)); ?>
