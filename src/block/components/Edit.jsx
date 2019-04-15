const { __, setLocaleData } = wp.i18n;
const { Component, Fragment, createRef } = wp.element;
const { Placeholder, Spinner } = wp.components;

class Edit extends Component {
    state = {
        sliders: {},
        loadingSliderList: true,
        htmlView: '',
        height: 0,
        sliderInit: false,
    }
    iframe = createRef()
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
        } );
    }
    componentDidUpdate( prevProps ) {
        const { attributes } = this.props;
        if ( attributes.slider !==  0 && prevProps.attributes.slider !==  attributes.slider && this.state.htmlView === '' ) {
            this.getSliderView();
        }
    }
    render() {
        const { attributes, setAttributes } = this.props;
        const { sliders, loadingSliderList, htmlView, height } = this.state;
        // console.log(attributes)
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
                                    slider: parseInt( e.target.value )
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
                    <div>
                        <iframe height={ height } ref={ this.iframe } onLoad={ () => {
                            this.setState( {
                                height: this.iframe.current.contentDocument.documentElement.offsetHeight
                            } )
                        } } srcdoc={ htmlView } />
                    </div>
                }
            </Fragment>
        )
    }
}

export default Edit;
