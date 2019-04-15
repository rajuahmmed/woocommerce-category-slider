const { __, setLocaleData } = wp.i18n;
const { Component, Fragment } = wp.element;
const { Placeholder } = wp.components;

class Edit extends Component {
    state = {
        sliders: {}
    }
    componentDidMount() {
        this.getSliders();
    }
    async getSliders() {
        const sliders = await wp.apiFetch( {
            path: 'wc-category-slider/v1/slider/all'
        } );

        this.setState( {
            sliders: sliders.data,
        } )
    }
    render() {
        const { sliders } = this.state;
        return (
            <Placeholder
                icon="images-alt"
                label={ __( 'WooCommerce Category Slider', 'woo-category-slider-by-pluginever' ) }>
                <select>
                    <option>--- Select a slider ---</option>
                    {
                        sliders && Object.keys( sliders ).length > 0 &&
                        <Fragment>
                            {
                                Object.keys( sliders ).map( ( slider_id ) => ( <option key={ slider_id } value={ slider_id }>{ sliders[ slider_id ] }</option> ) )
                            }
                        </Fragment>
                    }
                    
                </select>
            </Placeholder>
        )
    }
}

export default Edit;
