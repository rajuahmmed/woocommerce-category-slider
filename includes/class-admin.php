<?php

namespace Pluginever\WCS;
class Admin {

    /**
     * Constructor for the class
     *
     * Sets up all the appropriate hooks and actions
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function __construct() {

        // Include required files
        $this->includes();

        // Initialize the action hooks
        $this->init_actions();

        // instantiate classes
        $this->instantiate();
    }

    protected function includes() {
        require PLVR_WCS_INCLUDES . '/class-metabox.php';
    }

    public function init_actions() {
    }

    protected function instantiate() {
        new Metabox();
    }
}
new Admin();
