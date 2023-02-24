<?php
namespace UiCore;
defined('ABSPATH') || exit();

/**
 * Brisk Core Utils Functions
 */
class Utils
{

    const NO_PAGE_OPTIONS = [
        'attachment',
        'revision',
        'nav_menu_item',
        'custom_css',
        'customize_changeset',
        'elementor_library',
        'metform-form',
        'metform-entry',
        'elementor_icons',
        'elementor_font',
        'uicore-tb',
        'shop_order'
    ];
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->register_sidebars();
        $this->register_top_bar_menu();
        $this->register_custom_meta();
        add_action('init', [$this, 'register_portfolio'], 0);
        add_shortcode('year', [$this, 'year_shortcode']);
        add_shortcode('uicore-socials', [$this, 'social_icons_shortcode']);
        add_shortcode('uicore-icon', [$this, 'frontend_icons_shortcode']);
        add_action('admin_bar_menu', [$this, 'admin_bar_menu_to'], 98);
        //maintenance mode
        if (Helper::get_option('gen_maintenance', 'false') == 'true') {
            add_action('admin_bar_menu', [$this, 'admin_bar_menu_maintenance'], 99);
        }

        //Menu
        add_post_type_support( 'nav_menu_item', array( 'thumbnail' ) );
        add_filter( 'wp_setup_nav_menu_item',[$this, 'simple_megamenu'] );
    }

    /**
     * Register Admin Bar Menu
     *
     * @return void
     * @author Andrei Voica <andrei@uicore.co
     * @since 1.0.0
     */
    public function admin_bar_menu_to($admin_bar)
    {
        $capability = 'manage_options';
        $slug = 'uicore';

        $menu_id = 'uicore-to';
        // prettier-ignore
        if (current_user_can($capability)) {
            $admin_bar->add_menu(array('id' => $menu_id, 'title' => __('Theme Options', 'uicore-framework'), 'href' => '#'));
            $admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('General Settings', 'uicore-framework'), 'id' => 'uicore-general', 'href' => admin_url( 'admin.php?page=' . $slug . '#/general' ) ));
            $admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('Branding', 'uicore-framework'), 'id' => 'uicore-brandingl', 'href' => admin_url( 'admin.php?page=' . $slug . '#/branding' ) ));
            $admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('Top Banner', 'uicore-framework'), 'id' => 'uicore-rop-banner', 'href' => admin_url( 'admin.php?page=' . $slug . '#/top-banner' ) ));
            $admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('Header', 'uicore-framework'), 'id' => 'uicore-header', 'href' => admin_url( 'admin.php?page=' . $slug . '#/header' ) ));
            $admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('Footer', 'uicore-framework'), 'id' => 'uicore-footer', 'href' => admin_url( 'admin.php?page=' . $slug . '#/footer' ) ));
            $admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('Page Title', 'uicore-framework'), 'id' => 'uicore-pt', 'href' => admin_url( 'admin.php?page=' . $slug . '#/page-title' ) ));
            $admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('Blog', 'uicore-framework'), 'id' => 'uicore-blog', 'href' => admin_url( 'admin.php?page=' . $slug . '#/blog' ) ));
            $admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('Portfolio', 'uicore-framework'), 'id' => 'uicore-portfolio', 'href' => admin_url( 'admin.php?page=' . $slug . '#/portfolio' ) ));
            $admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('WooCommerce', 'uicore-framework'), 'id' => 'uicore-woo', 'href' => admin_url( 'admin.php?page=' . $slug . '#/woocommerce' ) ));
            $admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('Social', 'uicore-framework'), 'id' => 'uicore-social', 'href' => admin_url( 'admin.php?page=' . $slug . '#/social' ) ));
            $admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('Custom', 'uicore-framework'), 'id' => 'uicore-custom', 'href' => admin_url( 'admin.php?page=' . $slug . '#/custom' ) ));
        }
    }

    /**
     * Add Maintenance notice for loged in users
     *
     * @param array $classes
     * @return array $classes
     * @author Andrei Voica <andrei@uicore.co
     * @since 1.0.0
     */
    function admin_bar_menu_maintenance($admin_bar)
    {
        $page_id = Helper::get_option('gen_maintenance_page')['id'];
        $admin_bar->add_menu([
            'id' => 'my-item',
            'title' => 'Maintenance Mode is ON',
            'href' => '#',
            'meta' => [
                'title' => __('Maintenance Mode is ON'),
            ],
        ]);
        //If is not Default
        if ($page_id != 0) {
            $admin_bar->add_menu([
                'id' => 'my-sub-item',
                'parent' => 'my-item',
                'title' => 'View Maintenance Page',
                'href' => get_post_permalink($page_id),
                'meta' => [
                    'title' => __('View Maintenance Page'),
                    'target' => '_blank',
                    'class' => 'my_menu_item_class',
                ],
            ]);
        }
        $admin_bar->add_menu([
            'id' => 'my-second-sub-item',
            'parent' => 'my-item',
            'title' => 'View Maintenance Settings',
            'href' => get_site_url(null, 'wp-admin/admin.php?page=uicore#/general#set-10'),
            'meta' => [
                'title' => __('View Maintenance Settings'),
                'target' => '_blank',
                'class' => 'my_menu_item_class',
            ],
        ]);
    }

    /**
     * Register all sidebar needed for pages/posts and all footer columns
     *
     * @return void
     */
    function register_sidebars()
    {
        //Register Header Drawer
        $header_drawer = Helper::get_option('header_side_drawer');

        if ($header_drawer == 'true') {
            register_sidebar([
                'name' => 'Sliding Drawer',
                'id' => 'uicore-drawer',
                'before_widget' => '<div class="ui-drawer-widget uicore-widget">',
                'after_widget' => '</div>',
            ]);
        }
        //Register Header Custom Area
        $header_custom_desktop = Helper::get_option('header_custom_desktop');
        $header_custom_mobile = Helper::get_option('header_custom_mobile');

        if ($header_custom_desktop == 'true' || $header_custom_mobile == 'true') {
            register_sidebar([
                'name' => 'Header Custom Area',
                'id' => 'uicore-hca',
                'before_widget' => '<div class="uicore-hca">',
                'after_widget' => '</div>',
                'before_title' => '<p class="uicore-hca-title">',
                'after_title' => '</p>',
            ]);
        }

        //get the footer column number
        $layout = Helper::get_option('footer_layout', 'five');

        //register footer 1 column
        register_sidebar([
            'name' => 'Footer Col 1',
            'id' => 'footer-1',
            'before_widget' => '<div class="uicore-footer-widget">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="uicore-footer-title">',
            'after_title' => '</h4>',
        ]);
        //register footer 2 column
        if ($layout != 'one') {
            register_sidebar([
                'name' => 'Footer Col 2',
                'id' => 'footer-2',
                'before_widget' => '<div class="uicore-footer-widget">',
                'after_widget' => '</div>',
                'before_title' => '<h4 class="uicore-footer-title">',
                'after_title' => '</h4>',
            ]);
        }
        //register footer 3 column
        if ($layout != 'two' && $layout != 'two_left' && $layout != 'two_right' && $layout != 'one') {
            register_sidebar([
                'name' => 'Footer Col 3',
                'id' => 'footer-3',
                'before_widget' => '<div class="uicore-footer-widget">',
                'after_widget' => '</div>',
                'before_title' => '<h4 class="uicore-footer-title">',
                'after_title' => '</h4>',
            ]);
        }
        //register footer 4 column
        if (
            $layout == 'four' ||
            $layout == 'five_left' ||
            $layout == 'five_right' ||
            $layout == 'five' ||
            $layout == 'four_left' ||
            $layout == 'four_right' ||
            $layout == 'four_left_2' ||
            $layout == 'four_right_2'
        ) {
            register_sidebar([
                'name' => 'Footer Col 4',
                'id' => 'footer-4',
                'before_widget' => '<div class="uicore-footer-widget">',
                'after_widget' => '</div>',
                'before_title' => '<h4 class="uicore-footer-title">',
                'after_title' => '</h4>',
            ]);
        }
        //register footer 5 column
        if ($layout == 'five' || $layout == 'five_left' || $layout == 'five_right') {
            register_sidebar([
                'name' => 'Footer Col 5',
                'id' => 'footer-5',
                'before_widget' => '<div class="uicore-footer-widget">',
                'after_widget' => '</div>',
                'before_title' => '<h4 class="uicore-footer-title">',
                'after_title' => '</h4>',
            ]);
        }
        //register Blog Post Sidebar
        register_sidebar([
            'name' => 'Blog Post',
            'id' => 'blog-sidebar',
            'before_widget' => '<div class="uicore-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="uicore-widget-title">',
            'after_title' => '</h4>',
        ]);
        //register Blog Archive Sidebar
        register_sidebar([
            'name' => 'Blog Archive',
            'id' => 'blog-post-sidebar',
            'before_widget' => '<div class="uicore-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="uicore-widget-title">',
            'after_title' => '</h4>',
        ]);
        //register Portfolio Post Sidebar
        register_sidebar([
            'name' => 'Portfolio Post',
            'id' => 'portfolio-sidebar',
            'before_widget' => '<div class="uicore-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="uicore-widget-title">',
            'after_title' => '</h4>',
        ]);
        //register Portfolio Archive Sidebar
        register_sidebar([
            'name' => 'Portfolio Archive',
            'id' => 'portfolio-post-sidebar',
            'before_widget' => '<div class="uicore-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="uicore-widget-title">',
            'after_title' => '</h4>',
        ]);
        //register WooCommerce Sidebar
        register_sidebar([
            'name' => 'WooCommerce Shop',
            'id' => 'woo-sidebar',
            'before_widget' => '<div class="uicore-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="uicore-widget-title">',
            'after_title' => '</h4>',
        ]);
        //register WooCommerce Product Sidebar
        register_sidebar([
            'name' => 'WooCommerce Product',
            'id' => 'woo-product-sidebar',
            'before_widget' => '<div class="uicore-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="uicore-widget-title">',
            'after_title' => '</h4>',
        ]);
    }

    /**
     * Register The top bar menu positions
     *
     * @return void
     */
    public function register_top_bar_menu()
    {
        register_nav_menus([
            'uicore-menu-one' => __('Top Bar Column One','uicore-framework'),
            'uicore-menu-two' => __('Top Bar Column Two','uicore-framework'),
        ]);
    }

    /**
     * Register Custom Post for Portfolio
     *
     * @return void
     */
    function register_portfolio()
    {
        $name =  __('Portfolio', 'Frontend - Portfolio name default', 'uicore-framework');
        $slug =  __('portfolio', 'Frontend - Portfolio slug default', 'uicore-framework');

        $portfolio_page = Helper::get_option('portfolio_page');
        if(isset($portfolio_page['id']) && $portfolio_page['id'] != '0'){
            $slug = get_post_field( 'post_name', $portfolio_page['id'] );
            $name =  get_post_field( 'post_title', $portfolio_page['id'] );
        }

        //last chance
        $slug = apply_filters( 'uicore_portfolio_slug', $slug );
        $category_slug = apply_filters( 'uicore_portfolio_category_slug', $slug.'-category' );

        register_taxonomy(
            'portfolio_category',
            [],
            [
                'hierarchical' => true,
                // 'labels' => $portfolio_cats,
                'show_ui' => true,
                'show_admin_column' => true,
                'query_var' => true,
                'show_in_rest' => true,
                'rewrite' => ['slug' => $category_slug ],
            ]
        );

        register_post_type('portfolio', [
            'labels' => [
                'name' => $name,
                'singular_name' => $name,
            ],
            'has_archive' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'taxonomies' => ['portfolio_category'],
            'menu_icon' => 'dashicons-format-gallery',
            'public' => true,
            'rewrite' => ['slug' => $slug],
            'show_in_rest' => true,
            'supports' => [
                'title',
                'editor',
                'excerpt',
                'author',
                'thumbnail',
                'comments',
                'revisions',
                'custom-fields',
                'permalinks',
                'featured_image',
				'page-attributes',
            ],
        ]);

        if(get_option('uicore_needs_flush')){
            flush_rewrite_rules();
            delete_option('uicore_needs_flush');
        }
    }

    /**
     * Call the functions used for page description [meta-box]
     *
     * @return void
     */
    function register_custom_meta()
    {
        add_action('admin_head', [$this, 'add_page_meta']);
        add_action('save_post', [$this, 'save_page_meta']);
    }

    /**
     * Add Page Description Meta Box
     *
     * @return void
     */
    function add_page_meta()
    {
        $post_types = get_post_types( [], 'names' );
        foreach(self::NO_PAGE_OPTIONS as $type){
            if(isset($post_types[$type])){
                unset($post_types[$type]);
            }
        }
        add_meta_box(
            'page_options', // $id
            'Page Options', // $title
            [$this, 'show_page_options'], // $callback
            $post_types,
            'advanced', // $context
            'low' // $priority
        );
        add_meta_box(
            'page_description', // $id
            'Page Description', // $title
            [$this, 'show_page_description'], // $callback
            ['page'],
            'advanced', // $context
            'high' // $priority
        );
    }

    /**
     * Show Page Description Input in Page/Post Editor
     *
     * @return void
     */
    function show_page_description()
    {
        global $post;

        $meta = get_post_meta($post->ID, 'page_description', true);
        ?>
        <input type="hidden" name="uicore_meta_box_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>">
        <p>
            <textarea name="page_description" id="page_description" rows="5" cols="30" style="width:100%;"><?php echo $meta; ?></textarea>
        </p>
        <?php

    }

    /**
     * Show Page Description Input in Page/Post Editor
     *
     * @return void
     */
    function show_page_options()
    {
        global $post;

        $meta = get_post_meta($post->ID, 'page_options', true);
        //prettier-ignore
        ?>

        <script>
        window.uicore_post_type = '<?php echo $post->post_type ?>'
        </script>
        <input type="hidden" name="uicore_meta_box_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>">

        <input type="hidden" name="page_options_holder" id="uicore_page_options" value="<?php echo esc_attr($meta); ?>">
        <div id="page_options_wrapper"></div>
        <?php

    }

    /**
     * Save Page Description
     *
     * @param  mixed $post_id
     *
     * @return void
     */
    function save_page_meta($post_id)
    {
        // verify nonce
        if (
            isset($_POST['uicore_meta_box_nonce']) &&
            !wp_verify_nonce($_POST['uicore_meta_box_nonce'], basename(__FILE__))
        ) {
            return $post_id;
        }
        // check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }
        // check permissions
        // if (!current_user_can('edit_page', $post_id)) {
        //     return $post_id;
        // } elseif (!current_user_can('edit_post', $post_id)) {
        //     return $post_id;
        // }

        $old_description = get_post_meta($post_id, 'page_description', true);
        $old_options = get_post_meta($post_id, 'page_options', true);
        if (isset($_POST['page_description'])) {
            $new_description = $_POST['page_description'];

            if ($new_description && $new_description !== $old_description) {
                update_post_meta($post_id, 'page_description', $new_description);
            } elseif ('' === $new_description && $old_description) {
                delete_post_meta($post_id, 'page_description', $old_description);
            }
        }
        if (isset($_POST['page_options'])) {
            $new_option = $_POST['page_options'];

            if ($new_option && $new_option !== $old_options) {
                update_post_meta($post_id, 'page_options', $new_option);
            } elseif ('' === $new_option && $old_options) {
                delete_post_meta($post_id, 'page_options', $old_options);
            }
        }

    }


    /**
     *  Get The html with all the social icons that have a link
     *
     * @param array $settings
     * @return void
     * @author Andrei Voica <andrei@uicore.co>
     * @since 1.0.0
     */
    public static function get_social_icons()
    {
        $icons = [
            'social_fb'         => 'Facebook',
            'social_tw'         => 'Tweeter',
            'social_yt'         => 'Youtube',
            'social_in'         => 'Instagram',
            'social_lk'         => 'LinkedIn',
            'social_pn'         => 'Pinterest',
            'social_th'         => 'Twitch',
            'social_snapchat'   => 'Snapchat',
            'social_reddit'     => 'Reddit',
            'social_tiktok'     => 'Tiktok',
            'social_whatsapp'   => 'Whatsapp',
            'social_vimeo'      => 'Vimeo',
            'social_wechat'     => 'WeChat',
            'social_messenger'  => 'Messenger',
            'social_discord'    => 'Discord',
            'social_telegram'   => 'Telegram',
            'social_opensea'   => 'OpenSea'
        ];

        $socials = '';


        //just to be sure that settings exist
        foreach ($icons as $icon=>$name) {
            if ($url = Helper::get_option($icon)) {
                $socials .=
                    '<a class="uicore-social-icon uicore-link ' .
                    $icon .
                    '" href="' .
                    esc_url($url) .
                    '" target="_blank" aria-label="'.$name.'"></a>';
            }
        }
        return apply_filters('uicore-socials-markup', $socials);
    }

    /**
     * [year]
     *
     * @return void
     * @author Andrei Voica <andrei@uicore.co>
     * @since 1.0.0
     */
    public function year_shortcode()
    {
        $year = date('Y');
        return $year;
    }

    /**
     * [socials size=16px]
     *
     * @param [type] $atts
     * @return void
     * @author Andrei Voica <andrei@uicore.co>
     * @since 1.0.0
     */
    public function social_icons_shortcode($atts)
    {
        $a = shortcode_atts(
            [
                'size' => '100%',
            ],
            $atts
        );
        $pre = '<span class="uicore-socials-shortcode" style="font-size:' . $a['size'] . '">';
        $icons = Utils::get_social_icons();
        $after = '</span>';
        $socials = $pre . $icons . $after;
        return $socials;
    }

    /**
     * [uicore-icon icon=globe]Example[/uicore-icon]
     *
     * @param [type] $atts
     * @param [type] $content
     * @return void
     * @author Andrei Voica <andrei@uicore.co>
     * @since 1.0.0
     */
    public function frontend_icons_shortcode($atts, $content = null)
    {
        $data = shortcode_atts(
            [
                'icon' => 'globe',
                'size' => '100%',
                'color' => 'inherit',
                'left' => '0',
                'right' => '0',
            ],
            $atts
        );
        $html = '';

        $class = 'class="uicore-i-' . $data['icon'] . '"';
        $style =
            'style="font-size:' .
            $data['size'] .
            '; color:' .
            $data['color'] .
            '; padding-left:' .
            $data['left'] .
            '; padding-right:' .
            $data['right'] .
            ';"';
        $html .= '<i ' . $class . ' ' . $style . ' ></i>';

        if ($content != null) {
            $html = '<span class="uicore-icon-wrapp">' . $html . $content . '</span>';
        }

        return $html;
    }


    function simple_megamenu($menu_item)
    {
        $menu_item->mega = get_post_meta( $menu_item->ID, '_menu_item_mega', true );
        return $menu_item;
    }

}

new Utils();
