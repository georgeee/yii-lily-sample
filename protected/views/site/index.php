<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<p>This is a sample application for <?php echo CHtml::link('Lily module', 'https://github.com/georgeee/yii-lily'); ?> </p>

<ul>
<li><?php echo CHtml::link('Lily module\'s github page', 'https://github.com/georgeee/yii-lily'); ?></li>
<li><?php echo CHtml::link('Sample\'s github page', 'https://github.com/georgeee/yii-lily-sample'); ?></li>
<li><?php echo CHtml::link('Creator\'s website', 'http://georgeee.ru'); ?></li>
</ul>