<?php

/**
 * Site Under Maintenance
 */
Route::get('maintenance', 'HomeController@maintenance');

/**
 * Main Routes
 */
Route::middleware('install', 'web', 'maintenance', 'fw-block-bl')->group(function(){

	// Get Home Page
	Route::get('/', 'HomeController@index')->name('home');
	//Clear Cache facade value:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return $exitCode;
});

//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
	return $exitCode;});

//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
	return $exitCode;});

//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
	return $exitCode;});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
	return $exitCode;});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
	return $exitCode;});

	Route::get('vi/{ad_id}', 'Ads\ShowController@redirect');

	// Search Ads
	Route::get('/search', 'SearchController@search');
	Route::get('/search/country{country}', 'SearchController@country');
	Route::get('/search/state{state}', 'SearchController@state');

	// Create Search alert
	Route::post('/search/alert', 'AlertController@create');

	// Delete Search alert
	Route::post('/search/alert/delete', 'AlertController@delete');

	// Random Ad
	Route::get('/random', 'Ads\ShowController@random');

	// Get Countries
	Route::get('/countries', 'Ads\ShowController@countries');

	// Browse Ads
	Route::get('/browse', 'Ads\ShowController@browse');

	// Browse ads from followers
	Route::get('/browse/following', 'Ads\ShowController@following');

	// Browse By countries
	Route::get('/browse/country/{country}', 'Ads\ShowController@country');

	// Get Register routes
	Route::get('auth/register', 'Auth\RegisterController@getRegister');
	Route::post('auth/register', 'Auth\RegisterController@postRegister');

	// Get Login routes
	Route::get('auth/login', 'Auth\LoginController@getLogin')->name('login');
	Route::post('auth/login', 'Auth\LoginController@postLogin');

	// Login using facebook
	Route::get('/auth/facebook', 'Auth\FacebookController@redirect');
	Route::get('/auth/facebook/callback', 'Auth\FacebookController@callback');

	// Login using twitter
	Route::get('/auth/twitter', 'Auth\TwitterController@redirect');
	Route::get('/auth/twitter/callback', 'Auth\TwitterController@callback');

	// Login using google
	Route::get('/auth/google', 'Auth\GoogleController@redirect');
	Route::get('/auth/google/callback', 'Auth\GoogleController@callback');

	// Login using instagram
	Route::get('/auth/instagram', 'Auth\InstagramController@redirect');
	Route::get('/auth/instagram/callback', 'Auth\InstagramController@callback');

	// Login using pinterest
	Route::get('/auth/pinterest', 'Auth\PinterestController@redirect');
	Route::get('/auth/pinterest/callback', 'Auth\PinterestController@callback');

	// Login using linkedin
	Route::get('/auth/linkedin', 'Auth\LinkedinController@redirect');
	Route::get('/auth/linkedin/callback', 'Auth\LinkedinController@callback');

	// Login using vk
	Route::get('/auth/vk', 'Auth\VkController@redirect');
	Route::get('/auth/vk/callback', 'Auth\VkController@callback');

	// Login using Phone number
	Route::get('/auth/phone', 'Auth\PhoneController@redirect');
	Route::get('/auth/phone/callback', 'Auth\PhoneController@callback');

	// Password Reset
	Route::get('auth/password/reset', 'Auth\PasswordController@reset');
	Route::post('auth/password/reset', 'Auth\PasswordController@email');

	// Update Password
	Route::get('auth/password/update', 'Auth\PasswordController@update');
	Route::post('auth/password/update', 'Auth\PasswordController@new_pass');

	// Active Account
	Route::get('auth/activation', 'Auth\ActivationController@activation');
	Route::get('auth/activation/phone', 'Auth\ActivationController@phone');
	Route::post('auth/activation/phone', 'Auth\ActivationController@phone_verify');
	Route::get('auth/activation/phone/resend', 'Auth\ActivationController@phone_resend');
	Route::post('auth/activation/phone/resend', 'Auth\ActivationController@phone_send');
	Route::get('auth/activation/resend', 'Auth\ActivationController@new_key');
	Route::post('auth/activation/resend', 'Auth\ActivationController@resend');

	// Get Category
	Route::get('category/{parent}/{sub?}', 'Categories\CategoriesController@category');

	// Show Page
	Route::get('page/{slug}', 'PagesController@show');

	// Get Stores
	Route::get('stores', 'Stores\StoreController@stores');

	// Get Store
	Route::get('store/{store}', 'Stores\StoreController@store');

	// Contact Store Owner
	Route::post('store/{store}/contact', 'Stores\FeedbackController@send');

	// Show ad reviews
	Route::get('store/{store}/reviews/{id}', 'Stores\ReviewsController@reviews');

	// Get Pricing Plans
	Route::get('pricing', 'PlansController@plans');

	// View Ad Details
	Route::get('listing/{slug}', 'Ads\ShowController@show');

	// Translate Text
	Route::post('tools/translate', 'Tools\TranslateController@translate');

	// Subscribe to newsletter
	Route::get('tools/newsletter/subscribe', 'Tools\ToolsController@newsletter');

	// Send Ad to friend
	Route::post('tools/send', 'Tools\ToolsController@send');

	// Get states by country
	Route::get('tools/geo/states/states_by_country', 'Tools\ToolsController@states_by_country');

	// Get cities by state
	Route::get('tools/geo/cities/cities_by_state', 'Tools\ToolsController@cities_by_state');

	// Contact us
	Route::get('contact', 'ContactController@contact');
	Route::post('contact', 'ContactController@send');

	// Get Sitemap 
	Route::get('sitemap', 'SitemapController@index');
	Route::get('sitemap/ads', 'SitemapController@ads');
	Route::get('sitemap/categories', 'SitemapController@categories');

});


/**
 * Auth Routes
 */

Route::middleware('auth', 'maintenance', 'fw-block-bl')->group(function(){

	// Logout
	Route::get('auth/logout', 'Auth\AuthController@logout');

	// Create New Ad
	Route::get('create', 'Ads\CreateController@create');
	Route::post('create', 'Ads\CreateController@insert');

	// Create New Store
	Route::get('create/store', 'Stores\CreateController@create');
	Route::post('create/store', 'Stores\CreateController@insert');

	// User Account
	Route::get('account/settings', 'Account\AccountSettings@settings');
	Route::post('account/settings', 'Account\AccountSettings@update');

	// Login History
	Route::get('account/login/history', 'Account\HistoryController@history');

	// Two Factor Authentication
	Route::get('account/secure/2fa', 'Account\Google2FAController@get');

	// User Messages
	Route::get('account/inbox', 'Account\MessagesController@inbox');

	// Send user message about ad
	Route::post('account/inbox/create', 'Account\MessagesController@create');

	// Read Message
	Route::get('account/inbox/read/{id}', 'Account\MessagesController@read');

	// Delete Message
	Route::get('account/inbox/delete/{id}', 'Account\MessagesController@delete');

	// Reply Message
	Route::get('account/inbox/reply', 'Account\MessagesController@reply');
	Route::post('account/inbox/reply', 'Account\MessagesController@sendreply');

	// User Ads
	Route::get('account/ads', 'Ads\AdsController@myads');

	// Archive Ad
	Route::get('account/ads/archive/{ad}', 'Ads\AdsController@archive');

	// Edit Ad
	Route::get('account/ads/edit/{ad}', 'Ads\EditController@edit');
	Route::post('account/ads/edit/{ad}', 'Ads\EditController@update');

	// Delete Ad
	Route::get('account/ads/delete/{ad}', 'Ads\AdsController@delete');

	// Get Trash
	Route::get('account/ads/trash', 'Ads\AdsController@trash');

	// Restore Ad
	Route::get('account/ads/restore/{id}', 'Ads\AdsController@restore');

	// Delete Permanently
	Route::get('account/ads/remove/{id}', 'Ads\AdsController@remove');

	// Ad statistics
	Route::get('account/ads/stats/{ad}', 'Ads\AdsController@stats');

	// User Offers
	Route::get('account/offers', 'Ads\OffersController@myoffers');

	// Accept offer
	Route::get('account/offers/accept/{id}', 'Ads\OffersController@accept');

	// Refuse offer
	Route::get('account/offers/refuse/{id}', 'Ads\OffersController@refuse');

	// Delete offer
	Route::get('account/offers/delete/{id}', 'Ads\OffersController@delete');

	// Auto share ads
	Route::get('account/autoshare', 'Account\AutoShareController@autoshare');
	Route::post('account/autoshare', 'Account\AutoShareController@update');

	// Get user favorites ads
	Route::get('account/favorite/ads', 'Account\FavoritesController@ads');

	// Add ad to favorites
	Route::post('account/favorite/ads/add', 'Account\FavoritesController@add_ad');

	// Remove ad from favorites
	Route::get('account/favorite/ads/delete/{id}', 'Account\FavoritesController@delete_ad');

	// Get user Comments 
	Route::get('account/comments', 'Account\CommentsController@comments');

	// Read Comment
	Route::get('account/comments/read/{id}', 'Comments\OptionsController@read');

	// Edit Comment
	Route::get('account/comments/edit/{id}', 'Comments\OptionsController@edit');
	Route::post('account/comments/edit/{id}', 'Comments\OptionsController@update');

	// Delete Comment
	Route::get('account/comments/delete/{id}', 'Comments\OptionsController@delete');

	// Get Notification
	Route::get('account/notifications', 'Account\NotificationsController@redirect');

	// Get Ads Notifications
	Route::get('account/notifications/ads', 'Account\NotificationsController@ads');

	// Delete Ad Notification
	Route::get('account/notifications/ads/delete/{id}', 'Account\NotificationsController@delete_ad');

	// Get Comments Notifications
	Route::get('account/notifications/comments', 'Account\NotificationsController@comments');

	// Delete Comment Notification
	Route::get('account/notifications/comments/delete/{id}', 'Account\NotificationsController@delete_comment');

	// Get Likes Notifications
	Route::get('account/notifications/likes', 'Account\NotificationsController@likes');

	// Delete Like Notification
	Route::get('account/notifications/likes/delete/{id}', 'Account\NotificationsController@delete_like');

	// Get Messages Notifications
	Route::get('account/notifications/warnings', 'Account\NotificationsController@warnings');

	// Get Account Upgrade Payments
	Route::get('account/payments', 'Account\PaymentsController@account_upgrade');

	// Get Ads Upgrade Payments
	Route::get('account/payments/ads', 'Account\PaymentsController@ads_upgrade');

	// Store Settings
	Route::get('account/store/settings', 'Account\Store\StoreController@settings');
	Route::post('account/store/settings', 'Account\Store\StoreController@update');

	// Store Reviews
	Route::get('account/store/reviews', 'Account\Store\ReviewsController@reviews');

	// Publish OR Hide Review
	Route::get('account/store/reviews/publish/{id}', 'Account\Store\ReviewsController@publish');
	Route::get('account/store/reviews/hide/{id}', 'Account\Store\ReviewsController@hide');

	// Store Feedback
	Route::get('account/store/feedback', 'Account\Store\FeedbackController@feedback');

	// Delete Feedback
	Route::get('account/store/feedback/delete/{id}', 'Account\Store\FeedbackController@delete');

	// Create New Comment
	Route::post('comments/create', 'Comments\CreateController@create');

	// Update Comment
	Route::post('comments/update', 'Comments\CreateController@update');

	// Pin a comment
	Route::post('comments/pin', 'Comments\OptionsController@pin');

	// Make an Offer
	Route::post('offers/make', 'Ads\OffersController@make');

	// Report Abuse
	Route::post('tools/report', 'Tools\ReportController@report');

	// Report Comment Abuse
	Route::post('tools/report/comment', 'Tools\ReportController@comment');

	// Upgrade Account
	Route::get('upgrade', 'Account\UpgradeController@upgrade');
	Route::post('upgrade', 'Account\UpgradeController@payment');
	Route::get('upgrade/success', 'Account\UpgradeController@success');
	Route::get('upgrade/failed', 'Account\UpgradeController@failed');

	// Pay with PagSeguro
	Route::get('checkout/pagseguro', 'Payments\PagSeguroController@get');
	Route::post('checkout/pagseguro', 'Payments\PagSeguroController@post');
	Route::post('checkout/pagseguro/callback', 'Payments\PagSeguroController@callback');

	// Pay with InterKassa
	Route::get('checkout/interkassa', 'Payments\InterKassaController@get');
	Route::post('checkout/interkassa', 'Payments\InterKassaController@post');
	Route::post('checkout/interkassa/progress', 'Payments\InterKassaController@progress');
	Route::post('checkout/interkassa/callback', 'Payments\InterKassaController@callback');

	// Pay with Paytm
	Route::get('checkout/paytm', 'Payments\PaytmController@get');
	Route::post('checkout/paytm', 'Payments\PaytmController@post');
	Route::get('checkout/paytm/callback', 'Payments\PaytmController@callback');

	// Pay with Stripe
	Route::get('checkout/stripe', 'Payments\StripeController@get');
	Route::post('checkout/stripe', 'Payments\StripeController@post');

	// Pay with 2checkout
	Route::get('checkout/2checkout', 'Payments\TwoCheckoutController@get');
	Route::post('checkout/2checkout', 'Payments\TwoCheckoutController@post');

	// Pay with paypal
	Route::get('checkout/paypal', 'Payments\PayPalController@get');
	Route::post('checkout/paypal', 'Payments\PayPalController@post');
	Route::get('checkout/paypal/success', 'Payments\PayPalController@success');
	Route::get('checkout/paypal/failed', 'Payments\PayPalController@failed');

	// Pay with paystack
	Route::get('checkout/paystack', 'Payments\PayStackController@get');
	Route::post('checkout/paystack', 'Payments\PayStackController@post');
	Route::get('checkout/paystack/callback', 'Payments\PayStackController@callback');
	Route::get('checkout/paystack/ajax', 'Payments\PayStackController@ajax');
	Route::get('ads/checkout/paystack/ajax', 'Ads\Payments\PayStackController@ajax');

	// Pay with mollie
	Route::get('checkout/mollie', 'Payments\MollieController@get');
	Route::post('checkout/mollie', 'Payments\MollieController@post');
	Route::get('checkout/mollie/callback', 'Payments\MollieController@callback');

	// Pay with paysafecard
	Route::get('checkout/paysafecard', 'Payments\PaySafeCardController@get');
	Route::post('checkout/paysafecard', 'Payments\PaySafeCardController@post');
	Route::get('checkout/paysafecard/failed', 'Payments\PaySafeCardController@failed');
	Route::get('checkout/paysafecard/success', 'Payments\PaySafeCardController@success');

	// Pay with RazorPay
	Route::get('checkout/razorpay', 'Payments\RazorpayController@get');
	Route::post('checkout/razorpay', 'Payments\RazorpayController@post');
	Route::get('checkout/razorpay/progress', 'Payments\RazorpayController@progress');
	Route::post('checkout/razorpay/progress', 'Payments\RazorpayController@checkout');

	// Pay with Barion
	Route::get('checkout/barion', 'Payments\BarionController@get');
	Route::post('checkout/barion', 'Payments\BarionController@post');
	Route::get('checkout/barion/callback', 'Payments\BarionController@callback');

	// Pay with CashU
	Route::get('checkout/cashu', 'Payments\CashUController@get');
	Route::post('checkout/cashu', 'Payments\CashUController@post');
	Route::post('checkout/cashu/callback', 'Payments\CashUController@callback');
	Route::post('checkout/cashu/failed', 'Payments\CashUController@failed');

	/**
	 * Ads Upgrade 
	 */
	Route::get('account/ads/upgrade/{ad_id}', 'Ads\AdsController@upgrade');
	Route::post('account/ads/upgrade/{ad_id}', 'Ads\AdsController@checkout');

	// Pay with Stripe
	Route::get('account/ads/{ad_id}/checkout/stripe', 'Ads\Payments\StripeController@get');
	Route::post('account/ads/{ad_id}/checkout/stripe', 'Ads\Payments\StripeController@post');

	// Pay with 2checkout
	Route::get('account/ads/{ad_id}/checkout/2checkout', 'Ads\Payments\TwoCheckoutController@get');
	Route::post('account/ads/{ad_id}/checkout/2checkout', 'Ads\Payments\TwoCheckoutController@post');

	// Pay with paypal
	Route::get('account/ads/{ad_id}/checkout/paypal', 'Ads\Payments\PayPalController@get');
	Route::post('account/ads/{ad_id}/checkout/paypal', 'Ads\Payments\PayPalController@post');
	Route::get('account/ads/{ad_id}/checkout/paypal/success', 'Ads\Payments\PayPalController@success');
	Route::get('account/ads/{ad_id}/checkout/paypal/failed', 'Ads\Payments\PayPalController@failed');

	// Pay with paystack
	Route::get('account/ads/{ad_id}/checkout/paystack', 'Ads\Payments\PayStackController@get');
	Route::post('account/ads/{ad_id}/checkout/paystack', 'Ads\Payments\PayStackController@post');
	Route::get('account/ads/{ad_id}/checkout/paystack/callback', 'Ads\Payments\PayStackController@callback');
	Route::get('account/ads/{ad_id}/checkout/paystack/ajax', 'Ads\Payments\PayStackController@ajax');

	// Pay with mollie
	Route::get('account/ads/{ad_id}/checkout/mollie', 'Ads\Payments\MollieController@get');
	Route::post('account/ads/{ad_id}/checkout/mollie', 'Ads\Payments\MollieController@post');
	Route::get('account/ads/{ad_id}/checkout/mollie/callback', 'Ads\Payments\MollieController@callback');

	// Pay with paysafecard
	Route::get('account/ads/{ad_id}/checkout/paysafecard', 'Ads\Payments\PaySafeCardController@get');
	Route::post('account/ads/{ad_id}/checkout/paysafecard', 'Ads\Payments\PaySafeCardController@post');
	Route::get('account/ads/{ad_id}/checkout/paysafecard/failed', 'Ads\Payments\PaySafeCardController@failed');
	Route::get('account/ads/{ad_id}/checkout/paysafecard/success', 'Ads\Payments\PaySafeCardController@success');

	// Pay with RazorPay
	Route::get('account/ads/{ad_id}/checkout/razorpay', 'Ads\Payments\RazorpayController@get');
	Route::post('account/ads/{ad_id}/checkout/razorpay', 'Ads\Payments\RazorpayController@post');
	Route::get('account/ads/{ad_id}/checkout/razorpay/progress', 'Ads\Payments\RazorpayController@progress');
	Route::post('account/ads/{ad_id}/checkout/razorpay/progress', 'Ads\Payments\RazorpayController@checkout');

	// Pay with PagSeguro
	Route::get('account/ads/{ad_id}/checkout/pagseguro', 'Ads\Payments\PagSeguroController@get');
	Route::post('account/ads/{ad_id}/checkout/pagseguro', 'Ads\Payments\PagSeguroController@post');
	Route::get('account/ads/{ad_id}/checkout/pagseguro/callback', 'Ads\Payments\PagSeguroController@callback');

	// Pay with Barion
	Route::get('account/ads/{ad_id}/checkout/barion', 'Ads\Payments\BarionController@get');
	Route::post('account/ads/{ad_id}/checkout/barion', 'Ads\Payments\BarionController@post');
	Route::get('account/ads/{ad_id}/checkout/barion/callback', 'Ads\Payments\BarionController@callback');

	// Pay with CashU
	Route::get('account/ads/{ad_id}/checkout/cashu', 'Ads\Payments\CashUController@get');
	Route::post('account/ads/{ad_id}/checkout/cashu', 'Ads\Payments\CashUController@post');
	Route::post('account/ads/{ad_id}/checkout/cashu/callback', 'Ads\Payments\CashUController@callback');
	Route::post('account/ads/{ad_id}/checkout/cashu/failed', 'Ads\Payments\CashUController@failed');

	// For next update
	//Route::post('store/{username}/follow', 'FollowingController@follow');

	// Create new review
	Route::post('/reviews/create', 'Ads\ReviewsController@create');

});


/**
 * Admin Routes
 */
Route::prefix('dashboard')->middleware('admin', 'fw-block-bl')->group(function(){



	// Articles Settings
	Route::get('/articles', 'Dashboard\Blog\ArticlesController@articles');
	Route::get('/articles/edit/{id}', 'Dashboard\Blog\OptionsController@edit');
	Route::post('/articles/edit/{id}', 'Dashboard\Blog\OptionsController@update');
	Route::get('/articles/delete/{id}', 'Dashboard\Blog\OptionsController@delete');

	// Articles Options
	Route::get('/articles/create', 'Dashboard\Blog\ArticlesController@create');
	Route::post('/articles/create', 'Dashboard\Blog\ArticlesController@insert');
	Route::get('/articles/edit/{slug}', 'Dashboard\Blog\ArticlesController@edit');
	Route::post('/articles/edit/{slug}', 'Dashboard\Blog\ArticlesController@update');
	Route::get('/articles/delete/{slug}', 'Dashboard\Blog\ArticlesController@delete');
		// Get Dashboard Home
	
    Route::get('/', 'Dashboard\HomeController@get');
	// Ads Settings
	Route::get('/ads', 'Dashboard\Ads\SettingsController@settings');

	// Ads Stats
	Route::get('/ads/stats/{ad}', 'Dashboard\Ads\StatsController@stats');

	// Ads Messages
	Route::get('/ads/messages/{ad}', 'Dashboard\Ads\StatsController@messages');

	// Ads Comments
	Route::get('/ads/comments/{ad}', 'Dashboard\Ads\StatsController@comments');

	// Ads Offers
	Route::get('/ads/offers/{ad}', 'Dashboard\Ads\StatsController@offers');

	// Active Ad
	Route::get('/ads/active/{ad}', 'Dashboard\Ads\OptionsController@active');

	// Inactive Ad
	Route::get('/ads/inactive/{ad}', 'Dashboard\Ads\OptionsController@inactive');

	// Delete Ad
	Route::get('/ads/delete/{ad}', 'Dashboard\Ads\OptionsController@delete');

	// Edit Ad
	Route::get('/ads/edit/{ad}', 'Dashboard\Ads\EditController@edit');

	// Update Ad
	Route::post('/ads/edit/{ad}', 'Dashboard\Ads\EditController@update');

	// Get Categories
	Route::get('/categories', 'Dashboard\CategoriesController@categories');

	// Create New Category
	Route::get('/categories/create', 'Dashboard\CategoriesController@create');
	Route::post('/categories/create', 'Dashboard\CategoriesController@insert');

	// Edit Category
	Route::get('/categories/edit/{id}', 'Dashboard\CategoriesController@edit');
	Route::post('/categories/edit/{id}', 'Dashboard\CategoriesController@update');

	// Delete Category
	Route::get('/categories/delete/{id}', 'Dashboard\CategoriesController@delete');

	// Get Pages
	Route::get('pages', 'Dashboard\PagesController@pages');

	// Create New Page
	Route::get('pages/create', 'Dashboard\PagesController@create');
	Route::post('pages/create', 'Dashboard\PagesController@insert');

	// Edit Page
	Route::get('/pages/edit/{slug}', 'Dashboard\PagesController@edit');
	Route::post('/pages/edit/{slug}', 'Dashboard\PagesController@update');

	// Delete Page
	Route::get('/pages/delete/{slug}', 'Dashboard\PagesController@delete');

  	// Get Users
  	Route::get('users', 'Dashboard\UsersController@users');

  	// Delete User
  	Route::get('users/delete/{username}', 'Dashboard\UsersController@delete');

  	// Edit User
  	Route::get('users/edit/{username}', 'Dashboard\UsersController@edit');
  	Route::post('users/edit/{username}', 'Dashboard\UsersController@update');

  	// Send warning
  	Route::get('users/warning/{username}', 'Dashboard\UsersController@warning');

  	// Delete All warnings
  	Route::get('users/warnings/delete/{username}', 'Dashboard\UsersController@delete_warnings');

  	// Active || Inactive User
  	Route::get('users/active/{username}', 'Dashboard\UsersController@active');
  	Route::get('users/inactive/{username}', 'Dashboard\UsersController@inactive');

  	// User Details
  	Route::get('users/details/{username}', 'Dashboard\UsersController@details');

  	// Create a store for a user
  	Route::get('users/{username}/create/store', 'Dashboard\UsersController@makeStore');
  	Route::post('users/{username}/create/store', 'Dashboard\UsersController@insertStore');

  	// User Ads
  	Route::get('users/ads/{username}', 'Dashboard\UsersController@ads');

  	// User Comments
  	Route::get('users/comments/{username}', 'Dashboard\UsersController@comments');

  	// Get Users Messages
  	Route::get('messages/users', 'Dashboard\Inbox\UsersController@messages');

  	// Read Message
  	Route::get('messages/users/read/{id}', 'Dashboard\Inbox\UsersController@read');

  	// Delete Message
  	Route::get('messages/users/delete/{id}', 'Dashboard\Inbox\UsersController@delete');

  	// Get Admin Messages
  	Route::get('messages/admin', 'Dashboard\Inbox\AdminController@messages');

  	// Read Message
  	Route::get('messages/admin/read/{id}', 'Dashboard\Inbox\AdminController@read');

  	// Read Message
  	Route::get('messages/admin/delete/{id}', 'Dashboard\Inbox\AdminController@delete');

  	// Get Stores Messages
  	Route::get('messages/stores', 'Dashboard\Inbox\StoresController@messages');

  	// Read Message
  	Route::get('messages/stores/read/{id}', 'Dashboard\Inbox\StoresController@read');

  	// Read Message
  	Route::get('messages/stores/delete/{id}', 'Dashboard\Inbox\StoresController@delete');

  	// Manage Comments
  	Route::get('comments', 'Dashboard\CommentsController@comments');

  	// Read Comment
  	Route::get('comments/read/{id}', 'Dashboard\CommentsController@read');

  	// Delete Comment
  	Route::get('comments/delete/{id}', 'Dashboard\CommentsController@delete');

  	// Active Comment
  	Route::get('comments/active/{id}', 'Dashboard\CommentsController@active');

  	// Inactive Comment
  	Route::get('comments/inactive/{id}', 'Dashboard\CommentsController@inactive');

  	// Pin Comment
  	Route::get('comments/pin/{id}', 'Dashboard\CommentsController@pin');

  	// Unpin Comment
  	Route::get('comments/unpin/{id}', 'Dashboard\CommentsController@unpin');

  	// edit Comment
  	Route::get('comments/edit/{id}', 'Dashboard\CommentsController@edit');

  	// update Comment
  	Route::post('comments/edit/{id}', 'Dashboard\CommentsController@update');

  	// Get Stores
  	Route::get('stores', 'Dashboard\Stores\StoresController@stores');

  	// Active Store
  	Route::get('stores/active/{username}', 'Dashboard\Stores\OptionsController@active');

  	// Inactive Store
  	Route::get('stores/inactive/{username}', 'Dashboard\Stores\OptionsController@inactive');

  	// Store Detials
  	Route::get('stores/details/{username}', 'Dashboard\Stores\OptionsController@details');

  	// Delete Store
  	Route::get('stores/delete/{username}', 'Dashboard\Stores\OptionsController@delete');

  	// Edit Store
  	Route::get('stores/edit/{username}', 'Dashboard\Stores\OptionsController@edit');
  	Route::post('stores/edit/{username}', 'Dashboard\Stores\OptionsController@update');

  	// Get offers
  	Route::get('offers', 'Dashboard\OffersController@offers');

  	// Delete offer
  	Route::get('offers/delete/{id}', 'Dashboard\OffersController@delete');

  	// Get Advertisements Settings
  	Route::get('advertisements', 'Dashboard\AdvertisementsController@edit');
  	Route::post('advertisements', 'Dashboard\AdvertisementsController@update');

  	// Get Accounts Upgrade Payments History
  	Route::get('payments/accounts', 'Dashboard\PaymentsController@accounts');

  	// Accept Payment
  	Route::get('payments/accounts/accept/{id}', 'Dashboard\PaymentsController@account_accept');

  	// Refuse Payment
  	Route::get('payments/accounts/refuse/{id}', 'Dashboard\PaymentsController@account_refuse');

  	// Get Ads Upgrade Payments History
  	Route::get('payments/ads', 'Dashboard\PaymentsController@ads');

  	// Accept Payment
  	Route::get('payments/ads/accept/{id}', 'Dashboard\PaymentsController@ads_accept');

  	// Refuse Payment
  	Route::get('payments/ads/refuse/{id}', 'Dashboard\PaymentsController@ads_refuse');

  	// Payment Details
  	Route::get('payments/paypal/details/{id}', 'Dashboard\PaymentsController@paypal_details');

  	// Delete Payment
  	Route::get('payments/paypal/delete/{id}', 'Dashboard\PaymentsController@paypal_delete');

  	// Ads Notifications
  	Route::get('notifications/ads', 'Dashboard\Notifications\AdsController@ads');
  	Route::get('notifications/ads/delete/{id}', 'Dashboard\Notifications\AdsController@delete');

  	// Payments Notifications
  	Route::get('notifications/payments', 'Dashboard\Notifications\PaymentsController@payments');
  	Route::get('notifications/payments/delete/{id}', 'Dashboard\Notifications\PaymentsController@delete');

  	// Users Notifications
  	Route::get('notifications/users', 'Dashboard\Notifications\UsersController@users');
  	Route::get('notifications/users/delete/{id}', 'Dashboard\Notifications\UsersController@delete');

  	// Ads Reports Notifications
  	Route::get('notifications/reports', 'Dashboard\Notifications\ReportsController@ads');
  	Route::get('notifications/reports/delete/{id}', 'Dashboard\Notifications\ReportsController@delete');

  	// Stores Notifications
  	Route::get('notifications/stores', 'Dashboard\Notifications\StoresController@stores');
  	Route::get('notifications/stores/delete/{id}', 'Dashboard\Notifications\StoresController@delete');

  	// Get Countries
  	Route::get('geo/countries', 'Dashboard\Geo\CountriesController@countries');

  	// Add Country
  	Route::get('geo/countries/add', 'Dashboard\Geo\CountriesController@add');
  	Route::post('geo/countries/add', 'Dashboard\Geo\CountriesController@insert');

  	// Edit Country
  	Route::get('geo/countries/edit/{id}', 'Dashboard\Geo\CountriesController@edit');
  	Route::post('geo/countries/edit/{id}', 'Dashboard\Geo\CountriesController@update');

  	// Delete Country
  	Route::get('geo/countries/delete/{id}', 'Dashboard\Geo\CountriesController@delete');

  	// Get States
  	Route::get('geo/states', 'Dashboard\Geo\StatesController@states');

  	// Add State
  	Route::get('geo/states/add', 'Dashboard\Geo\StatesController@add');
  	Route::post('geo/states/add', 'Dashboard\Geo\StatesController@insert');

  	// Edit State
  	Route::get('geo/states/edit/{id}', 'Dashboard\Geo\StatesController@edit');
  	Route::post('geo/states/edit/{id}', 'Dashboard\Geo\StatesController@update');

  	// Delete State
  	Route::get('geo/states/delete/{id}', 'Dashboard\Geo\StatesController@delete');

  	// Add States by country
  	Route::get('geo/states/states_by_country', 'Dashboard\Geo\StatesController@states_by_country');

  	// Get Cities
  	Route::get('geo/cities', 'Dashboard\Geo\CitiesController@cities');

  	// Add City
  	Route::get('geo/cities/add', 'Dashboard\Geo\CitiesController@add');
  	Route::post('geo/cities/add', 'Dashboard\Geo\CitiesController@insert');

  	// Edit City
  	Route::get('geo/cities/edit/{id}', 'Dashboard\Geo\CitiesController@edit');
  	Route::post('geo/cities/edit/{id}', 'Dashboard\Geo\CitiesController@update');

  	// Delete City
  	Route::get('geo/cities/delete/{id}', 'Dashboard\Geo\CitiesController@delete');

  	// General settings
  	Route::get('settings/general', 'Dashboard\Settings\GeneralController@edit');
  	Route::post('settings/general', 'Dashboard\Settings\GeneralController@update');

  	// Home settings
  	Route::get('settings/home', 'Dashboard\Settings\HomeController@edit');
  	Route::post('settings/home', 'Dashboard\Settings\HomeController@update');

  	// SEO settings
  	Route::get('settings/seo', 'Dashboard\Settings\SEOController@edit');
  	Route::post('settings/seo', 'Dashboard\Settings\SEOController@update');

  	// Manage Geo Settings
  	Route::get('settings/geo', 'Dashboard\Settings\GeoController@edit');
  	Route::post('settings/geo', 'Dashboard\Settings\GeoController@update');

  	// Watermark Settings
  	Route::get('settings/watermark', 'Dashboard\Settings\WatermarkController@settings');
  	Route::post('settings/watermark', 'Dashboard\Settings\WatermarkController@update');

  	// Packages settings
  	Route::get('settings/packages', 'Dashboard\PackagesController@packages');
  	Route::post('settings/packages', 'Dashboard\PackagesController@packages');

  	// Security settings
  	Route::get('settings/security', 'Dashboard\Settings\SecurityController@security');
  	Route::post('settings/security', 'Dashboard\Settings\SecurityController@update');

  	// SMTP settings
  	Route::get('settings/smtp', 'Dashboard\Settings\SmtpController@smtp');
  	Route::post('settings/smtp', 'Dashboard\Settings\SmtpController@update');
  	Route::get('settings/smtp/test', 'Dashboard\Settings\SmtpController@test');

  	// Membership settings
  	Route::get('settings/membership', 'Dashboard\Settings\MembershipController@membership');
  	Route::post('settings/membership', 'Dashboard\Settings\MembershipController@update');

  	// Membership settings
  	Route::get('settings/auth', 'Dashboard\Settings\AuthController@edit');
  	Route::post('settings/auth', 'Dashboard\Settings\AuthController@update');

  	// Footer settings
  	Route::get('settings/footer', 'Dashboard\Settings\FooterController@edit');
  	Route::post('settings/footer', 'Dashboard\Settings\FooterController@update');

  	// Failed Login
  	Route::get('login/history', 'Dashboard\FirewallController@failed_login');

  	// Clear Failed Login
  	Route::get('login/history/clear', 'Dashboard\FirewallController@login_history_clear');

  	// Get Blocked IP List
  	Route::get('firewall', 'Dashboard\FirewallController@firewall');

  	// Add IP
  	Route::get('firewall/add', 'Dashboard\FirewallController@add');
  	Route::post('firewall/add', 'Dashboard\FirewallController@insert');

  	// Delete IP from Ban list
  	Route::get('firewall/delete/{ip}', 'Dashboard\FirewallController@delete');

  	// Maintenance Mode
  	Route::get('maintenance', 'Dashboard\HomeController@maintenance');
  	Route::post('maintenance', 'Dashboard\HomeController@update_maintenance');

  	Route::get('currencies', 'Dashboard\CurrenciesController@currencies');
  	Route::get('currencies/create', 'Dashboard\CurrenciesController@create');
  	Route::post('currencies/create', 'Dashboard\CurrenciesController@insert');
  	Route::get('currencies/edit/{code}', 'Dashboard\CurrenciesController@edit');
  	Route::post('currencies/edit/{code}', 'Dashboard\CurrenciesController@update');
  	Route::get('currencies/delete/{code}', 'Dashboard\CurrenciesController@delete');

  	Route::get('settings/payments/paypal', 'Dashboard\Settings\Payments\PayPalController@get');
  	Route::post('settings/payments/paypal', 'Dashboard\Settings\Payments\PayPalController@post');

  	Route::get('settings/payments/2checkout', 'Dashboard\Settings\Payments\TwoCheckoutController@get');
  	Route::post('settings/payments/2checkout', 'Dashboard\Settings\Payments\TwoCheckoutController@post');

  	Route::get('settings/payments/stripe', 'Dashboard\Settings\Payments\StripeController@get');
  	Route::post('settings/payments/stripe', 'Dashboard\Settings\Payments\StripeController@post');

  	Route::get('settings/payments/mollie', 'Dashboard\Settings\Payments\MollieController@get');
  	Route::post('settings/payments/mollie', 'Dashboard\Settings\Payments\MollieController@post');

  	Route::get('settings/payments/paystack', 'Dashboard\Settings\Payments\PayStackController@get');
  	Route::post('settings/payments/paystack', 'Dashboard\Settings\Payments\PayStackController@post');

  	Route::get('settings/payments/paysafecard', 'Dashboard\Settings\Payments\PaySafeCardController@get');
  	Route::post('settings/payments/paysafecard', 'Dashboard\Settings\Payments\PaySafeCardController@post');

  	Route::get('settings/payments/yandex', 'Dashboard\Settings\Payments\YandexController@get');
  	Route::post('settings/payments/yandex', 'Dashboard\Settings\Payments\YandexController@post');

  	Route::get('settings/payments/razorpay', 'Dashboard\Settings\Payments\RazorpayController@get');
  	Route::post('settings/payments/razorpay', 'Dashboard\Settings\Payments\RazorpayController@post');

  	Route::get('settings/payments/barion', 'Dashboard\Settings\Payments\BarionController@get');
  	Route::post('settings/payments/barion', 'Dashboard\Settings\Payments\BarionController@post');

  	Route::get('settings/payments/pagseguro', 'Dashboard\Settings\Payments\PagSeguroController@get');
  	Route::post('settings/payments/pagseguro', 'Dashboard\Settings\Payments\PagSeguroController@post');

  	Route::get('settings/payments/interkassa', 'Dashboard\Settings\Payments\InterKassaController@get');
  	Route::post('settings/payments/interkassa', 'Dashboard\Settings\Payments\InterKassaController@post');

  	Route::get('settings/payments/paytm', 'Dashboard\Settings\Payments\PaytmController@get');
  	Route::post('settings/payments/paytm', 'Dashboard\Settings\Payments\PaytmController@post');

  	Route::get('settings/payments/cashu', 'Dashboard\Settings\Payments\CashUController@get');
  	Route::post('settings/payments/cashu', 'Dashboard\Settings\Payments\CashUController@post');

  	/**
	* Cloud Services
	* available: Amazon S3, Google Cloud
  	*/
  	Route::get('settings/cloud/amazon', 'Dashboard\Cloud\AmazonController@get');
  	Route::post('settings/cloud/amazon', 'Dashboard\Cloud\AmazonController@post');
  	Route::get('settings/cloud/google', 'Dashboard\Cloud\GoogleController@get');
  	Route::post('settings/cloud/google', 'Dashboard\Cloud\GoogleController@post');
  	Route::get('settings/cloud/rackspace', 'Dashboard\Cloud\RackspaceController@get');
  	Route::post('settings/cloud/rackspace', 'Dashboard\Cloud\RackspaceController@post');
  	Route::get('settings/cloud/cloudinary', 'Dashboard\Cloud\CloudinaryController@get');
  	Route::post('settings/cloud/cloudinary', 'Dashboard\Cloud\CloudinaryController@post');

  	/**
	* SMS Gateways
  	*/
  	Route::get('settings/sms/nexmo', 'Dashboard\Sms\NexmoController@get');
  	Route::post('settings/sms/nexmo', 'Dashboard\Sms\NexmoController@post');
  	Route::get('settings/sms/identifyme', 'Dashboard\Sms\IdentifyMeController@get');
  	Route::post('settings/sms/identifyme', 'Dashboard\Sms\IdentifyMeController@post');

});

/**
 * Blog Routes
 */
Route::prefix('blog')->middleware('web', 'install', 'maintenance', 'fw-block-bl')->group(function(){

	// Blog Articles
	Route::get('/', 'Blog\HomeController@index');
	Route::get('/{slug}', 'Blog\HomeController@article');

});