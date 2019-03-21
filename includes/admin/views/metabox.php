<?php

$navs = array(
	'Categories',
	'Display Settings',
	'Slider Settings',
	'Font Settings'
);

?>

<div class="ever-row">
	<div class="ever-col-12">
		<div class="ever-tabs">

			<?php

			$content = '';
			$active = 'active';

			foreach ( $navs as $nav ) {

				$icon = ''; //Tab menu icons

				switch ( $nav ) {
					case 'Categories':
						$icon = 'align-justify';
						break;
					case 'Display Settings':
						$icon = 'tv';
						break;
					case 'Slider Settings':
						$icon = 'sliders';
						break;
					case 'Font Settings':
						$icon = 'font';
						break;
				}

				$label = sprintf(__('%s', 'woo-category-slider-by-pluginever'), $nav); //tab nav label

				$template = sanitize_title($nav);

				ob_start();

				echo "<div class='tab-content-item {$active}' id='{$template}'>";
				include WC_SLIDER_INCLUDES . "/admin/views/metabox-{$template}.php"; //include metabox template file
				echo '</div>';

				$content .= ob_get_clean();

				echo sprintf( '<a href="#" class="tab-item %s" data-target="%s"><span class="fa fa-%s"></span> %s</a>', $active, $template , $icon, $label );

				$active = '';

			}

			?>

		</div>

		<div class="tab-content">

			<?php echo $content ?>

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

		$tab_item.each(function () {
			jQuery('.tab-content-item').removeClass('active');
		});

		var $target = jQuery(this).data('target');
		jQuery('#'+$target).addClass('active');

		jQuery(this).addClass('active');
	});

</script>

