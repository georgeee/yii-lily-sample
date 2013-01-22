<?php
/* @var $this ArticleController */
/* @var $data Article */
?>

<div class="view">

    <b><?php echo CHtml::link(CHtml::encode($data->title), array('view', 'id' => $data->aid)); ?></b>
    <br />

    <?php echo str_replace("\n", "<br />", CHtml::encode($data->body)); ?>
    <br />

    <ul class="artileProps">
        <li>
            <b><?php echo CHtml::encode(Yii::t('ls', 'User')); ?>:</b>
            <?php echo CHtml::encode(LUser::model()->findByPk($data->uid)->nameId); ?>
        </li>
        <li>
            <b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
            <?php echo CHtml::encode(Yii::app()->locale->dateFormatter->formatDateTime($data->created)); ?>
        </li>
        <li>
            <b><?php echo CHtml::encode($data->getAttributeLabel('updated')); ?>:</b>
            <?php echo CHtml::encode(Yii::app()->locale->dateFormatter->formatDateTime($data->updated)); ?>
        </li>
    </ul>

</div>