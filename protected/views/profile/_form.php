<?php
/* @var $this ProfileController */
/* @var $model Profile */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'profile-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
            ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>


    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
<?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 255)); ?>
<?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'username'); ?>
<?php echo $form->textField($model, 'username', array('size' => 60, 'maxlength' => 255)); ?>
<?php echo $form->error($model, 'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'about'); ?>
<?php echo $form->textArea($model, 'about', array('rows' => 6, 'cols' => 50)); ?>
<?php echo $form->error($model, 'about'); ?>
    </div>

    <div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->