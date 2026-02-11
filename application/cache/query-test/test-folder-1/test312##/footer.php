<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package point-of-purchase
 */

?>
<!-- Footer start -->
<footer class="footerWide">
    <div class="container footer">
        <div class="row">
            <div class="col-sm-12">
                <div class="social-ft">
                    <a href="https://twitter.com/ToyoTiresCanada" target="_blank" class="twitter-ico"></a>
                    <a href="https://www.facebook.com/ToyoTiresCanada" target="_blank" class="facebook-ico"></a>
                    <a href="https://www.youtube.com/ToyoTiresCanada" target="_blank" class="youtube-ico"></a>
                </div>
            	<ul class="footerMenu">
            		<li><a href="https://demowp.toyosupport.ca/frontend/privacypolicy/">Privacy Policy</a></li>
                    <li><a href="https://demowp.toyosupport.ca/frontend/contactus/">Contact Us</a></li>
                </ul>
                <p>Copyright © 2018 Toyo Tires. All rights reserved. Powered by BIT</p>
            </div>
        </div>
    </div>
</footer>
<!-- Footer end -->
<script>
jQuery(document).ready(function(){
    jQuery('.cus-crt-btn .add_to_cart_button').html('<i class="fa fa-shopping-cart" aria-hidden="true"></i>');
    jQuery('.right-icon').on('click', function () { 
        jQuery('.bl-from').show(); 
        jQuery('.bl-address').hide();
    });
    // jQuery('#ship-to-different-address-checkbox').on('click', function () { 
    //     jQuery('.bl-from').hide(); 
    //     jQuery('.bl-address').show();
    // });
});
</script>

<?php wp_footer(); ?>

</body>
</html>
