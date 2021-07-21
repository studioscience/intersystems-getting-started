<?php
/**
 * Twenty Eleven functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, twentyeleven_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://developer.wordpress.org/themes/advanced-topics/child-themes/
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'twentyeleven_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see https://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
	$content_width = 584;
}

define( 'THEME_NAME', 'ISC Theme' );
define( 'THEME_VERSION', '1.1.4' );

/*
 * Tell WordPress to run twentyeleven_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'twentyeleven_setup' );

if ( ! function_exists( 'twentyeleven_setup' ) ) :
	/**
	 * Set up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which runs
	 * before the init hook. The init hook is too late for some features, such as indicating
	 * support post thumbnails.
	 *
	 * To override twentyeleven_setup() in a child theme, add your own twentyeleven_setup to your child theme's
	 * functions.php file.
	 *
	 * @uses load_theme_textdomain()    For translation/localization support.
	 * @uses add_editor_style()         To style the visual editor.
	 * @uses add_theme_support()        To add support for post thumbnails, automatic feed links, custom headers
	 *                                  and backgrounds, and post formats.
	 * @uses register_nav_menus()       To add support for navigation menus.
	 * @uses register_default_headers() To register the default custom header images provided with the theme.
	 * @uses set_post_thumbnail_size()  To set a custom post thumbnail size.
	 *
	 * @since Twenty Eleven 1.0
	 */
	function twentyeleven_setup() {

		/*
		 * Make Twenty Eleven available for translation.
		 * Translations can be added to the /languages/ directory.
		 * If you're building a theme based on Twenty Eleven, use
		 * a find and replace to change 'twentyeleven' to the name
		 * of your theme in all the template files.
		 */
		load_theme_textdomain( 'twentyeleven', get_template_directory() . '/languages' );

		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();

		// Load regular editor styles into the new block-based editor.
		add_theme_support( 'editor-styles' );

		// Load default block styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

		// Add support for custom color scheme.
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Blue', 'twentyeleven' ),
					'slug'  => 'blue',
					'color' => '#1982d1',
				),
				array(
					'name'  => __( 'Black', 'twentyeleven' ),
					'slug'  => 'black',
					'color' => '#000',
				),
				array(
					'name'  => __( 'Dark Gray', 'twentyeleven' ),
					'slug'  => 'dark-gray',
					'color' => '#373737',
				),
				array(
					'name'  => __( 'Medium Gray', 'twentyeleven' ),
					'slug'  => 'medium-gray',
					'color' => '#666',
				),
				array(
					'name'  => __( 'Light Gray', 'twentyeleven' ),
					'slug'  => 'light-gray',
					'color' => '#e2e2e2',
				),
				array(
					'name'  => __( 'White', 'twentyeleven' ),
					'slug'  => 'white',
					'color' => '#fff',
				),
			)
		);

		// Load up our theme options page and related code.
		require( get_template_directory() . '/inc/theme-options.php' );

		// Grab Twenty Eleven's Ephemera widget.
		require( get_template_directory() . '/inc/widgets.php' );

		// Add default posts and comments RSS feed links to <head>.
		add_theme_support( 'automatic-feed-links' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menu( 'primary', __( 'Primary Menu', 'twentyeleven' ) );

		// Add support for a variety of post formats
		add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );

		$theme_options = twentyeleven_get_theme_options();
		if ( 'dark' == $theme_options['color_scheme'] ) {
			$default_background_color = '1d1d1d';
		} else {
			$default_background_color = 'e2e2e2';
		}

		// Add support for custom backgrounds.
		add_theme_support(
			'custom-background',
			array(
				/*
				* Let WordPress know what our default background color is.
				* This is dependent on our current color scheme.
				*/
				'default-color' => $default_background_color,
			)
		);

		// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
		add_theme_support( 'post-thumbnails' );

		// Add support for custom headers.
		$custom_header_support = array(
			// The default header text color.
			'default-text-color'     => '000',
			// The height and width of our custom header.
			/**
			 * Filter the Twenty Eleven default header image width.
			 *
			 * @since Twenty Eleven 1.0
			 *
			 * @param int The default header image width in pixels. Default 1000.
			 */
			'width'                  => apply_filters( 'twentyeleven_header_image_width', 1000 ),
			/**
			 * Filter the Twenty Eleven default header image height.
			 *
			 * @since Twenty Eleven 1.0
			 *
			 * @param int The default header image height in pixels. Default 288.
			 */
			   'height'              => apply_filters( 'twentyeleven_header_image_height', 288 ),
			// Support flexible heights.
			'flex-height'            => true,
			// Random image rotation by default.
			'random-default'         => true,
			// Callback for styling the header.
			'wp-head-callback'       => 'twentyeleven_header_style',
			// Callback for styling the header preview in the admin.
			'admin-head-callback'    => 'twentyeleven_admin_header_style',
			// Callback used to display the header preview in the admin.
			'admin-preview-callback' => 'twentyeleven_admin_header_image',
		);

		add_theme_support( 'custom-header', $custom_header_support );

		if ( ! function_exists( 'get_custom_header' ) ) {
			// This is all for compatibility with versions of WordPress prior to 3.4.
			define( 'HEADER_TEXTCOLOR', $custom_header_support['default-text-color'] );
			define( 'HEADER_IMAGE', '' );
			define( 'HEADER_IMAGE_WIDTH', $custom_header_support['width'] );
			define( 'HEADER_IMAGE_HEIGHT', $custom_header_support['height'] );
			add_custom_image_header( $custom_header_support['wp-head-callback'], $custom_header_support['admin-head-callback'], $custom_header_support['admin-preview-callback'] );
			add_custom_background();
		}

		/*
		 * We'll be using post thumbnails for custom header images on posts and pages.
		 * We want them to be the size of the header image that we just defined.
		 * Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
		 */
		set_post_thumbnail_size( $custom_header_support['width'], $custom_header_support['height'], true );

		/*
		 * Add Twenty Eleven's custom image sizes.
		 * Used for large feature (header) images.
		 */
		add_image_size( 'large-feature', $custom_header_support['width'], $custom_header_support['height'], true );
		// Used for featured posts if a large-feature doesn't exist.
		add_image_size( 'small-feature', 500, 300 );

		// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
		register_default_headers(
			array(
				'wheel'      => array(
					'url'           => '%s/images/headers/wheel.jpg',
					'thumbnail_url' => '%s/images/headers/wheel-thumbnail.jpg',
					/* translators: header image description */
					'description'   => __( 'Wheel', 'twentyeleven' ),
				),
				'shore'      => array(
					'url'           => '%s/images/headers/shore.jpg',
					'thumbnail_url' => '%s/images/headers/shore-thumbnail.jpg',
					/* translators: header image description */
					'description'   => __( 'Shore', 'twentyeleven' ),
				),
				'trolley'    => array(
					'url'           => '%s/images/headers/trolley.jpg',
					'thumbnail_url' => '%s/images/headers/trolley-thumbnail.jpg',
					/* translators: header image description */
					'description'   => __( 'Trolley', 'twentyeleven' ),
				),
				'pine-cone'  => array(
					'url'           => '%s/images/headers/pine-cone.jpg',
					'thumbnail_url' => '%s/images/headers/pine-cone-thumbnail.jpg',
					/* translators: header image description */
					'description'   => __( 'Pine Cone', 'twentyeleven' ),
				),
				'chessboard' => array(
					'url'           => '%s/images/headers/chessboard.jpg',
					'thumbnail_url' => '%s/images/headers/chessboard-thumbnail.jpg',
					/* translators: header image description */
					'description'   => __( 'Chessboard', 'twentyeleven' ),
				),
				'lanterns'   => array(
					'url'           => '%s/images/headers/lanterns.jpg',
					'thumbnail_url' => '%s/images/headers/lanterns-thumbnail.jpg',
					/* translators: header image description */
					'description'   => __( 'Lanterns', 'twentyeleven' ),
				),
				'willow'     => array(
					'url'           => '%s/images/headers/willow.jpg',
					'thumbnail_url' => '%s/images/headers/willow-thumbnail.jpg',
					/* translators: header image description */
					'description'   => __( 'Willow', 'twentyeleven' ),
				),
				'hanoi'      => array(
					'url'           => '%s/images/headers/hanoi.jpg',
					'thumbnail_url' => '%s/images/headers/hanoi-thumbnail.jpg',
					/* translators: header image description */
					'description'   => __( 'Hanoi Plant', 'twentyeleven' ),
				),
			)
		);

		// Indicate widget sidebars can use selective refresh in the Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
endif; // twentyeleven_setup

/**
 * Enqueue scripts and styles for front end.
 *
 * @since Twenty Eleven 2.9
 */
/*
function twentyeleven_scripts_styles() {
	// Theme block stylesheet.
	wp_enqueue_style( 'twentyeleven-block-style', get_template_directory_uri() . '/blocksZZ.css', array(), '20181230' );
}
add_action( 'wp_enqueue_scripts', 'twentyeleven_scripts_styles' );
*/
/**
 * Enqueue styles for the block-based editor.
 *
 * @since Twenty Eleven 2.9
 */
function twentyeleven_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'twentyeleven-block-editor-style', get_template_directory_uri() . '/editor-blocks.css', array(), '20181230' );
}
add_action( 'enqueue_block_editor_assets', 'twentyeleven_block_editor_styles' );

if ( ! function_exists( 'twentyeleven_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @since Twenty Eleven 1.0
	 */
	function twentyeleven_header_style() {
		$text_color = get_header_textcolor();

		// If no custom options for text are set, let's bail.
		if ( $text_color == HEADER_TEXTCOLOR ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css" id="twentyeleven-header-css">
		<?php
		// Has the text been hidden?
		if ( 'blank' == $text_color ) :
			?>
		#site-title,
		#site-description {
			position: absolute;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
			<?php
			// If the user has set a custom color for the text use that
		else :
			?>
		#site-title a,
		#site-description {
			color: #<?php echo $text_color; ?>;
		}
	<?php endif; ?>
	</style>
		<?php
	}
endif; // twentyeleven_header_style

if ( ! function_exists( 'twentyeleven_admin_header_style' ) ) :
	/**
	 * Styles the header image displayed on the Appearance > Header admin panel.
	 *
	 * Referenced via add_theme_support('custom-header') in twentyeleven_setup().
	 *
	 * @since Twenty Eleven 1.0
	 */
	function twentyeleven_admin_header_style() {
		?>
	<style type="text/css" id="twentyeleven-admin-header-css">
	.appearance_page_custom-header #headimg {
		border: none;
	}
	#headimg h1,
	#desc {
		font-family: "Helvetica Neue", Arial, Helvetica, "Nimbus Sans L", sans-serif;
	}
	#headimg h1 {
		margin: 0;
	}
	#headimg h1 a {
		font-size: 32px;
		line-height: 36px;
		text-decoration: none;
	}
	#desc {
		font-size: 14px;
		line-height: 23px;
		padding: 0 0 3em;
	}
		<?php
		// If the user has set a custom color for the text use that
		if ( get_header_textcolor() != HEADER_TEXTCOLOR ) :
			?>
	#site-title a,
	#site-description {
		color: #<?php echo get_header_textcolor(); ?>;
	}
	<?php endif; ?>
	#headimg img {
		max-width: 1000px;
		height: auto;
		width: 100%;
	}
	</style>
		<?php
	}
endif; // twentyeleven_admin_header_style

if ( ! function_exists( 'twentyeleven_admin_header_image' ) ) :
	/**
	 * Custom header image markup displayed on the Appearance > Header admin panel.
	 *
	 * Referenced via add_theme_support('custom-header') in twentyeleven_setup().
	 *
	 * @since Twenty Eleven 1.0
	 */
	function twentyeleven_admin_header_image() {

		?>
		<div id="headimg">
			<?php
			$color = get_header_textcolor();
			$image = get_header_image();
			$style = 'display: none;';
			if ( $color && $color != 'blank' ) {
				$style = 'color: #' . $color . ';';
			}
			?>
			<h1 class="displaying-header-text"><a id="name" style="<?php echo esc_attr( $style ); ?>" onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>" tabindex="-1"><?php bloginfo( 'name' ); ?></a></h1>
		<div id="desc" class="displaying-header-text" style="<?php echo esc_attr( $style ); ?>"><?php bloginfo( 'description' ); ?></div>
		<?php if ( $image ) : ?>
			<img src="<?php echo esc_url( $image ); ?>" alt="" />
		<?php endif; ?>
		</div>
		<?php
	}
endif; // twentyeleven_admin_header_image

/**
 * Set the post excerpt length to 40 words.
 *
 * To override this length in a child theme, remove
 * the filter and add your own function tied to
 * the excerpt_length filter hook.
 *
 * @since Twenty Eleven 1.0
 *
 * @param int $length The number of excerpt characters.
 * @return int The filtered number of characters.
 */
function twentyeleven_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'twentyeleven_excerpt_length' );

if ( ! function_exists( 'twentyeleven_continue_reading_link' ) ) :
	/**
	 * Return a "Continue Reading" link for excerpts
	 *
	 * @since Twenty Eleven 1.0
	 *
	 * @return string The "Continue Reading" HTML link.
	 */
	function twentyeleven_continue_reading_link() {
		return ' <a href="' . esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) . '</a>';
	}
endif; // twentyeleven_continue_reading_link

/**
 * Replace "[...]" in the Read More link with an ellipsis.
 *
 * The "[...]" is appended to automatically generated excerpts.
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Eleven 1.0
 *
 * @param string $more The Read More text.
 * @return The filtered Read More text.
 */
function twentyeleven_auto_excerpt_more( $more ) {
	if ( ! is_admin() ) {
		return ' &hellip;' . twentyeleven_continue_reading_link();
	}
	return $more;
}
add_filter( 'excerpt_more', 'twentyeleven_auto_excerpt_more' );

/**
 * Add a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Eleven 1.0
 *
 * @param string $output The "Continue Reading" link.
 * @return string The filtered "Continue Reading" link.
 */
function twentyeleven_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() && ! is_admin() ) {
		$output .= twentyeleven_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'twentyeleven_custom_excerpt_more' );

/**
 * Show a home link for the wp_nav_menu() fallback, wp_page_menu().
 *
 * @since Twenty Eleven 1.0
 *
 * @param array $args The page menu arguments. @see wp_page_menu()
 * @return array The filtered page menu arguments.
 */
function twentyeleven_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) ) {
		$args['show_home'] = true;
	}
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentyeleven_page_menu_args' );

/**
 * Register sidebars and widgetized areas.
 *
 * Also register the default Epherma widget.
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_widgets_init() {

	register_widget( 'Twenty_Eleven_Ephemera_Widget' );

	register_sidebar(
		array(
			'name'          => __( 'Main Sidebar', 'twentyeleven' ),
			'id'            => 'sidebar-1',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Showcase Sidebar', 'twentyeleven' ),
			'id'            => 'sidebar-2',
			'description'   => __( 'The sidebar for the optional Showcase Template', 'twentyeleven' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer Area One', 'twentyeleven' ),
			'id'            => 'sidebar-3',
			'description'   => __( 'An optional widget area for your site footer', 'twentyeleven' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer Area Two', 'twentyeleven' ),
			'id'            => 'sidebar-4',
			'description'   => __( 'An optional widget area for your site footer', 'twentyeleven' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer Area Three', 'twentyeleven' ),
			'id'            => 'sidebar-5',
			'description'   => __( 'An optional widget area for your site footer', 'twentyeleven' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'twentyeleven_widgets_init' );

if ( ! function_exists( 'twentyeleven_content_nav' ) ) :
	/**
	 * Display navigation to next/previous pages when applicable.
	 *
	 * @since Twenty Eleven 1.0
	 *
	 * @param string $html_id The HTML id attribute.
	 */
	function twentyeleven_content_nav( $html_id ) {
		global $wp_query;

		if ( $wp_query->max_num_pages > 1 ) :
			?>
			<nav id="<?php echo esc_attr( $html_id ); ?>">
				<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentyeleven' ); ?></h3>
				<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentyeleven' ) ); ?></div>
				<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?></div>
			</nav><!-- #nav-above -->
			<?php
	endif;
	}
endif; // twentyeleven_content_nav

/**
 * Return the first link from the post content. If none found, the
 * post permalink is used as a fallback.
 *
 * @since Twenty Eleven 1.0
 *
 * @uses get_url_in_content() to get the first URL from the post content.
 *
 * @return string The first link.
 */
function twentyeleven_get_first_url() {
	$content = get_the_content();
	$has_url = function_exists( 'get_url_in_content' ) ? get_url_in_content( $content ) : false;

	if ( ! $has_url ) {
		$has_url = twentyeleven_url_grabber();
	}

	/** This filter is documented in wp-includes/link-template.php */
	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

/**
 * Return the URL for the first link found in the post content.
 *
 * @since Twenty Eleven 1.0
 *
 * @return string|bool URL or false when no link is present.
 */
function twentyeleven_url_grabber() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) ) {
		return false;
	}

	return esc_url_raw( $matches[1] );
}

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer.
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'sidebar-4' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'sidebar-5' ) ) {
		$count++;
	}

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
	}

	if ( $class ) {
		echo 'class="' . esc_attr( $class ) . '"';
	}
}

if ( ! function_exists( 'twentyeleven_comment' ) ) :
	/**
	 * Template for comments and pingbacks.
	 *
	 * To override this walker in a child theme without modifying the comments template
	 * simply create your own twentyeleven_comment(), and that function will be used instead.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @since Twenty Eleven 1.0
	 *
	 * @param object $comment The comment object.
	 * @param array  $args    An array of comment arguments. @see get_comment_reply_link()
	 * @param int    $depth   The depth of the comment.
	 */
	function twentyeleven_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback':
			case 'trackback':
				?>
		<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyeleven' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?></p>
				<?php
				break;
			default:
				?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 68;
					if ( '0' != $comment->comment_parent ) {
						$avatar_size = 39;
					}

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf(
							__( '%1$s on %2$s <span class="says">said:</span>', 'twentyeleven' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf(
								'<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'twentyeleven' ), get_comment_date(), get_comment_time() )
							)
						);
					?>

						<?php edit_comment_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .comment-author .vcard -->

					<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentyeleven' ); ?></em>
					<br />
				<?php endif; ?>

				</footer>

				<div class="comment-content"><?php comment_text(); ?></div>

				<div class="reply">
					<?php
					comment_reply_link(
						array_merge(
							$args,
							array(
								'reply_text' => __( 'Reply <span>&darr;</span>', 'twentyeleven' ),
								'depth'      => $depth,
								'max_depth'  => $args['max_depth'],
							)
						)
					);
					?>
				</div><!-- .reply -->
			</article><!-- #comment-## -->

				<?php
				break;
		endswitch;
	}
endif; // ends check for twentyeleven_comment()

if ( ! function_exists( 'twentyeleven_posted_on' ) ) :
	/**
	 * Print HTML with meta information for the current post-date/time and author.
	 *
	 * Create your own twentyeleven_posted_on to override in a child theme
	 *
	 * @since Twenty Eleven 1.0
	 */
	function twentyeleven_posted_on() {
		printf(
			__( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'twentyeleven' ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'twentyeleven' ), get_the_author() ) ),
			get_the_author()
		);
	}
endif;

/**
 * Add two classes to the array of body classes.
 *
 * The first is if the site has only had one author with published posts.
 * The second is if a singular post being displayed
 *
 * @since Twenty Eleven 1.0
 *
 * @param array $classes Existing body classes.
 * @return array The filtered array of body classes.
 */
function twentyeleven_body_classes( $classes ) {

	if ( function_exists( 'is_multi_author' ) && ! is_multi_author() ) {
		$classes[] = 'single-author';
	}

	if ( is_singular() && ! is_home() && ! is_page_template( 'showcase.php' ) && ! is_page_template( 'sidebar-page.php' ) ) {
		$classes[] = 'singular';
	}

	return $classes;
}
add_filter( 'body_class', 'twentyeleven_body_classes' );

/**
 * Retrieve the IDs for images in a gallery.
 *
 * @uses get_post_galleries() First, if available. Falls back to shortcode parsing,
 *                            then as last option uses a get_posts() call.
 *
 * @since Twenty Eleven 1.6
 *
 * @return array List of image IDs from the post gallery.
 */
function twentyeleven_get_gallery_images() {
	$images = array();

	if ( function_exists( 'get_post_galleries' ) ) {
		$galleries = get_post_galleries( get_the_ID(), false );
		if ( isset( $galleries[0]['ids'] ) ) {
			$images = explode( ',', $galleries[0]['ids'] );
		}
	} else {
		$pattern = get_shortcode_regex();
		preg_match( "/$pattern/s", get_the_content(), $match );
		$atts = shortcode_parse_atts( $match[3] );
		if ( isset( $atts['ids'] ) ) {
			$images = explode( ',', $atts['ids'] );
		}
	}

	if ( ! $images ) {
		$images = get_posts(
			array(
				'fields'         => 'ids',
				'numberposts'    => 999,
				'order'          => 'ASC',
				'orderby'        => 'menu_order',
				'post_mime_type' => 'image',
				'post_parent'    => get_the_ID(),
				'post_type'      => 'attachment',
			)
		);
	}

	return $images;
}

/**
 * Modifies tag cloud widget arguments to display all tags in the same font size
 * and use list format for better accessibility.
 *
 * @since Twenty Eleven 2.7
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array The filtered arguments for tag cloud widget.
 */
function twentyeleven_widget_tag_cloud_args( $args ) {
	$args['largest']  = 22;
	$args['smallest'] = 8;
	$args['unit']     = 'pt';
	$args['format']   = 'list';

	return $args;
}
add_filter( 'widget_tag_cloud_args', 'twentyeleven_widget_tag_cloud_args' );

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Fire the wp_body_open action.
	 *
	 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
	 *
	 * @since Twenty Eleven 3.3
	 */
	function wp_body_open() {
		/**
		 * Triggered after the opening <body> tag.
		 *
		 * @since Twenty Eleven 3.3
		 */
		do_action( 'wp_body_open' );
	}
endif;

// REMOVE TWENTY ELEVEN DEFAULT HEADER IMAGES Raj
function wptips_remove_header_images() {
    unregister_default_headers( array('wheel','shore','trolley','pine-cone','chessboard','lanterns','willow','hanoi')
    );
}
add_action( 'after_setup_theme', 'wptips_remove_header_images', 11 );

// Add a menu location Raj
function register_raj_nav_menu() {
	register_nav_menu('raj-nav-menu', __('Raj Nav Menu'));
}
add_action( 'init', 'register_raj_nav_menu');

// Convenience shortcodes Raj

// setup note
function isc_note_irissetup_shortcode() {
	$output = '<div class="isc_infobox isc_infobox--note">';
	$output .= '  <div class="isc_infobox--icon"><img src="' . get_template_directory_uri() . '/assets/images/box_icon_note.svg" alt="note"></div>';
	$output .= '  <div class="isc_infobox--content"><div class="isc_infobox--title">Note:</div><div>If you don’t have InterSystems IRIS set up yet,  <a href="https://www.intersystems.com/try" target="sandboxwindow">get a free development sandbox here</a>.</div></div>';
	$output .= '</div>';
	return $output;
}
add_shortcode('isc_note_irissetup', 'isc_note_irissetup_shortcode');

// generic note
function isc_note_shortcode($atts, $content=null) {
	$output = '<div class="isc_infobox isc_infobox--note">';
	$output .= '  <div class="isc_infobox--icon"><img src="' . get_template_directory_uri() . '/assets/images/box_icon_note.svg" alt="note"></div>';
	$output .= '  <div class="isc_infobox--content"><div class="isc_infobox--title">Note:</div><div>' . $content . '</div></div>';
	$output .= '</div>';
	return $output;
}
add_shortcode('isc_note', 'isc_note_shortcode');

// useful hint
function isc_tip_shortcode($atts, $content=null) {
	$output = '<div class="isc_infobox isc_infobox--tip">';
	$output .= '  <div class="isc_infobox--icon"><img src="' . get_template_directory_uri() . '/assets/images/box_icon_tip.svg" alt="tip"></i></div>';
	$output .= '  <div class="isc_infobox--content"><div class="isc_infobox--title">Tip</div><div>' . $content . '</div></div>';
	$output .= '</div>';
	return $output;
}
add_shortcode('isc_tip', 'isc_tip_shortcode');

// warning note
function isc_warning_shortcode($atts, $content=null) {
	$output = '<div class="isc_infobox isc_infobox--warning">';
	$output .= '  <div class="isc_infobox--icon"><img src="' . get_template_directory_uri() . '/assets/images/box_icon_warning.svg" alt="warning"></i></div>';
	$output .= '  <div class="isc_infobox--content"><div class="isc_infobox--title">Warning<div>' . $content . '</div></div>';
	$output .= '</div>';
	return $output;
}
add_shortcode('isc_warning', 'isc_warning_shortcode');

// time to completion
function isc_note_timetocomplete_shortcode($atts, $content=null) {
	$vals = shortcode_atts( array(
		'minutes' => '10',
	), $atts);

	$output = '<div class="isc_infobox">';
	$output .= '  <div class="isc_infobox--icon"><i class="fas fa-user-clock" style="font-size:smaller" alt="time to complete"></i></div>';
	$output .= '  <div class="isc_infobox--title isc_infobox--warning--title">' . $vals['minutes'] . ' minutes</div>';
	$output .= '  <div class="isc_infobox--content">estimated time of completion</a>.</div>';
	$output .= '</div>';
	return $output;
}
add_shortcode('isc_note_timetocomplete', 'isc_note_timetocomplete_shortcode');

// finding the Terminal
function isc_note_terminal_shortcode() {
	$output = '<div class="isc_infobox">';
	$output .= '  <div class="isc_infobox--icon"><img src="' . get_template_directory_uri() . '/assets/images/icon-info.png""></i></div>';
	$output .= '  <div class="isc_infobox--content">';
	$output .= '  <div class="isc_infobox--title">Opening the IRIS Terminal</div>';
	$output .= '  <ul>';
	$output .= '    <li>Learning Labs Sandbox: from the InterSytems menu, select <strong>InterSystems IRIS Terminal</strong></li>';
	$output .= '    <li>Docker-based: from the container host’s shell, use the command <code>docker exec -it try-iris iris terminal &lt;IRIS instance name&gt;</code></li>';
	$output .= '  </ul>';
	$output .= '</div>';
	$output .= '</div>';
	return $output;
}
add_shortcode('isc_note_terminal', 'isc_note_terminal_shortcode');

// populates a language table entry
function isc_lang_support_shortcode($atts, $content=null) {
	$values = shortcode_atts( array(
		'url'		=> "",
	), $atts);
	if ( strlen($values['url']) < 1 ) 
		$values['url'] = null;
	$output = '<a href="' . $values['url'] . '"><i class="fas fa-check"></i></a>';
	return $output;
}
add_shortcode('isc_lang', 'isc_lang_support_shortcode');

// Prevent WP from adding <p> tags on all post types
function disable_wp_auto_p( $content ) {
	remove_filter( 'the_content', 'wpautop' );
	remove_filter( 'the_excerpt', 'wpautop' );
	return $content;
  }
  add_filter( 'the_content', 'disable_wp_auto_p', 0 );


/**
 * Enqueue Scripts - Load Front End JS
 */
function isc_enqueue_front_end_scripts() {

	$version = THEME_VERSION;
	$handle = sanitize_title_with_dashes( THEME_NAME );
	//wp_dequeue_script('jquery');
	wp_enqueue_script( $handle . 'main', get_template_directory_uri() . '/assets/js/main.min.js', array(), $version, true );

	// for making AJAX calls to WP
	$theme_url  = get_template_directory_uri();     // Used to keep our Template Directory URL
	$ajax_url   = admin_url( 'admin-ajax.php' );        // Localized AJAX URL
	
	// Register our script for localization
	wp_register_script(
		'sandbox-config', 
		"{$theme_url}/inc/sandbox-config.js", 
		array('jquery'), 
		'1.0', 
		true
	);
	// Localize our script so we can use `ajax_url`
	wp_localize_script('sandbox-config', 'ajax_url', $ajax_url);
	// Finally, enqueue our script
	wp_enqueue_script('sandbox-config');
	// Register our script for localization
	wp_register_script(
		'heap-scroll-track', 
		"{$theme_url}/inc/heap-scroll-track.js", array('jquery'), '1.0', true
	);
	// Localize our script so we can use `ajax_url`
	wp_localize_script('heap-scroll-track', 'ajax_url', $ajax_url);
	// Finally, enqueue our script
	wp_enqueue_script('heap-scroll-track');
}
add_action( 'wp_enqueue_scripts', 'isc_enqueue_front_end_scripts' );

/**
 * Get Menu Name
 */
function isc_get_menu_name( $location ) {
    if( empty($location) ) return false;

    $locations = get_nav_menu_locations();
    if( ! isset( $locations[$location] ) ) return false;

    $menu_obj = get_term( $locations[$location], 'nav_menu' );

    return $menu_obj->name;
}

/**
* Custom Menu Walker to Add Span for Dropdown
*/
class Isc_Walker extends Walker_Nav_Menu {
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		// Close Tags and Add Span if Dropdown
		$output .= '<li class="' .  implode(' ', $item->classes) . '">';
		$output .= '<a href="' . $item->url . '" target="' . $item->target . '">';
		$output .= $item->title;
		$output .= '</a>';
		if(in_array( 'menu-item-has-children', $item->classes)) {
			$output .= '<span class="plus"><span class="horizontal"></span><span class="vertical"></span></span>';
		}
	}
}

/**
* Add custom styles to the WordPress editor
*/
function isc_custom_styles( $init_array ) {

    $style_formats = array(
        // These are the custom styles
        array(
            'title'   => 'New Custom Styles',
            'items' => array(
		        array(
		            'title' => 'Heading 1',
		            'block' => 'span',
		            'classes' => 'h_1',
		            'wrapper' => true,
		        ),
		        array(
		            'title' => 'Heading 2',
		            'block' => 'span',
		            'classes' => 'h_2',
		            'wrapper' => true,
		        ),
		        array(
		            'title' => 'Heading 3',
		            'block' => 'span',
		            'classes' => 'h_3',
		            'wrapper' => true,
		        ),
		        array(
		            'title' => 'Heading 4',
		            'block' => 'span',
		            'classes' => 'h_4',
		            'wrapper' => true,
		        ),
		        array(
		            'title' => 'Heading 5',
		            'block' => 'span',
		            'classes' => 'h_5',
		            'wrapper' => true,
		        ),
		        array(
		            'title' => 'Paragraph Small',
		            'selector' => 'p',
		            'classes' => 'p_sm',
		            'wrapper' => true,
		        ),
		        array(
		            'title' => 'Paragraph Large',
		            'selector' => 'p',
		            'classes' => 'p_lg',
		            'wrapper' => true,
		        ),
            ),
        ),
    );
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );

    return $init_array;

}
add_filter( 'tiny_mce_before_init', 'isc_custom_styles' );

/** 
* Common sense function for automating image retrieval 
*/
function isc_get_attachment( $attachment_id, $size = '' ) {

	$attachment = get_post( $attachment_id );

	if ( ! $attachment )
		return;

	$src = ( $size != '' ) ? wp_get_attachment_image_src( $attachment_id, $size )[0] : wp_get_attachment_url($attachment_id);
	$srcset = wp_get_attachment_image_srcset( $attachment_id );

	return array(
		'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
		'href' => get_permalink( $attachment->ID ),
		'src' => $src,
		'srcset' => $srcset,
	);
}

/**
* EXTRA SHORTCODES
*/

// Button with option for video modal popup by adding class .js-modalTrigger and using video ID for brightcove video for iframe embed
function isc_button_shortcode($atts) {
	global $isc_globals;

	$values = shortcode_atts( array(
		'class' => "isc_btn",
		'href' => "#",
		'label' => "Button Label",
		'target' => "_self",
	), $atts);

	if(strpos($values['class'], 'js-modalTrigger') !== false) {
		$output = '<a href="#' . $values['href'] . '" class="' . $values['class'] . '" target="' . $values['target'] . '"><img src="' . get_template_directory_uri() . '/assets/images/play-button.svg" />' . $values['label'] . '</a>';
		$output .= '<div id="' . $values['href'] . '" class="int-modal int-modal--center">';
		$output .= '<div class="int-modal__overlay"></div>';
		$output .= '<div class="int-modal__dialog">';
		$output .= '<div class="video-container">';
		$output .= '<div class="video">';
		$output .= '<div class="video-responsive">';
		$output .= '<iframe class="vidyard_iframe" src="https://players.brightcove.net/610060920001/' . $isc_globals['brightcove_video_id'] . '_default/index.html?videoId=' . $values['href'] . '" allowfullscreen webkitallowfullscreen mozallowfullscreen></iframe>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '<a href="#" class="int-modal__close js-closeModal">+</a>';
		$output .= '</div>';
		$output .= '</div>';
	} else {
		$output = '<a href="' . $values['href'] . '" class="' . $values['class'] . '" target="' . $values['target'] . '">' . $values['label'] . '</a>';
	}

	return $output;
}
add_shortcode('isc_button', 'isc_button_shortcode');

// Content anchor for in page links
function isc_anchor_shortcode($atts) {
	$values = shortcode_atts( array(
		'id' => "#",
	), $atts);

	$output = '<span id="' . $values['id'] . '" class="anchor-tag"></span>';

	return $output;
}
add_shortcode('isc_anchor', 'isc_anchor_shortcode');

// Content divider
function isc_divider_shortcode() {

	$output = '<div class="content-divider"></div>';

	return $output;
}
add_shortcode('isc_divider', 'isc_divider_shortcode');

// Add a menus to theme
function isc_register_menus() {
	register_nav_menu('top-menu', __('Top Menu'));
	register_nav_menu('footer-menu', __('Footer Menu'));
}
add_action( 'init', 'isc_register_menus');

/*
Enable Options Page
*/
if( function_exists('acf_add_options_page') ) {	
	acf_add_options_page();
}


/** 
 * Drift Chatbot Implementation
 * Puts the Drift JavaScript in the page header.
 */
/*****
add_action('wp_head', 'install_drift');
function install_drift() {
?>
<!-- Start Async Drift Code --> 
<script> "use strict"; !function() { var t = window.driftt = window.drift = window.driftt || []; if (!t.init) { if (t.invoked) return void (window.console && console.error && console.error("Drift snippet included twice.")); t.invoked = !0, t.methods = [ "identify", "config", "track", "reset", "debug", "show", "ping", "page", "hide", "off", "on" ], t.factory = function(e) { return function() { var n = Array.prototype.slice.call(arguments); return n.unshift(e), t.push(n), t; }; }, t.methods.forEach(function(e) { t[e] = t.factory(e); }), t.load = function(t) { var e = 3e5, n = Math.ceil(new Date() / e) * e, o = document.createElement("script"); o.type = "text/javascript", o.async = !0, o.crossorigin = "anonymous", o.src = "https://js.driftt.com/include/" + n + "/" + t + ".js"; var i = document.getElementsByTagName("script")[0]; i.parentNode.insertBefore(o, i); }; } }(); drift.SNIPPET_VERSION = '0.3.1'; drift.load('w9s2kkgrasip'); </script> 
<!-- End of Async Drift Code --> 
<?php 
};
/*****
/** End Drift Chatbot Implementation **/


/** 
 * InterSystems SSO Implementation
 * Implements OAuth2 login to InterSystems SSO OAuth2 service 
 * to log any InterSystems SSO user into WordPress.
 */

// modify the generic SSO login button for InterSystems
add_filter('openid-connect-generic-login-button-text', function( $text ) {
    $text = __('Login'); // __('InterSystems Login');
    return $text;
});

// Based on some data in the user_claim, modify the user.
add_action('openid-connect-generic-update-user-using-current-claim', function( $user, $user_claim) {
    if ( !empty( $user_claim['wp_user_role'] ) ) {
        update_user_meta( $user->ID, 'ISCLOGIN', 1 );
    }
}, 10, 2);

// React to a user being redirected after a successful login
// by trying to go to a page anchor named "getsandbox"
add_action('openid-connect-generic-redirect-user-back', function( $redirect_url, $user ) {
	wp_redirect($redirect_url . '#getsandbox');
	exit();
}, 10, 2); 
/** End InterSystems SSO Implementation **/

/** 
 * InterSystems Sandbox Implementation
 * Any logged in user has been authenticated using SSO, so we know if 
 * we have an email address for them, we're willing to create the evaluation service for them. 
 * Use their email to get a token back from the LS service, then use the token to get the evail service.
 * We use JavaScript so the UI can be non-blocking and show a loading animation while the user 
 * waits 20-40 seconds for their containers to spin up.
 */
function sandbox_expired() {
	if ( !sandbox_exists() ) return True;

	$user_id = get_current_user_id();
	$sandbox_expires_date = strtotime( get_user_meta( $user_id, 'sandbox_expires', True) );
	$nowdate = current_time( 'timestamp', 0 );
	$exp = ($sandbox_expires_date - $nowdate) < 1 ? True : False;
	return ( $exp );
}

function sandbox_exists() {
	$user_id = get_current_user_id();
	if ( get_user_meta( $user_id, 'sandbox_expires', True) == "" ) {
		return False;
	}
	return True;
}

function three_days_from_now() {
	$nowtime = current_time( 'timestamp', 0 );
	$thentime = $nowtime + (86400 * 3); // # of seconds in a day times 3 days
	return $thentime;
}

function one_hour_from_now() {
	$nowtime = current_time( 'timestamp', 0 );
	$thentime = $nowtime + (60 * 60); // # of seconds in a minute times # of minutes in an hour
	return $thentime;
}

// Show evaluation instance credentials
function show_eval_creds($atts = [], $content = null) {
	$values = shortcode_atts( array(
		'login_box_content' => '<div class="isc_infobox--title">Need InterSystems IRIS?</div><div>Get a free, online development sandbox here. Log in with your InterSystems universal account, or register for one below.</div>',
		'launch_box_content' => '<div class="isc_infobox--title">Provision your free, online sandbox environment</div><div>Includes InterSystems IRIS and a browser-based IDE.</div>', 
		'login_after_reg_box_content' => '<div class="isc_infobox--title">Thanks for registering!</div><div>Now login to launch your InterSystems IRIS sandbox</div>'
	), $atts);

	$user_id = get_current_user_id();

	// When visitor is not logged in (via ISC SSO), then they must do this before launching sandbox
	if ( $user_id < 1 ) {
		global $wp;
		global $isc_globals;
		$thisurl = urlencode(home_url( $wp->request ) . '#getsandbox');
		$ssoregister = $isc_globals['sso_registration_page'] . $thisurl;
		$ssologin = $isc_globals['sso_login_page'] . $thisurl;
		
		// If user has just registered, they won't be logged in and have a user id, but there will be an ssoToken parameter in the URL, so we can just log them in
		ob_start();
		?>
		<a name="getsandbox"></a>
		<div class="isc_infobox isc_infobox--tip">
			<div class="isc_infobox--icon">
				<img src="<?php echo get_template_directory_uri()?>/assets/images/icon-tip.png" class="ls-is-cached lazyloaded" alt="tip"></i>
			</div>
			<div class="isc_infobox--content">
				<?php if ( !isset($_GET["ssoToken"]) ) echo ($values['login_box_content'])?>
				<?php if ( isset($_GET["ssoToken"]) ) echo ($values['login_after_reg_box_content'])?>
				<div  style="text-align: center;padding-top: 24px">
					<?php echo (do_shortcode($content)) ?>
					<?php if ( !isset($_GET["ssoToken"]) ) echo ('<a class="isc_btn isc_register" href="' . $ssoregister . '">Register</a>')?>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}

	// If we're here the user is logged in. 
	$user_info = get_userdata($user_id);
	$useremail = $user_info->user_email;

	// Now check if they have an active sandbox. 
	// If so, just show the info. 
	// If not, do all the things to launch one
	$output = '';
	$all_meta_for_user = array_map( function( $a ){ return $a[0]; }, get_user_meta( $user_id ) );
	if ( sandbox_expired() ) {
		// Sandbox is either non-existent, or expired
		// Get a token for creating an evaluation sandbox for the user
		// Returns 200 and a token that is valid for the provided email address for 10 minutes if email is associated with a fully-registered SSO user.
		// Otherwise returns 401 w/ error message
		global $isc_globals;
		$token_url = $isc_globals['sandbox_token_service'] . '/authorize/' . $useremail;
		$sandbox_token = file_get_contents($token_url);
		error_log("token_url: $token_url");
		$sandbox_meta_url = $isc_globals['sandbox_token_service'] . '/containers/' . $useremail;
		error_log("sandbox_meta_url: $sandbox_meta_url");

		// Show an explanation of sandbox has expired
		$expired_messsage = sandbox_exists() ? "<br><em>Please provision your sandbox.</em>" : "";

		ob_start();
		?>
		<a name="getsandbox"></a>
		<div class="isc_infobox isc_infobox--tip">
			<div class="isc_infobox--icon">
				<img src="<?php echo get_template_directory_uri()?>/assets/images/icon-tip.png" class="ls-is-cached lazyloaded" alt="tip"></i>
			</div>
			<div class="isc_infobox--content">
				<div id="sandboxloadingbar"></div>
				<div id="isc-waiting-area">
					<?php echo ($values['launch_box_content'])?>
					<!-- <?php echo $expired_messsage?> -->
				</div>
				<div style="text-align:center;margin-top:24px;">
					<a style="width:320px;" id="isc-launch-eval-btn" class="isc_btn" href="#" onclick="launcheval('<?php echo($sandbox_meta_url)?>', '<?php echo($sandbox_token)?>')">Provision Sandbox</a>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
	else {
		// Sandbox is not expired so just show stored settings
		ob_start();
		?>
		<a name="getsandbox"></a>
		<div class="isc_infobox isc_infobox--tip">
			<div class="isc_infobox--icon">
				<img src="<?php echo get_template_directory_uri()?>/assets/images/icon-tip.png" class="ls-is-cached lazyloaded" alt="tip"></i>
			</div>
			<div class="isc_infobox--content">
				<p class="h_5" style="margin:0">InterSystems Sandbox provisioned.</p>
				<p>You may now continue the exercise. You'll be prompted when you need to use the sandbox, but you can also launch the tools from here.
				<div style="text-align:center;margin-top:24px;">
					<a style="width:240px;" class="isc_btn" href="<?php echo $all_meta_for_user['sandbox_ide_url']?>" target="_blank">Sandbox IDE</a>
					<a style="width:240px;" class="isc_btn" href="<?php echo $all_meta_for_user['sandbox_smp']?>" target="_blank">Management Portal</a>
				</div>
				<div style="text-align:center;margin-top:24px;">
					<a style="width:320px;" id="isc-reset-sandbox-btn" href="#" onclick="sandbox_reset()">Delete Sandbox</a>
				</div>
			</div>
		</div>
		
		<?php 
		return ob_get_clean();
	}
	return $output;
}
add_shortcode('iris_eval_creds', 'show_eval_creds');

function show_iris_eval_setting($atts = [], $content = "") {
	$values = shortcode_atts( array(
		'setting' => null, 
		'linktext' => null, 
		'prefix' => "", 
		'suffix' => "", 
		'fallback' => ""
	), $atts);
	if ( sandbox_expired() ) 
		return '<em><a href="#getsandbox">-- cannot display value - please provision a sandbox</a></em>';

	if ( $values['setting'] == null ) 
		return 'MISSING SETTING VALUE';

	$user_id = get_current_user_id();
	if ( $user_id < 1 ) 
		return ($values['fallback']);
	
	$all_meta_for_user = array_map( function( $a ){ return $a[0]; }, get_user_meta( $user_id ) );
	if ( !array_key_exists($values['setting'], $all_meta_for_user) ) 
		return ($values['fallback']);

	$val = $all_meta_for_user[$values['setting']];
	if ( $val ) {
		if ( $values['linktext'] ) {
			return '<a href="' . $val . '" target="_blank">' . $values['linktext'] . '</a>' . $content;
		} else {
			$pre = html_entity_decode($values['prefix']);
			$suf = html_entity_decode($values['suffix']);
			return "{$pre}" . "{$val}" . "{$suf}" . $content;
		}
	}
}
add_shortcode('iris_eval_settings', 'show_iris_eval_setting');

function sandbox_config_callback() {
	if ( !isset($_POST) || empty($_POST) || !is_user_logged_in() ) {
		header('HTTP/1.1 400 Empty POST Values');
		echo 'Could Not Verify POST Values.';
		exit;
	}

	$user_id = get_current_user_id();
	$PD = $_POST['project_details'];
	$sandbox_ide_url = sanitize_text_field( $PD['ide']);
	update_user_meta( $user_id, 'sandbox_ide_url', $sandbox_ide_url);
	$sandbox_username = sanitize_text_field( $PD['username']);
	update_user_meta( $user_id, 'sandbox_username', $sandbox_username);
	$sandbox_password = sanitize_text_field( $PD['password']);
	update_user_meta( $user_id, 'sandbox_password', $sandbox_password);
	$sandbox_smp = sanitize_text_field( $PD['MP']);
	update_user_meta( $user_id, 'sandbox_smp', $sandbox_smp);
	$sandbox_ext_ide_ip = sanitize_text_field( $PD['HostServerAddress']);
	update_user_meta( $user_id, 'sandbox_ext_ide_ip', $sandbox_ext_ide_ip);
	$sandbox_ext_ide_port = sanitize_text_field( $PD['HostWebPort']);
	update_user_meta( $user_id, 'sandbox_ext_ide_port', $sandbox_ext_ide_port);
	$sandbox_isc_ip = sanitize_text_field( $PD['InterSystemsIP']);
	update_user_meta( $user_id, 'sandbox_isc_ip', $sandbox_isc_ip);
	$sandbox_isc_port = sanitize_text_field( $PD['InterSystems51773Port']);
	update_user_meta( $user_id, 'sandbox_isc_port', $sandbox_isc_port);
	$sandbox_gateway_port = sanitize_text_field( $PD['InterSystems1972Port']);
	update_user_meta( $user_id, 'sandbox_gateway_port', $sandbox_gateway_port);
	$sandbox_webdev_port = sanitize_text_field( $PD['TheiaIDE4200Port']);
	update_user_meta( $user_id, 'sandbox_webdev_port', $sandbox_webdev_port);
	// ignore expiration date returned from sandbox API because 
	// we want to just cache the info for an hour, and get it fresh again 
	// any time after that
	// $sandbox_expires = sanitize_text_field( $_POST['expiration_date']);
	// update_user_meta( $user_id, 'sandbox_expires', $sandbox_expires);
	update_user_meta( $user_id, 'sandbox_expires', date('c', one_hour_from_now()) );

	header('HTTP/1.1 200');
	echo 'Successful POST: ISC Sandbox config';
	exit;
}
add_action('wp_ajax_nopriv_sandbox_config_cb', 'sandbox_config_callback');
add_action('wp_ajax_sandbox_config_cb', 'sandbox_config_callback');

// deletes the sandbox metadata and sends a delete request to the sandbox API
function sandbox_reset() {
	if ( !is_user_logged_in() ) {
		header('HTTP/1.1 400 User not logged in');
		echo 'User not logged in.';
		exit;
	}

	$user_id = get_current_user_id();
	$user_info = get_userdata($user_id);
	$useremail = $user_info->user_email;

	global $isc_globals;
	$token_url = $isc_globals['sandbox_token_service'] . '/authorize/' . $useremail;
	$sandbox_token = file_get_contents($token_url);
	$sandbox_meta_url = $isc_globals['sandbox_token_service'] . '/containers/' . $useremail;
	$opts = stream_context_create([
		'http' => [
			'method' => 'DELETE', 
			'header' => 'Authorization: Basic ' . $sandbox_token
		]
	]);
	$result = file_get_contents($sandbox_meta_url, false, $opts );

	delete_user_meta( $user_id, 'sandbox_ide_url');
	delete_user_meta( $user_id, 'sandbox_username');
	delete_user_meta( $user_id, 'sandbox_password');
	delete_user_meta( $user_id, 'sandbox_smp');
	delete_user_meta( $user_id, 'sandbox_ext_ide_ip');
	delete_user_meta( $user_id, 'sandbox_ext_ide_port');
	delete_user_meta( $user_id, 'sandbox_isc_ip');
	delete_user_meta( $user_id, 'sandbox_isc_port');
	delete_user_meta( $user_id, 'sandbox_gateway_port');
	delete_user_meta( $user_id, 'sandbox_webdev_port');
	delete_user_meta( $user_id, 'sandbox_expires');

	header('HTTP/1.1 200');
	echo 'Successful sandbox deletion';
	exit;
}
add_action('wp_ajax_nopriv_sandbox_reset', 'sandbox_reset');
add_action('wp_ajax_sandbox_reset', 'sandbox_reset');
/** end InterSystems InterSystems Sandbox Implementation **/

/** 
 * InterSystems CUSTOM GLOBAL VARIABLES
 */
function isc_global_vars() {

	global $isc_globals;
	$isc_globals = array(
		'sandbox_token_service'  => 'https://lsiris.intersystems.com/try-iris/v2',
		'sso_registration_page'  => 'https://login.intersystems.com/login/SSO.UI.Register.cls?referrer=',
		'sso_login_page'      => 'https://login.intersystems.com/oauth2/authorize?response_type=code&scope=email+profile+openid&client_id=zwdubaHB5lKWgT6JL-UAvH6T0wsDNpTlwRVBieR41C4&redirect_uri=',
	);
	$h = home_url();
	// things to do if this is a development site
	// - sandbox endpoint is test-iris instead of try-iris
	// - SSO registration changes to URLs with uat in the endpoint
	if ( strpos($h, 'dev-start') ) {
		$isc_globals['sandbox_token_service']  = 'https://lsiris.intersystems.com/test-iris/v2';
		$isc_globals['sso_registration_page'] = 'https://login.intersystems.com/loginuat/SSO.UI.Register.cls?referrer=';
		$isc_globals['sso_login_page'] = 'https://login.intersystems.com/uat/oauth2/authorize?response_type=code&scope=email+profile+openid&client_id=6XlAB83aJbEcrCJ4oisbRUc0elnmYtRrjXQBFX4NRlw&redirect_uri=';
	}
	// things to do if this is a health site
	$isc_globals['brightcove_video_id'] = 'WZIjldXv6';
	if ( strpos($h, 'health') ) {
		$isc_globals['brightcove_video_id'] = 'k2mhikLom';
	}
}
add_action( 'parse_query', 'isc_global_vars' );
/** InterSystems CUSTOM GLOBAL VARIABLES */
