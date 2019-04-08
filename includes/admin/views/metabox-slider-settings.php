<?php

echo wc_category_slider()->elements->switcher( array(
	'name'           => 'autoplay',
	'label'          => __( 'Slider Autoplay', 'woo-category-slider-by-pluginever' ),
	'double_columns' => false,
	'value'          => wc_category_slider_get_meta( $post->ID, 'autoplay', true ),
	'desc'           => __( 'Slider will automatically start playing is set Yes.', 'woo-category-slider-by-pluginever' ),
) );

echo wc_get_metabox_promo_text();

echo wc_category_slider()->elements->switcher( apply_filters( 'wc_category_slider_lazy_load_args', array(
	'name'     => 'lazy_load',
	'label'    => __( 'Lazy Load', 'woo-category-slider-by-pluginever' ),
	'value'    => wc_category_slider_get_meta( $post->ID, 'lazy_load', 'off' ),
	'disabled' => 'disabled',
), $post->ID ) );

echo wc_category_slider()->elements->input( apply_filters( 'wc_category_slider_cols_args', array(
	'name'        => 'cols',
	'type'        => 'number',
	'label'       => __( 'Number of Column (Desktop)', 'woo-category-slider-by-pluginever' ),
	'disabled'    => 'disabled',
	'placeholder' => '4',
), $post->ID ) );

echo wc_category_slider()->elements->input( apply_filters( 'wc_category_slider_tab_cols_args', array(
	'name'        => 'tab_cols',
	'type'        => 'number',
	'label'       => __( 'Number of Column (Tablet)', 'woo-category-slider-by-pluginever' ),
	'disabled'    => 'disabled',
	'placeholder' => '2',
), $post->ID ) );

echo wc_category_slider()->elements->input( apply_filters( 'wc_category_slider_phone_cols_args', array(
	'name'        => 'phone_cols',
	'type'        => 'number',
	'label'       => __( 'Number of Column (Phone)', 'woo-category-slider-by-pluginever' ),
	'disabled'    => 'disabled',
	'placeholder' => '1',
), $post->ID ) );

echo wc_category_slider()->elements->input( apply_filters( 'wc_category_slider_autoplay_speed_args', array(
	'name'     => 'autoplay_speed',
	'label'    => __( 'AutoPlay Speed', 'woo-category-slider-by-pluginever' ),
	'type'     => 'number',
	'disabled' => 'disabled',
	'placeholder' => '600',
), $post->ID ) );

echo wc_category_slider()->elements->input( apply_filters( 'wc_category_slider_slider_speed_args', array(
	'name'     => 'slider_speed',
	'label'    => __( 'Slider Speed', 'woo-category-slider-by-pluginever' ),
	'type'     => 'number',
	'disabled' => 'disabled',
	'placeholder' => '3000',
), $post->ID ) );

echo wc_category_slider()->elements->switcher( apply_filters( 'wc_category_slider_loop_args', array(
	'name'     => 'loop',
	'label'    => __( 'Loop', 'woo-category-slider-by-pluginever' ),
	'disabled' => 'disabled',
), $post->ID ) );

echo wc_category_slider()->elements->input( apply_filters( 'wc_category_slider_column_gap_args', array(
	'name'     => 'column_gap',
	'type'     => 'number',
	'label'    => __( 'Column Gap', 'woo-category-slider-by-pluginever' ),
	'disabled' => 'disabled',
	'placeholder' => '10',
), $post->ID ) );




