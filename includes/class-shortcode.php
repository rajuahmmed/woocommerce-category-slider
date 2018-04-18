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
     *
     * @return string
     *
     */
    public function woo_cat_slider_callback( $attr ) {
        $params        = shortcode_atts( [ 'id' => null ], $attr );
        $settings      = $this->get_slider_settings( $params['id'] );
        $categories    = $this->get_selected_categories( $settings );
        $slider_config = $this->get_slider_config( $settings );
        $css_classes   = $this->get_wrapper_class( $settings );
        $id            = $this->get_random_id();
        $html          = '';
        if ( ! is_array( $categories ) || empty( $categories ) ) {
            $html = __( 'No Category Found', 'woocatslider' );
        } else {
            ob_start();
            ?>
            <div class="<?php echo implode( ' ', $css_classes ); ?>" id="<?php echo $id; ?>"
                 data-slider-config='<?php echo $slider_config; ?>'>
                <?php foreach ( $categories as $category ): ?>
                    <div class="ever-slider-item">

                        <?php if ( empty( $settings['hide_image'] ) ): ?>
                            <div class="ever-slider-image-wrapper">
                                <?php echo $category['image']; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( empty( $settings['hide_content'] ) ): ; ?>
                            <div
                                class="ever-slider-caption <?php echo ! empty( $settings['hide_image'] ) ? 'position-relative' : ''; ?>">

                                <?php if ( empty( $settings['hide_name'] ) ) { ?>
                                    <h3 class="ever-slider-caption-title"><?php echo $category['name'] ?></h3>
                                <?php } ?>

                                <?php if ( empty( $settings['hide_count'] ) ) { ?>
                                    <span
                                        class="ever-slider-caption-subtitle"><?php echo sprintf( _n( '%s product', '%s products', $category['count'], 'woocatslider' ), $category['count'] ); ?></span>
                                <?php } ?>

                                <?php if ( empty( $settings['hide_button'] ) ) { ?>
                                    <a href="<?php echo $category['url'] ?>"
                                       class="ever-slider-caption-btn"><?php echo wp_kses_post( $settings['button_text'] ); ?></a>
                                <?php } ?>

                            </div>

                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>
            </div>

            <?php
            do_action('woo_category_slider_after_html', $settings, $id);
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
            'hide_empty'     => '0',
            'include_child'  => '1',
            'number'         => '20',

            //design
            'hide_image'     => '0',
            'hide_content'   => '0',
            'hide_button'    => '0',
            'hide_name'      => '0',
            'hide_count'     => '0',
            'hide_nav'       => '0',
            'hover_style'    => 'hover-zoom-in',
            'hide_border'    => '0',
            'theme'          => 'default',
            'button_text'    => 'Shop Now',

            //slider
            'autoplay'       => '1',
            'cols'           => '4',
            'tab_cols'       => '2',
            'phone_cols'     => '1',
            'slider_speed'   => '2000',
            'loop'           => '1',
            'column_gap'     => '10',
            'lazy_load'      => '1',
        );

        $default_fields = apply_filters( 'woo_category_slider_default_meta_fields', $default );

        if ( $post_id !== null && get_post_status( $post_id ) ) {
            foreach ( $default_fields as $key => $value ) {
                $saved = get_post_meta( $post_id, $key, true );
                if ( $saved == '0' || ! empty( $saved ) ) {
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
            'number'         => 20,
            'hide_empty'     => 0,
            'order'          => 'name',
            'order_by'       => 'ASC',
            'hierarchical'   => true,
            'include_child'  => '1',
        );
        $settings = wp_parse_args( $settings, $default );
        if ( $settings['selection_type'] == 'all' ) {
            $settings['include'] = array();
        }
        //get categories
        $categories = woocatslider_get_wc_categories( $settings );
        if ( ! empty( $settings['include_child'] ) && ( $settings['selection_type'] !== 'all' ) ) {
            $child_settings = $settings;

            $child_keys     = [ 'hide_empty', 'order', 'order_by' ];
            $child_settings = array_intersect_key( $child_settings, array_flip( $child_keys ) );
            foreach ( $settings['include'] as $cat_id ) {
                $child_settings['child_of'] = $cat_id;
                $child_categories           = woocatslider_get_wc_categories( $child_settings );
                $categories                 = array_merge( $categories, $child_categories );
            }
        }
        $results = [];

        foreach ( $categories as $category ) {
            $results[] = [
                'term_id'     => $category->term_id,
                'name'        => $category->name,
                'slug'        => $category->slug,
                'url'         => get_term_link( $category->term_id ),
                'description' => $category->description,
                'count'       => $category->count,
                'image'       => $this->get_category_image( $category, $settings ),
            ];

        }


        return $results;
    }

    protected function get_slider_config( $settings ) {
        $config = array(
            'dots'               => false,
            'autoHeight'         => true,
            'singleItem'         => true,
            'autoplay'           => empty( $settings['autoplay'] ) ? false : true,
            'loop'               => empty( $settings['loop'] ) ? false : true,
            'lazyLoad'           => empty( $settings['lazy_load'] ) ? false : true,
            'margin'             => intval( $settings['column_gap'] ),
            'autoplayTimeout'    => intval( $settings['slider_speed'] ),
            'autoplayHoverPause' => true,
            'fluidSpeed'         => intval( $settings['slider_speed'] ),
            'smartSpeed'         => intval( $settings['slider_speed'] ),
            'nav'                => empty( $settings['hide_nav'] ) ? true : false,
            'navText'            => [ '<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>' ],
            'stagePadding'       => 4,
            'items'              => empty( $settings['cols'] ) ? 4 : intval( $settings['cols'] ),
            'responsive'         => [
                '0'    => [
                    'items' => empty( $settings['phone_cols'] ) ? 4 : intval( $settings['phone_cols'] ),
                ],
                '600'  => [
                    'items' => empty( $settings['tab_cols'] ) ? 4 : intval( $settings['tab_cols'] ),
                ],
                '1000' => [
                    'items' => empty( $settings['cols'] ) ? 4 : intval( $settings['cols'] ),
                ],
            ],


        );


        $config = apply_filters( 'woo_category_slider_slider_config', $config );

        return json_encode( $config );
    }

    protected function get_wrapper_class( $settings ) {
        $classes = array(
            'owl-carousel',
            'owl-theme',
            'ever-slider',
            'ever-category-slider'
        );

        if ( ! empty( $settings['theme'] ) ) {
            $classes[] = sanitize_key( $settings['theme'] );
        }

        if ( empty( $settings['hide_border'] ) ) {
            $classes[] = 'border';
        }

        if ( !empty( $settings['button_type'] ) ) {
            $classes[] = sanitize_key($settings['button_type']);
        }

        if ( intval( $settings['cols'] ) < 2 ) {
            $classes[] = 'single-slide';
        }

        if ( ! empty( $settings['hover_style'] ) || $settings['hover_style'] !== 'no-hover' ) {
            $classes[] = esc_attr( $settings['hover_style'] );
        }


        return apply_filters( 'woo_cat_slider_wrapper_classes', $classes, $settings );
    }

    /**
     * Get slider ID
     *
     * @return string
     */
    protected function get_random_id() {
        return 'woo-cat-slider-' . strtolower( wp_generate_password( 5, false, false ) );
    }

    /**
     * get category image
     *
     * @param $category
     * @param $settings
     *
     * @return string
     */
    protected function get_category_image( $category, $settings ) {
        $image_size   = apply_filters( 'woo_cat_slider_image_size', 'large', $settings );
        $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
        if ( ! empty( $thumbnail_id ) ) {
            $img = wp_get_attachment_image( $thumbnail_id, $image_size );
        } else {
            $src = PLVR_WCS_ASSETS . '/images/placeholder.png';
            $img = "<img src='{$src}' alt='$category->name'/>";
        }

        return apply_filters( 'woo_category_slider_category_image', $img, $thumbnail_id, $category );
    }
}
