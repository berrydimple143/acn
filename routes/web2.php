<?php
Route::get('/mobile', 'FrontController@mobile')->name('mobile');
Route::post('/mobile', 'FrontController@post_mobile')->name('mobile.post');
Route::post('/mobile/confirmed', 'FrontController@mobile_confirmed')->name('mobile.confirmed');
Route::post('/create/user', 'FrontController@create_user')->name('user.create');
Route::get('/share', 'FrontController@share')->name('share');
Route::post('/share', 'FrontController@post_share')->name('post.share');
Route::post('manage/paypal/ipn', 'FrontController@manage_paypal_ipn')->name('manage.paypal.ipn'); //Manage Paypal IPN
Auth::routes();
//Route::get('/login', 'LoginController@index')->name('login');
Route::get('/login', 'LoginController@index')->name('login');
Route::post('/login', 'LoginController@login');
Route::get('/redirect', 'SocialAuthFacebookController@redirect')->name('facebook.redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback')->name('facebook.callback');

//	Payment
Route::post('/process/payment', 'PaymentController@processPayment')->name('process.pay');
Route::get('/paypal/{id}/{subscription}/{price}/{membership}/success', 'PaymentController@payment_successful')->name('payment.success');
Route::get('/payments/fails/{id}', 'PaymentController@payment_failed')->name('payment.failed');

//Admin
Route::get('/', 'AdminController@index')->name('home');
Route::get('/settings', 'AdminController@settings')->name('settings');
Route::put('/settings/update/{id}', 'AdminController@update_settings')->name('settings.update');
Route::get('/profile', 'AdminController@profile')->name('profile');
Route::put('/profile/update/{id}', 'AdminController@update_profile')->name('profile.update');
Route::get('/logout', 'AdminController@logout')->name('logout');
Route::get('/admin/mobile', 'AdminController@mobile')->name('admin.mobile');
Route::post('/admin/mobile', 'AdminController@post_mobile')->name('admin.mobile.post');
Route::post('/admin/mobile/confirmed', 'AdminController@mobile_confirmed')->name('admin.mobile.confirmed');
Route::get('/validate/email', 'AdminController@validateEmail')->name('validate.email');
Route::get('/confirm/email/{email}/{cc}', 'AdminController@confirmEmail')->name('email.confirmation');
Route::get('/cancel/delete/account', 'AdminController@cancel_delete')->name('admin.cancel.delete');
Route::get('/delete/account', 'AdminController@delete')->name('delete.account');
Route::delete('/destroy/account/{id}', 'AdminController@destroy')->name('destroy.account');

// Skippycoin
Route::get('/skippycoin', 'SkippycoinController@index')->name('skippycoin');
Route::post('/save/skippywallet', 'SkippycoinController@store_wallet')->name('save.skippywallet');
Route::get('/skippycoin/failed/{errorMessage}', 'SkippycoinController@skcFailed')->name('skippycoin.failed');

//Errors
Route::get('/error/found/{errorMessage}', 'AdminController@errorFound')->name('error.found');

//Advertisements
Route::get('/ads', 'AdsController@index')->name('advertisements');
Route::get('/ads/data', 'AdsController@data')->name('ads.information');
Route::get('/ads/select', 'AdsController@select')->name('ads.select');
Route::get('/ads/selected/{adtype}', 'AdsController@selected')->name('ads.selected');
Route::post('/ad/post', 'AdsController@store')->name('ads.post');
Route::get('/ad/edit/{id}', 'AdsController@edit')->name('ads.edit');
Route::put('ad/update/{id}', 'AdsController@update')->name('ads.update');
Route::get('/ad/{slug}', 'AdsController@slug')->name('ads.slug');
Route::get('/video/test', 'AdsController@testVideo')->name('video.test');
Route::get('/ads/category', 'AdsController@getCategories')->name('ads.categories');
Route::get('/ads/location', 'AdsController@getLocation')->name('ads.location');
Route::get('ads/delete/{id}', 'AdsController@delete')->name('ads.delete');
Route::delete('ads/destroy/{id}', 'AdsController@destroy')->name('ads.destroy');
		
//Articles
Route::get('/articles', 'ArticleController@index')->name('articles');
Route::get('/article/add', 'ArticleController@create')->name('article.add');
Route::post('/article/post', 'ArticleController@store')->name('article.post');
Route::put('article/update/{id}', 'ArticleController@update')->name('article.update');
Route::get('/article/edit/{id}', 'ArticleController@edit')->name('article.edit');
Route::get('/article/{slug}', 'ArticleController@slug')->name('article.slug');
Route::get('/articles/data', 'ArticleController@data')->name('articles.information');
Route::get('/article/video/test', 'ArticleController@testYVideo')->name('article.video.test');
Route::get('/art/location', 'ArticleController@getLocation')->name('article.location');
Route::get('article/delete/{id}', 'ArticleController@delete')->name('article.delete');
Route::delete('article/destroy/{id}', 'ArticleController@destroy')->name('article.destroy');

//Events
Route::get('/events', 'EventController@index')->name('events');
Route::get('/events/data', 'EventController@data')->name('events.information');
Route::get('/event/select', 'EventController@select')->name('event.select');
Route::get('/event/selected/{evtype}', 'EventController@selected')->name('event.selected');
Route::get('/event/video/test', 'EventController@testYVideo')->name('event.video.test');
Route::get('/event/edit/{id}', 'EventController@edit')->name('event.edit');
Route::put('event/update/{id}', 'EventController@update')->name('event.update');
Route::get('/event/location', 'EventController@getLocation')->name('event.location');
Route::get('/event/delete/{id}', 'EventController@delete')->name('event.delete');
Route::post('/event/post', 'EventController@store')->name('event.post');
Route::delete('event/destroy/{id}', 'EventController@destroy')->name('event.destroy');

//Photos
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

//Banners
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

//Portraits
Route::get('/portraits', 'PortraitController@index')->name('portraits');
Route::post('/portrait/search', 'PortraitController@search')->name('portrait.search');
Route::get('/portrait/add', 'PortraitController@create')->name('portrait.add');
Route::post('/portrait/post', 'PortraitController@store')->name('portrait.post');
Route::post('/portrait/save', 'PortraitController@save')->name('portrait.save');
Route::get('/portrait/cancelled/{flname}', 'PortraitController@cancel')->name('cancel.portrait');
Route::get('portrait/set/primary/{id}', 'PortraitController@setPrimary')->name('portrait.set.primary');
Route::get('portrait/delete/{id}', 'PortraitController@delete')->name('delete.portrait');
Route::delete('portrait/destroy/{id}', 'PortraitController@destroy')->name('portrait.destroy');

//Logos
Route::get('/logos', 'LogoController@index')->name('logos');
Route::post('/logo/search', 'LogoController@search')->name('logo.search');
Route::get('/logo/add', 'LogoController@create')->name('logo.add');
Route::post('/logo/post', 'LogoController@store')->name('logo.post');
Route::post('/logo/save', 'LogoController@save')->name('logo.save');
Route::get('/logo/cancelled/{flname}', 'LogoController@cancel')->name('cancel.logo');
Route::get('logo/set/primary/{id}', 'LogoController@setPrimary')->name('logo.set.primary');
Route::get('logo/delete/{id}', 'LogoController@delete')->name('delete.logo');
Route::delete('logo/destroy/{id}', 'LogoController@destroy')->name('logo.destroy');

// Move Portal
Route::get('/move', 'MoveController@index')->name('move');
Route::get('/state/regions', 'MoveController@getRegions')->name('state.regions');
Route::get('/goto/region', 'MoveController@gotoRegion')->name('goto.region');
Route::get('/move/portal', 'MoveController@movehere')->name('move.portal');
Route::get('/back/home', 'MoveController@backhome')->name('back.home');

// Membership
Route::get('/membership', 'AdminController@membership')->name('membership');
Route::get('/localresident', 'AdminController@localresident')->name('localresident');
Route::get('/communityleader', 'AdminController@communityleader')->name('communityleader');
Route::get('/localbusiness', 'AdminController@localbusiness')->name('localbusiness');
Route::get('/nationalbusiness', 'AdminController@nationalbusiness')->name('nationalbusiness');
Route::get('/sponsorship', 'AdminController@sponsorship')->name('sponsorship');
Route::get('/sponsorshipkey', 'AdminController@sponsorshipkey')->name('sponsorshipkey');

//Paypal Transactions
Route::get('manage/paypal', 'AdminController@manage_paypal')->name('manage.paypal');
Route::get('/paypal/data', 'AdminController@paypal_data')->name('paypal.data');
