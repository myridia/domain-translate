=== Domain-translate ===
Contributors: veto
Tags: translate domains, google translate, automatic translate
Requires PHP: 8.2.0
Requires at least: 6.7
Tested up to: 6.8
Stable Tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Plugin URI: **https://domain-translate.myridia.com/**

Automatically translate your Site based on your Domain, a source and target Language.          

== Description ==

Automatic Website Translation: Integrates directly with the Google Translate JavaScript API to provide instant, machine-powered translation of your entire WordPress website content.[1] This includes posts, pages, widgets, and other dynamic content.[3]
    User-Friendly Interface: The plugin typically adds a customizable translation widget or a floating language selector to your website, allowing visitors to easily choose their preferred language.[4]
    No Database Modifications: Unlike traditional multilingual plugins that store translated content in your database, this plugin translates content dynamically in the user's browser, meaning no additional database tables or content duplication are required.[2] This simplifies maintenance and reduces server load.
    Lightweight and Efficient: By leveraging Google's robust infrastructure, the plugin remains lightweight on your server, as the translation processing occurs client-side.[1]
    Customizable Appearance: Many implementations allow for customization of the translation widget's appearance and placement to seamlessly integrate with your website's design.[4]
    Broad Language Support: Benefits from the extensive language support offered by Google Translate, enabling your website to be translated into a wide array of languages.[3]

How it Works

The plugin injects the Google Translate JavaScript API into your WordPress website's frontend.[1] When a user selects a language from the provided widget or selector, the Google Translate script intercepts the page's content and dynamically translates it in the user's browser.[2] This process happens client-side, meaning the original content on your server remains in its primary language, and the translated version is rendered directly for the end-user.[3]
Installation

    Download the plugin (if applicable, from the WordPress plugin repository or a provided ZIP file).
    Upload the plugin to your WordPress installation via Plugins > Add New > Upload Plugin or by uploading the unzipped folder to the /wp-content/plugins/ directory.[5]
    Activate the plugin through the 'Plugins' menu in WordPress.[5]
    Configure the plugin settings (usually found under Settings > Google Translate or a similar menu item) to customize language options, widget placement, and appearance.[4]

Usage

Once activated and configured, a translation widget or language selector will appear on your website's frontend. Visitors can then select their desired language to view the translated content.[4] The translation is performed automatically by Google Translate.
Limitations

    Machine Translation Accuracy: While Google Translate is highly advanced, machine translations may not always be perfectly accurate or contextually appropriate.[6] Human review for critical content is always recommended.
    SEO Considerations: Since the translation happens client-side, search engines typically index only the original language content of your website.[2] This plugin is primarily for user experience and accessibility, not for improving multilingual SEO. For robust multilingual SEO, dedicated multilingual plugins that store translated content are generally preferred.[7]
    Dynamic Content Challenges: While generally effective, some highly dynamic or JavaScript-rendered content might occasionally present challenges for seamless translation.[3]

Support

For support, please refer to the plugin's documentation or the support forums on WordPress.org (if applicable).





== Frequently Asked Questions ==

= Can I suggest/request a feature to be added? =

Yes, we really need any feedback and requests <a href="mailto:domain-translate@myridia.com">email</a>.

== Changelog ==

