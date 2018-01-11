<?php

namespace Pluginever\WCS;
class Metabox {
    /**
     * Metabox constructor.
     */
    public function __construct() {
        add_action( 'admin_init', [ $this, 'init_category_settings_metabox' ] );
        add_action( 'admin_init', [ $this, 'init_display_settings_metabox' ] );
        add_action( 'admin_init', [ $this, 'init_slider_settings_metabox' ] );
        add_action( 'add_meta_boxes', [ $this, 'init_shortcode_metabox' ] );
        if( ! woocatslider_is_pro_active() ){
            add_action( 'add_meta_boxes', [ $this, 'init_promotion_metabox' ] );
        }
    }

    public function init_category_settings_metabox() {
        $metabox = new \Pluginever\Framework\Metabox( 'woo_cat_slider_category_metabox' );
        $config  = array(
            'title'        => __( 'Category Settings', 'woocatslider' ),
            'screen'       => 'woocatslider',
            'context'      => 'normal',
            'priority'     => 'high',
            'lazy_loading' => 'true',
            'fields'       => array(
                array(
                    'type'     => 'select',
                    'name'     => 'selection_type',
                    'label'    => 'Selection Type',
                    'value'    => 'all',
                    'tooltip'    => __('Select all categories or any custom categories','woocatslider'),
                    'sanitize' => 'sanitize_key',
                    'required' => 'true',
                    'options'  => array(
                        'all'    => 'All',
                        'custom' => 'Custom'
                    ),
                ),
                array(
                    'type'      => 'select',
                    'name'      => 'include',
                    'label'     => 'Select Categories',
                    'value'     => 'all',
                    'multiple'  => true,
                    'class'     => 'select2',
                    'sanitize'  => 'intval',
                    'condition' => array(
                        'depend_on'    => 'selection_type',
                        'depend_value' => 'custom',
                        'depend_cond'  => '==',
                    ),
                    'options'   => $this->get_wc_category_list(),
                ),
                array(
                    'type'     => 'select',
                    'name'     => 'hide_empty',
                    'label'    => __( 'Hide Empty Categories', 'woocatslider' ),
                    'tooltip'    => __('Automatically hides Category without products','woocatslider'),
                    'value'    => '1',
                    'sanitize' => 'intval',
                    'options'  => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                ),
                array(
                    'type'     => 'select',
                    'name'     => 'hide_no_image',
                    'label'    => __( 'Hide Categories Without Image', 'woocatslider' ),
                    'tooltip'    => __('Automatically hides Category without category image','woocatslider'),
                    'value'    => '1',
                    'sanitize' => 'intval',
                    'options'  => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                ),
                array(
                    'type'     => 'number',
                    'name'     => 'limit',
                    'tooltip'    => __('Limit the number of category appear on the slider','woocatslider'),
                    'label'    => __( 'Limit Items', 'woocatslider' ),
                    'value'    => '20',
                    'sanitize' => 'intval',
                ),
            ),
        );
        $metabox->init( apply_filters( 'woo_category_slider_settings_config', $config ) );
    }

    public function init_display_settings_metabox() {
        $metabox = new \Pluginever\Framework\Metabox( 'woo_cat_slider_display_metabox' );
        $config  = array(
            'title'        => __( 'Display Settings', 'woocatslider' ),
            'screen'       => 'woocatslider',
            'context'      => 'normal',
            'priority'     => 'high',
            'lazy_loading' => 'true',
            'fields'       => array(
                array(
                    'type'     => 'select',
                    'name'     => 'show_content',
                    'label'    => __( 'Show Content', 'woocatslider' ),
                    'value'    => '1',
                    'sanitize' => 'intval',
                    'options'  => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                ),
                array(
                    'type'      => 'select',
                    'name'      => 'show_button',
                    'label'     => __( 'Show Button', 'woocatslider' ),
                    'value'     => '1',
                    'sanitize'  => 'intval',
                    'options'   => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                    'condition' => array(
                        'depend_on'    => 'show_content',
                        'depend_value' => '1',
                        'depend_cond'  => '==',
                    ),
                ),
                array(
                    'type'      => 'select',
                    'name'      => 'show_name',
                    'label'     => __( 'Show Name', 'woocatslider' ),
                    'value'     => '0',
                    'sanitize'  => 'intval',
                    'options'   => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                    'condition' => array(
                        'depend_on'    => 'show_content',
                        'depend_value' => '1',
                        'depend_cond'  => '==',
                    ),
                ),

                array(
                    'type'      => 'select',
                    'name'      => 'show_count',
                    'label'     => __( 'Show Count', 'woocatslider' ),
                    'value'     => '0',
                    'sanitize'  => 'intval',
                    'options'   => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                    'condition' => array(
                        'depend_on'    => 'show_content',
                        'depend_value' => '1',
                        'depend_cond'  => '==',
                    ),
                ),
                array(
                    'type'      => 'select',
                    'name'      => 'show_nav',
                    'label'     => __( 'Show Navigation', 'woocatslider' ),
                    'value'     => '0',
                    'sanitize'  => 'intval',
                    'options'   => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                    'condition' => array(
                        'depend_on'    => 'show_content',
                        'depend_value' => '1',
                        'depend_cond'  => '==',
                    ),
                ),
                array(
                    'type'      => 'select',
                    'name'      => 'nav_position',
                    'label'     => __( 'Navigation Position', 'woocatslider' ),
                    'value'     => 'top-right',
                    'sanitize'  => 'sanitize_key',
                    'options'   => array(
                        'top-right'    => 'Top Right',
                        'top-left'     => 'Top Left',
                        'bottom-right' => 'Bottom Right',
                        'bottom-left'  => 'Bottom Left'
                    ),
                    'condition' => array(
                        'depend_on'    => 'show_nav',
                        'depend_value' => '1',
                        'depend_cond'  => '==',
                    ),
                ),
                array(
                    'type'     => 'select',
                    'name'     => 'border',
                    'label'    => __( 'Add Border', 'woocatslider' ),
                    'tooltip'    => __('Show border around slider image?','woocatslider'),
                    'value'    => '1',
                    'sanitize' => 'intval',
                    'options'  => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                ),
                array(
                    'type'     => 'select',
                    'name'     => 'hover_effect',
                    'label'    => __( 'Hover Effect', 'woocatslider' ),
                    'value'    => '1',
                    'sanitize' => 'intval',
                    'options'  => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                ),
            ),
        );
        $metabox_config = apply_filters( 'woo_category_slider_display_config', $config );
        $metabox->init( $metabox_config );
    }

    public function init_slider_settings_metabox() {
        $metabox = new \Pluginever\Framework\Metabox( 'woo_cat_slider_slider_metabox' );
        $config  = array(
            'title'        => __( 'Slider Settings', 'woocatslider' ),
            'screen'       => 'woocatslider',
            'context'      => 'normal',
            'priority'     => 'high',
            'lazy_loading' => 'true',
            'fields'       => array(
                array(
                    'type'     => 'select',
                    'name'     => 'autoplay',
                    'label'    => __( 'Slider Autoplay', 'woocatslider' ),
                    'tooltip'    => __('Slider will automatically start playing is set Yes.','woocatslider'),
                    'value'    => '1',
                    'sanitize' => 'intval',
                    'options'  => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                ),
                array(
                    'type'     => 'select',
                    'name'     => 'responsive',
                    'label'    => __( 'Responsive', 'woocatslider' ),
                    'value'    => '1',
                    'sanitize' => 'intval',
                    'options'  => array(
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                ),
            ),
        );
        $metabox->init( apply_filters( 'woo_category_slider_slider_config', $config ) );
    }

    public function init_shortcode_metabox() {
        add_meta_box( 'woo-cat-slider-shotcode', __( 'Shotcode', 'woocatslider' ), [
            $this,
            'shortcode_metabox_callback'
        ], 'woocatslider', 'side' );
    }

    public function init_promotion_metabox() {
        add_meta_box( 'woo-cat-slider-promotion', __( 'What More?', 'woocatslider' ), [
            $this,
            'shortcode_promotion_callback'
        ], 'woocatslider', 'side' );
    }

    public function shortcode_metabox_callback( $post ) {
        echo "<pre><code>[woo_category_slider id='{$post->ID}']</code></pre>";
        echo '<p>' . __( 'Use the shortocode to render the slider anywhere in page or post.', 'woocatslider' ) . '</p>';
    }

    public function shortcode_promotion_callback() {
        ?>
        <img src="<?php echo PLVR_WCS_ASSETS . '/images/woo-category-slider-pro.png'; ?>" alt="WOO Category Slider Pro"
             style="width: 100%;margin-bottom: 10px;">
        <h4 style="margin: 0;padding: 0;border-bottom: 1px solid #333;"><?php _e('Pro Features', 'woocatslider'); ?></h4>
        <ul style="padding-left: 25px;list-style: disc;">
            <li>10+ Eye-Catching ready-made theme</li>
            <li>Custom Image size</li>
            <li>Custom WooCommerce Category Order</li>
            <li>Custom Column Size</li>
            <li>Ability to Customize Almost Everything</li>
            <li>Custom Content Color</li>
            <li>Custom Content Background Color</li>
            <li>Custom Button Color</li>
            <li>Custom Button Background Color</li>
            <li>Custom CSS class</li>
            <li>Custom Autoplay Speed</li>
            <li>Excluding any categories</li>
            <li>9+ Hover effects</li>
            <li>Different button type</li>
            <li>Slider Loop Support</li>
            <li>RTL Support</li>
            <li>And Many More</li>
        </ul>
        <a href="https://www.pluginever.com/plugins/woo-category-slider/?utm_source=site&utm_medium=banner&utm_campaign=woocatsliderUpgrade" target="_blank" style="text-align: center;font-weight: bold;">Upgrade To PRO Now</a>
        <?php
    }

    protected function get_wc_category_list() {

        $categories = woocatslider_get_wc_categories();
        $list       = array();
        foreach ( $categories as $key => $category ) {
            $list[ $category->term_id ] = $category->name;
        }

        return $list;
    }


}
new Metabox();
