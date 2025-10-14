```
function gtranslate_scripts()
{
  if(is_admin() == false):
   if( ! in_array(parse_url(get_site_url(), PHP_URL_HOST),['www.shock.se','shock.se']) ):
     $script_js = get_stylesheet_directory_uri() . '/js/gtranslator.js';      
     $script_css = get_stylesheet_directory_uri() . '/css/gtranslator.css';
     $args = array( 
      'in_footer' => true,
      'strategy'  => 'defer',
     );
      wp_enqueue_script( 'gtranslate_js' , $script_js , array(), '1.0',  false );
      wp_enqueue_style( 'gtranslate_css', $script_css , array(), '1.0',  false );    
      wp_enqueue_script( 'google', '//translate.google.com/translate_a/element.js?cb=gtranslate_init' , array(), '1.0',  $args );

   endif;    
  endif;       
}
add_action( 'wp_enqueue_scripts', 'gtranslate_scripts' );

```
