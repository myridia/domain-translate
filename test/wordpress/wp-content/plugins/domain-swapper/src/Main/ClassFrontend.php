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
    private $siteurl;
    private $new_siteurl;
    private $new_domain;
    private $old_domain;
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
            if ($this->new_siteurl != $this->siteurl) {
                // error_log('....start swapping');
                add_filter('option_siteurl', [$this, 'swap_siteurl']);
                add_filter('style_loader_src', [$this, 'swap_style_loader_src'], 10, 4);
                add_filter('script_loader_src', [$this, 'swap_script_loader_src'], 10, 4);
                add_filter('template_directory_uri', [$this, 'swap_template_directory_uri']);
                add_filter('get_canonical_url', [$this, 'swap_get_canonical_url'], 10, 2);
                add_filter('pre_get_shortlink', [$this, 'swap_pre_get_shortlink'], 10, 4);
                add_filter('the_content', [$this, 'swap_the_content'], 1);
                add_filter('home_url', [$this, 'swap_home_url'], 10, 4);
                add_filter('site_url', [$this, 'swap_site_url'], 10, 4);
                add_filter('wp_setup_nav_menu_item', [$this, 'swap_wp_setup_nav_menu_item']);
                add_filter('plugins_url', [$this, 'swap_plugin_url']);
                add_filter('wp_resource_hints', [$this, 'swap_prefetch_resource'], 10, 2);
                add_filter('wp_get_attachment_image_attributes', [$this, 'swap_attachment_image_attributes'], 10, 3);
                add_filter('woocommerce_gallery_image_html_attachment_image_params', [$this, 'swap_woocommerce_gallery_image_html_attachment_image_params'], 10, 4);
                add_filter('wp_script_attributes', [$this, 'swap_wp_script_attributes'], 10, 2);
                add_action('template_redirect', [$this, 'swap_template_redirect']);
                add_filter('woocommerce_store_api_cart_item_images', [$this, 'swap_woocommerce_store_api_cart_item_images'], 10, 3);
            }
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
        $this->siteurl = get_option('siteurl');
        $this->new_siteurl = $this->siteurl;

        $this->old_domain = str_replace('https://', '', get_option('siteurl'));
        $this->old_domain = str_replace('http://', '', $this->old_domain);

        $new_domain = str_replace('https://', '', $this->new_siteurl);
        $new_domain = str_replace('http://', '', $new_domain);

        if (isset($_SERVER['HTTP_HOST'])) {
            $unslashed = sanitize_text_field(wp_unslash($_SERVER['HTTP_HOST']));
            if ('' != $unslashed) {
                $new_domain = $unslashed;
            }
        } elseif (isset($_SERVER['SERVER_NAME'])) {
            $unslashed = sanitize_text_field(wp_unslash($_SERVER['SERVER_NAME']));
            if ('' != $unslashed) {
                $new_domain = $unslashed;
            }
        }

        if (in_array($new_domain, $this->domains)) {
            $this->new_siteurl = 'https://'.$new_domain;
            $this->new_domain = $new_domain;
        }
    }

    /**
     * Overwrite filter hook woocommerce_store_api_cart_item_images.
     *
     * https://developer.wordpress.org/reference/hooks/woocommerce_store_api_cart_item_images
     *
     * @since 1.0.0
     *
     * @return array $produt_images
     */
    public function swap_woocommerce_store_api_cart_item_images($product_images, $cart_item, $cart_item_key)
    {
        foreach ($product_images as $k => $v) {
            $product_images[$k]->src = str_replace($this->siteurl, $this->new_siteurl, $v->src);
            $product_images[$k]->thumbnail = str_replace($this->siteurl, $this->new_siteurl, $v->thumbnail);
            $product_images[$k]->srcset = str_replace($this->siteurl, $this->new_siteurl, $v->srcset);
        }

        return $product_images;
    }

    /**
     * Overwrite filter hook template_redirect.
     *
     * https://developer.wordpress.org/reference/hooks/template_redirect
     *
     * @since 1.0.0
     *
     * @return string $html
     */
    public function swap_template_redirect()
    {
        ob_start(function ($html) {
            $html = str_replace($this->siteurl, $this->new_siteurl, $html);

            // Maybe it can taken out, wait and make more tests
            // $html = str_replace($this->old_domain, $this->new_domain, $html);

            // error_log($html);
            return $html;
        });
    }

    /**
     * Overwrite filter hook wp_script_attributes.
     *
     * https://developer.wordpress.org/reference/hooks/wp_script_attributes
     *
     * @since 1.0.0
     *
     * @return array $attr
     */
    public function swap_wp_script_attributes(array $attr)
    {
        $attr['src'] = str_replace($this->siteurl, $this->new_siteurl, $attr['src']);

        return $attr;
    }

    /**
     * Overwrite filter hook woocommerce_gallery_image_html_attachment_image_params.
     *
     * https://developer.wordpress.org/reference/hooks/woocommerce_gallery_image_html_attachment_image_params
     *
     * @since 1.0.0
     *
     * @return array $params
     */
    public function swap_woocommerce_gallery_image_html_attachment_image_params($params, $attachment_id, $post_id, $image_class)
    {
        $params['data-src'] = str_replace($this->siteurl, $this->new_siteurl, $params['data-src']);
        $params['data-large_image'] = str_replace($this->siteurl, $this->new_siteurl, $params['data-large_image']);

        return $params;
    }

    /**
     * Overwrite filter hook attachment_image_attributes.
     *
     * https://developer.wordpress.org/reference/hooks/attachment_image_attributes
     *
     * @since 1.0.0
     *
     * @return array $att
     */
    public function swap_attachment_image_attributes($attr, $attachment, $size)
    {
        $attr['srcset'] = str_replace($this->siteurl, $this->new_siteurl, $attr['srcset']);
        $attr['src'] = str_replace($this->siteurl, $this->new_siteurl, $attr['src']);

        return $attr;
    }

    /**
     * Overwrite filter hook prefetch_resource.
     *
     * https://developer.wordpress.org/reference/hooks/prefetch_resource
     *
     * @since 1.0.0
     *
     * @return array $url
     */
    public function swap_prefetch_resource($urls, $relation_type)
    {
        if ('prefetch' === $relation_type) {
            foreach ($urls as $k => $v) {
                $urls[$k]['href'] = str_replace($this->siteurl, $this->new_siteurl, $v['href']);
            }
        }

        return $urls;
    }

    /**
     * Overwrite filter hook style_loader_src.
     *
     * https://developer.wordpress.org/reference/hooks/style_loader_src
     *
     * @since 1.0.0
     *
     * @return string $new_url
     */
    public function swap_style_loader_src($url)
    {
        $new_url = $url;
        $src_parse = wp_parse_url($url);
        if (isset($src_parse['host']) && isset($src_parse['scheme'])) {
            $host = $src_parse['scheme'].'://'.$src_parse['host'];

            if (isset($src_parse['port'])) {
                $host = $host.':'.$src_parse['port'];
            }

            if ($host == $this->siteurl) {
                $new_url = str_replace($this->siteurl, $this->new_siteurl, $url);
            }
        }
        $new_url = str_replace('http://', 'https://', $new_url);
        $new_url = str_replace($this->siteurl, $this->new_siteurl, $new_url);

        return $new_url;
    }

    /**
     * Overwrite filter hook script_loader_src.
     *
     * https://developer.wordpress.org/reference/hooks/script_loader_src
     *
     * @since 1.0.0
     *
     * @return string $html
     */
    public function swap_script_loader_src($url)
    {
        $new_url = $url;
        $src_parse = wp_parse_url($url);
        if (isset($src_parse['host'])) {
            $host = $src_parse['scheme'].'://'.$src_parse['host'];

            if (isset($src_parse['port'])) {
                $host = $host.':'.$src_parse['port'];
            }

            if ($host == $this->siteurl) {
                $new_url = str_replace($this->siteurl, $this->new_siteurl, $url);
            }
        }
        $new_url = str_replace('http://', 'https://', $new_url);
        $new_url = str_replace($this->siteurl, $this->new_siteurl, $new_url);

        return $new_url;
    }

    /**
     * Overwrite filter hook plugin_url.
     *
     * https://developer.wordpress.org/reference/hooks/plugin_url
     *
     * @since 1.0.0
     *
     * @return string $url
     */
    public function swap_plugin_url($url)
    {
        // https://developer.wordpress.org/reference/hooks/plugin_url
        $url = str_replace($this->siteurl, $this->new_siteurl, $url);

        return $url;
    }

    /**
     * Overwrite filter hook wp_setup_nav_menu_item.
     *
     * https://developer.wordpress.org/reference/hooks/wp_setup_nav_menu_item
     *
     * @since 1.0.0
     *
     * @return string $menu_item
     */
    public function swap_wp_setup_nav_menu_item($menu_item)
    {
        $menu_item->url = str_replace($this->siteurl, $this->new_siteurl, $menu_item->url);

        return $menu_item;
    }

    /**
     * Overwrite filter hook site_url.
     *
     * https://developer.wordpress.org/reference/hooks/site_url
     *
     * @since 1.0.0
     *
     * @return string $url
     */
    public function swap_site_url($url, $path, $orig_scheme, $blog_id)
    {
        // https://developer.wordpress.org/reference/hooks/swap_site_url/
        if ($this->siteurl == $url) {
        } else {
            $url = str_replace('http://', 'https://', $url);
        }

        return $url;
    }

    /**
     * Overwrite filter hook home_url.
     *
     * https://developer.wordpress.org/reference/hooks/home_url
     *
     * @since 1.0.0
     *
     * @return string $url
     */
    public function swap_home_url($url, $path, $orig_scheme, $blog_id)
    {
        // https://developer.wordpress.org/reference/hooks/home_url/
        if ($this->siteurl == $url) {
        } else {
            $url = str_replace($this->siteurl, $this->new_siteurl, $url);
        }

        return $url;
    }

    /**
     * Overwrite filter hook the_content.
     *
     * https://developer.wordpress.org/reference/hooks/the_content
     *
     * @since 1.0.0
     *
     * @return string $content
     */
    public function swap_the_content($content)
    {
        if (is_singular() && in_the_loop() && is_main_query()) {
            $new_content = str_replace($this->siteurl, $this->new_siteurl, $content);

            return $new_content;
        }

        return $content;
    }

    /**
     * Overwrite filter hook get_shortlink.
     *
     * https://developer.wordpress.org/reference/hooks/get_shortlink
     *
     * @since 1.0.0
     *
     * @return string $shortlink
     */
    public function swap_pre_get_shortlink($shortlink, $id, $context, $allow_slugs)
    {
        if (0 == strlen($shortlink) && '' != $this->new_siteurl) {
            $shortlink = $this->new_siteurl;
        } elseif ('' != $this->new_siteurl) {
            $shortlink = str_replace($this->siteurl, $this->new_siteurl, $shortlink);
        }

        return $shortlink;
    }

    /**
     * Overwrite filter hook get_canonical_url.
     *
     * https://developer.wordpress.org/reference/hooks/get_canonical_url
     *
     * @since 1.0.0
     *
     * @return string $url
     */
    public function swap_get_canonical_url($url, $post)
    {
        $url = str_replace($this->siteurl, $this->new_siteurl, $url);

        return $url;
    }

    /**
     * Overwrite filter hook template_directory_uri.
     *
     * https://developer.wordpress.org/reference/hooks/template_directory_uri
     *
     * @since 1.0.0
     *
     * @return string $url
     */
    public function swap_template_directory_uri($url)
    {
        // https://developer.wordpress.org/reference/hooks/template_directory_uri/
        $url = str_replace($this->siteurl, $this->new_siteurl, $url);

        return $url;
    }

    /**
     * Overwrite filter hook siteurl.
     *
     * https://developer.wordpress.org/reference/hooks/siteurl
     *
     * @since 1.0.0
     *
     * @return string $url
     */
    public function swap_siteurl($url)
    {
        if ('' != $this->new_siteurl) {
            if (!defined('WP_SITEURL')) {
                define('WP_SITEURL', $this->new_siteurl);
            }

            $url = $this->new_siteurl;
        }

        return $url;
    }
}
