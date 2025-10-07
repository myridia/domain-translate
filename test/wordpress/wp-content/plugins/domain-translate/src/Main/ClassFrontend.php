<?php

namespace WPDT\DS\Main;

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
    private $active;

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
            add_action('wp_enqueue_scripts', [$this, 'add_scripts']);
            add_action('wp_enqueue_scripts', [$this, 'add_styles']);
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
        $o = get_option(WPDT_OPTION);
        if (isset($o['active'])) {
            $this->active = 1;
        } else {
            $this->active = 0;

            return;
        }
        $this->domains = $o['include'];
    }

    public function add_scripts()
    {
        wp_register_script(
            'domain-translate',
            plugins_url('domain-translate/js/domain-translate.js'),
            [],
            '1.0.0',
            [
                'strategy' => 'defer',
            ]
        );

        wp_localize_script('domain-translate', 'domain_translate_data', [
            'lang' => 'dk',
            'nonce' => wp_create_nonce('mg_ajax_nonce'),
        ]);

        wp_enqueue_script('domain-translate');

        wp_register_script(
            'domain-translate-google',
            'http://translate.google.com/translate_a/element.js?cb=gtranslate_init',
            [],
            '1.0.0',
            [
                'in_footer' => 'true',
                'strategy' => 'defer',
            ]
        );

        wp_enqueue_script('domain-translate-google');
    }

    public function add_styles()
    {
        wp_register_style('domain-translate',
            plugins_url('domain-translate/css/domain-translate.css'));
        wp_enqueue_style('domain-translate');
    }
}
