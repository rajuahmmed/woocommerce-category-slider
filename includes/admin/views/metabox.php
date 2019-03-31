<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
			$active  = 'active';

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

				$label = sprintf( __( '%s', 'woo-category-slider-by-pluginever' ), $nav ); //tab nav label

				$template = sanitize_title( $nav );

				ob_start();

				echo "<div class='tab-content-item {$active}' id='{$template}'>";
				include WC_SLIDER_INCLUDES . "/admin/views/metabox-{$template}.php"; //include metabox template file
				echo '</div>';

				$content .= ob_get_clean();

				echo sprintf( '<a href="#" class="tab-item %s" data-target="%s"><span class="fa fa-%s"></span> %s</a>', $active, $template, $icon, $label );

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
	jQuery(document).ready(function () {
		var $pro_title = jQuery('.pro-feat-title').nextAll('.ever-form-group');
		<?php if(! wc_category_slider()->is_pro_installed()){ ?>
		$pro_title.find('input, select, button').prop('disabled', 'disabled');
		$pro_title.find('.ever-label').css('color', '#aaa');
		<?php } ?>

		function CategorySliderSetActiveTab($target) {
			jQuery('.tab-item, .tab-content-item').removeClass('active');
			jQuery('.tab-item[data-target="' + $target + '"]').addClass('active');
			jQuery('.tab-content-item[id="' + $target + '"]').addClass('active');
			if (typeof(localStorage) !== 'undefined') {
				localStorage.setItem("wc_category_slider_active_tab", $target);
			}
		}

		var activeTab = 'categories';
		if (typeof(localStorage) !== 'undefined') {
			activeTab = localStorage.getItem('wc_category_slider_active_tab') || 'categories';
		}
		CategorySliderSetActiveTab(activeTab);

		jQuery('.tab-item').on('click', function (e) {
			e.preventDefault();
			var $target = jQuery(this).data('target');
			CategorySliderSetActiveTab($target);
		})
	});


</script>

