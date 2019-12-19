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
define( 'THEME_VERSION', '1.1.0' );

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
function twentyeleven_scripts_styles() {
	// Theme block stylesheet.
	wp_enqueue_style( 'twentyeleven-block-style', get_template_directory_uri() . '/blocks.css', array(), '20181230' );
}
add_action( 'wp_enqueue_scripts', 'twentyeleven_scripts_styles' );

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
	$output = '<div class="isc--infobox">';
	$output .= '  <div class="isc--infobox--icon"><img src="' . get_template_directory_uri() . '/assets/images/alert-icon.svg""></div>';
	$output .= '  <div class="isc--infobox--title">Note</div>';
	$output .= '  <div>If you don’t have InterSystems IRIS set up yet,  <a href="http://www.intersystems.com/try">get a free development sandbox here</a>.</div>';
	$output .= '</div>';
	return $output;
}
add_shortcode('isc_note_irissetup', 'isc_note_irissetup_shortcode');

// generic note
function isc_note_shortcode($atts, $content=null) {
	$output = '<div class="isc--infobox">';
	$output .= '  <div class="isc--infobox--icon"><img src="' . get_template_directory_uri() . '/assets/images/alert-icon.svg""></div>';
	$output .= '  <div class="isc--infobox--title">Note</div>';
	$output .= '  <div>' . $content . '</div>';
	$output .= '</div>';
	return $output;
}
add_shortcode('isc_note', 'isc_note_shortcode');

// useful hint
function isc_tip_shortcode($atts, $content=null) {
	$output = '<div class="isc--infobox isc--infobox--tip">';
	$output .= '  <div class="isc--infobox--icon"><img src="' . get_template_directory_uri() . '/assets/images/alert-icon.svg""></i></div>';
	$output .= '  <div class="isc--infobox--title isc--infobox--tip--title">Tip</div>';
	$output .= '  <div>' . $content . '</div>';
	$output .= '</div>';
	return $output;
}
add_shortcode('isc_tip', 'isc_tip_shortcode');

// time to completion
function isc_note_timetocomplete_shortcode($atts, $content=null) {
	$vals = shortcode_atts( array(
		'minutes' => '10',
	), $atts);

	$output = '<div class="isc--infobox isc--infobox--warning">';
	$output .= '  <div class="isc--infobox--icon"><i class="fas fa-user-clock" style="font-size:smaller"></i></div>';
	$output .= '  <div class="isc--infobox--title isc--infobox--warning--title">' . $vals['minutes'] . ' minutes</div>';
	$output .= '  <div>estimated time of completion</a>.</div>';
	$output .= '</div>';
	return $output;
}
add_shortcode('isc_note_timetocomplete', 'isc_note_timetocomplete_shortcode');

// finding the Terminal
function isc_note_terminal_shortcode() {
	$output = '<div class="isc--infobox isc--infobox--warning">';
	$output .= '  <div class="isc--infobox--icon"><img src="' . get_template_directory_uri() . '/assets/images/alert-icon.svg""></i></div>';
	$output .= '  <div class="isc--infobox--title isc--infobox--warning--title">Opening the IRIS Terminal</div>';
	$output .= '  <ul>';
	$output .= '    <li>Learning Labs Sandbox: from the InterSytems menu, select <strong>InterSystems IRIS Terminal</strong></li>';
	$output .= '    <li>Docker-based: from the container host’s shell, use the command <code>docker exec -it try-iris iris terminal &lt;IRIS instance name&gt;</code></li>';
	$output .= '  </ul>';
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


// make the guidepost
function isc_guidepost_shortcode($atts, $content=null) {
	$values = shortcode_atts( array(
		'next'		=> 2,
		'itemurls'	=> null, 
		'itemnames'	=> null, 
		'alturls' 	=> null,
		'altnames' 	=> null
	), $atts);
	$next = intval($values['next']) - 1;

	$itemurls = explode("|", $values['itemurls']);
	if ( count($itemurls) == 1 && $itemurls[0] == "" ) unset($itemurls[0]);
	$itemurlcount = count($itemurls);
	$itemnames = explode("|", $values['itemnames']);
	$alturls = explode("|", $values['alturls']);
	if ( count($alturls) == 1 && $alturls[0] == "" ) unset($alturls[0]);
	$altnames = explode("|", $values['altnames']);

	$output = "<div id='isc--guidepost--section'>";

	if ( $itemurlcount > 0 ) {
		$output .= "<h2>Up Next</h2>";
		// main text row
		$output .= "<table class='isc--guidepost isc--has--main--line'><tbody>";
		$output .= "<tr class='main--text'>";
		for ($i = 0; $i < $itemurlcount; $i++) {
			if ( $i == $next ) {
				$output .= "<td class='stop--col main--stop--text'>";
				$output .= "<div class='main--stop--title'><a href='" . $itemurls[$i] . "'>" . $itemnames[$i] . " »</a></div>";
				$output .= "</td>";
			} elseif ( $i == $next - 1) {
				$output .= "<td class='stop--col'>" . $itemnames[$i] . "</td>";
			} else {
				$output .= "<td class='stop--col'><a href='" . $itemurls[$i] . "'>" . $itemnames[$i] . "</a></td>";
			}
			if ( $i != $itemurlcount - 1 ) {
				$output .= "<td class='between-stops'></td>";
			}
		}
		$output .= "</tr>";

		// main line
		$output .= "<tr class='main--line'>";
		for ($i = 0; $i < $itemurlcount; $i++) {
			// add a stop graphic
			// 1st do background
			if ( $i == 0 ) { // 1st stop needs a curved left side
				if ( count($alturls)>0 && $next == 1) // if it has a alternative line coming off it, join them
					$output .= "<td class='stop stop--left--first'>";
				else 
					$output .= "<td class='stop stop--left'>";
			} elseif ( $i == $itemurlcount - 1 ) { // last stop needs a curved right side
				if ( count($alturls)>0 && $i == $next - 1 ) // if it has a alternative line coming off it, join them
					$output .= "<td class='stop stop--right--last'>";
				else 
					$output .= "<td class='stop stop--right'>";
			} else {
				$output .= "<td class='stop stop--mid'>";
			}
			// then put circle on top
			if ( $i == ($next-1) ) 
				$output .= "<div class='stop--circle next--stop'>";
			else 
				$output .= "<div class='stop--circle'>";
			// finally, put in the link and close tags
			$output .= "<a href='" . $itemurls[$i] . "'>&nbsp;</a></div></td>";

			// then add an intermediate graphic between stops, unless we're at the end
			if ( $i < $itemurlcount - 1 ) {
				$output .= "<td class='between-stops'></td>";
			}


			// if ( $i == 0 ) {
			// 	$output .= "<td class='stop stop--left'><div class='stop--circle'><a href='" . $itemurls[$i] . "'>&nbsp;</a></div></td>";
			// } elseif ( $i == $itemurlcount - 1 ) {
			// 	$output .= "<td class='stop stop--right'><div class='stop--circle'><a href='" . $itemurls[$i] . "'>&nbsp;</a></div></td>";
			// } else {
			// 	if ( $i == $next ) 
			// 		$output .= "<td class='stop stop--mid'><div class='stop--circle next--stop'><a href='" . $itemurls[$i] . "'>&nbsp;</a></div></td>";
			// 	else 
			// 		$output .= "<td class='stop stop--mid'><div class='stop--circle'><a href='" . $itemurls[$i] . "'>&nbsp;</a></div></td>";
			// }
			// if ( $i < $itemurlcount - 1 ) {
			// 	$output .= "<td class='between-stops'></td>";
			// }
		}
		$output .= "</tr>";

	} else {
		$itemurlcount = 5;
	}
	
	if ( count($alturls) > 0 ) {
		if ( count($itemurls) < 1 ) {
			$output .= "<h2>Related</h2>";
			$output .= "<table class='isc--guidepost'><tbody>";
		}

		for ($i = 0; $i < count($alturls); $i++) {
			$output .= "<tr class='secondary--line'>";
			for ($j = 0; $j < $itemurlcount; $j++) {
				if ( $j == $next - 1 ) {
					if ( $i == count($alturls) - 1 ) {
						$output .= "<td class='stop stop--bottom stop--secondary'><div class='stop--circle'><a href='" . $alturls[$i] . "'>&nbsp;</a></div></td>";
					} elseif ( $i == 0 and count($itemurls) < 1 ) {
						$output .= "<td class='stop stop--top stop--secondary'><div class='stop--circle'><a href='" . $alturls[$i] . "'>&nbsp;</a></div></td>";
					} else {
						$output .= "<td class='stop stop--mid stop--secondary'><div class='stop--circle'><a href='" . $alturls[$i] . "'>&nbsp;</a></div></td>";
					}
					$output .= "<td class='stop--col secondary--stop--text between-stops'><div class='secondary--stop--title'><a href='" . $alturls[$i] . "'>" . $altnames[$i] . " »</a></div>";
					$output .= "</td>";
				} else {
					$output .= "<td class='stop--col'></td>";
					if ( $j < $itemurlcount - 1 ) {
						$output .= "<td class='between-stops'></td>";
					}
				}
			}
			$output .= "</tr>";
		}
	}

	$output .= "</tbody></table></div>";

	return $output;
}
add_shortcode('isc_guidepost', 'isc_guidepost_shortcode');

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
		$output .= '<iframe src="https://players.brightcove.net/610060920001/SJUmxczP_default/index.html?videoId=' . $values['href'] . '" allowfullscreen webkitallowfullscreen mozallowfullscreen></iframe>';
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
