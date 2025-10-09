<?php

namespace WPDT\Ds\Main;

/**
 * Main Admin Class.
 *
 * Register and un-register the plugin. Setting Page render.
 *
 * @since 1.0.0
 */
class ClassAdmin
{
    private $options;
    private $lang_codes = [
        ['af', 'Afrikaans'],
        ['sq', 'Albanian'],
        ['am', 'Amharic'],
        ['ar', 'Arabic'],
        ['hy', 'Armenian'],
        ['az', 'Azerbaijani'],
        ['eu', 'Basque'],
        ['be', 'Belarusian'],
        ['bn', 'Bengali'],
        ['bs', 'Bosnian'],
        ['bg', 'Bulgarian'],
        ['ca', 'Catalan'],
        ['ceb', 'Cebuano'],
        ['ny', 'Chichewa'],
        ['zh-CN', 'Chinese (Simplified)'],
        ['zh-TW', 'Chinese (Traditional)'],
        ['co', 'Corsican'],
        ['hr', 'Croatian'],
        ['cs', 'Czech'],
        ['da', 'Danish'],
        ['nl', 'Dutch'],
        ['en', 'English'],
        ['eo', 'Esperanto'],
        ['et', 'Estonian'],
        ['tl', 'Filipino'],
        ['fi', 'Finnish'],
        ['fr', 'French'],
        ['fy', 'Frisian'],
        ['gl', 'Galician'],
        ['ka', 'Georgian'],
        ['de', 'German'],
        ['el', 'Greek'],
        ['gu', 'Gujarati'],
        ['ht', 'Haitian Creole'],
        ['ha', 'Hausa'],
        ['haw', 'Hawaiian'],
        ['iw', 'Hebrew'],
        ['hi', 'Hindi'],
        ['hmn', 'Hmong'],
        ['hu', 'Hungarian'],
        ['is', 'Icelandic'],
        ['ig', 'Igbo'],
        ['id', 'Indonesian'],
        ['ga', 'Irish'],
        ['it', 'Italian'],
        ['ja', 'Japanese'],
        ['jw', 'Javanese'],
        ['kn', 'Kannada'],
        ['kk', 'Kazakh'],
        ['km', 'Khmer'],
        ['ko', 'Korean'],
        ['ku', 'Kurdish (Kurmanji)'],
        ['ky', 'Kyrgyz'],
        ['lo', 'Lao'],
        ['la', 'Latin'],
        ['lv', 'Latvian'],
        ['lt', 'Lithuanian'],
        ['lb', 'Luxembourgish'],
        ['mk', 'Macedonian'],
        ['mg', 'Malagasy'],
        ['ms', 'Malay'],
        ['ml', 'Malayalam'],
        ['mt', 'Maltese'],
        ['mi', 'Maori'],
        ['mr', 'Marathi'],
        ['mn', 'Mongolian'],
        ['my', 'Burmese'],
        ['ne', 'Nepali'],
        ['no', 'Norwegian'],
        ['or', 'Odia'],
        ['ps', 'Pashto'],
        ['fa', 'Persian'],
        ['pl', 'Polish'],
        ['pt', 'Portuguese'],
        ['pa', 'Punjabi'],
        ['ro', 'Romanian'],
        ['ru', 'Russian'],
        ['sm', 'Samoan'],
        ['gd', 'Scots Gaelic'],
        ['sr', 'Serbian'],
        ['st', 'Sesotho'],
        ['sn', 'Shona'],
        ['sd', 'Sindhi'],
        ['si', 'Sinhala'],
        ['sk', 'Slovak'],
        ['sl', 'Slovenian'],
        ['so', 'Somali'],
        ['es', 'Spanish'],
        ['su', 'Sundanese'],
        ['sw', 'Swahili'],
        ['sv', 'Swedish'],
        ['tg', 'Tajik'],
        ['ta', 'Tamil'],
        ['te', 'Telugu'],
        ['th', 'Thai'],
        ['tr', 'Turkish'],
        ['uk', 'Ukrainian'],
        ['ur', 'Urdu'],
        ['uz', 'Uzbek'],
        ['vi', 'Vietnamese'],
        ['cy', 'Welsh'],
        ['xh', 'Xhosa'],
        ['yi', 'Yiddish'],
        ['yo', 'Yoruba'],
        ['zu', 'Zulu'],
        ['', ''],
    ];

    public function __construct()
    {
        $this->options = [
            'include' => ['fi.app.local', 'dk.app.local', 'de.app.local', 'es.app.local', 'th.app.local'],
        ];
    }

    /**
     *  Default On.
     *
     * @since 1.0.0
     */
    public static function activate()
    {
        $options = [
            'include' => ['fi.app.local', 'dk.app.local', 'de.app.local', 'es.app.local', 'th.app.local'],
        ];
        if (false == get_option(WPDT_OPTION)) {
            update_option(WPDT_OPTION, $options);
        }
    }

    /**
     * Default Deacativation.
     *
     * @since 1.0.0
     */
    public static function deactivate()
    {
        delete_option(WPDT_OPTION);
    }

    /**
     * Add Menu Setting.
     *
     * The Menu will appear under Settings
     *
     * @since 1.0.0
     */
    public function add_menu_setting()
    {
        add_submenu_page(
            'options-general.php',
            esc_html__('Domain Translate', 'domain-translate'),
            esc_html__('Domain Translate', 'domain-translate'),
            'manage_options',
            'domain-translate',
            [$this, 'wporg_options_page_html'],
            99
        );
    }

    /**
     * Add an API based Setting Page
     * doc: https://developer.wordpress.org/plugins/settings/custom-settings-page/.
     *
     * @since 1.0.0
     */
    public function register_settings()
    {
        register_setting(WPDT_OPTION, WPDT_OPTION, [$this, 'validate']);

        // https://developer.wordpress.org/reference/functions/add_settings_section/
        add_settings_section(
            'section1',
            __('Section General:', 'domain-translate'),
            [$this, 'callback'],
            WPDT_OPTION
        );

        // https://developer.wordpress.org/reference/functions/add_settings_section/
        add_settings_section(
            'section2',
            __('Section Domain 1:', 'domain-translate'),
            [$this, 'callback'],
            WPDT_OPTION
        );
        // https://developer.wordpress.org/reference/functions/add_settings_field/

        add_settings_field(
            'active',
            __('Active:', 'domain-translate'),
            [$this, 'field_active'],
            WPDT_OPTION,
            'section1',
            [
                'label_for' => 'plugin_domain_translate[active]',
            ]
        );

        add_settings_field(
            'source_lang_code',
            __('Source Lang Code:', 'domain-translate'),
            [$this, 'make_select'],
            WPDT_OPTION,
            'section1',
            [
                'label_for' => 'plugin_domain_translate[source_lang_code]',
                'name' => 'source_lang_code',
            ]
        );

        add_settings_field(
            'domain1',
            __('Domain 1:', 'domain-translate'),
            [$this, 'domain1'],
            WPDT_OPTION,
            'section2',
            [
                'label_for' => 'plugin_domain_translate[domain1]',
            ]
        );

        add_settings_field(
            'target_lang_code1',
            __('Target Lang Code 1:', 'domain-translate'),
            [$this, 'make_select'],
            WPDT_OPTION,
            'section2',
            [
                'label_for' => 'plugin_domain_translate[target_lang_code1]',
                'name' => 'target_lang_code1',
            ]
        );
    }

    /**
     * Field Active HTML output.
     *
     * Generate a text checkbox field for the Plugin activation
     *
     * @since 1.0.0
     *
     * @param array $args {
     *                    Field array
     *
     * @var string label_for
     *             }
     *
     * @return string $input
     */
    public function field_active($args)
    {
        $o = get_option(WPDT_OPTION);
        $checked = '';
        if (isset($o['active'])) {
            if ('on' == $o['active']) {
                $checked = 'checked=checked';
            }
        }
        $html_content = "<input type='checkbox' name='{$args['label_for']}'  {$checked} />";
        echo wp_kses($html_content, [
            'input' => [
                'id' => [],
                'name' => [],
                'type' => [],
                'value' => [],
                'checked' => [],
            ],
        ]);
    }

    public function domain1($args)
    {
        $o = get_option(WPDT_OPTION);
        if (isset($o['domain1'])) {
            $key = esc_attr($o['domain1']);
        }

        $html_content = "<input type='text' name='{$args['label_for']}' value='{$key}'   />";
        echo wp_kses($html_content, [
            'input' => [
                'id' => [],
                'name' => [],
                'type' => [],
                'value' => [],
                'checked' => [],
            ],
        ]);
    }

    public function field_target_lang_code1($args)
    {
        $o = get_option(WPDT_OPTION);
        if (isset($o['target_lang_code1'])) {
            $key = esc_attr($o['target_lang_code1']);
        }

        $html_content = "<input type='text' name='{$args['label_for']}' value='{$key}'   />";
        echo wp_kses($html_content, [
            'input' => [
                'id' => [],
                'name' => [],
                'type' => [],
                'value' => [],
                'checked' => [],
            ],
        ]);
    }

    /**
     * Select html.
     *
     * Generate a text checkbox field for the Plugin activation
     *
     * @since 1.0.0
     *
     * @param array $args {
     *                    Field array
     *
     * @var string label_for
     *             }
     *
     * @return string $input
     */
    public function make_select($args)
    {
        $name = esc_attr($args['name']);
        $o = get_option(WPDT_OPTION);
        if (isset($o[$name])) {
            $key = esc_attr($o[$name]);
        }

        $html = "<select name='{$args['label_for']}' />";
        foreach ($this->lang_codes as $i) {
            $code = $i[0];
            $name = $i[1];
            $selected = '';
            if ($key == $code) {
                $selected = 'selected';
            }

            $html .= "<option value='{$code}' {$selected} >{$name}</option>";
        }
        $html .= '</select>';

        echo wp_kses($html, [
            'select' => [
                'name' => true,
                'id' => true,
                'class' => true,
            ],
            'option' => [
                'value' => true,
                'selected' => true,
            ],
        ]);
    }

    /**
     * Generate Setting Page.
     *
     * Generate a text input fields for the Domain names
     *
     * @since 1.0.0
     */
    public function wporg_options_page_html()
    {
        if (!current_user_can('manage_options')) {
            return;
        }
        settings_errors('wporg_messages');
        ?>
	<div class="wrap">
		<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
		<form action="options.php" method="post">
	    <?php
        wp_nonce_field('wpds_save', 'wpds_nonce');
        settings_fields(WPDT_OPTION);
        do_settings_sections(WPDT_OPTION);
        submit_button('Save Settings');
        ?>
		</form>
	</div>
	<?php
    }

    /**
     * Check for valid Domain.
     *
     * @since 1.0.0
     *
     * @param string $domain_name
     *
     * @return bool $ok
     */
    public function is_valid_domain_name($domain_name)
    {
        $ok = preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) // valid chars check
                && preg_match('/^.{1,253}$/', $domain_name) // overall length check
                && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name); // length of each label
        if ('localhost' != $domain_name) {
            if (false == strpos($domain_name, '.')) {
                $ok = false;
            }
        }

        return $ok;
    }

    /**
     * Validate input.
     *
     * @since 1.0.0
     *
     * @param string $input
     *
     * @return string $input
     */
    public function validate($input)
    {
        $newinput = $input;
        $newinput['include'] = [];
        if (isset($input['include'])) {
            if ('array' == gettype($input['include'])) {
                foreach ($input['include'] as $i) {
                    if (true == $this->is_valid_domain_name($i)) {
                        $newinput['include'][] = $i;
                    } else {
                        $newinput['include'][] = '';
                    }
                }
            }
        }
        add_settings_error('wporg_messages', 'wporg_message', __('Settings saved successfully to the database option settings:  plugin_domain_translate', 'domain-translate'), 'updated');

        return $newinput;
    }

    /**
     * Callback after Save Settings.
     *
     * @since 1.0.0
     */
    public function callback()
    {
        // esc_html_e('Settings Saved to ', 'domain-translate');
    }
}
