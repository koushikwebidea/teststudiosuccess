<?php
namespace UiCore;
defined('ABSPATH') || exit();
/**
 * UiCore Utils Functions
 */
class Helper
{
    /**
     * Page Option Setting filter
     *
     * @param  string $setting - page option setting name
     * @param  string $global_setting - Theme options setting name
     * @param  string $default - default value
     * @param  mixed $post - Post ID
     *
     * @return string // setting value
     */
    public static function po($setting, $global_setting, $default, $post)
    {
        //Check if is blog and get the meta from blog page
        $is_blog =
			is_search() ||
            is_post_type_archive('post') ||
            is_home() ||
            is_category() ||
            is_day() ||
            is_month() ||
            is_author() ||
            is_year() ||
            is_tag();
        if ($is_blog) {
            $post = get_option('page_for_posts');
        }
        //Check if is Portfolio and get the meta from blog page
        $is_portfolio = is_post_type_archive('portfolio') || is_tax('portfolio_category');
        if ($is_portfolio) {
            $page = self::get_option('portfolio_page');

            if (isset($page['id'])) {
                $post = $page['id'];
            }
        }

        //Extra Check for using woocomerce functions
        if (class_exists('WooCommerce')) {
            $is_shop = is_product_taxonomy() || is_shop();
            if ($is_shop) {
                $post = get_option('woocommerce_shop_page_id');
            }
        }

        $meta = get_post_meta($post, 'page_options', true);

        //if is false don't look for it
        if($global_setting){
            $global_setting = self::get_option($global_setting);
        }

        if (!Helper::isJson($meta)) {
            if(!$global_setting){
                return $default;
            }else{
                return $global_setting;
            }
        } else {
            $meta = json_decode($meta, true);

            if (isset($meta[$setting])) {
                if ($meta[$setting] == 'theme default') {
                    if(!$global_setting){
                        return $default;
                    }else{
                        return $global_setting;
                    }
                }
                if ($meta[$setting] == 'enable') {
                    return 'true';
                }
                if ($meta[$setting] == 'disable') {
                    return 'false';
                }
                if ($meta[$setting] == '') {
                    if(!$global_setting){
                        return $default;
                    }else{
                        return $global_setting;
                    }
                } else {
                    return $meta[$setting];
                }
            } else {
                if(!$global_setting){
                    return $default;
                }else{
                    return $global_setting;
                }
            }
        }
    }

    /**
     * isJson - Check if sting is Json
     *
     * @param  mixed $string
     *
     * @return bolean
     */
    public static function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public static function get_separator()
    {
        return '<span class="uicore-meta-separator"></span>';
    }

    public static function delete_frontend_transients()
    {
        delete_transient('uicore_pages'); //pages list for Theme Option
        delete_transient('uicore-main-menu');
        delete_transient('uicore-footer-markup');
        delete_transient('uicore-social-markup');
        delete_transient('uicore-style');
        delete_transient('uicore-style-json');
        if (function_exists('sg_cachepress_purge_cache')) {
            sg_cachepress_purge_cache();
        }
    }

    public static function parse_css($css)
    {
        preg_match_all( '/(?ims)([a-z0-9\s\.\:#_\-@,]+)\{([^\}]*)\}/', $css, $arr);
        $result = array();
        foreach ($arr[0] as $i => $x){
            $selector = trim($arr[1][$i]);
            $rules = explode(';', trim($arr[2][$i]));
            $rules_arr = array();
            foreach ($rules as $strRule){
                if (!empty($strRule)){
                    $rule = explode(":", $strRule);
                    $rules_arr[trim($rule[0])] = trim($rule[1]);
                }
            }

            $selectors = explode(',', trim($selector));
            foreach ($selectors as $strSel){
                $result[$strSel] = $rules_arr;
            }
        }
        return $result;

    }

    	/**
	 * Return Theme options.
	 *
	 * @param  string $option       Option key.
	 * @param  string $default      Option default value.
	 * @param  string $deprecated   Option default value.
	 * @return Mixed               Return option value.
	 */
	static function get_option( $option, $default = '') {

		$theme_options = ThemeOptions::get_front_options_all();

		$value = ( isset( $theme_options[ $option ] ) && '' !== $theme_options[ $option ] ) 
        ? $theme_options[ $option ] 
        : $default;

		return apply_filters( "uicore_get_option_{$option}", $value, $option, $default );
	}

    static function is_full()
    {
        if(function_exists('tutor_utils')){
            global $wp_query;

            if ( ! empty($wp_query->query['tutor_student_username'])){
                return true;
            }
            if(is_singular(['lesson', 'tutor_quiz']) ){
                return true;
            }
            $dashboard_page = (int) tutor_utils()->get_option('tutor_dashboard_page_id');
            if($dashboard_page  === get_the_ID()){
                return true;
            }
        }

        return false;
    }

    /**
     * Retrive the actual css color value (filter globals)
     *
     * @param string $color
     * @return void
     * @author Andrei Voica <andrei@uicore.co>
     * @since 3.2.2
     */
    static function get_css_color($color, $fallback = null)
    {
        if(!$color){
            return self::get_css_color($fallback);
        }
        $globals = ['Primary', 'Secondary', 'Accent', 'Headline', 'Body', 'Dark Neutral', 'Light Neutral'];
        if(in_array($color, $globals)){
            $set = strtolower( $color[0] ) . 'Color';
            $color = Helper::get_option($set);
        }
        return $color;
    }

}
