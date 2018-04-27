<?php

namespace Pluginever\WoocommerceCategorySlider;

class Shortcode {
    /**
     * Shortcode constructor.
     */
    public function __construct() {
        add_shortcode( 'woo_category_slider', array( $this, 'render_shortcode' ) );
    }


    public function render_shortcode( $attr ) {
        $params = shortcode_atts( [ 'id' => null ], $attr );
        if ( empty( $params['id'] ) ) {
            return false;
        }

        $post_id = $params['id'];

        $settings      = wc_category_slider_get_settings( $post_id );
        $categories    = wc_category_slider_get_selected_categories( $settings, $post_id );
        $slider_config = $this->get_slider_config( $settings );

        $css_classes = $this->get_wrapper_class( $settings );
        $id          = $this->get_slider_id( $post_id );

        //var_dump($settings);
        if ( ! is_array( $categories ) || empty( $categories ) ) {
            $html = __( 'No Category Found', 'wc_category_slider' );
        } else {
            ob_start();
            ?>

            <div class="<?php echo implode( ' ', $css_classes ); ?>" id="<?php echo $id; ?>"
                 data-slider-config='<?php echo $slider_config; ?>'>
                <?php foreach ( $categories as $category ): ?>
                    <div class="ever-slider-item">
                        <?php if ( empty( $settings['hide_image'] ) ): ?>
                            <a href="<?php echo $category['url'] ?>" class="cat-link">
                                <div class="ever-slider-image-wrapper">
                                    <img src="<?php echo $category['image']; ?>" alt="<?php echo $category['name']; ?>"
                                         class="ever-slider-image">

                                </div>
                            </a>
                        <?php endif; ?>

                        <?php if ( empty( $settings['hide_content'] ) ): ; ?>
                            <div
                                class="ever-slider-caption <?php echo ! empty( $settings['hide_image'] ) ? 'position-relative' : ''; ?>">

                                <?php if ( empty( $settings['hide_name'] ) ) { ?>
                                    <a href="<?php echo $category['url'] ?>" class="cat-link"> <h3 class="ever-slider-caption-title"><?php echo $category['name'] ?></h3></a>
                                <?php } ?>

                                <?php if ( empty( $settings['hide_count'] ) ) { ?>
                                    <span
                                        class="ever-slider-caption-subtitle"><?php echo sprintf( _n( '%s product', '%s products', $category['count'], 'woocatslider' ), $category['count'] ); ?></span>
                                <?php } ?>

                                <?php if (! empty( $settings['show_desc'] ) ) { ?>
                                    <p
                                        class="ever-slider-desc"><?php echo wp_kses_post($category['description']); ?></p>
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
            do_action( 'wc_category_slider_after_html', $settings, $id );
            $html = ob_get_contents();
            ob_get_clean();
        }


        return $html;
    }

    /**
     * Get slider settings
     *
     * @param $settings
     *
     * @return object
     */
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

        if( !empty($settings['fluid_speed'])){
            $config['fluidSpeed'] = intval( $settings['slider_speed'] );
            $config['smartSpeed'] = intval( $settings['slider_speed'] );
        }
        $config = apply_filters( 'woo_category_slider_slider_config', $config );

        return json_encode( $config );
    }

    /**
     * Get slider wrapper classes
     *
     * @param $settings
     *
     * @return array
     */
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

        if ( ! empty( $settings['button_type'] ) ) {
            $classes[] = sanitize_key( $settings['button_type'] );
        }

        if ( intval( $settings['cols'] ) < 2 ) {
            $classes[] = 'single-slide';
        }

        if ( ! empty( $settings['hover_style'] ) || $settings['hover_style'] !== 'no-hover' ) {
            $classes[] = esc_attr( $settings['hover_style'] );
        }


        return apply_filters( 'wc_category_slider_wrapper_classes', $classes, $settings );
    }

    /**
     * Get slider ID
     *
     * @return string
     */
    protected function get_slider_id( $post_id ) {
        return esc_attr( 'woo-cat-slider-' . $post_id );
    }
}
