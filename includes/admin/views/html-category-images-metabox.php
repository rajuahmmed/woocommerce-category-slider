<div class="ever-row">
	<div class="ever-col-12">
		<div class="ever-tabs">
			<a href="#" class="tab-item active">
				<span class="fa fa-align-justify"></span>
				Categories
			</a>
			<a href="#" class="tab-item">
				<span class="fa fa-wrench"></span>
				Category Settings
			</a>
			<a href="#" class="tab-item">
				<span class="fa fa-tv"></span>
				Display Settings
			</a>
			<a href="#" class="tab-item">
				<span class="fa fa-sliders"></span>
				Slider Settings
			</a>
			<a href="#" class="tab-item">
				<span class="fa fa-font"></span>
				Font Settings
			</a>
		</div>

		<div class="tab-content">

			<div class="ever-row wc-category-slides-wrapper">
				<div class="wccs-spinner"></div>
				<h2 class="wccs-loading-text">
					<?php _e( 'Categories are loading....', 'woo-category-slider-by-pluginever' ); ?>
				</h2>
			</div>

		</div>
	</div>
</div>

<script>

	var $tab_item = jQuery('.tab-item');

	$tab_item.click(function(e) {

		e.preventDefault();

		$tab_item.each(function () {
			jQuery(this).removeClass('active');
		});


		jQuery(this).addClass('active');
	});

</script>

