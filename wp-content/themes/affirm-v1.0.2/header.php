<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package uicore-theme
 */

global $post;
defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '5083959578364135');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=5083959578364135&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->








<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-M1TD0PPW8X"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-M1TD0PPW8X');
</script>
</head>

<body <?php body_class(); ?>>
		<?php 
		
		wp_body_open();
		
		if (class_exists('\UiCore\Core')){ 
			do_action( "uicore_before_body_content");
			echo "<!-- 1.1 uicore_before_body_content -->"; 
		}
		?>
	<div class="uicore-body-content">
		<?php 
		if (class_exists('\UiCore\Core')){ 
			do_action( "uicore_before_page_content");
			echo "<!-- 1.2 uicore_before_page_content -->"; 
		}
		?>
		<div id="uicore-page">
		<?php 
		if (class_exists('\UiCore\Core')){ 
			do_action( "uicore_page", $post ); 
			echo "<!-- 1.3 uicore_page -->"; 
			} else {?>
			<header id="masthead" class="site-header">
				<div class="uicore-container">
					<div class="uicore-row">
						<div class="site-branding">
								<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
						</div>

						<nav id="site-navigation" class="main-navigation">
							<div class="menu-toggle"><span></span></div>
							<?php
							wp_nav_menu( array(
								'theme_location' => 'primary',
								'menu_id'        => 'primary-menu',
								'menu_class'     => 'nav-menu'
							) );
							?>
						</nav>
					</div>
				</div>
			</header>
			<div class="ui-page-title">
				<div class="uicore-container">
					<?php
					level_page_title();

					if ( 'post' === get_post_type() ) {
						echo '<div class="entry-meta">';
							if ( is_singular() ) {
							global $post; 
							$author_id=$post->post_author;
							level_posted_by($author_id);
							$categories_list = get_the_category_list( esc_html__( ', ', 'affirm' ) );
							if ( $categories_list ) {
								echo ' • ';
								echo '<span class="cat-links">' . $categories_list . '</span>';
							}
							level_posted_on();
							}
						echo'</div><!-- .entry-meta -->';
					} 
					?>
				</div>
			</div>
			<?php } ?>
			<div id="content" class="uicore-content">

			<?php 
			if (class_exists('\UiCore\Core')){ 
				do_action( "uicore_before_content", $post ); 
				echo "<!-- 1.4 uicore_before_content -->";
			} 
