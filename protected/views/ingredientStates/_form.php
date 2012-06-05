<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ingredient-states-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'IST_DESC_EN'); ?>
		<?php echo $form->textField($model,'IST_DESC_EN',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'IST_DESC_EN'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'IST_DESC_DE'); ?>
		<?php echo $form->textField($model,'IST_DESC_DE',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'IST_DESC_DE'); ?>
	</div>

	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? $this->trans->GENERAL_CREATE : $this->trans->GENERAL_SAVE); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->