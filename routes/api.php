<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'user'=>'API\UserController',
    'contact' => 'API\ContactController',
    'settings' => 'API\settingsController',
    'socialmedia' => 'API\SocialmediaController',
    'carousel' => 'API\carouselController',
    'carousel' => 'API\carouselController',
    'carouselalt' => 'API\carouselaltController',
    'sss' => 'API\sssController',
    'posts' => 'API\postController',
    'categories' => 'API\categoriesController',
    'ourteam' => 'API\ourTeamController',
    'extras' => 'API\extrasController',
    'activities' => 'API\activitiesController',
    'dashboard' => 'API\dashboardController',
    'contactus' => 'API\ContactUsController',
    'regs' => 'API\regApplicationsController',
    'sponsor' => 'API\sponsorController',
    'products' => 'API\productsController',
    'topcategory' => 'API\shp_topcategoryController',
    'pages' => 'API\PagecreatorController',
    'regsforandroid' => 'API\regsForAndroidController',
    'fueteknigi' => 'API\fueteknigiPageController',
    'kadinlardasacekimi' => 'API\kadinlardasacekimiPageController',
    'kasekimi' => 'API\kasekimiPageController',
    'trassizsacekimi' => 'API\trassizsacekimiPageController',
    'sakalbiyikekimi' => 'API\sakalbiyikekimiPageController',
    'prptedavisihizmeti' => 'API\prptedavisihizmetiPageController',
    'dhisacekimi' => 'API\dhisacekimiPageController',
    'implant' => 'API\implantPageController',
    'sabitprotez' => 'API\sabitprotezPageController',
    'zirkonyum' => 'API\zirkonyumPageController',
    'hareketliprotezler' => 'API\hareketliprotezlerPageController',
    'erkenimplantyerlesimi' => 'API\erkenimplantyerlesimiPageController',
    'erkenimplantyuklemesi' => 'API\erkenimplantyuklemesiPageController',
    'ortodonti' => 'API\ortodontiPageController',
    'hizmetturs' => 'API\hizmetturController',
    'althizmetturs' => 'API\althizmetturController',
    'localizations' => 'API\localizationController',
    'icerikler' => 'API\hizmetlerController',
    'icerikler2' => 'API\iceriklerController',
    'icerikler3' => 'API\carusellerController',
    'icerikler4' => 'API\bloglarController',
    'resimler' => 'API\galeryController',
    'comments' => 'API\commentsController'

]);
Route::get('findUser', 'API\UserController@search');
Route::get('profile', 'API\UserController@profile');
Route::put('profile', 'API\UserController@updateProfile');
Route::post('profile_image_editor', 'API\UserController@storeimagebyeditor');
Route::get('contactinfo', 'API\ContactController@show');
Route::put('contactinfo', 'API\ContactController@update');
Route::get('cataloginfo', 'API\CatalogController@show');
Route::put('cataloginfo', 'API\CatalogController@update');
Route::get('settings', 'API\settingsController@show');
Route::put('settings', 'API\settingsController@update');
Route::post('settings_image', 'API\settingsController@storeimage');
Route::get('findSocialmedia', 'API\SocialmediaController@search');
Route::put('socialmedia', 'API\SocialmediaController@update');
Route::post('socialmedia_image', 'API\SocialmediaController@storeimage');
Route::post('socialmediaup', 'API\SocialmediaController@up');
Route::post('socialmediadown', 'API\SocialmediaController@down');
Route::get('findcarousel', 'API\carouselController@search');
Route::put('carousel', 'API\carouselController@update');
Route::post('carousel_image', 'API\carouselController@storeimage');
Route::post('carouselup', 'API\carouselController@up');
Route::post('carouseldown', 'API\carouselController@down');
Route::get('findcarouselalt', 'API\carouselaltController@search');
Route::put('carouselalt', 'API\carouselaltController@update');
Route::post('carouselaltup', 'API\carouselaltController@up');
Route::post('carouselaltdown', 'API\carouselaltController@down');
Route::get('allcarousels', 'API\carouselController@allcarousels');
Route::get('findsss', 'API\sssController@search');
Route::get('sssbylang/{id}', 'API\sssController@listbylang');
Route::put('sss', 'API\sssController@update');
Route::post('sss_image_editor', 'API\sssController@storeimagebyeditor');
Route::post('sssup', 'API\sssController@up');
Route::post('sssdown', 'API\sssController@down');
Route::get('mainpage', 'API\mainPageController@show');
Route::put('mainpage', 'API\mainPageController@update');
Route::post('mainpage_image', 'API\mainPageController@storeimage');
Route::post('mainpage_image_editor', 'API\mainPageController@storeimagebyeditor');
Route::get('registerpage', 'API\registerPageController@show');
Route::put('registerpage', 'API\registerPageController@update');
Route::post('registerpage_image', 'API\registerPageController@storeimage');
Route::post('registerpage_image_editor', 'API\registerPageController@storeimagebyeditor');
Route::get('ssspage', 'API\sssPageController@show');
Route::put('ssspage', 'API\sssPageController@update');
Route::post('ssspage_image', 'API\sssPageController@storeimage');
Route::post('ssspage_image_editor', 'API\sssPageController@storeimagebyeditor');
Route::get('aboutme', 'API\aboutmeController@show');
Route::put('aboutme', 'API\aboutmeController@update');
Route::post('aboutme_image', 'API\aboutmeController@storeimage');
Route::post('aboutme_image_editor', 'API\aboutmeController@storeimagebyeditor');
Route::get('leanedir', 'API\leanedirPageController@show');
Route::put('leanedir', 'API\leanedirPageController@update');
Route::post('leanedir_image', 'API\leanedirPageController@storeimage');
Route::post('leanedir_image_editor', 'API\leanedirPageController@storeimagebyeditor');
Route::get('findCategory', 'API\categoriesController@search');
Route::put('categories', 'API\categoriesController@update');
Route::post('category_image', 'API\categoriesController@storeimage');
Route::post('category_image_editor', 'API\categoriesController@storeimagebyeditor');
Route::post('categoryup', 'API\categoriesController@up');
Route::post('categorydown', 'API\categoriesController@down');
Route::get('findPosts', 'API\postController@search');
Route::put('posts', 'API\postController@update');
Route::post('posts_image', 'API\postController@storeimage');
Route::post('posts_image1', 'API\postController@storeimage1');
Route::post('posts_image2', 'API\postController@storeimage2');
Route::post('posts_image3', 'API\postController@storeimage3');
Route::post('posts_image4', 'API\postController@storeimage4');
Route::post('posts_image_editor', 'API\postController@storeimagebyeditor');
Route::post('postup', 'API\postController@up');
Route::post('postdown', 'API\postController@down');
Route::get('allcategories', 'API\categoriesController@allcategories');
Route::get('findourteam', 'API\ourTeamController@search');
Route::put('ourteam', 'API\ourTeamController@update');
Route::post('ourteam_image', 'API\ourTeamController@storeimage');
Route::post('ourteam_image1', 'API\ourTeamController@storeimage1');
Route::post('ourteam_image2', 'API\ourTeamController@storeimage2');
Route::post('ourteam_image3', 'API\ourTeamController@storeimage3');
Route::post('ourteam_image4', 'API\ourTeamController@storeimage4');
Route::post('ourteam_image_editor', 'API\ourTeamController@storeimagebyeditor');
Route::post('ourteamup', 'API\ourTeamController@up');
Route::post('ourteamdown', 'API\ourTeamController@down');
Route::get('findextras', 'API\extrasController@search');
Route::put('extras', 'API\extrasController@update');
Route::post('extras_image', 'API\extrasController@storeimage');
Route::post('extrasup', 'API\extrasController@up');
Route::post('extrasdown', 'API\extrasController@down');
Route::get('findcontactus', 'API\ContactUsController@search');
Route::put('contactus', 'API\ContactUsController@update');
Route::post('contactus_image', 'API\ContactUsController@storeimage');
Route::get('allcities', 'API\regApplicationsController@allcities');
Route::get('stats_counts', 'API\dashboardController@sessions');
Route::get('statscountall', 'API\dashboardController@statscountall');
Route::get('statscountday', 'API\dashboardController@statscountday');
Route::get('statscountweek', 'API\dashboardController@statscountweek');
Route::get('statscountrecent', 'API\dashboardController@statscountrecent');
Route::get('apiPageviews', 'API\dashboardController@apiPageviews');
Route::get('findPages', 'API\PagecreatorController@search');
Route::put('pages', 'API\PagecreatorController@update');
Route::post('pagesup', 'API\PagecreatorController@up');
Route::post('pagesdown', 'API\PagecreatorController@down');
Route::post('image', 'API\ImageController@store');

Route::get('findHizmettur', 'API\hizmetturController@search');
Route::get('hizmettursbylang/{id}', 'API\hizmetturController@listbylang');
Route::get('hizmettursbylang2/{id}', 'API\hizmetturController@listbylang2');
Route::get('Allhizmettur', 'API\hizmetturController@all');
Route::put('hizmettur', 'API\hizmetturController@update');
Route::post('hizmettur_image', 'API\hizmetturController@storeimage');
Route::post('hizmetturup', 'API\hizmetturController@up');
Route::post('hizmetturdown', 'API\hizmetturController@down');

Route::get('findAlthizmettur/{id}', 'API\althizmetturController@search');
Route::get('althizmettursbylang/{id}', 'API\althizmetturController@listbylang');
Route::get('Allalthizmettur/{id}', 'API\althizmetturController@all');
Route::put('Althizmettur', 'API\althizmetturController@update');
Route::post('Althizmettur_image', 'API\althizmetturController@storeimage');
Route::post('Althizmetturup', 'API\althizmetturController@up');
Route::post('Althizmetturdown', 'API\althizmetturController@down');

//Hizmetler
Route::get('findIcerikler', 'API\hizmetlerController@search');
Route::get('iceriklerbylang/{id}', 'API\hizmetlerController@listbylang');
Route::get('iceriklerbylang2/{id}', 'API\hizmetlerController@listbylang2');
Route::put('icerikler', 'API\hizmetlerController@update');
Route::post('eslestir', 'API\hizmetlerController@eslestir');
Route::post('icerikler_image', 'API\hizmetlerController@storeimage');
Route::post('icerikler_image1', 'API\hizmetlerController@storeimage1');
Route::post('icerikler_image2', 'API\hizmetlerController@storeimage2');
Route::post('icerikler_image3', 'API\hizmetlerController@storeimage3');
Route::post('icerikler_image4', 'API\hizmetlerController@storeimage4');
Route::post('icerikler_image5', 'API\hizmetlerController@storeimage5');
Route::post('iceriklerup', 'API\hizmetlerController@up');
Route::post('iceriklerdown', 'API\hizmetlerController@down');
Route::post('icerikler_image_editor', 'API\hizmetlerController@storeimagebyeditor');
Route::post('althizmettursbyid', 'API\hizmetlerController@listbyid');

//içerikler
Route::get('findIcerikler2', 'API\iceriklerController@search');
Route::get('icerikler2bylang/{id}', 'API\iceriklerController@listbylang');
Route::put('icerikler2', 'API\iceriklerController@update');
Route::post('icerikler2_image', 'API\iceriklerController@storeimage');
Route::post('icerikler2_image1', 'API\iceriklerController@storeimage1');
Route::post('icerikler2_image2', 'API\iceriklerController@storeimage2');
Route::post('icerikler2_image3', 'API\iceriklerController@storeimage3');
Route::post('icerikler2_image4', 'API\iceriklerController@storeimage4');
Route::post('icerikler2_image5', 'API\iceriklerController@storeimage5');
Route::post('icerikler2up', 'API\iceriklerController@up');
Route::post('icerikler2down', 'API\iceriklerController@down');
Route::post('icerikler2_image_editor', 'API\iceriklerController@storeimagebyeditor');

//caruseller
Route::get('findIcerikler3', 'API\carusellerController@search');
Route::get('icerikler3bylang/{id}', 'API\carusellerController@listbylang');
Route::put('icerikler3', 'API\carusellerController@update');
Route::post('icerikler3_image', 'API\carusellerController@storeimage');
Route::post('icerikler3_image1', 'API\carusellerController@storeimage1');
Route::post('icerikler3_image2', 'API\carusellerController@storeimage2');
Route::post('icerikler3_image3', 'API\carusellerController@storeimage3');
Route::post('icerikler3_image4', 'API\carusellerController@storeimage4');
Route::post('icerikler3_image5', 'API\carusellerController@storeimage5');
Route::post('icerikler3up', 'API\carusellerController@up');
Route::post('icerikler3down', 'API\carusellerController@down');
Route::post('icerikler3_image_editor', 'API\carusellerController@storeimagebyeditor');

//blog
Route::get('findIcerikler4', 'API\bloglarController@search');
Route::get('icerikler4bylang/{id}', 'API\bloglarController@listbylang');
Route::put('icerikler4', 'API\bloglarController@update');
Route::post('icerikler4_image', 'API\bloglarController@storeimage');
Route::post('icerikler4_image1', 'API\bloglarController@storeimage1');
Route::post('icerikler4_image2', 'API\bloglarController@storeimage2');
Route::post('icerikler4_image3', 'API\bloglarController@storeimage3');
Route::post('icerikler4_image4', 'API\bloglarController@storeimage4');
Route::post('icerikler4_image5', 'API\bloglarController@storeimage5');
Route::post('icerikler4up', 'API\bloglarController@up');
Route::post('icerikler4down', 'API\bloglarController@down');
Route::post('icerikler4_image_editor', 'API\bloglarController@storeimagebyeditor');

//Resimler
Route::get('findResimler', 'API\galeryController@search');
Route::get('resimlerbylang/{id}', 'API\galeryController@listbylang');
Route::put('resimler', 'API\galeryController@update');
Route::post('resimler_image', 'API\galeryController@storeimage');
Route::post('resimler_image1', 'API\galeryController@storeimage1');
Route::post('resimlerup', 'API\galeryController@up');
Route::post('resimlerdown', 'API\galeryController@down');

//Resimler
Route::get('findComments', 'API\commentsController@search');
Route::get('commentsbylang/{id}', 'API\commentsController@listbylang');
Route::put('comments', 'API\commentsController@update');
Route::post('comments_image', 'API\commentsController@storeimage');
Route::post('comments_image1', 'API\commentsController@storeimage1');
Route::post('commentsup', 'API\commentsController@up');
Route::post('commentsdown', 'API\commentsController@down');