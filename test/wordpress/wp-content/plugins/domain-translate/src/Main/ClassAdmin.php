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
    // Possible Google Translate Codes with Name
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

    /**
     * Class Constructor.
     *
     * Place Holder for the moment
     *
     * @since 1.0.0
     */
    public function __construct()
    {
    }

    /**
     * Default Activate.
     *
     * Place Holder for the moment
     *
     * @since 1.0.0
     */
    public static function activate()
    {
    }

    /**
     * Default Deactivate.
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
        // https://developer.wordpress.org/reference/functions/add_settings_section/
        register_setting(WPDT_OPTION, WPDT_OPTION, [$this, 'validate']);

        add_settings_section(
            'section',
            __('Section General:', 'domain-translate'),
            [$this, 'callback'],
            WPDT_OPTION
        );

        add_settings_section(
            'section1',
            __('Section Domain 1:', 'domain-translate'),
            [$this, 'callback'],
            WPDT_OPTION
        );

        add_settings_section(
            'section2',
            __('Section Domain 2:', 'domain-translate'),
            [$this, 'callback'],
            WPDT_OPTION
        );

        add_settings_section(
            'section3',
            __('Section Domain 3:', 'domain-translate'),
            [$this, 'callback'],
            WPDT_OPTION
        );

        add_settings_section(
            'section4',
            __('Section Domain 4:', 'domain-translate'),
            [$this, 'callback'],
            WPDT_OPTION
        );

        add_settings_section(
            'section5',
            __('Section Domain 5:', 'domain-translate'),
            [$this, 'callback'],
            WPDT_OPTION
        );

        /************************* General ************************************/
        add_settings_field(
            'active',
            __('Active:', 'domain-translate'),
            [$this, 'make_checkbox'],
            WPDT_OPTION,
            'section',
            [
                'name' => 'active',
                'label_for' => 'plugin_domain_translate[active]',
            ]
        );

        add_settings_field(
            'source_lang_code',
            __('Source Lang Code:', 'domain-translate'),
            [$this, 'make_select'],
            WPDT_OPTION,
            'section',
            [
                'label_for' => 'plugin_domain_translate[source_lang_code]',
                'name' => 'source_lang_code',
            ]
        );

        /************************* Domain 1 ************************************/
        add_settings_field(
            'domain1',
            __('Domain 1:', 'domain-translate'),
            [$this, 'make_input_text'],
            WPDT_OPTION,
            'section1',
            [
                'name' => 'domain1',
                'label_for' => 'plugin_domain_translate[domain1]',
            ]
        );

        add_settings_field(
            'target_lang_code1',
            __('Target Language 1:', 'domain-translate'),
            [$this, 'make_select'],
            WPDT_OPTION,
            'section1',
            [
                'label_for' => 'plugin_domain_translate[target_lang_code1]',
                'name' => 'target_lang_code1',
            ]
        );

        /************************* Domain 2 ************************************/

        add_settings_field(
            'domain2',
            __('Domain 2:', 'domain-translate'),
            [$this, 'make_input_text'],
            WPDT_OPTION,
            'section2',
            [
                'name' => 'domain2',
                'label_for' => 'plugin_domain_translate[domain2]',
            ]
        );

        add_settings_field(
            'target_lang_code2',
            __('Target Language 2:', 'domain-translate'),
            [$this, 'make_select'],
            WPDT_OPTION,
            'section2',
            [
                'label_for' => 'plugin_domain_translate[target_lang_code2]',
                'name' => 'target_lang_code2',
            ]
        );

        /************************* Domain 3 ************************************/

        add_settings_field(
            'domain3',
            __('Domain 3:', 'domain-translate'),
            [$this, 'make_input_text'],
            WPDT_OPTION,
            'section3',
            [
                'name' => 'domain3',
                'label_for' => 'plugin_domain_translate[domain3]',
            ]
        );

        add_settings_field(
            'target_lang_code3',
            __('Target Language 3:', 'domain-translate'),
            [$this, 'make_select'],
            WPDT_OPTION,
            'section3',
            [
                'label_for' => 'plugin_domain_translate[target_lang_code3]',
                'name' => 'target_lang_code3',
            ]
        );

        /************************* Domain 4 ************************************/

        add_settings_field(
            'domain4',
            __('Domain 4:', 'domain-translate'),
            [$this, 'make_input_text'],
            WPDT_OPTION,
            'section4',
            [
                'name' => 'domain4',
                'label_for' => 'plugin_domain_translate[domain4]',
            ]
        );

        add_settings_field(
            'target_lang_code4',
            __('Target Language 4:', 'domain-translate'),
            [$this, 'make_select'],
            WPDT_OPTION,
            'section4',
            [
                'label_for' => 'plugin_domain_translate[target_lang_code4]',
                'name' => 'target_lang_code4',
            ]
        );

        /************************* Domain 5 ************************************/

        add_settings_field(
            'domain5',
            __('Domain 5:', 'domain-translate'),
            [$this, 'make_input_text'],
            WPDT_OPTION,
            'section5',
            [
                'name' => 'domain5',
                'label_for' => 'plugin_domain_translate[domain5]',
            ]
        );

        add_settings_field(
            'target_lang_code5',
            __('Target Language 5:', 'domain-translate'),
            [$this, 'make_select'],
            WPDT_OPTION,
            'section5',
            [
                'label_for' => 'plugin_domain_translate[target_lang_code5]',
                'name' => 'target_lang_code5',
            ]
        );
    }

    /**
     * Generate a text checkbox field.
     *
     * @since 1.0.0
     *
     * @param array $args {Field array }
     *
     * @return string
     */
    public function make_checkbox($args)
    {
        $name = esc_attr($args['name']);
        $o = get_option(WPDT_OPTION);
        $checked = '';
        if (isset($o[$name])) {
            if ('on' == $o[$name]) {
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

    /**
     * Generate a text input field.
     *
     * @since 1.0.0
     *
     * @param array $args {Field array }
     *
     * @return string
     */
    public function make_input_text($args)
    {
        $name = esc_attr($args['name']);
        $o = get_option(WPDT_OPTION);
        if (isset($o[$name])) {
            $key = esc_attr($o[$name]);
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
     * Generate HTML Select.
     *
     * @since 1.0.0
     *
     * @param array $args { Field array}
     *
     * @return string
     */
    public function make_select($args)
    {
        $name = esc_attr($args['name']);
        $o = get_option(WPDT_OPTION);
        $key = '';
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
     * Validate input of valid Domains.
     *
     * @since 1.0.0
     *
     * @param string $input
     *
     * @return string $input
     */
    public function validate($input)
    {
        if (isset($input['domain1'])) {
            if (false == $this->is_valid_domain_name($input['domain1'])) {
                $input['domain1'] = '';
            }
        }

        if (isset($input['domain2'])) {
            if (false == $this->is_valid_domain_name($input['domain2'])) {
                $input['domain2'] = '';
            }
        }

        if (isset($input['domain3'])) {
            if (false == $this->is_valid_domain_name($input['domain3'])) {
                $input['domain3'] = '';
            }
        }

        if (isset($input['domain4'])) {
            if (false == $this->is_valid_domain_name($input['domain4'])) {
                $input['domain4'] = '';
            }
        }
        if (isset($input['domain5'])) {
            if (false == $this->is_valid_domain_name($input['domain5'])) {
                $input['domain5'] = '';
            }
        }

        add_settings_error('wporg_messages', 'wporg_message', __('Settings saved successfully to the database option settings:  plugin_domain_translate', 'domain-translate'), 'updated');

        return $input;
    }

    /**
     * Callback after add Settings - for the moment a placeholder.
     *
     * @since 1.0.0
     */
    public function callback()
    {
        // esc_html_e('Settings added to ', 'domain-translate');
    }
}
