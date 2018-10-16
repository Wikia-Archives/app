<div class="category-gallery-form">
	<?= wfMessage( 'category-exhibition-sorttype' )->escaped(); ?>
	<?php
	$dropdown = array();
	foreach ( $sortTypes as $sortType ) {
		$el = array();
		if ( $current == $sortType ) {
			$el["class"] = "selected";
		}
		$el["href"] = "$path?sort=$sortType";
		$el["id"] = Sanitizer::escapeId( "category-exhibition-form-$sortType" );
		$el["text"] = wfMessage( "category-exhibition-$sortType" )->escaped();
		$dropdown[] = $el;
	}
	?>
	<?= F::app()->renderView( 'MenuButton',
		'Index',
		array(
			'action' => array( "text" => wfMessage( 'category-exhibition-' . $current )->escaped(), "id" => "category-exhibition-form-current" ),
			'class' => 'secondary',
			'dropdown' => $dropdown,
			'name' => 'sortType'
		)
	); ?>
</div>
