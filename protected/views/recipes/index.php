<?php
$this->breadcrumbs=array(
	'Recipes',
);

$this->menu=array(
	array('label'=>'Create Recipes', 'url'=>array('create')),
	array('label'=>'Manage Recipes', 'url'=>array('admin')),
);
?>

<h1><?php echo $this->trans->TITLE_RECIPES_LIST; ?></h1>

<?php $this->widget('AjaxPagingListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
