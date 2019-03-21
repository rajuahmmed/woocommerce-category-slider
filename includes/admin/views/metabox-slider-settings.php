<?php

echo wc_category_slider()->elements->switcher( array(
	'name'           => 'autoplay',
	'label'          => __( 'Slider Autoplay', 'woo-category-slider-by-pluginever' ),
	'double_columns' => false,
	'value'          => wc_slider_get_slider_settings( $post->ID, 'autoplay', true ),
	'desc'           => __( 'Slider will automatically start playing is set Yes.', 'woo-category-slider-by-pluginever' ),
) );

echo sprintf('<h2 class="pro-feat-title">%s</h2>', 'Pro Features', 'woo-category-slider-by-pluginever');

echo wc_category_slider()->elements->switcher( array(
	'name'           => 'lazy_load',
	'label'          => __( 'Lazy Load', 'woo-category-slider-by-pluginever' ),
	'value'          => wc_slider_get_slider_settings( $post->ID, 'lazy_load', 'off' ),
) );

echo wc_category_slider()->elements->switcher( array(
	'name'           => 'cols',
	'label'          => __( 'Number of Column (Desktop)', 'woo-category-slider-by-pluginever' ),
	'value'          => wc_slider_get_slider_settings( $post->ID, 'cols', '4' ),
) );

echo wc_category_slider()->elements->switcher( array(
	'name'           => 'tab_cols',
	'label'          => __( 'Number of Column (Tablet)', 'woo-category-slider-by-pluginever' ),
	'value'          => wc_slider_get_slider_settings( $post->ID, 'tab_cols', '2' ),
) );

echo wc_category_slider()->elements->switcher( array(
	'name'           => 'phone_cols',
	'label'          => __( 'Number of Column (Phone)', 'woo-category-slider-by-pluginever' ),
	'value'          => wc_slider_get_slider_settings( $post->ID, 'phone_cols', '1' ),
) );

echo wc_category_slider()->elements->input( array(
	'name'  => 'slider_speed',
	'label' => __( 'Slider Speed', 'woo-category-slider-by-pluginever' ),
	'type'  => 'number',
	'value' => wc_slider_get_slider_settings( $post->ID, 'slider_speed', '2000' ),
) );

echo wc_category_slider()->elements->switcher( array(
	'name'           => 'loop',
	'label'          => __( 'Loop', 'woo-category-slider-by-pluginever' ),
	'value'          => wc_slider_get_slider_settings( $post->ID, 'loop', 'on' ),
) );

echo wc_category_slider()->elements->input( array(
	'name'           => 'column_gap',
	'label'          => __( 'Column Gap', 'woo-category-slider-by-pluginever' ),
	'type'  => 'number',
	'value'          => wc_slider_get_slider_settings( $post->ID, 'column_gap', '10' ),
) );




