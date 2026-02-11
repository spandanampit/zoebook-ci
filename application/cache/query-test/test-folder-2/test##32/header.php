<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package promo-materials
 */

$siteurl = str_replace('/promomaterials', '',get_bloginfo('url'));
?>
<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?php echo get_bloginfo( 'name' ); ?></title>


<link href="<?php echo $siteurl; ?>/wp-content/themes/wplmsblankchildhtheme/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?php echo $siteurl; ?>/wp-content/themes/wplmsblankchildhtheme/css/global-style.css" rel="stylesheet" type="text/css">
<link href="<?php echo $siteurl; ?>/wp-content/themes/wplmsblankchildhtheme/css/media-queries.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="<?php echo $siteurl; ?>/wp-content/themes/wplmsblankchildhtheme/css/bootstrap-select.min.css" />
<link href="<?php echo $siteurl; ?>/wp-content/themes/wplmsblankchildhtheme/css/jquery.scrolling-tabs.css" rel="stylesheet">

<link rel="icon" href="<?php echo $siteurl; ?>/admin_theme/images/favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<?php   wp_head();   ?>

</head>

<style>
.navbar-nav .menu-item-has-children {
    position: relative;
}

.navbar-nav .menu-item-has-children .sub-menu {
    display: none;
    position: absolute;
    background: #1969bc;
    list-style: none;
    padding: 5px;
    min-width: 180px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2)

}

.navbar-nav .menu-item-has-children:hover .sub-menu,
.navbar-nav .menu-item-has-children:focus-within .sub-menu {
    display: block;
}

.navbar-nav .sub-menu li a {
    color: black !important;
    padding: 8px 15px;
    display: block;
    text-decoration: none;
}

.navbar-nav .sub-menu li a:hover {
    background: white; /* Darker blue on hover */
    border-radius: 3px;
}

li > ul, li > ol {
    margin-bottom: 0;
    margin-left: 0px !important;
}

@media (min-width: 1200px) {
    .container {
        width: 1410px;
    }
}
</style>

<body <?php body_class(); ?> >
    
<?php wp_body_open(); ?>
<!--</?php echo $siteurl;die; ?>-->

<script>
function setLanguage(lang) {
    document.cookie = `lang=${lang}; expires=Fri, 31 Dec 9999 23:59:59 GMT`;
    window.location.reload();
}
</script>


<?php  
$current_language = apply_filters('wpml_current_language', null);
    if ($current_language == 'fr') {
        $language = 'french';
    } else {
        $language = 'english';
    }
  //echo $language;
  $url = "https://demowp.toyosupport.ca";
?>

<!-- Header start -->

<header class="headerWide">

    <div class="container header">

        <div class="row">

            <div class="col-xs-4 logo">

            <!--<a href="</?php  echo site_url() ?>/dashboard"><img src="</?php echo $siteurl; ?>/wp-content/themes/wplmsblankchildhtheme/img/logo.png" alt="Logo" title="Logo" class="img-responsive"/></a>-->
            <a href="<?php echo $url . ($current_language == 'en' ? '/dashboard/' : '/fr/tableau-de-bord'); ?>">
              <img src="<?php echo $siteurl; ?>/wp-content/themes/wplmsblankchildhtheme/img/logo.png" alt="Logo" title="Logo" class="img-responsive"/>
            </a>

            </div>

            <div class="col-xs-8">

                <nav class = "navbar navbar-default" role = "navigation">   

                    <div class = "navbar-header">

                        <button type = "button" class = "navbar-toggle" data-toggle = "collapse" data-target = "#example-navbar-collapse">
                            <span class = "sr-only">Toggle navigation</span>
                            <span class = "icon-bar"></span>
                            <span class = "icon-bar"></span>
                            <span class = "icon-bar"></span>
                        </button>
                   </div>

                    <div class = "collapse navbar-collapse" id = "example-navbar-collapse">
                       
                    <?php    
                        wp_nav_menu(array(
                            'menu'           => 'Header Menu',
                            'theme_location' => 'header-menu',
                            'menu_class'     => 'nav navbar-nav',
                            'container'      => false,
                            'fallback_cb'    => false,
                            'depth'          => 2,
                        ));
                    ?>


<!--
<ul id="menu-header-menu" class="nav navbar-nav"><li id="menu-item-529" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-529"><a href="#">Coop Guide</a></li>
<li id="menu-item-530" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-530"><a href="#">Contact us</a></li>
<li id="menu-item-531" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-531"><a href="#">My Account</a><ul class="dropdown-menu">	<li id="menu-item-532" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-532"><a href="#">Update Profile</a></li>
	<li id="menu-item-533" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-533"><a href="#">Chnage Pasword</a></li>
	<li id="menu-item-534" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-534"><a href="#">Management</a></li>
</ul>
-->

                    <ul  class="nav navbar-nav">
                        <li>
                            <a href="<?php echo wp_logout_url( network_home_url() ); ?>"><img src="<?php echo $siteurl; ?>/wp-content/uploads/2024/04/Logout-button-blk.png" alt="Logout" title="Logout" style="width:24px;"></a>
                        </li>
                    </ul>

                </div>

                </nav>

            </div>

        </div>

    </div>

</header>

<!-- Header end --> 
    
<!-- Sticky social media icon Start -->  
    
<section class="sticky-container innerSticker">
    <ul class="sticky">
        <li>
            <img src="<?php echo $siteurl; ?>/wp-content/uploads/2024/04/tw-white.png" alt="Twitter">
            <p><a href="https://twitter.com/ToyoTiresCanada" target="_blank">Follow Us on<br>Twitter</a></p>
        </li>
        <li>
            <img src="<?php echo $siteurl; ?>/wp-content/uploads/2024/04/fb-white.png" alt="Facebook">
            <p><a href="https://www.facebook.com/ToyoTiresCanada" target="_blank">Like Us on<br>Facebook</a></p>
        </li>
        <li>
            <img src="<?php echo $siteurl; ?>/wp-content/uploads/2024/04/yt-white.png" alt="Youtube">
            <p><a href="https://www.youtube.com/ToyoTiresCanada" target="_blank">Subscribe on<br>YouYube</a></p>
        </li>
    </ul>
</section>
    
<!-- Sticky social media icon end -->      
    
	

<!-- categories list start -->
<?php
$url = "https://demowp.toyosupport.ca";
?>
<section class="cl-wrapper">
    <div class="container">
	<div class="navbar-inrtp-MenuBx"><!--New div add (navbar-inrtp-MenuBx) -->
	<div class="text-center"><!--New div add-->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#NavbarInrtopMenu"><!--New button for mobile icon-->
			         <span class="sr-only">Toggle navigation</span>
			         <span class="icon-bar"></span>
			         <span class="icon-bar"></span>
			         <span class="icon-bar"></span>
		      	</button>
		     </div>
	<div class="collapse navbar-collapse" id="NavbarInrtopMenu"> <!--New div add-->
        <ul class="clearfix lst-cate navbar-nav ml-auto topnav">
						
            <li><a href="<?php echo $url; echo ($current_language == 'en' ? '/admaterials/' : '/fr/admateriaux/'); ?>"><i><img src="<?php echo $siteurl; ?>/wp-content/uploads/2024/04/lst-ico-2.png"></i><?php echo $language == 'english' ? 'Advertising Material' : 'Matériel publicitaire' ?></a></li>
			<?php if($role != 'normal_user') { ?>
			    <li><a href="<?php echo $url; echo ($current_language == 'en' ? '/dealer-resources/' : '/fr/ressources-pour-les-concessionnaires/'); ?>"><i><img src="<?php echo $siteurl; ?>/wp-content/uploads/2024/04/lst-ico-3.png"></i><?php echo $language == 'english' ? 'Dealer Resources' : 'Ressources du détaillant' ?></a></li>
			<?php }; ?>
			<li><a href="<?php echo $url; echo ($current_language == 'en' ? '/training/' : '/fr/formation/'); ?>"><i><img src="<?php echo $siteurl; ?>/wp-content/uploads/2024/04/lst-ico-1.png"></i><?php echo $language == 'english' ? 'Training Site' : ' Site de formation' ?></a></li>
			<li><a href="<?php echo $url; echo ($current_language == 'en' ? '/promomaterials/' : '/promomaterials/fr'); ?>"><i><img src="<?php echo $siteurl; ?>/wp-content/uploads/2024/04/dealer31.png"></i><?php echo $language == 'english' ? 'Promo Materials' : 'Matériel promotionnel' ?></a></li>
   			<li><a href="<?php echo $url; echo ($current_language == 'en' ? '/pointofpurchase/' : '/pointofpurchase/fr'); ?>"><i><img src="<?php echo $siteurl; ?>/wp-content/uploads/2024/04/resource11.png"></i><?php echo $language == 'english' ? 'Point of Purchase' : 'Point de vente' ?></a></li>
    
       </ul>
    </div>
	</div>
	</div>
</section>


   
<!-- categories list End -->  
