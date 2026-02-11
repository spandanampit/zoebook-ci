<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package point-of-purchase
 */

?>
<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="utf-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="format-detection" content="telephone=no">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Welcome to Toyo Support Site</title>



<!-- Bootstrap CSS-->

<link href="https://demowp.toyosupport.ca/wp-content/themes/wplmsblankchildhtheme/css/bootstrap.css" rel="stylesheet" type="text/css">

<!-- Custom CSS -->

<link href="https://demowp.toyosupport.ca/wp-content/themes/wplmsblankchildhtheme/css/global-style.css" rel="stylesheet" type="text/css">

<!-- Media queries CSS -->

<link href="https://demowp.toyosupport.ca/wp-content/themes/wplmsblankchildhtheme/css/media-queries.css" rel="stylesheet" type="text/css">

<!-- bootstrap select CSS -->

<link rel="stylesheet" type="text/css" href="https://demowp.toyosupport.ca/wp-content/themes/wplmsblankchildhtheme/css/bootstrap-select.min.css" />

<!-- Custom css for listing page  -->

<link href="https://demowp.toyosupport.ca/wp-content/themes/wplmsblankchildhtheme/css/jquery.scrolling-tabs.css" rel="stylesheet">

<!-- Custom css for listing page  -->

<link rel="icon" href="https://demowp.toyosupport.ca/admin_theme/images/favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<?php   wp_head();   ?>

</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>


<script>
     // window.location.reload();
function setLanguage(lang) {
  // Set a cookie with the selected language
  document.cookie = `lang=${lang}; expires=Fri, 31 Dec 9999 23:59:59 GMT`;

  //window.location.href='http://localhost/webdev/toyo/site/dashboard';


  // Reload the page with the language parameter
 // const currentUrl = window.location.href;
  //alert(currentUrl);
  // const updatedUrl = `${currentUrl}?lang=${lang}`;
  // const updatedUrl = currentUrl+'?lang'+'='+${lang};
  // alert(updatedUrl);
  //window.location.href = updatedUrl;
   
   // Define the cookie name, value, and expiration date (in days)
//    const cookieName = 'myCookie';
//             const cookieValue = 'Hello, this is my cookie!';
//             const expirationDays = 7; // Cookie will expire in 7 days

//             // Calculate the expiration date
//             const expirationDate = new Date();
//             expirationDate.setDate(expirationDate.getDate() + expirationDays);

//             // Create the cookie string
//             const cookieString = `${cookieName}=${encodeURIComponent(cookieValue)}; expires=${expirationDate.toUTCString()}; path=/`;

//             // Set the cookie
//             document.cookie = cookieString;

      window.location.reload();

  
}


</script>


<?php 

if (isset($_COOKIE['lang']) && $_COOKIE['lang']=="fr") {
    // Cookie exists
    //$lang = $_COOKIE['lang'];
    $language="french";
   
 } else {

    $language="english";
    // Cookie doesn't exist
    //echo "The 'lang' cookie does not exist.";
 }

?>




<!-- Header start -->

<header class="headerWide">

    <div class="container header">

        <div class="row">

            <div class="col-xs-4 logo">

            <a href="<?php  echo site_url()   ?>/dashboard"><img src="https://demowp.toyosupport.ca/wp-content/themes/wplmsblankchildhtheme/img/logo.png" alt="Logo" title="Logo" class="img-responsive"/></a>

            </div>

            <div class="col-xs-8">

                <nav class = "navbar navbar-default" role = "navigation">   

                   <div class = "navbar-header">

                      <button type = "button" class = "navbar-toggle" 

                         data-toggle = "collapse" data-target = "#example-navbar-collapse">

                         <span class = "sr-only">Toggle navigation</span>

                         <span class = "icon-bar"></span>

                         <span class = "icon-bar"></span>

                         <span class = "icon-bar"></span>

                      </button>



<!--                      <a class = "navbar-brand" href = "#">Menu</a>-->

                   </div>



				   
                   <div class = "collapse navbar-collapse" id = "example-navbar-collapse">

                   <?php
// wp_nav_menu(array(
// 'theme_location' => 'primary', // Use the menu location you registered
// 'menu_class' => 'nav navbar-nav', // Add your custom CSS class
// 'container' => false, // Remove the wrapping <div>
// 'walker' => new Custom_Walker_Nav_Menu(), // Use the custom Walker class
// ));
?>
<ul id="menu-header-menu" class="nav navbar-nav"><li id="menu-item-529" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-529"><a href="#">Coop Guide</a></li>
<li id="menu-item-530" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-530"><a href="#">Contact us</a></li>
<li id="menu-item-531" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-531"><a href="#">My Account</a><ul class="dropdown-menu">	<li id="menu-item-532" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-532"><a href="#">Update Profile</a></li>
	<li id="menu-item-533" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-533"><a href="#">Chnage Pasword</a></li>
	<li id="menu-item-534" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-534"><a href="#">Management</a></li>
</ul>
</li>
</ul>
<ul  class="nav navbar-nav">
<li>
<a href="<?php echo wp_logout_url( network_home_url() ); ?>"><img src="http://demowp.toyosupport.ca/wp-content/uploads/2024/04/Logout-button-blk.png" alt="Logout" title="Logout" style="width:24px;"></a>
</li>
<li>
<?php //if (isset($_COOKIE['lang']) && $_COOKIE['lang']=="fr") {  ?>

<!--<a class="adeng" href="#" onclick="setLanguage('en')">English</a>-->

<?php   //}else{  ?>

<!--<a class="adfre" href="#" onclick="setLanguage('fr')">Français</a>-->

<?php  //}   ?> 
<?php echo do_shortcode('[wpml_language_selector_footer]');?>

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
            <img src="http://demowp.toyosupport.ca/wp-content/uploads/2024/04/tw-white.png" alt="Twitter">
            <p><a href="https://twitter.com/ToyoTiresCanada" target="_blank">Follow Us on<br>Twitter</a></p>
        </li>
        <li>
            <img src="http://demowp.toyosupport.ca/wp-content/uploads/2024/04/fb-white.png" alt="Facebook">
            <p><a href="https://www.facebook.com/ToyoTiresCanada" target="_blank">Like Us on<br>Facebook</a></p>
        </li>
        <li>
            <img src="http://demowp.toyosupport.ca/wp-content/uploads/2024/04/yt-white.png" alt="Youtube">
            <p><a href="https://www.youtube.com/ToyoTiresCanada" target="_blank">Subscribe on<br>YouYube</a></p>
        </li>
    </ul>
</section>
    
<!-- Sticky social media icon end -->      
    
	
<!-- Slider Start -->
<?php  //echo do_shortcode('[metaslider id="314"]');     ?>
<!-- Slider end -->

<!-- categories list start -->

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
						
				            <li><a href="<?php echo site_url();?>/admaterials"><i><img src="http://demowp.toyosupport.ca/wp-content/uploads/2024/04/lst-ico-2.png"></i>Advertising Material</a></li>
							
							
			<li><a href="#" target="_blank"><i><img src="http://demowp.toyosupport.ca/wp-content/uploads/2024/04/b2b11.png"></i>B2B Access</a></li>
							
						
			            <li><a href="#"><i><img src="http://demowp.toyosupport.ca/wp-content/uploads/2024/04/lst-ico-3.png"></i>Dealer Resources</a></li>
						<!--<//?php
			
				if($this->loginuserdetl['Level']==0){
				$usrmngmnt=0;
				}elseif($this->loginuserdetl['Level']==1){
				$usrmngmnt=0;
				}
				else
				{
				$usrmngmnt=1;
				}
				if($val['Management']==1 && ($user_data['accessotbannermanage']==1 || $user_data['accesstoweekvideomanage']==1 || $user_data['accesstobuetinmanage']==1 || $usrmngmnt==1)) 
				{
				?>
			<li><a href="<//?php echo base_url();?>management/index"><i><img src="<//?php echo base_url();?>assets/img/management-icon.png"></i><//?php echo $this->lang->line('Management'); ?></a></li>
			<//?php }?>-->
			
						
			<li><a href="<?php echo site_url();?>"><i><img src="http://demowp.toyosupport.ca/wp-content/uploads/2024/04/resource11.png"></i>Point of Purchase</a></li>
									
			<li><a href="https://demowp.toyosupport.ca/promomaterials/"><i><img src="http://demowp.toyosupport.ca/wp-content/uploads/2024/04/dealer31.png"></i>Promo Materials</a></li>
						
											<li><a href="#"><i><img src="http://demowp.toyosupport.ca/wp-content/uploads/2024/04/lst-ico-1.png"></i>Training Site</a></li>
			
								            <li><a href="https://demowp.toyosupport.ca/vehicleidea/idealist"><i><img src="http://demowp.toyosupport.ca/wp-content/uploads/2024/04/management-icon.png"></i>Vehicle Build</a></li>
					                   </ul>
    </div>
	</div>
	</div>
</section>


<form method="POST" action="https://claims.toyosupport.ca/login/process" accept-charset="UTF-8" id="my_form__claim" >
<input name="_token" type="hidden" value="ndBpTJQc3kz0AI4TTd4QPZ4FtxY3OEC8tiFEHgAE">
                <input name="userid" type="hidden" value="1">
				<input name="supportsiteuserid" type="hidden" value="128630">
</form>

<form method="POST" action="https://pos.toyosupport.ca/webservices/login.php" accept-charset="UTF-8" id="my_form_pos_menu" >

                <input name="username" type="hidden" value="parthasarothihazra@gmail.com">
				<input name="password" type="hidden" value="Pa@123456">
								<input name="Language" type="hidden" value="en">
					<input name="Level" type="hidden" value="3">
</form>
<form method="POST" action="https://promo.toyosupport.ca/webservices/login.php" accept-charset="UTF-8" id="my_form_promo_menu" >

                <input name="username" type="hidden" value="parthasarothihazra@gmail.com">
				<input name="password" type="hidden" value="Pa@123456">
								<input name="Language" type="hidden" value="en">
				<input name="Level" type="hidden" value="3">
</form>    
<!-- categories list End -->  