<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Graming
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<!-- Required meta tags -->
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<?php wp_head(); ?>
</head>

<body <?php if (is_user_logged_in()) {
	echo 'class="logged"';
} ?>>
	<div id="overlayer">
		<div class="loader">
			<div class="loader-inner"></div>
		</div>
	</div>
	<!-- header-section start -->
	<header class="header-section">
		<div class="header">
			<div class="header_logo">
				<a class="site-logo" href="<?php if (!is_user_logged_in()): ?>/<?php else: ?>/my-account/<?php endif; ?>">
					Graming <img src="<?php echo get_template_directory_uri() . '/src/images/logo.svg' ?>">
				</a>
			</div>
			<nav class="primary_menu">
				<?php wp_nav_menu(['theme_location' => 'menu-1']); ?>
			</nav>
			<div class="account_menu">
				<div class="trust_pilot">
					<img src="<?php echo get_template_directory_uri(); ?>/src/images/Trust_Pilot_Top.svg" alt="">
					<img src="<?php echo get_template_directory_uri(); ?>/src/images/Trust_Pilot_Bottom.svg" alt="">
				</div>
				<?php if (!is_user_logged_in()): ?>
					<div class="login_btn btn-gray"><a href="/my-account">Log in</a></div>
					<div class="signup_btn btn-red"><a href="/my-account/?register">Sign Up</a></div>
				<?php else: ?>
					<div class="balance">
						<a href="/service/usd/">
							<?php get_user_balance(); ?>
						</a>
					</div>
				<?php endif; ?>
				<div class="my_account">
					<div class="account_icon"></div>
					<ul class="sub-menu">
						<?php if (!is_user_logged_in()): ?>
							<div class="login_btn btn-gray"><a href="/my-account">Log in</a></div>
							<div class="signup_btn btn-red"><a href="/my-account/?register">Sign Up</a></div>
						<?php else: ?>
							<li>
								<?php echo get_user_email(); ?>
							</li>
							<li><a href="/my-account">Graming Panel</a></li>
							<li><a href="/my-account/orders/">View Orders</a></li>
							<li><a href="<?php echo wp_logout_url("/"); ?>">Log Out</a></li>
							<div class="btn-red"><a href="/service/usd/">Top up</a></div>
						<?php endif; ?>
					</ul>

				</div>

				<div class="additional_menu">
					<div class="additional_menu_icon"></div>
					<?php wp_nav_menu(['theme_location' => 'menu-3']); ?>
					<?php wp_nav_menu(['theme_location' => 'menu-2']); ?>

				</div>
			</div>
		</div>
	</header>
	<!-- header-section end -->

	<?php
// $userName="svi_pl";
// $apiKey="SsOycN7Pejhz7xsZWzwx9TmsO";
// $auth = base64_encode($userName.":".$apiKey);
// $postParams = array(
// 	"scraper" => "instagramProfile",
// 	"account" => "k_gntv234234"
// );

// $apiEndPoint = "http://api.scraping-bot.io/scrape/data-scraper";

// $json = json_encode($postParams);


// $curl = curl_init();

// curl_setopt_array($curl, array(
//   CURLOPT_URL => $apiEndPoint,
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => "POST",
//   CURLOPT_POSTFIELDS => $json,
//   CURLOPT_HTTPHEADER => array(
//     "Authorization: Basic ".$auth,
//     "Content-Type: application/json"
//   ),
// ));

// $response = curl_exec($curl);
// $err = curl_error($curl);

// curl_close($curl);

// if ($err) {
//   echo "cURL Error #:" . $err;
// } else {
//   echo $response;
// }





// $userName = "svi_pl";
// $apiKey = "SsOycN7Pejhz7xsZWzwx9TmsO";
// $auth = base64_encode($userName . ":" . $apiKey);

// $responseId = "kcb2dt1702034682385rrdrik29tmd8";
// $scraper = "instagramProfile";

// $responseEndPoint = "http://api.scraping-bot.io/scrape/data-scraper-response?responseId={$responseId}&scraper={$scraper}";

// $curl = curl_init();

// curl_setopt_array($curl, array(
//     CURLOPT_URL => $responseEndPoint,
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST => "GET",
//     CURLOPT_HTTPHEADER => array(
//         "Authorization: Basic " . $auth,
//         "Content-Type: application/json"
//     ),
// ));

// $responseData = curl_exec($curl);
// $err = curl_error($curl);

// curl_close($curl);

// if ($err) {
//     echo "cURL Error #:" . $err;
// } else {
//     echo $responseData;
// }
?>
