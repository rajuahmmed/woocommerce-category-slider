const { __, setLocaleData } = wp.i18n;
const { Fragment } = wp.element;

import Edit from "./components/Edit";

export default {
    title: __( 'WooCommerce Category Slider', 'woo-category-slider-by-pluginever' ),
	icon: 'images-alt',
    category: 'layout',
    attributes: {
		slider: {
            type: 'number',
            default: 0
		},
    },
    edit: Edit,
    save: ( { attributes, className  } ) => {
        return (
            <Fragment>
                {
                   attributes.slider !==  0 &&
                    <div>{ `[woo_category_slider id="${ attributes.slider || '' }"]` }</div>
                }
            </Fragment>
        )
    },
}