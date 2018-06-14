<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'Localization', 'prefix' => Session::get('locale')], function () {
    Route::get('/', 'Controller@getHome');
    Route::get('/language-{id}', 'Controller@setLanguage');
    Route::post('/subscribe', 'Controller@Subscribe');

    Route::get('/{slug_menu}/{slug}/brand-{id}/filter-product', 'Controller@getBrandProduct');
    Route::get('/{slug_menu}/{slug}/collection-{id}/filter-product', 'Controller@getCollectionProduct');
    Route::get('/san-pham/price-{id}/filter-product', 'Controller@getPriceProduct');

    Route::get('/sitemap.xml', 'Controller@sitemap');
    Route::get('/google15f58b494fbc43ae.html', 'Controller@htmlGoogle');
    Route::post('/submit-contact', 'Controller@SubmitContact');
    Route::post('/subscribe-wine', 'Controller@SubscribeWine');
    Route::get('/search-product', 'Controller@SearchProduct');
    Route::get('/country-{id}/filter', 'Controller@getCountryProduct');
   

    Route::get('/{lang}-{id}-{slug}', 'Controller@getMenuPage');
    Route::get('/{id_menu}-{slug_menu}/{lang}-{id}-{slug}', 'Controller@getDetail');
    Route::get('/wine-center/{id}-{id_menu}/{slug_menu}', 'Controller@getWineCenter');
    Route::get('/{id_menu}-{slug_menu}/{id}/{slug}', 'Controller@getProduct');
    
     Route::get('/order-by-{id}/filter', 'Controller@getOrderbyProduct');
   Route::get('/{id}-{slug}/search-news','Controller@SearchNews');
});
//================== Admin routes ================================
Route::get('/admin','Admin\AdminController@Home')->middleware('not.login');
Route::get('/admin/log-in','Admin\AccountController@getLogin');
Route::get('/admin/log-out','Admin\AccountController@Logout');
Route::post('/admin/log-in','Admin\AccountController@postLogin');
Route::group(['prefix'=>'admin'],function (){
//system config

    Route::get('/system-config','Admin\AdminController@getSystemConfig')->middleware('not.login');
    Route::post('/system-config','Admin\AdminController@updateSystemConfig')->middleware('not.login');

    //system language
    Route::get('/system-language','Admin\AdminController@getLanguage')->middleware('not.login');
    Route::get('/create-language','Admin\AdminController@getCreateNewLanguage')->middleware('not.login');
    Route::post('/create-language','Admin\AdminController@postCreateNewLanguage')->middleware('not.login');
    Route::get('/edit-language-{id}','Admin\AdminController@getEditLanguage')->middleware('not.login');
    Route::post('/edit-language-{id}','Admin\AdminController@postEditLanguage')->middleware('not.login');
    Route::get('/delete-language-{id}','Admin\AdminController@getDeleteLanguage')->middleware('not.login');
    Route::post('/delete-language-{id}','Admin\AdminController@postDeleteLanguage')->middleware('not.login');
    //system permission
    Route::get('/system-permission','Admin\PermissionController@Index')->middleware('not.login');
    Route::get('/resize-image','Admin\PermissionController@getResize')->middleware('not.login');
    Route::post('/resize-image','Admin\PermissionController@postResize')->middleware('not.login');

    //menu management
    Route::get('/{id}-menu-management','Admin\AdminController@getMenuAdmin')->middleware('not.login');
    Route::get('/create-new-menu','Admin\AdminController@getCreateNewMenu')->middleware('not.login');
    Route::post('/create-new-menu','Admin\AdminController@postCreateNewMenu')->middleware('not.login');
    Route::get('/delete-menu-{id}','Admin\AdminController@getDeleteMenu')->middleware('not.login');
    Route::post('/delete-menu-{id}','Admin\AdminController@postDeleteMenu')->middleware('not.login');
    Route::get('/edit-menu-{id}','Admin\AdminController@getEditMenu')->middleware('not.login');
    Route::post('/edit-menu-{id}','Admin\AdminController@postEditMenu')->middleware('not.login');

    //slider management
    Route::get('/{id}-slider','Admin\SliderController@getSlider')->middleware('not.login');
    Route::get('/create-new-slider','Admin\SliderController@getCreateNewSlider')->middleware('not.login');
    Route::post('/create-new-slider','Admin\SliderController@postCreateNewSlider')->middleware('not.login');
    Route::get('/edit-slider-{id}','Admin\SliderController@getEditSlider')->middleware('not.login');
    Route::post('/edit-slider-{id}','Admin\SliderController@postEditSlider')->middleware('not.login');
    Route::get('/delete-slider-{id}','Admin\SliderController@getDeleteSlider')->middleware('not.login');
    Route::post('/delete-slider-{id}','Admin\SliderController@postDeleteSlider')->middleware('not.login');
    
	//product managerment
    Route::get('/{id}-product','Admin\ProductController@getProductAdmin')->middleware('not.login');
    Route::get('/product/create-product','Admin\ProductController@getCreateProduct')->middleware('not.login');
    Route::post('/product/create-product','Admin\ProductController@postCreateProduct')->middleware('not.login');
    Route::get('/product/edit-product-{id}','Admin\ProductController@getEditProduct')->middleware('not.login');
    Route::post('/product/edit-product-{id}','Admin\ProductController@postEditProduct')->middleware('not.login');
    Route::get('/product/delete-product-{id}','Admin\ProductController@getDeleteProduct')->middleware('not.login');
    Route::post('/product/delete-product-{id}','Admin\ProductController@postDeleteProduct')->middleware('not.login');
    Route::get('/product/remove-product-image-{id_image}','Admin\ProductController@RemoveImage')->middleware('not.login');
    //collection
    Route::get('/{id}-collection','Admin\CollectionController@getCollectionAdmin')->middleware('not.login');
    Route::get('/collection/create-new-collection','Admin\CollectionController@getCreateCollection')->middleware('not.login');
    Route::post('/collection/create-new-collection','Admin\CollectionController@postCreateCollection')->middleware('not.login');
    Route::get('/collection/edit-collection-{id}','Admin\CollectionController@getEditCollection')->middleware('not.login');
    Route::post('/collection/edit-collection-{id}','Admin\CollectionController@postEditCollection')->middleware('not.login');
    Route::get('/collection/delete-collection-{id}','Admin\CollectionController@getDeleteCollection')->middleware('not.login');
    Route::post('/collection/delete-collection-{id}','Admin\CollectionController@postDeleteCollection')->middleware('not.login');
    //brand
    Route::get('/{id}-brand','Admin\BrandController@getBrandAdmin')->middleware('not.login');
    Route::get('/brand/create-brand','Admin\BrandController@getCreateNewBrand')->middleware('not.login');
    Route::post('/brand/create-brand','Admin\BrandController@postCreateNewBrand')->middleware('not.login');
    Route::get('/brand/edit-brand-{id}','Admin\BrandController@getDetailBrand')->middleware('not.login');
    Route::post('/brand/edit-brand-{id}','Admin\BrandController@postDetailBrand')->middleware('not.login');
    Route::get('/brand/delete-brand-{id}','Admin\BrandController@getDeleteBrand')->middleware('not.login');
    Route::post('/brand/delete-brand-{id}','Admin\BrandController@postDeleteBrand')->middleware('not.login');
    //country
    Route::get('/{id}-country','Admin\CountryController@getAdminCountry')->middleware('not.login');
    Route::get('/country/create-country','Admin\CountryController@getCreateNewCountry')->middleware('not.login');
    Route::post('country/create-country','Admin\CountryController@postCreateNewCountry')->middleware('not.login');
    Route::get('/country/edit-country-{id}','Admin\CountryController@getDetailCountry')->middleware('not.login');
    Route::post('/country/edit-country-{id}','Admin\CountryController@postDetailCountry')->middleware('not.login');
    Route::get('/country/delete-country-{id}','Admin\CountryController@getDeleteCountry')->middleware('not.login');
    Route::post('/country/delete-country-{id}','Admin\CountryController@postDeleteCountry')->middleware('not.login');

    //Menu News Management
    Route::get('/{id}-menu-news','Admin\MenuNewsController@getMenuNews')->middleware('not.login');
    Route::get('/menu-news/create-menu-news','Admin\MenuNewsController@getCreateNewMenuNews')->middleware('not.login');
    Route::post('/menu-news/create-menu-news','Admin\MenuNewsController@postCreateNewMenuNews')->middleware('not.login');
    Route::get('/menu-news/edit-menu-news-{id}','Admin\MenuNewsController@getDetailMenuNews')->middleware('not.login');
    Route::post('/menu-news/edit-menu-news-{id}','Admin\MenuNewsController@postDetailMenuNews')->middleware('not.login');
    Route::get('/menu-news/delete-menu-news-{id}','Admin\MenuNewsController@getDeleteMenuNews')->middleware('not.login');
    Route::post('/menu-news/delete-menu-news-{id}','Admin\MenuNewsController@postDeleteMenuNews')->middleware('not.login');
    //News management
    Route::get('/{id}-news','Admin\NewsController@getNews')->middleware('not.login');
    Route::get('/news/create-news','Admin\NewsController@getCreateNews')->middleware('not.login');
    Route::post('/news/create-news','Admin\NewsController@postCreateNews')->middleware('not.login');
    Route::get('/news/edit-news-{id}','Admin\NewsController@getEditNews')->middleware('not.login');
    Route::post('/news/edit-news-{id}','Admin\NewsController@postEditNews')->middleware('not.login');
    Route::get('/news/delete-news-{id}','Admin\NewsController@getDeleteNews')->middleware('not.login');
    Route::post('/news/delete-news-{id}','Admin\NewsController@postDeleteNews')->middleware('not.login');

    //About management
    Route::get('/{id}-wine-center','Admin\WineCenterController@getWineCenterAdmin')->middleware('not.login');
    Route::get('/wine-center/edit-wine-center-{id}','Admin\WineCenterController@getEditWineCenter')->middleware('not.login');
    Route::post('/wine-center/edit-wine-center-{id}','Admin\WineCenterController@postEditWineCenter')->middleware('not.login');
    Route::get('/wine-center/delete-wine-center-{id}','Admin\WineCenterController@getDeleteWineCenter')->middleware('not.login');
    Route::post('/wine-center/delete-wine-center-{id}','Admin\WineCenterController@postDeleteWineCenter')->middleware('not.login');

    //Address management
    Route::get('/{id}-address-management','Admin\AddressController@getAddressAdmin')->middleware('not.login');
    Route::get('/address/create-address','Admin\AddressController@getCreateAddress')->middleware('not.login');
    Route::post('/address/create-address','Admin\AddressController@postCreateAddress')->middleware('not.login');
    Route::get('/address/edit-address-{id}','Admin\AddressController@getEditAddress')->middleware('not.login');
    Route::post('/address/edit-address-{id}','Admin\AddressController@postEditAddress')->middleware('not.login');
    Route::get('/address/delete-address-{id}','Admin\AddressController@getDeleteAddress')->middleware('not.login');
    Route::post('/address/delete-address-{id}','Admin\AddressController@postDeleteAddress')->middleware('not.login');

    //Labels
    Route::get('/{id}-labels-management','Admin\LabelsController@getLabelsAdmin')->middleware('not.login');
    Route::post('/1/save-label','Admin\LabelsController@UpdateLabelAdmin')->middleware('not.login');
    
    //Subscribe management
    Route::get('/subscribe-management','Admin\SubscribeController@getSubscribeAdmin')->middleware('not.login');
    Route::get('/subscribe/edit-subscribe-{id}','Admin\SubscribeController@getEditSubscribe')->middleware('not.login');
    Route::post('/subscribe/edit-subscribe-{id}','Admin\SubscribeController@postEditSubscribe')->middleware('not.login');
    Route::get('/subscribe/delete-subscribe-{id}','Admin\SubscribeController@getDeleteSubscribe')->middleware('not.login');
    Route::post('/subscribe/delete-subscribe-{id}','Admin\SubscribeController@postDeleteSubscribe')->middleware('not.login');
    //Subscribe Wine management
    Route::get('/subscribe-wine-management','Admin\SubscribeWineController@getSubscribeWineAdmin')->middleware('not.login');
    Route::get('/subscribe-wine/edit-subscribe-wine-{id}','Admin\SubscribeWineController@getEditSubscribeWine')->middleware('not.login');
    Route::post('/subscribe-wine/edit-subscribe-wine-{id}','Admin\SubscribeWineController@postEditSubscribeWine')->middleware('not.login');
    Route::get('/subscribe-wine/delete-subscribe-wine-{id}','Admin\SubscribeWineController@getDeleteSubscribeWine')->middleware('not.login');
    Route::post('/subscribe-wine/delete-subscribe-wine-{id}','Admin\SubscribeWineController@postDeleteSubscribeWine')->middleware('not.login');

//User management
    Route::get('/user-management','Admin\UserController@Index')->middleware('not.login');
    Route::get('/user/create-user','Admin\UserController@CreateUser')->middleware('not.login');
    Route::post('/user/create-user','Admin\UserController@StoredUser')->middleware('not.login');
    Route::get('/user/edit-user-{id}','Admin\UserController@EditUser')->middleware('not.login');
    Route::post('/user/edit-user-{id}','Admin\UserController@postUpdatePermission')->middleware('not.login');
    Route::get('/user/delete-user-{id}','Admin\UserController@DeleteUser')->middleware('not.login');
    Route::post('/user/delete-user-{id}','Admin\UserController@RemoveUser')->middleware('not.login');
    Route::get('/user/profile-{id}','Admin\UserController@Profile')->middleware('not.login');
    Route::post('/user/profile-{id}','Admin\UserController@UpdateProfile')->middleware('not.login');

});


