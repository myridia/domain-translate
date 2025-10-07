<?php

namespace WPDS\DS\Main;

/**
 * Class Frontend.
 *
 * Handle all Request to to browser Frontend
 *
 * @since 1.0.0
 */
class ClassFrontend
{
    private $domains;
    private $activate;

    /**
     * Init the Frontend Filter Hooks.
     *
     * If Plugin is active  and if the new_siteurl is different to the base stieurl, then init the ajax filter hooks
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        // error_log('...swap browser frontent calls');
        $this->set_domain_data();
        if ($this->active) {
        }
    }

    /**
     * Set Urls.
     *
     * Set the new_domain and and old domain and other data
     *
     * Register and un-register the plugin. Setting Page render - Same like in ClassAjax
     *
     * @since 1.0.0
     */
    public function set_domain_data()
    {
        $o = get_option(WPDS_OPTION);
        if (isset($o['active'])) {
            $this->active = 1;
        } else {
            $this->active = 0;

            return;
        }
        $this->domains = $o['include'];

    }


}
