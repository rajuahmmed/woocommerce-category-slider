<?php

namespace Pluginever\WCS;
class Shortcode {

    /**
     * Shortcode constructor.
     */
    public function __construct() {
        add_shortcode( 'woo_category_slider', array( $this, 'woo_cat_slider_callback' ) );
    }

    /**
     * Render the shortcode
     *
     * @since 2.0.0
     *
     * @param $attr
     */
    public function woo_cat_slider_callback( $attr ) {
        $params        = shortcode_atts( [ 'id' => null ], $attr );
        $settings      = $this->get_slider_settings( $params['id'] );
        $categories    = $this->get_selected_categories( $settings );
        $slider_config = $this->get_slider_config( $settings );
        $css_classes   = $this->get_wrapper_class( $settings );

        $id   = $this->get_random_id();
        $html = '';
        if ( ! is_array( $categories ) || empty( $categories ) ) {
            $html = __( 'No Category Found', 'woocatslider' );
        } else {
            ob_start();
            ?>
            <div class="<?php echo implode( ' ', $css_classes ); ?>" id="<?php echo $id; ?>"
                 data-sliderconfig='<?php echo $slider_config; ?>'>
                <?php foreach ( $categories as $category ): ?>
                    <div>
                        <?php echo $this->get_category_image( $category ); ?>
                        <a href="<?php echo get_term_link( $category->term_id ) ?>" class="abs-link"></a>
                        <div class="slider-caption">
                            <h3 class="slider-caption-title"><?php echo $category->name ?></h3>
                            <span
                                class="slider-caption-sub-header product-count"><?php _e( $category->count . ' Product(s)', 'woocatslider' ) ?></span>
                            <a href="<?php echo get_term_link( $category->term_id ) ?>"
                               class="slider-btn"> <?php echo $category->name ?></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php
            $html = ob_get_contents();
            ob_get_clean();
        }


        return $html;
    }


    /**
     * Get the slider settings
     *
     * @since 2.0.0
     *
     * @param null $post_id
     *
     * @return array
     */
    protected function get_slider_settings( $post_id = null ) {
        $settings = array();
        $default  = array(
            'selection_type' => 'all',
            'include'        => [],
            'hide_empty'     => '1',
            'hide_no_image'  => '1',
            'limit'          => '20',
            //design
            'show_content'   => '1',
            'show_button'    => '1',
            'show_name'      => '1',
            'show_count'     => '1',
            'show_nav'       => '1',
            'nav_position'   => 'top-right',
            'hover_effect'   => '1',
            'border'         => '1',
            //slider
            'autoplay'       => '1',
            'responsive'     => '1',
        );

        $default_fields = apply_filters( 'woo_category_slider_default_meta_fields', $default );

        if ( $post_id !== null && get_post_status( $post_id ) ) {
            foreach ( $default_fields as $key => $value ) {
                $saved = get_post_meta( $post_id, $key, true );
                if ( $saved !== false ) {
                    $settings[ $key ] = $saved;
                } else {
                    $settings[ $key ] = $value;
                }
            }

            return $settings;
        }

        return $default;
    }

    protected function get_selected_categories( $settings ) {
        $default  = array(
            'selection_type' => 'all',
            'include'        => [],
            'exclude'        => [],
            'limit'          => 20,
            'hide_empty'     => 1,
            'hide_no_image'  => 1,
            'order'          => 'name',
            'order_by'       => 'ASC',
            'hierarchical'   => true,
        );
        $settings = wp_parse_args( $settings, $default );
        if ( $settings['selection_type'] == 'all' ) {
            $settings['include'] = array();
        }
        //get categories
        $categories = woocatslider_get_wc_categories( $settings );

        //if hide empty image then filter the result
        $is_exclude_no_image = empty( $settings['hide_no_image'] ) ? 0 : 1;
        $categories          = array_filter( $categories, function ( $category ) use ( $is_exclude_no_image ) {
            $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
            if ( $is_exclude_no_image && empty( $thumbnail_id ) ) {
                return false;
            }

            return true;
        } );

        return $categories;
    }

    protected function get_slider_config( $settings ) {
        $config = array(
            'dots'           => false,
            'arrows'         => empty( $settings['show_nav'] ) ? false : true,
            'slidesToShow'   => 4,
            'slidesToScroll' => 1,
            'autoplay'       => empty( $settings['autoplay'] ) ? false : true,
            'autoplaySpeed'  => 3000,
            'pauseOnHover'   => false,
            'responsive'     => array(
                array(
                    'breakpoint' => 1024,
                    'settings'   => array(
                        'slidesToShow' => 4
                    ),
                ),
                array(
                    'breakpoint' => 600,
                    'settings'   => array(
                        'slidesToShow'   => 2,
                        'slidesToScroll' => 2,
                    ),
                ),
                array(
                    'breakpoint' => 480,
                    'settings'   => array(
                        'slidesToShow'   => 1,
                        'slidesToScroll' => 1,
                    ),
                )
            ),
        );


        $config = apply_filters( 'woo_category_slider_slider_config', $config );

        return json_encode( $config );
    }

    protected function get_wrapper_class( $settings ) {
        $classes = array(
            'plvr-slider',
            'plvr-category-slider',
            'woo-category-slider',
            'has-padding',
            'woo-category-slider-loading'
        );


        if ( $settings['show_content'] !== '1' ) {
            $classes[] = 'no-content';
        }
        if ( $settings['border'] == '1' ) {
            $classes[] = 'has-border';
        }
        if ( $settings['show_button'] !== '1' ) {
            $classes[] = 'no-btn';
        }
        if ( $settings['show_count'] !== '1' ) {
            $classes[] = 'no-count';
        }
        if ( $settings['show_name'] !== '1' ) {
            $classes[] = 'no-name';
        }
        if ( in_array( $settings['nav_position'], array( 'top-left', 'top-right', 'bottom-left', 'bottom-right' ) ) ) {
            $classes[] = 'nav-' . esc_attr( $settings['nav_position'] );
        }

        if ( $settings['hover_effect'] == '1' ) {
            $classes[] = 'has-hover-effect';
        }


        return $classes;
    }

    protected function get_random_id() {
        return 'woo-cat-slider-' . strtolower( wp_generate_password( 5, false, false ) );
    }

    protected function get_category_image( $category ) {
        $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
        if ( ! empty( $thumbnail_id ) ) {
            $img = wp_get_attachment_image( $thumbnail_id, 'large' );
        } else {
            $img = '';
        }

        return apply_filters( 'woo_category_slider_category_image', $img, $thumbnail_id, $category );
    }
}
