<div class="resultArea">
	<?php echo CHtml::link(CHtml::image($this->createUrl('products/displaySavedImage', array('id'=>$data['PRO_ID'], 'ext'=>'png')), '', array('class'=>'product', 'alt'=>$data['PRO_IMG_CR'], 'title'=>$data['PRO_IMG_CR'])), array('view', 'id'=>$data['PRO_ID'])); ?>
	
	
	<div class="options">
		<?php echo CHtml::link('&nbsp;', array('delicious', 'id'=>$data['PRO_ID']), array('class'=>'delicious backpic', 'title'=>$this->trans->GENERAL_DELICIOUS)); ?>
		<?php echo CHtml::link('&nbsp;', array('disgusting', 'id'=>$data['PRO_ID']), array('class'=>'disgusting backpic','title'=>$this->trans->GENERAL_DISGUSTING)); ?><br>
	</div>
	
	<div class="data">
		<div class="name">
			<?php echo CHtml::link(CHtml::encode($data['PRO_NAME_' . Yii::app()->session['lang']]), array('view', 'id'=>$data['PRO_ID'])); ?>
		</div>
		
		<?php
		/*
		echo '<span><strong>' . CHtml::encode($this->trans->PRODUCTS_AVAILABLE_AT) .':</strong> ' . CHtml::encode($data['avail_store']) ."</span><br/>\n";
		echo '<span>'; printf($this->trans->PRODUCTS_DISTANCE_TO_YOU, $data['dist_you']); echo '</span><br/>'."\n";
		echo '<span>'; printf($this->trans->PRODUCTS_DISTANCE_TO_HOME, $data['dist_home']); echo '</span><br/>'."\n";
		*/
		
		echo '<span><strong>' . CHtml::encode($this->trans->PRODUCTS_SUSTAINABILITY) .':</strong> ' . CHtml::encode($data['ECO_DESC_'.Yii::app()->session['lang']]) ."</span><br/>\n";
		echo CHtml::link(CHtml::encode($this->trans->PRODUCTS_ASSIGN_SHOP), array('stores/assign', 'pro_id'=>$data['PRO_ID']), array('class'=>'button f-right'));
		echo '<span><strong>' . CHtml::encode($this->trans->PRODUCTS_ETHICAL) .':</strong> ' . CHtml::encode($data['ETH_DESC_'.Yii::app()->session['lang']]) ."</span><br/>\n";
		echo '<span>'; printf($this->trans->PRODUCTS_PACKAGE_SIZE, $data['PRO_PACKAGE_GRAMMS']); echo '</span><br/>'."\n";
		
/*
	<b><?php echo CHtml::encode($data->getAttributeLabel('PRO_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data['PRO_ID']), array('view', 'id'=>$data['PRO_ID'])); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PRO_BARCODE')); ?>:</b>
	<?php echo CHtml::encode($data['PRO_BARCODE']); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PRO_PACKAGE_GRAMMS')); ?>:</b>
	<?php echo CHtml::encode($data['PRO_PACKAGE_GRAMMS']); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ING_ID')); ?>:</b>
	<?php echo CHtml::encode($data['ING_ID']); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ECO_ID')); ?>:</b>
	<?php echo CHtml::encode($data['ECO_ID']); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ETH_ID')); ?>:</b>
	<?php echo CHtml::encode($data['ETH_ID']); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PRO_IMG')); ?>:</b>
	<?php echo CHtml::encode($data['PRO_IMG']); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PRO_IMG_CR')); ?>:</b>
	<?php echo CHtml::encode($data['PRO_IMG_CR']); ?>
	<br />

	*/ ?>
	</div>
</div>