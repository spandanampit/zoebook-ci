<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

 	$current_user = wp_get_current_user();

 	// Switch to the main site
 	switch_to_blog(1); // Replace 1 with your main site's blog ID
 
 	$user_a = 1;
	$user_b = 2;
	$user_c = 3;
	$user_d = 4;
	$user_e = 5;
	$user1 = 6;
	$user2 = 7;
	$user3 = 8;
	$user4 = 9;
	$user5 = 10;

	if ( ! empty( $current_user->roles ) && is_array( $current_user->roles ) ) {
		if ( in_array( 'um_advance-user', $current_user->roles ) ) {
		   $user_a = 'advanceuser';
		}
	}
	if ( ! empty( $current_user->roles ) && is_array( $current_user->roles ) ) {
		if ( in_array( 'um_field-employee', $current_user->roles ) ) {
			$user_b = 'fieldemployee';
		}
	}
	if ( ! empty( $current_user->roles ) && is_array( $current_user->roles ) ) {
		if ( in_array( 'um_inside-employee', $current_user->roles ) ) {
			$user_c = 'insideemployee';
		}
	}
	if ( ! empty( $current_user->roles ) && is_array( $current_user->roles ) ) {
		if ( in_array( 'um_normal-user', $current_user->roles ) ) {
			$user_d = 'normaluser';
		}
	}
	if ( ! empty( $current_user->roles ) && is_array( $current_user->roles ) ) {
		if ( in_array( 'um_super-user', $current_user->roles ) ) {
			$user_e = 'superuser';
		}
	}

	$saved_checkbox_values = get_option('user_management_checkbox_values', array());
 
	if ( $saved_checkbox_values['advance-user']['Point-of-Purchase'] == 'Point-of-Purchase' ) {
	$user1 = 'advanceuser';
	}
	if ( $saved_checkbox_values['field-employee']['Point-of-Purchase'] == 'Point-of-Purchase' ) {
	$user2 = 'fieldemployee';
	}
	if ( $saved_checkbox_values['inside-employee']['Point-of-Purchase'] == 'Point-of-Purchase' ) {
	$user3 = 'insideemployee';
	}
	if ( $saved_checkbox_values['normal-user']['Point-of-Purchase'] == 'Point-of-Purchase' ) {
	$user4 = 'normaluser';
	}
	if ( $saved_checkbox_values['super-user']['Point-of-Purchase'] == 'Point-of-Purchase' ) {
	$user5 = 'superuser';
	}

	$is_admin = in_array('administrator', (array) $current_user->roles);
 
	// Switch back to the child site
	restore_current_blog();

	$user_id = get_current_user_id();

	$user_access_pointofpurchase = get_user_meta($user_id, 'user_access_pointofpurchase', true);
    
 
	if ( (($user1 === $user_a) || ($user2 === $user_b) || ($user3 === $user_c) || ($user4 === $user_d) || ($user5 === $user_e) && $user_access_pointofpurchase) || $is_admin ) {

 // if ( is_user_logged_in() ) {
 defined( 'ABSPATH' ) || exit;

get_header( 'shop' ); ?>
<section class="product-listing-sec">
<div class="container">
<div class="row">
<?php
/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>
<!-- <header class="woocommerce-products-header"> -->
	<?php //if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<!-- <h1 class="woocommerce-products-header__title page-title"><?php //woocommerce_page_title(); ?></h1> -->
	<?php //endif; ?>

	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
	remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
	remove_action('woocommerce_archive_description', 'woocommerce_product_archive_description', 10);
	?>
<!-- </header> -->
<div class="col-md-3">
	<div class="homecatLink">
	<h2> Categories </h2>
	<?php
		$taxonomy = 'product_cat';
		$arg = array(
			'taxonomy'    => $taxonomy,
			'hide_empty'  => false,
			'exclude' => 15
		);
	
		// Get subcategories of the current category
		
		$terms = get_terms($arg);
	
		$output = '<ul class="subcategories-list">';
	
		// Loop through product subcategories WP_Term Objects
		foreach ( $terms as $term ) {
			$term_link = get_term_link( $term, $taxonomy );
	
			$output .= '<li class="'. $term->slug .'"><a href="'. $term_link .'">'. $term->name .'</a></li>';
		}
	
		echo $output . '</ul>';
	?>
	</div>
	<div class="featuredBox">
		<h2> Specials </h2>
		<ul>
			<li>
				<span><a href=""><img src="https://pos.nittosupport.ca/pub/media/catalog/product/n/t/nt0258.jpg" alt="Tire Stand - Black"></a></span>
				<h5><a href="">Tire Stand - Black</a></h5>
				<p>Price: CAD
					0.00
				</p>  
				<div class="btn">
					<button type="submit" title="Add to Cart" class="">
					<span>Add to Cart </span>
					</button>
				</div>
				<!--
					<a href="#" class="fdetail">Add to Cart</a>-->
			</li>
			<li>
				<span><a href=""><img src="https://pos.nittosupport.ca/pub/media/catalog/product/n/i/nitto_tire_centre.png" alt="17 Inch Tire Centre / Centre de pneus de 17 pouces"></a></span>
				<h5><a href="">17 Inch Tire Centre / Centre de pneus de 17 pouces</a></h5>
				<p>Price: CAD
					0.00
				</p>
					
				<div class="btn">
					<button type="submit" title="Add to Cart" class="">
					<span>Add to Cart </span>
					</button>
				</div>
			</li>
		</ul>
	</div>
</div>
<div class="col-md-9 cus-product-wrap">
	<h2 class="woocommerce-products-header__title page-title"><?php if(is_front_page()) { ?> Welcome <span style="color:#006cb7;"><?php  echo $current_user->user_firstname; ?></span> : To the Toyo Point of Sale<?php } else { echo woocommerce_page_title(); } ?></h2>
	<h2 class="f-prodct">Featured Products:</h2>
<?php
if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' ); ?>
</div>

<?php
/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
do_action( 'woocommerce_sidebar' );

?>

</div>
</div>

</section>

<?php get_footer( 'shop' ); 
} else {
	$main_site_url = network_home_url();
	wp_redirect( $main_site_url );
	// wp_redirect( 'https://demowp.toyosupport.ca/' );
	exit;
}