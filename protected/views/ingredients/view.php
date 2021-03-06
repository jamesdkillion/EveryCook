<?php
/*
This is the EveryCook Recipe Database. It is a web application for creating (and storing) machine (and human) readable recipes.
These recipes are linked to foods and suppliers to allow meal planning and shopping list creation. It also guides the user step-by-step through the recipe with the CookAssistant
EveryCook is an open source platform for collecting all data about food and make it available to all kinds of cooking devices.

This program is copyright (C) by EveryCook. Written by Samuel Werder, Matthias Flierl and Alexis Wiasmitinow.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

See GPLv3.htm in the main folder for details.
*/

$this->breadcrumbs=array(
	'Ingredients'=>array('index'),
	$model->ING_ID,
);

$this->menu=array(
	array('label'=>'List Ingredients', 'url'=>array('index')),
	array('label'=>'Create Ingredients', 'url'=>array('create')),
	array('label'=>'Update Ingredients', 'url'=>array('update', 'id'=>$model->ING_ID)),
	array('label'=>'Delete Ingredients', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->ING_ID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Ingredients', 'url'=>array('admin')),
);

$this->mainButtons = array(
	array('label'=>$this->trans->GENERAL_EDIT, 'link_id'=>'middle_single', 'url'=>array('ingredients/update',$this->getActionParams())),
);
$preloadedInfoResetScript = "\r\n".'var glob = glob || {};'."\r\n".'glob.preloadedInfo = {};';
$searchType = 'ingredients/search';
if(isset($_GET['searchType']) && strlen($_GET['searchType'])>0){
	$searchType = $_GET['searchType'];
}
$urlParams = array();
if($this->isFancyAjaxRequest){
	$urlParams['fancyAjax'] = '1';
}
?>
<input type="hidden" id="getNextLink" value="<?php echo $this->createUrl('ingredients/getNext', array('ing_id'=>$model->ING_ID)); ?>"/>

<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($searchType, $urlParams),
		'id'=>'ingredients_form',
		'method'=>'post',
		'htmlOptions'=>array('class'=>($this->isFancyAjaxRequest)?'fancyForm':''),
	)); ?>
	<div class="f-right search ingSearch">
		<?php
		echo Functions::label($this->trans->INGREDIENTS_SEARCH_TITLE, Functions::getIdByName('SimpleSearchForm[query]'));
		echo Functions::specialField('SimpleSearchForm[query]', '', 'search', array('class'=>'search_query', 'autofocus'=>'autofocus'));
		echo CHtml::imageButton(Yii::app()->request->baseUrl . '/pics/search.png', array('class'=>'search_button', 'title'=>$this->trans->GENERAL_SEARCH));
		?>
	</div>
	<div class="clearfix"></div>
<?php $this->endWidget(); ?>
<div class="detailView" id="ingredients">
<?php
	if (!$this->isFancyAjaxRequest){
		if (isset(Yii::app()->session['Ingredients'])){
			if (isset(Yii::app()->session['Ingredients']['model'])){
				$back_url = array('ingredients/advanceSearch');
			} else {
				$back_url = array('ingredients/search');
			}
			echo CHtml::link(CHtml::encode($this->trans->INGREDIENTS_BACK_TO_INGREDIENTS), $back_url, array('class'=>'button f-center')); 
		}
	}
	$ingredientName = $model->__get('ING_NAME_'.Yii::app()->session['lang']);
	?>
	<div class="clearfix"></div>
	
	<?php /*<div class="f-left"> */ ?>
		<div class="options">
			<?php
				echo CHtml::link('&nbsp;', array('delicious', 'id'=>$model['ING_ID']), array('class'=>'delicious noAjax backpic f-left', 'title'=>$this->trans->GENERAL_DELICIOUS));
				//echo CHtml::link('&nbsp;', array('recipes/search', 'ing_id'=>$model['ING_ID']), array('class'=>'cookwith backpic f-right', 'title'=>$this->trans->INGREDIENTS_COOK_WITH));
				echo CHtml::link('&nbsp;', array('disgusting', 'id'=>$model['ING_ID']), array('class'=>'disgusting noAjax backpic f-center','title'=>$this->trans->GENERAL_DISGUSTING));
			?>
		</div>
		<h1><?php echo $ingredientName; ?></h1>
		<div class="otherNames">
			<?php
			echo '<span class="title">' . $this->trans->GENERAL_OTHER_NAMES . '</span>';
			foreach($this->allLanguages as $lang=>$name){
				echo '<div class="label">' . $model->getAttributeLabel('ING_NAME_'.$lang) . '</div><div class="otherName">' . $model->__get('ING_NAME_'.$lang) . '</div>';
				echo '<div class="clearfix"></div>';
			}
			foreach($this->allLanguages as $lang=>$name){
				echo '<div class="label">' . $model->getAttributeLabel('ING_SYNONYM_'.$lang) . '</div><div class="otherName">' . $model->__get('ING_SYNONYM_'.$lang) . '</div>';
				echo '<div class="clearfix"></div>';
			}
			?>
		</div>
		<div class="clearfix"></div>
		<div class="detail_img f-left">
			<?php echo CHtml::image($this->createUrl('ingredients/displaySavedImage', array('id'=>$model->ING_ID, 'ext'=>'.png')), $model->__get('ING_NAME_' . Yii::app()->session['lang']), array('class'=>'ingredient', 'title'=>$model->__get('ING_NAME_' . Yii::app()->session['lang']))); ?>
			<div class="img_auth"><?php if ($model->ING_IMG_ETAG == '') { echo '&nbsp;'; } else {echo '© by ' . $model->ING_IMG_AUTH; } ?></div>
		</div>
		
		<div class="ingInfo f-left">
			<?php
			echo '<span><span class="title">' . CHtml::encode($this->trans->INGREDIENTS_GROUP) .':</span> <span class="value">' . CHtml::encode($model->groupNames['GRP_DESC_'.Yii::app()->session['lang']]) ."</span></span><br>\n";
			if ($model->subgroupNames['SGR_DESC_'.Yii::app()->session['lang']] != ''){
				echo '<span><span class="title">' . CHtml::encode($this->trans->INGREDIENTS_SUBGROUP) .':</span> <span class="value">' . CHtml::encode($model->subgroupNames['SGR_DESC_'.Yii::app()->session['lang']]) ."</span></span><br>\n";
			}
			echo '<span><span class="title">' . CHtml::encode($this->trans->INGREDIENTS_STORABILITY) .':</span> <span class="value">' . CHtml::encode($model->storability['STB_DESC_'.Yii::app()->session['lang']]) ."</span></span><br>\n";
			if (isset($model->origins) && $model->origins->ORI_ID != IngredientsController::ORIGIN_IGNORE_ID){
				echo '<span><span class="title">' . CHtml::encode($this->trans->INGREDIENTS_ORIGINS) .':</span> <span class="value">' . CHtml::encode($model->origins['ORI_DESC_'.Yii::app()->session['lang']]) ."</span></span><br>\n";
			}
			
			echo '<span><span class="title">' . CHtml::encode($this->trans->INGREDIENTS_CONVENIENCE) .':</span> <span class="value">' . CHtml::encode($model->ingredientConveniences['ICO_DESC_'.Yii::app()->session['lang']]) ."</span></span><br>\n";
			echo '<span><span class="title">' . CHtml::encode($this->trans->INGREDIENTS_STATE) .':</span> <span class="value">' . CHtml::encode($model->ingredientStates['IST_DESC_'.Yii::app()->session['lang']]) ."</span></span><br>\n";
			if (isset($model->conditions)){
				echo '<span><span class="title">' . CHtml::encode($this->trans->INGREDIENTS_CONDITIONS) .':</span> <span class="value">' . CHtml::encode($model->conditions['CND_DESC_'.Yii::app()->session['lang']]) ."</span></span><br>\n";
			}
			echo '<span><span class="title">' . CHtml::encode($this->trans->INGREDIENTS_STORAGE_TEMP) .':</span> <span class="value">';
			if (isset($model->ING_MIN_TEMP)){
				if (isset($model->ING_MAX_TEMP)){
					echo sprintf($this->trans->INGREDIENTS_TEMP_RANGE, $model->ING_MIN_TEMP, $model->ING_MAX_TEMP);
				} else {
					echo sprintf($this->trans->INGREDIENTS_TEMP_ABOVE, $model->ING_MIN_TEMP);
				}
			} else if (isset($model->ING_MAX_TEMP)){
				echo sprintf($this->trans->INGREDIENTS_TEMP_BELOW, $model->ING_MAX_TEMP);
			} else {
				echo CHtml::encode($model->tempGroups['TGR_DESC_'.Yii::app()->session['lang']]);
			}
			echo "</span></span><br>\n";
			echo '<span><span class="title">' . CHtml::encode($this->trans->INGREDIENTS_STORAGE_IN_FREEZER) .':</span> <span class="value">' . (($model->ING_FREEZER == 'Y')? $this->trans->GENERAL_YES: $this->trans->GENERAL_NO) ."</span></span>\n";
			?>
		</div>
		<div class="clearfix"></div>
	<?php /*</div> */ ?>
	
	<?php

	if ($nutrientData != null){
		$fields = array();
		$fields[0] = array(
			'NUT_WATER',
			'NUT_ENERG',
			'NUT_PROT',
			'NUT_LIPID',
			'NUT_ASH',
			'NUT_CARB',
			'NUT_FIBER',
			'NUT_SUGAR',
		);
		$fields[1] = array(
			'NUT_FA_SAT',
			'NUT_FA_MONO',
			'NUT_FA_POLY',
			'NUT_CHOLEST',
			'NUT_REFUSE',
		);
		$fields[3] = array(
			'NUT_VIT_C',
			'NUT_THIAM',
			'NUT_RIBOF',
			'NUT_NIAC',
			'NUT_PANTO',
			'NUT_VIT_B6',
			'NUT_FOLAT_TOT',
			'NUT_FOLIC',
			'NUT_FOLATE_FD',
			'NUT_FOLATE_DFE',
			'NUT_CHOLINE',
			'NUT_VIT_B12',
			'NUT_VIT_A_IU',
			'NUT_VIT_A_RAE',
			'NUT_RETINOL',
			'NUT_ALPHA_CAROT',
			'NUT_BETA_CAROT',
			'NUT_BETA_CRYPT',
			'NUT_LYCOP',
			'NUT_LUT_ZEA',
			'NUT_VIT_E',
			'NUT_VIT_D',
			'NUT_VIT_D_IU',
			'NUT_VIT_K',
		);
		$fields[2] = array(
			'NUT_CALC',
			'NUT_IRON',
			'NUT_MAGN',
			'NUT_PHOS',
			'NUT_POTAS',
			'NUT_SODIUM',
			'NUT_ZINC',
			'NUT_COPP',
			'NUT_MANG',
			'NUT_SELEN',
		);
		
		
		$units = array();
		$units[0] = array(
			'%',
			'kcal/100 g',
			'%',
			'%',
			'%',
			'%',
			'%',
			'%',
		);
		$units[1] = array(
			'%',
			'%',
			'%',
			'mg/100 g',
			'%',
		);
		$units[3] = array(
			'mg/100 g',
			'mg/100 g',
			'mg/100 g',
			'mg/100 g',
			'mg/100 g',
			'mg/100 g',
			'μg/100 g',
			'μ/100 g',
			'μ/100 g',
			'μ dietary folate equivalents/100 g',
			'mg/100 g',
			'μ/100 g',
			'IU/100 g',
			'μ retinol activity equivalents/100g',
			'μ/100 g',
			'μ/100 g',
			'μ/100 g',
			'μ/100 g',
			'μ/100 g',
			'μ/100 g',
			'alpha-tocopherol',
			'μ/100 g',
			'IU/100 g',
			'phylloquinone',
		);
		$units[2] = array(
			'mg/100 g',
			'mg/100 g',
			'mg/100 g',
			'mg/100 g',
			'mg/100 g',
			'mg/100 g',
			'mg/100 g',
			'mg/100 g',
			'mg/100 g',
			'μg/100 g',
		);
		

		echo '<div class="nutrientTable">';
		echo '<span class="title">' . $this->trans->GENERAL_NUTRIENTS . '</span>';
		echo '<div class="f-left">';
		for($group=0; $group<count($fields); $group++){
			if ($group == 3){
				echo '</div>';
				echo '<div class="f-left">';
			}
			echo '<div class="nutrientDataGroup">';
				for($field=0; $field<count($fields[$group]); $field++){
					$nut_field = $fields[$group][$field];
					echo '<div class="nutrient_row' . (($field == count($fields[$group])-1)?' last':'') . '">';
					echo '<span class="name">' . CHtml::encode($this->trans->__get('FIELD_'.$nut_field)) . '</span>';
					echo '<span class="value">'; printf('%1.2f',$nutrientData->$nut_field); echo '</span>';
					echo '<span class="unit">' . $units[$group][$field] . '</span>';
					echo '</div>';
				}
			echo '</div>';
		}
		echo '</div>';
		echo '</div>';
	}
?>
	<div class="clearfix"></div>
	<div class="recipes otherItems">
		<?php
		echo '<div class="otherItemsTitle">'.sprintf($this->trans->INGREDIENTS_MATCHING_RECIPES, $ingredientName).'</div>';
		if ($otherItemsAmount['recipes'] == 0){
			echo '<span class="noItems">'.$this->trans->INGREDIENTS_NO_MATCHING_RECIPES .'</span>';
		} else {
			if ($otherItemsAmount['recipes'] > IngredientsController::RECIPES_AMOUNT){?>
				<input name="recipe" class="imgIndex" type="hidden" value="0" />
				<input name="amount" class="imgIndexAmount" type="hidden" value="<?php echo IngredientsController::RECIPES_AMOUNT; ?>" />
				<div class="left-arrow"><div class="left1"></div><div class="left2"></div></div>
				<?php
				$preloadedInfoResetScript .= "\r\n".'glob.preloadedInfo.recipe = {};';
			}
			$index = 0;
			foreach($recipes as $recipe){
				if ($index < IngredientsController::RECIPES_AMOUNT){
					$this->renderAjax('../recipes/_preview',array('recipe'=>$recipe, 'linkTarget'=>'_blank'), 'inline');
					if ($otherItemsAmount['recipes'] > IngredientsController::RECIPES_AMOUNT){
						$preloadedInfoResetScript .= "\r\n".'glob.preloadedInfo.recipe.idx' . $index . ' = {img:"'.$this->createUrl('recipes/displaySavedImage', array('id'=>$recipe['REC_ID'], 'ext'=>'.png')).'", url:"'.Yii::app()->createUrl('recipes/view', array('id'=>$recipe['REC_ID'])).'", auth:"'.$recipe['REC_IMG_AUTH'].'", name:"'.$recipe['REC_NAME_' . Yii::app()->session['lang']].'", index: '.$index.'};';
					}
				} else {
					$preloadedInfoResetScript .= "\r\n".'glob.preloadedInfo.recipe.idx' . $index . ' = {img:"'.$this->createUrl('recipes/displaySavedImage', array('id'=>$recipe['REC_ID'], 'ext'=>'.png')).'", url:"'.Yii::app()->createUrl('recipes/view', array('id'=>$recipe['REC_ID'])).'", auth:"'.$recipe['REC_IMG_AUTH'].'", name:"'.$recipe['REC_NAME_' . Yii::app()->session['lang']].'", index: '.$index.'};';
				}
				++$index;
			}
			if ($otherItemsAmount['recipes'] > IngredientsController::RECIPES_AMOUNT){
				$preloadedInfoResetScript .= "\r\n".'glob.preloadedInfo.recipe.nextPreloadIndex = '.$index.';';
				$preloadedInfoResetScript .= "\r\n".'glob.preloadedInfo.recipe.prevPreloadIndex = -1;';
				echo '<div class="right-arrow"><div class="right1"></div><div class="right2"></div></div>';
			}
			echo '<div class="clearfix"></div>';
		}
		echo CHtml::link(sprintf($this->trans->INGREDIENTS_MORE_MATCHING_RECIPES, $ingredientName), array('recipes/search', 'ing_id'=>$model['ING_ID']), array('class'=>'button'));
		?>
	</div>
	<?php /* ?>
	<div class="products otherItems">
		<?php
		echo '<div class="otherItemsTitle">'.sprintf($this->trans->INGREDIENTS_MATCHING_PRODUCTS, $ingredientName).'</div>';
		if ($otherItemsAmount['products'] == 0){
			echo '<a href="' . Yii::app()->createUrl('products/create',array('ing_id'=>$model['ING_ID'], 'newModel'=>time())) . '" class="shopInfo actionlink" title="' . $this->trans->INGREDIENTS_CREATE_PRODUCTS . '">';
			echo '<span class="noItems">'.$this->trans->INGREDIENTS_CREATE_PRODUCTS .'</span>';
			//echo '<span class="noItems">'.$this->trans->INGREDIENTS_NO_MATCHING_PRODUCTS .'</span>';
			echo '</a>';
		} else {
			if ($otherItemsAmount['products'] > IngredientsController::PRODUCTS_AMOUNT){ ?>
				<input name="product" class="imgIndex" type="hidden" value="0" />
				<input name="amount" class="imgIndexAmount" type="hidden" value="<?php echo IngredientsController::PRODUCTS_AMOUNT; ?>" />
				<div class="up-arrow"><div class="up1"></div><div class="up2"></div></div>
				<?php
				$preloadedInfoResetScript .= "\r\n".'glob.preloadedInfo.product = {};';
			}
			$index = 0;
			foreach($products as $product){
				if ($index < IngredientsController::PRODUCTS_AMOUNT){
					echo '<div class="item">';
						echo CHtml::link($product['PRO_NAME_' . Yii::app()->session['lang']], array('products/view', 'id'=>$product['PRO_ID']), array('class'=>'title', 'title'=>$product['PRO_NAME_' . Yii::app()->session['lang']]));
						echo '<div class="small_img">';
							echo CHtml::link(CHtml::image($this->createUrl('products/displaySavedImage', array('id'=>$product['PRO_ID'], 'ext'=>'.png')), $product['PRO_NAME_' . Yii::app()->session['lang']], array('class'=>'product', 'title'=>$product['PRO_NAME_' . Yii::app()->session['lang']])), array('products/view', 'id'=>$product['PRO_ID']));
							echo '<div class="img_auth">';
							if ($product['PRO_IMG_ETAG'] == '') { echo '&nbsp;'; } else {echo '© by ' . $product['PRO_IMG_AUTH']; }
							echo '</div>';
						echo '</div>';
					echo '</div>';
					if ($otherItemsAmount['products'] > IngredientsController::PRODUCTS_AMOUNT){
						$preloadedInfoResetScript .= "\r\n".'glob.preloadedInfo.product.idx' . $index . ' = {img:"'.$this->createUrl('products/displaySavedImage', array('id'=>$product['PRO_ID'], 'ext'=>'.png')).'", url:"'.Yii::app()->createUrl('products/view', array('id'=>$product['PRO_ID'])).'", auth:"'.$product['PRO_IMG_AUTH'].'", name:"'.$product['PRO_NAME_' . Yii::app()->session['lang']].'", index: '.$index.'};';
					}
				} else {
					$preloadedInfoResetScript .= "\r\n".'glob.preloadedInfo.product.idx' . $index . ' = {img:"'.$this->createUrl('prod ucts/displaySavedImage', array('id'=>$product['PRO_ID'], 'ext'=>'.png')).'", url:"'.Yii::app()->createUrl('products/view', array('id'=>$product['PRO_ID'])).'", auth:"'.$product['PRO_IMG_AUTH'].'", name:"'.$product['PRO_NAME_' . Yii::app()->session['lang']].'", index: '.$index.'};';
				}
				++$index;
			}
			if ($otherItemsAmount['products'] > IngredientsController::PRODUCTS_AMOUNT){
				$preloadedInfoResetScript .= "\r\n".'glob.preloadedInfo.product.nextPreloadIndex = '.$index.';';
				$preloadedInfoResetScript .= "\r\n".'glob.preloadedInfo.product.prevPreloadIndex = -1;';
				echo '<div class="down-arrow"><div class="down1"></div><div class="down2"></div></div>';
			}
			echo '<div class="clearfix"></div>';
		}
		?>
	</div>
	<?php */ ?>
	<?php if (count($model->ingToIngs)>0) { ?>
	<div class="ingredients otherItems">
		<?php
		echo '<div class="otherItemsTitle">'.sprintf($this->trans->INGREDIENTS_MAIN_INGREDIENTS, $ingredientName).'</div>';
		foreach($model->ingToIngs as $ingToIng){
			$ingredient = $ingToIng->ingredient2;
			$this->checkRenderAjax('_preview',array('ingredient'=>$ingredient, 'linkClass'=>'fancyLink'), 'inline');
		}
		echo '<div class="clearfix"></div>';
		?>
	</div>
	<?php } ?>
	<div class="clearfix"></div>
</div>
<?php echo '<script>' . $preloadedInfoResetScript . "\r\n".'</script>'; ?>