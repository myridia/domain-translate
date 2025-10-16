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
    private $domain;
    private $base_domain;
    private $options;
    private $source_lang_code;
    private $target_lang_code;
    private $lang_codes;
    private $domains;

    /**
     * Class Constructor.
     *
     * If Source and Target is set, init the plugins
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        if ($this->is_active()) {
            $this->set_domain();
            $this->set_lang_codes($this->domain, $this->options);
            if ($this->source_lang_code && $this->target_lang_code) {
                add_action('wp_enqueue_scripts', [$this, 'add_scripts']);
                add_action('wp_enqueue_scripts', [$this, 'add_styles']);
            }
        }
    }

    /**
     * Class function to set all set domain target language combinations.
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function set_lang_codes($domain, $options)
    {
        // Set Source Lang
        if (isset($options['source_lang_code'])) {
            $this->source_lang_code = esc_attr($options['source_lang_code']);
        }
        $domains = [];
        if (isset($options['domain1']) && isset($options['target_lang_code1'])) {
            $domains[$options['domain1']] = esc_attr($options['target_lang_code1']);
        }
        if (isset($options['domain2']) && isset($options['target_lang_code2'])) {
            $domains[$options['domain2']] = esc_attr($options['target_lang_code2']);
        }
        if (isset($options['domain3']) && isset($options['target_lang_code3'])) {
            $domains[$options['domain3']] = esc_attr($options['target_lang_code3']);
        }

        if (isset($options['domain4']) && isset($options['target_lang_code4'])) {
            $domains[$options['domain4']] = esc_attr($options['target_lang_code4']);
        }

        if (isset($options['domain5']) && isset($options['target_lang_code5'])) {
            $domains[$options['domain5']] = esc_attr($options['target_lang_code5']);
        }

        // Set Target Lang
        if (array_key_exists($domain, $domains)) {
            $this->target_lang_code = $domains[$domain];
        }
        $this->domains = $domains;
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
        if (isset($o['active'])) {
            $this->options = $o;

            return true;
        } else {
            $this->options = [];

            return false;
        }
    }

    /**
     * Set Class Propertier like actual Domain.
     *
     * @return string - Actual Domain
     *
     * @since 1.0.0
     */
    public function set_domain()
    {
        $domain = get_option('siteurl'); // Set default url from the wordpress setting
        if (isset($_SERVER['HTTP_HOST'])) {
            $unslashed = sanitize_text_field(wp_unslash($_SERVER['HTTP_HOST']));
            if ('' != $unslashed) {
                $domain = $unslashed;
            }
        } elseif (isset($_SERVER['SERVER_NAME'])) {
            $unslashed = sanitize_text_field(wp_unslash($_SERVER['SERVER_NAME']));
            if ('' != $unslashed) {
                $domain = $unslashed;
            }
        }

        $a = array_reverse(explode('.', $domain));
        if (count($a) > 2) {
            $this->base_domain = $a[1].'.'.$a[0];
        }
        $this->domain = $domain;

        return $domain;
    }

    /**
     * Add the extra plugins JavaScript files, like google translate and its callback ini functions.
     *
     * @return void
     *
     * @since 1.0.0
     */
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
            'source_lang_code' => $this->source_lang_code,
            'target_lang_code' => $this->target_lang_code,
            'domain' => $this->domain,
            'domains' => $this->domains,
            'nonce' => wp_create_nonce('mg_ajax_nonce'),
        ]);

        wp_enqueue_script('domain-translate');

        wp_register_script(
            'domain-translate-google',
            //            plugins_url('domain-translate/js/google_translate.js?cb=domain_translate_init'),
            'https://translate.google.com/translate_a/element.js?cb=domain_translate_init',
            [],
            '1.0.0',
            [
                'in_footer' => 'true',
                'strategy' => 'defer',
            ]
        );

        wp_enqueue_script('domain-translate-google');
    }

    /**
     * Add the extra plugins CSS files for hiding the google trans tool bar
     * See doc https://developer.wordpress.org/reference/functions/wp_register_style/.
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function add_styles()
    {
        wp_register_style('domain-translate',
            plugins_url('domain-translate/css/domain-translate.css'), [], 1);
        wp_enqueue_style('domain-translate');
    }
}
