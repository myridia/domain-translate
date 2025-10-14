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
    private $domain;
    private $active;

    /**
     * Init the Ajax Filter Hooks.
     *
     * If Plugin is activated and if the new_siteurl is different to the base stieurl, then init the ajax filter hooks
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        if ($this->is_active()) {
            // error_log('...is active');
            // $this->set_domain_data();
        }
    }

    /**
     * Check if the plugin is set Active.
     *
     * @return boolen - true or false
     *
     * @since 1.0.0
     */
    public function is_active()
    {
        $o = get_option(WPDT_OPTION);
        if ($o['active']) {
            return true;
        } else {
            $this->active = 0;

            return false;
        }
    }
}
