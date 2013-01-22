<?php
/* @var $this ArticleController */
/* @var $model Article */

$this->breadcrumbs=array(
	'Articles'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Article', 'url'=>array('index'), 'visible' => Yii::app()->user->checkAccess('listArticles')),
	array('label'=>'Create Article', 'url'=>array('create'), 'visible' => Yii::app()->user->checkAccess('createArticle')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#article-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Articles</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'article-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'aid' => array(
                    'name' => 'aid',
                    'htmlOptions'=>array('style'=>'width:50px;'),
                    'headerHtmlOptions'=>array('style'=>'width:50px;'),
                ),
		'uid' => array(
                    'name' => 'uid',
                    'htmlOptions'=>array('style'=>'width:50px;'),
                    'headerHtmlOptions'=>array('style'=>'width:50px;'),
                ),
                'user' => array(
                    'header' => Yii::t('ls', 'User'),
                    'value'=>'CHtml::link(CHtml::encode($data->user->name), array("/".LilyModule::route("user/view"), array("uid"=>$data->uid)))',
                    'type' => 'raw',
                ),
		'title',
		'updated' => array(
                    'name' => 'updated',
                    'value' => 'Yii::app()->locale->dateFormatter->formatDateTime($data->updated)'
                ),
		'created' => array(
                    'name' => 'created',
                    'value' => 'CHtml::encode(Yii::app()->locale->dateFormatter->formatDateTime($data->created))'
                ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
