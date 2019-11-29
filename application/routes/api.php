<?php

Route::namespace('Api')->group(function () {

	/**
	 * Auth routes
	 */
	Route::prefix('auth')->group(function () {

		// Login route
		Route::post('login', 'Auth\LoginController@login');

		// Register route
		Route::post('register', 'Auth\RegisterController@register');

		// Refresh token
		Route::post('refresh', 'Auth\LoginController@refresh');

		// Facebook login
		Route::post('facebook', 'Auth\SocialMediaController@facebook');

		// Twitter login
		Route::post('twitter', 'Auth\SocialMediaController@twitter');

		// Google login
		Route::post('google', 'Auth\SocialMediaController@google');

		// Reset password
		Route::post('password/reset', 'Auth\PasswordController@reset');

	});

	/**
	 * Authenticated routes
	 */
	Route::middleware('auth:api')->group(function () {

	    // Get ads
	    Route::get('/', 'HomeController@index');

	    // Profile settings
	    Route::get('profile', 'Account\ProfileController@profile');
	    Route::post('profile', 'Account\ProfileController@settings');

	    // Show available stores
	    Route::get('stores', 'Stores\StoresController@stores');

	    // Get store
	    Route::get('store/{store}', 'Stores\StoresController@store');

		// Logout route
	    Route::post('logout', 'Auth\LoginController@logout');

	    // Get user favorites ads
	    Route::get('favorites', 'Ads\FavoritesController@favorites');

	    // Create new ad
	    Route::post('create', 'Ads\CreateController@create');

	    // Show ad
	    Route::get('listing/{id}', 'Ads\ShowController@show');

	    // Get Categories
	    Route::get('categories', 'Categories\CategoriesController@categories');

	    // Get ads by category
	    Route::get('category/{parent}/{child?}', 'Categories\CategoriesController@category');

	    // Search ads
	    Route::post('search', 'SearchController@search');

	});

	/**
	 * Guest routes
	 */
	
	// Contact us
	Route::post('contact', 'ContactController@contact');

	// Show a custom page
	Route::get('page/{slug}', 'PagesController@page');

});

