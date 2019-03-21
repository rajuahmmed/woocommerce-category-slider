<?php

echo wc_category_slider()->elements->switcher( array(
	'name'           => 'autoplay',
	'label'          => __( 'Slider Autoplay', 'woo-category-slider-by-pluginever' ),
	'double_columns' => false,
	'value'          => get_post_meta( $post->ID, 'autoplay', true ),
	'desc'           => __( 'Slider will automatically start playing is set Yes.', 'woo-category-slider-by-pluginever' ),
) );


