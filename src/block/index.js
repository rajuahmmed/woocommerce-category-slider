const { __, setLocaleData } = wp.i18n;

import Edit from "./components/Edit";

export default {
    title: __( 'WooCommerce Category Slider', 'woo-category-slider-by-pluginever' ),
	icon: 'images-alt',
    category: 'layout',
    attributes: {
		slider: {
			type: 'number',
		},
    },
    edit: Edit,
    save: () => {},
}