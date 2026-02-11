<?php
/**
 * promo-materials functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package promo-materials
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

include_once get_stylesheet_directory().'/functions-custom.php';


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
 
function promo_materials_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on promo-materials, use a find and replace
		* to change 'promo-materials' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'promo-materials', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'promo-materials' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'promo_materials_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'promo_materials_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function promo_materials_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'promo_materials_content_width', 640 );
}
add_action( 'after_setup_theme', 'promo_materials_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function promo_materials_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'promo-materials' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'promo-materials' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'promo_materials_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function promo_materials_scripts() {
	wp_enqueue_style( 'promo-materials-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'promo-materials-style', 'rtl', 'replace' );

	wp_enqueue_script( 'promo-materials-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'promo_materials_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
   add_theme_support( 'woocommerce' );
}

/** Remove product data tabs */
 
add_filter( 'woocommerce_product_tabs', 'my_remove_product_tabs', 98 );
 
function my_remove_product_tabs( $tabs ) {
  unset( $tabs['additional_information'] ); // To remove the additional information tab
  return $tabs;
}

/**
 * @snippet       Rename Description Product Tab Label @ WooCommerce Single Product
 */
 
add_filter( 'woocommerce_product_description_tab_title', 'bbloomer_rename_description_product_tab_label' );
 
function bbloomer_rename_description_product_tab_label() {
    return 'Details';
}

/**
 * Remove "Description" Heading Title @ WooCommerce Single Product Tabs
 */
add_filter( 'woocommerce_product_description_heading', '__return_null' );


/**
 * Pre-populate Woocommerce checkout fields
 * Note that this filter populates shipping_ and billing_ fields with a different meta field eg 'first_name'
 */
// add_filter('woocommerce_checkout_get_value', function($input, $key ) {

// 	global $current_user;

// 	switch ($key) :
// 		case 'billing_first_name':
// 		//case 'shipping_first_name':
// 			return $current_user->first_name;
// 		break;
		
// 		case 'billing_last_name':
// 		//case 'shipping_last_name':
// 			return $current_user->last_name;
// 		break;

// 		case 'billing_email':
// 			return $current_user->user_email;
// 		break;

// 		case 'billing_phone':
// 			return $current_user->phone;
// 		break;

// 	endswitch;

// }, 10, 2);

/**
 * @snippet       Shipping Phone & Email - WooCommerce
 */
 
// add_filter( 'woocommerce_checkout_fields', 'toyo_shipping_phone_checkout' );
 
// function toyo_shipping_phone_checkout( $fields ) {
//   $fields['shipping']['shipping_phone'] = array(
//       'label' => 'Phone',
//       'type' => 'tel',
//       'required' => true,
//       'class' => array( 'form-row-wide' ),
//       'validate' => array( 'phone' ),
//       'autocomplete' => 'tel',
//       'priority' => 100,
//   );
//   return $fields;
// }
  
// add_action( 'woocommerce_admin_order_data_after_shipping_address', 'toyo_shipping_phone_checkout_display' );
 
// function toyo_shipping_phone_checkout_display( $order ){
//     echo '<p><b>Shipping Phone:</b> ' . get_post_meta( $order->get_id(), '_shipping_phone', true ) . '</p>';
// }




if ( ! defined( 'ABSPATH' ) || ! defined( 'WC_VERSION' ) ) {
    exit;
}

// Function to get user wallet balance
function get_user_wallet_balance( $user_id ) {
    return get_user_meta( $user_id, 'wallet_amount', true ) ?: 0;
}

// Add wallet checkbox to checkout
add_action( 'woocommerce_review_order_before_order_total', 'add_wallet_checkbox' );
function add_wallet_checkbox() {
    $user_id = get_current_user_id();
    $wallet_balance = 100; // Replace with: get_user_meta($user_id, 'wallet_amount', true);

    $wallet_used = WC()->session->get( 'wallet_discount_applied', 0 );
    $remaining_balance = $wallet_balance - $wallet_used;
    
    ?>
    <tr class="wallet-option">
        <th><?php echo __( 'Use your Toyo dollers balance?', 'your-text-domain' ); ?></th>
        <td class="d-flex">
            <p>Do you wish to apply your Toyo dollers to this purchase? </p>
            <label>
                <input 
                    type="checkbox" 
                    name="use_wallet" 
                    value="50" 
                    id="use_wallet"
                    <?php checked( isset( WC()->session ) ? WC()->session->get( 'use_wallet' ) : false, true ); ?>
                /> 
                <?php 
                printf(
                    __( 'Apply wallet balance (%s) - Total balance left: %s', 'your-text-domain' ), 
                    wc_price( $wallet_balance ),
                    wc_price( max(0, $remaining_balance) )
                ); 
                ?>
            </label>
        </td>
    </tr>
    <?php
}

// Apply wallet discount to subtotal
add_action( 'woocommerce_cart_calculate_fees', 'apply_wallet_discount' );
function apply_wallet_discount( $cart ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;
    if ( ! WC()->session ) return;

    $use_wallet = WC()->session->get( 'use_wallet' );
    if ( $use_wallet ) {
        $user_id = get_current_user_id();
        if ( ! $user_id ) return;

        // $wallet_balance = get_user_wallet_balance( $user_id );
        $wallet_balance = 100;
        $cart_subtotal = WC()->cart->subtotal;
        
        if ( $wallet_balance > 0 ) {
            $discount = min( $wallet_balance, $cart_subtotal );
            if ( $discount > 0 ) {
                $cart->add_fee( __( 'Wallet Discount', 'your-text-domain' ), -$discount, true );
                WC()->session->set( 'wallet_discount_applied', $discount );
            }
        }
    }
}

// Save wallet checkbox state
add_action( 'woocommerce_checkout_update_order_review', 'save_wallet_option' );
function save_wallet_option( $post_data ) {
    parse_str( $post_data, $post_data_array );
    WC()->session->set( 'use_wallet', isset( $post_data_array['use_wallet'] ) ? 1 : 0 );
}

// Save applied wallet discount to order meta
add_action( 'woocommerce_checkout_create_order', 'save_wallet_discount_to_order', 10, 2 );
function save_wallet_discount_to_order( $order, $data ) {
    $wallet_discount = WC()->session->get( 'wallet_discount_applied', 0 );
    if ( $wallet_discount > 0 ) {
        $order->update_meta_data( '_wallet_discount_applied', $wallet_discount );
    }
}

// Display wallet discount on admin order details
add_action( 'woocommerce_admin_order_totals_after_total', 'display_wallet_discount_in_admin' );
function display_wallet_discount_in_admin( $order_id ) {
    $order = wc_get_order( $order_id );
    $wallet_discount = $order->get_meta( '_wallet_discount_applied', true );

    if ( $wallet_discount > 0 ) {
        echo '<tr>
            <td class="label">' . __( 'Wallet Discount:', 'woocommerce' ) . '</td>
            <td>- ' . wc_price( $wallet_discount ) . '</td>
        </tr>';
    }
}

// Wallet checkbox script for updating checkout
add_action( 'wp_footer', 'wallet_checkbox_script' );
function wallet_checkbox_script() {
    if ( is_checkout() ) :
    ?>
    <script>
    jQuery(function($) {
        $(document).on('change', '#use_wallet', function() {
            $('body').trigger('update_checkout');
        });
    });
    </script>
    <?php
    endif;
}


add_action( 'woocommerce_checkout_order_processed', 'handle_wallet_discount_after_order', 10, 1 );
function handle_wallet_discount_after_order( $order_id ) {
    $order = wc_get_order( $order_id );
    
    $user_id = $order->get_user_id();

    if ( $user_id ) {
        $wallet_discount = $order->get_meta( '_wallet_discount_applied', true );
        if ( $wallet_discount > 0 ) {
            // $wallet_balance = get_user_meta( $user_id, 'wallet_amount', true ) ?: 0;
            $wallet_balance = 100;
            $new_balance = $wallet_balance - $wallet_discount;
            update_user_meta( $user_id, 'wallet_amount', $new_balance );
            // $order->add_order_note( sprintf(
            //     __( 'Wallet balance reduced by %s. New balance: %s.', 'your-text-domain' ),
            //     wc_price( $wallet_discount ),
            //     wc_price( $new_balance )
            // ) );
        }
    }
}

// Change button color
function custom_change_view_cart_button_color($fragments)
{
	ob_start();
?>
	<a href="<?php echo esc_url(wc_get_cart_url()); ?>" tabindex="1" class="button wc-forward" style="background-color: orange; color: white;">
		View cart
	</a>
<?php
	$fragments['.wc-forward'] = ob_get_clean();
	return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'custom_change_view_cart_button_color');


// Remove the coupon field on the WooCommerce cart page
function remove_coupon_field_on_cart_page($enabled) {
    if (is_cart()) {
        $enabled = false;
    }
    return $enabled;
}
add_filter('woocommerce_coupons_enabled', 'remove_coupon_field_on_cart_page');


function custom_order_comments_css() {
    $custom_css = "
        #order_comments {
            height: 205px !important;
        }
        
        #ship-to-different-address-checkbox {
            position: relative;
            margin-right: 5px !important;
        }
        
        .woocommerce-columns--addresses{
            display: flex;
        }
        .woocommerce-column--shipping-address address{
            min-height: 196px;
        }
        
        .woocommerce-column--billing-address address {
            min-height: 196px;
        }
        
        .d-flex{
            display:flex;
        }
        .w-18{
            width:18% !important;
        }
        
        .attachment-woocommerce_thumbnail{
                width: 64px !important;
        }";
    wp_add_inline_style('woocommerce-inline', $custom_css);
}
add_action('wp_enqueue_scripts', 'custom_order_comments_css');


add_action('woocommerce_review_order_after_submit', 'add_custom_checkout_button');

function add_custom_checkout_button() {
    ?>
    <style>
        .custom-button {
            background-color: #ff6e00;
            color: white;
            padding: 7px 4px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            margin-left: 88rem;
            font-weight: bold;
        }
    </style>
    <?php
    echo '<a href="' . home_url() . '/promomaterials/cart">
        <button type="button" class="custom-button"> 
            &nbsp; Edit Order &nbsp;
        </button>
      </a>';
}


add_action('wp_footer', function() {
    if (is_cart()) {
        ?>
		<style>
			#add_payment_method table.cart img, .woocommerce-cart table.cart img, .woocommerce-checkout table.cart img {
				width: 32px;
				box-shadow: none;
				min-width: 6rem !important;
				max-width: 6rem !important;
				padding: 3px;
				border: 1px solid black;
			}
			
			.woocommerce-error, .woocommerce-info, .woocommerce-message {
			    background-color: #d7d7d7 !important;
			}
		</style>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let cartTitle = document.querySelector('h1');
                if (cartTitle && cartTitle.textContent.trim() === 'Cart') {
                    cartTitle.textContent = 'Toyo Promotional Items Cart';
                }
            });
        </script>
        <?php
    }
});


function custom_woocommerce_inline_css() {
    echo '<style>
        .woocommerce-error, .woocommerce-info, .woocommerce-message {
			    background-color: #d7d7d7 !important;
			}
    </style>';
}
add_action('wp_head', 'custom_woocommerce_inline_css');

function restrict_admin_access_by_site() {
    $user = wp_get_current_user();
    $allowed_site_id = 3;
    $restricted_user_email = 'mike@topmktg.net';

    if (is_multisite()) {
        if ($user->user_email == $restricted_user_email && get_current_blog_id() != $allowed_site_id) {
            wp_redirect(home_url() . '/dashboard');
            exit;
        }
    }
}


