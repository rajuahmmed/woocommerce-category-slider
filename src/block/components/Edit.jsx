import { sanitize } from 'dompurify'
const { __, setLocaleData } = wp.i18n;
const { Component, Fragment, createRef } = wp.element;
const { Placeholder, Spinner } = wp.components;

class Edit extends Component {
    state = {
        sliders: {},
        loadingSliderList: true,
        htmlView: '',
        sliderInit: false,
        loadingSliderView: true,
    }
    container = createRef()
    componentDidMount() {
        const { attributes } = this.props;
        this.getSliders();

        if ( attributes.slider !==  0 && this.state.htmlView === '' ) {
            this.getSliderView();
        }

    }
    async getSliders() {
        const sliders = await wp.apiFetch( {
            path: 'wc-category-slider/v1/slider/all'
        } );

        this.setState( {
            sliders: sliders.success !== undefined && sliders.success === true ? sliders.data : {},
            loadingSliderList: false,
        } )
    }
    async getSliderView() {
        const { attributes } = this.props;
        const slider_view = await wp.apiFetch( {
            path: 'wc-category-slider/v1/slider/' + attributes.slider,
        } );

        this.setState( {
            htmlView: slider_view.success !== undefined && slider_view.success === true ? slider_view.data : '',
            loadingSliderView: false
        } );
    }
    componentDidUpdate() {
        const { attributes } = this.props;
        if ( attributes.slider !==  0 && this.state.htmlView === '' ) {
            this.getSliderView();
            console.log( jQuery.wc_category_slider_public )
        }

        if ( this.state.htmlView !== '' && ! this.state.sliderInit  ) {
            setTimeout( () => {
                jQuery.wc_category_slider_public.init();
            }, 10 );

            this.setState( {
                sliderInit: true,
            } )
        }
    }
    render() {
        const { attributes, setAttributes } = this.props;
        const { sliders, loadingSliderList, htmlView, loadingSliderView } = this.state;
        
        return (
            <Fragment>
                {
                    attributes.slider ===  0 ?
                    <Placeholder
                        icon="images-alt"
                        label={ __( 'WooCommerce Category Slider', 'woo-category-slider-by-pluginever' ) }>
                        {
                            loadingSliderList ?
                            <Spinner />
                            :
                            <select onChange={ ( e ) => {
                                e.preventDefault();

                                setAttributes( {
                                    slider: parseInt( e.target.value ),
                                } );
                            } }>
                                <option>{ __( '--- Select a slider ---', 'woo-category-slider-by-pluginever' ) }</option>
                                {
                                    sliders && Object.keys( sliders ).length > 0 &&
                                    <Fragment>
                                        {
                                            Object.keys( sliders ).map( ( slider_id ) => ( <option key={ slider_id } value={ slider_id }>{ sliders[ slider_id ] }</option> ) )
                                        }
                                    </Fragment>
                                }
                                
                            </select>
                        }
                    </Placeholder>
                    :
                    <Fragment>
                        {
                            loadingSliderView ?
                                <Placeholder
                                    icon="images-alt"
                                    label={ __( 'WooCommerce Category Slider', 'woo-category-slider-by-pluginever' ) }>
                                    <Spinner />
                                </Placeholder>
                                :
                                <div dangerouslySetInnerHTML={ { __html: sanitize( htmlView ) } } />
                        }
                    </Fragment>
                }
            </Fragment>
        )
    }
}

export default Edit;
