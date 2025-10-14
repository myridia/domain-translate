<?php

/**
 * @see              https://domain-translate.myridia.com
 * @since             1.0.0
 *
 * @wordpress-plugin
 * Plugin Name: Domain-translate
 * Plugin URI: https://wordpress.org/plugins/domain-translate
 * Description: Automatically translate your Site based on your language code subdomain like de., es. dk. etc.
 * Version: 1.0.0
 * Author: veto, Myridia Company
 * Author URI: http://domain-translate.myridia.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: domain-translate
 * Domain Path: /languages
 * Update URL: https://github.com/myridia/domain-translate
 * Constant Prefix: WPDT_
 * Prefix: wpdt_
 * Option_key: plugin_domain_translate
 **/

/*
 * Default Wordpress Constant
 *
 * @since 1.0.0 (if available)
 */
defined('ABSPATH') or exit('Something went wrong');

/*
 * Set the Plugin Namespace
 *
 * @since 1.0.0 (if available)
 */
use WPDT\Ds\Main\ClassAdmin;
use WPDT\Ds\Main\ClassFrontend;

/*
 * Constants Calls
 * @since 1.0.0 (if available)
 */
define('WPDT_OPTION', 'plugin_domain_translate');

/*
 * Default Plugin activate hooks. Started as a static class functions
 *
 * @since 1.0.0 (if available)
 */
register_activation_hook(__FILE__, ['WPDT\Ds\Main\ClassAdmin', 'activate']);

/*
 * Default Plugin deactivate hooks. Started as a static class functions
 *
 * @since 1.0.0 (if available)
 */
register_deactivation_hook(__FILE__, ['WPDT\Ds\Main\ClassAdmin', 'deactivate']);

// Register to start the Plugin

add_action('init', 'myridia_wpdt_plugin_init', 80);
add_action('admin_init', 'myridia_wpdt_plugin_admin_init', 99);

/**
 * Init the Admin Plugin .
 *
 * Init ClassAdmin and register the settings
 *
 * @since 1.0.0
 */
function myridia_wpdt_plugin_admin_init()
{
    $plugin = new ClassAdmin();
    $plugin->register_settings();
    // $plugin->key();
}

/**
 * Init the User Front Plugin.
 *
 * Init ClassAdmin,ClassFrontend
 *
 * @since 1.0.0
 */
function myridia_wpdt_plugin_init()
{
    $plugin = new ClassAdmin();
    $plugin->add_menu_setting();
    $plugin2 = new ClassFrontend();
}

/*
 * Register Classes
 *
 *  Register a PHP Class with Namespace
 *
 * @since 1.0.0
 * @param String $className
 */
spl_autoload_register(function (string $className) {
    if (false === strpos($className, 'WPDT\\Ds')) {
        return;
    }
    $className = str_replace('WPDT\\Ds\\', __DIR__.'/src/', $className);
    $classFile = str_replace('\\', '/', $className).'.php';
    require_once $classFile;
});
