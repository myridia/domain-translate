<?php

namespace WPDT\DS\Main;

/**
 * Class Ajax.
 *
 * Handle Ajax requests
 *
 * @since 1.0.0
 */
class ClassAjax
{
    private $domains;
    private $siteurl;
    private $new_siteurl;
    private $new_domain;
    private $old_domain;

    /**
     * Init the Ajax Filter Hooks.
     *
     * If Plugin is activated and if the new_siteurl is different to the base stieurl, then init the ajax filter hooks
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        // error_log('...swap ajax calls');
        $this->set_domain_data();
        if ($this->active) {
        }
    }

    /**
     * Set Urls.
     *
     * Set the new_domain and and old domain and other data
     *
     * Register and un-register the plugin. Setting Page render.
     *
     * @since 1.0.0
     */
    public function set_domain_data()
    {
        $o = get_option(WPDS_OPTION);
        if ($o['active']) {
            $this->active = 1;
        } else {
            $this->active = 0;

            return;
        }

        $this->domains = $o['include'];


    }

}
