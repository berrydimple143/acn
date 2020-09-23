<?php
/* These are the routes when logging in with mobile */
Route::get('/mobile/{email}', 'FrontController@mobile')->name('mobile');
Route::post('/mobile', 'FrontController@post_mobile')->name('mobile.post');
Route::post('/mobile/confirmed', 'FrontController@mobile_confirmed')->name('mobile.confirmed');

/* This is the route when manually creating a user or a customer */
Route::post('/create/user', 'FrontController@create_user')->name('user.create');

/* These are the routes when a Tell a Friend button is clicked */
Route::get('/share', 'FrontController@share')->name('share');
Route::post('/share', 'FrontController@post_share')->name('post.share');

//	These are the routes when paying a subscription through paypal or credit card
Route::post('/process/payment', 'PaymentController@processPayment')->name('process.pay');
Route::get('/payment/successful', 'PaymentController@payment_successful')->name('payment.success');
Route::get('/payment/failed', 'PaymentController@payment_failed')->name('payment.failed');
Route::post('manage/paypal/ipn', 'PaymentController@manage_paypal_ipn')->name('manage.paypal.ipn'); 

/* Automatic routing when using authentication in this project */
Auth::routes();

/* Overriding the default authentication routes for login controller */
Route::get('/login', 'LoginController@index')->name('login');
Route::get('/login/with', 'LoginController@login_with')->name('login.with');
Route::post('/login', 'LoginController@login');

/* Reset password button routes */
Route::get('/go/back', 'ResetPasswordController@go_back')->name('go.back');
Route::get('/reset/password/of/{email}', 'ResetPasswordController@go_reset')->name('go.reset');
Route::post('/reset/now', 'ResetPasswordController@reset_now')->name('reset.now');

/* Facebook login routes using the socialite package */
Route::get('/redirect', 'SocialAuthFacebookController@redirect')->name('facebook.redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback')->name('facebook.callback');

/* User's dashboard route (requires logged in) */
Route::get('/', 'AdminController@index')->name('home');

/* User's account settings route (requires logged in) */
Route::get('/settings', 'AdminController@settings')->name('settings');
Route::put('/settings/update/{id}', 'AdminController@update_settings')->name('settings.update');

/* User's profile settings route (requires logged in) */
Route::get('/profile', 'AdminController@profile')->name('profile');
Route::put('/profile/update/{id}', 'AdminController@update_profile')->name('profile.update');

/* Logout button route if logged in */
Route::get('/logout', 'AdminController@logout')->name('logout');

/* User's mobile validation route (requires logged in) */
Route::get('/admin/mobile', 'AdminController@mobile')->name('admin.mobile');
Route::post('/admin/mobile', 'AdminController@post_mobile')->name('admin.mobile.post');
Route::post('/admin/mobile/confirmed', 'AdminController@mobile_confirmed')->name('admin.mobile.confirmed');

/* User's email validation route (requires logged in) */
Route::get('/validate/email', 'AdminController@validateEmail')->name('validate.email');
Route::get('/confirm/email/{email}/{cc}', 'AdminController@confirmEmail')->name('email.confirmation');

/* User's route for deleting his/her account (requires logged in) */
Route::get('/cancel/delete/account', 'AdminController@cancel_delete')->name('admin.cancel.delete');
Route::get('/delete/account', 'AdminController@delete')->name('delete.account');
Route::delete('/destroy/account/{id}', 'AdminController@destroy')->name('destroy.account');

/* User's route when update fails (requires logged in) */
Route::get('/update/failed/{errorMessage}', 'AdminController@updateFailed')->name('update.failed');

/* User's skippycoin interface routes (requires logged in). Skippycoin is a customized crypto currency in Australia (same as bitcoin) but still in progress. */
Route::get('/skippycoin', 'SkippycoinController@index')->name('skippycoin');
Route::post('/save/skippywallet', 'SkippycoinController@store_wallet')->name('save.skippywallet');
Route::get('/skippycoin/failed/{errorMessage}', 'SkippycoinController@skcFailed')->name('skippycoin.failed');
Route::get('/skippycoin/status', 'SkippycoinController@status')->name('skippycoin.status');
Route::get('/skippycoin/status/update/{old}', 'SkippycoinController@status_update')->name('skippycoin.status.update');

/* User's route when something's went wrong in the admin area */
Route::get('/error/found/{errorMessage}', 'AdminController@errorFound')->name('error.found');

/* User's route when adding, editing, deleting and other related functions (such as adding youtube videos, etc.) in the Advertisements Section (requires logged in) */
Route::get('/ads', 'AdsController@index')->name('advertisements');
Route::get('/ads/data', 'AdsController@data')->name('ads.information');
Route::get('/ads/select', 'AdsController@select')->name('ads.select');
Route::get('/ads/selected/{adtype}', 'AdsController@selected')->name('ads.selected');
Route::post('/ad/post', 'AdsController@store')->name('ads.post');
Route::get('/ad/edit/{id}', 'AdsController@edit')->name('ads.edit');
Route::put('ad/update/{id}', 'AdsController@update')->name('ads.update');
Route::get('/ad/{slug}', 'AdsController@slug')->name('ads.slug');
Route::get('/video/test', 'AdsController@testVideo')->name('video.test');
Route::post('ads/video/check', 'AdsController@checkVideo')->name('video.check');
Route::get('/ads/category', 'AdsController@getCategories')->name('ads.categories');
Route::post('/check/category', 'AdsController@checkCategory')->name('ads.check.category');
Route::post('/ads/category/post', 'AdsController@addCategories')->name('ads.category.post');
Route::get('/ads/location', 'AdsController@getLocation')->name('ads.location');
Route::get('ads/delete/{id}', 'AdsController@delete')->name('ads.delete');
Route::delete('ads/destroy/{id}', 'AdsController@destroy')->name('ads.destroy');
		
/* User's route when adding, editing, deleting and other related functions (such as adding youtube videos, etc.) in the Articles Section (requires logged in) */
Route::get('/articles', 'ArticleController@index')->name('articles');
Route::get('/article/add', 'ArticleController@create')->name('article.add');
Route::post('/article/post', 'ArticleController@store')->name('article.post');
Route::post('article/video/check', 'ArticleController@checkVideo')->name('article.video.check');
Route::put('article/update/{id}', 'ArticleController@update')->name('article.update');
Route::get('/article/edit/{id}', 'ArticleController@edit')->name('article.edit');
Route::get('/article/{slug}', 'ArticleController@slug')->name('article.slug');
Route::get('/articles/data', 'ArticleController@data')->name('articles.information');
Route::get('/article/video/test', 'ArticleController@testYVideo')->name('article.video.test');
Route::get('/art/location', 'ArticleController@getLocation')->name('article.location');
Route::get('article/delete/{id}', 'ArticleController@delete')->name('article.delete');
Route::delete('article/destroy/{id}', 'ArticleController@destroy')->name('article.destroy');

/* User's route when adding, editing, deleting and other related functions (such as adding youtube videos, etc.) in the Events Section (requires logged in) */
Route::get('/events', 'EventController@index')->name('events');
Route::get('/events/data', 'EventController@data')->name('events.information');
Route::get('/event/select', 'EventController@select')->name('event.select');
Route::get('/event/selected/{evtype}', 'EventController@selected')->name('event.selected');
Route::post('event/video/check', 'EventController@checkVideo')->name('event.video.check');
Route::get('/event/video/test', 'EventController@testYVideo')->name('event.video.test');
Route::get('/event/edit/{id}', 'EventController@edit')->name('event.edit');
Route::put('event/update/{id}', 'EventController@update')->name('event.update');
Route::get('/event/location', 'EventController@getLocation')->name('event.location');
Route::get('/event/delete/{id}', 'EventController@delete')->name('event.delete');
Route::post('/event/post', 'EventController@store')->name('event.post');
Route::delete('event/destroy/{id}', 'EventController@destroy')->name('event.destroy');

/* User's route when uploading, editing, deleting and other related functions in the Photos Section (requires logged in) */
Route::get('/photos', 'PhotoController@index')->name('photos');
Route::post('/photo/search', 'PhotoController@search')->name('photo.search');
Route::get('/photo/add', 'PhotoController@create')->name('photo.add');
Route::post('/photo/post', 'PhotoController@store')->name('photo.post');
Route::post('/photo/save', 'PhotoController@save')->name('photo.save');
Route::get('/photo/cancelled/{flname}', 'PhotoController@cancel')->name('cancel');
Route::get('photo/delete/{id}', 'PhotoController@delete')->name('delete.image');
Route::delete('photo/destroy/{id}', 'PhotoController@destroy')->name('image.destroy');
Route::get('photo/remove/gallery/{id}', 'PhotoController@removeFromGallery')->name('remove.gallery');
Route::delete('photo/remove/{id}', 'PhotoController@remove')->name('image.remove');
Route::get('photo/publish-to-gallery/{id}', 'PhotoController@publishToGallery')->name('publish.gallery');
Route::get('photo/move/{id}', 'PhotoController@movePhoto')->name('photo.move');
Route::put('move/photo/update/{id}', 'PhotoController@movePhotoNow')->name('move.photo.update');
Route::get('/move/now', 'PhotoController@moveNow')->name('move.photo.now');
Route::get('/remove/now', 'PhotoController@removeNow')->name('remove.photo.now');

/* User's route when creating, uploading, editing, deleting and other related functions in the Banners Section (requires logged in) */
Route::get('/banners', 'BannerController@index')->name('banners');
Route::post('/banner/search', 'BannerController@search')->name('banner.search');
Route::get('/banner/selection', 'BannerController@selection')->name('banner.selection');
Route::get('/banner/selected/{btype}', 'BannerController@selected')->name('banner.selected');
Route::post('/banner/post', 'BannerController@store')->name('banner.post');
Route::post('/banner/save', 'BannerController@save')->name('banner.save');
Route::get('/banner/cancelled/{flname}', 'BannerController@cancel')->name('cancel.banner');
Route::get('/banner/delete/{id}', 'BannerController@delete')->name('banner.delete');
Route::delete('banner/destroy/{id}', 'BannerController@destroy')->name('banner.destroy');
Route::post('/banner/maker/post', 'BannerController@maker_post')->name('banner.maker.post');
Route::get('/banner/maker/upload/{type}', 'BannerController@maker_upload')->name('banner.maker.upload');
Route::get('/update/banner', 'BannerController@update_banner')->name('update.banner');
Route::post('/create-banner', 'BannerController@createBanner')->name('create.banner');
Route::post('/banner-image-upload', 'BannerController@imageUpload')->name('banner.image.upload');

/* User's route when uploading, editing, deleting and other related functions in the Portraits Section (requires logged in) */
Route::get('/portraits', 'PortraitController@index')->name('portraits');
Route::post('/portrait/search', 'PortraitController@search')->name('portrait.search');
Route::get('/portrait/add', 'PortraitController@create')->name('portrait.add');
Route::post('/portrait/post', 'PortraitController@store')->name('portrait.post');
Route::post('/portrait/save', 'PortraitController@save')->name('portrait.save');
Route::get('/portrait/cancelled/{flname}', 'PortraitController@cancel')->name('cancel.portrait');
Route::get('portrait/set/primary/{id}', 'PortraitController@setPrimary')->name('portrait.set.primary');
Route::get('portrait/delete/{id}', 'PortraitController@delete')->name('delete.portrait');
Route::delete('portrait/destroy/{id}', 'PortraitController@destroy')->name('portrait.destroy');
Route::post('portrait/angle', 'PortraitController@getAngle')->name('portrait.angle');

/* User's route when uploading, editing, deleting and other related functions in the Logos Section (requires logged in) */
Route::get('/logos', 'LogoController@index')->name('logos');
Route::post('/logo/search', 'LogoController@search')->name('logo.search');
Route::get('/logo/add', 'LogoController@create')->name('logo.add');
Route::post('/logo/post', 'LogoController@store')->name('logo.post');
Route::post('/logo/save', 'LogoController@save')->name('logo.save');
Route::get('/logo/cancelled/{flname}', 'LogoController@cancel')->name('cancel.logo');
Route::get('logo/set/primary/{id}', 'LogoController@setPrimary')->name('logo.set.primary');
Route::get('logo/delete/{id}', 'LogoController@delete')->name('delete.logo');
Route::delete('logo/destroy/{id}', 'LogoController@destroy')->name('logo.destroy');

/* User's route when moving from one portal/location to another in the same ARN network (requires logged in) */
Route::get('/move', 'MoveController@index')->name('move');
Route::get('/state/regions', 'MoveController@getRegions')->name('state.regions');
Route::get('/goto/region', 'MoveController@gotoRegion')->name('goto.region');
Route::get('/move/portal', 'MoveController@movehere')->name('move.portal');
Route::get('/back/home', 'MoveController@backhome')->name('back.home');

/* User's route when upgrading or downgrading a membership status (Membership Levels are Local Resident, Community Leader, Local Business, and National Business) (requires logged in) */
Route::get('/membership', 'AdminController@membership')->name('membership');
Route::get('/localresident', 'AdminController@localresident')->name('localresident');
Route::get('/communityleader', 'AdminController@communityleader')->name('communityleader');
Route::get('/localbusiness', 'AdminController@localbusiness')->name('localbusiness');
Route::get('/nationalbusiness', 'AdminController@nationalbusiness')->name('nationalbusiness');
Route::get('/sponsorship', 'AdminController@sponsorship')->name('sponsorship');
Route::get('/sponsorshipkey', 'AdminController@sponsorshipkey')->name('sponsorshipkey');

/* User's interface for managing his/her paypal transactions */
Route::get('manage/paypal', 'AdminController@manage_paypal')->name('manage.paypal');
Route::get('/paypal/data', 'AdminController@paypal_data')->name('paypal.data');

/* Custom test code */
Route::get('test/code', 'AdminController@test_code')->name('test.code');

/* User's custom marketing tools and interface within the ARN system */
Route::get('marketing/tools', 'AdminController@marketing')->name('marketing.tools');
Route::get('email/lists', 'MarketingController@email_lists')->name('email.lists');
Route::get('/email/list/data', 'MarketingController@data')->name('lists.information');
Route::get('email/templates', 'MarketingController@email_templates')->name('email.templates');
Route::get('email/campaigns', 'MarketingController@email_campaigns')->name('email.campaigns');
Route::get('exempted/emails', 'MarketingController@exempted_emails')->name('email.exempted');
Route::get('/email/list/add', 'MarketingController@list_add')->name('list.add');
Route::post('/email/list/post', 'MarketingController@list_store')->name('list.post');
Route::get('/email/list/edit/{id}', 'MarketingController@list_edit')->name('list.edit');
Route::put('/email/list/update/{id}', 'MarketingController@list_update')->name('list.update');
Route::get('/email/list/delete/{id}', 'MarketingController@list_delete')->name('list.delete');
Route::delete('/email/list/destroy/{id}', 'MarketingController@list_destroy')->name('list.destroy');
Route::get('/emails/of/list/{id}', 'MarketingController@list_emails')->name('list.emails');
Route::get('/emails/list/add/options/{id}', 'MarketingController@email_add_options')->name('email.add.options');
