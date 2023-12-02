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

Route::match(['get', 'post'], 'loading-share/', function () {
    return '<h4 style="color:red"> Loading preview... </h4>';
});

/* Route::get('/', function () {
    return view('welcome');
}); */ 

// Route::get('/form/{test}', function ($test) {
//     return view('test',['test'=>$test]);
// });
// Route::get('/archeive', function () {
//     return view('archeive/archeive','UserController@archeive');
// });

 Route::get('/', 'HomeController@index');
 Route::get('/home/', 'HomeController@index');
 
#Route::middleware(['slashes'])->group(function () {
Route::any('/archive/', 'UserController@error_404');
Route::any('/archive/{id}', 'UserController@archive')->where('id', '[0-9]+');
Route::any('/archive_pdf/', 'UserController@error_404');
Route::any('/archive/{title?}/', 'UserController@archive_pdf');
Route::any('/auth/login/{method?}/{producttype?}', 'AuthController@login');
Route::any('/auth/callback/{method?}', 'AuthController@callback');
 Route::any('/socialmedia/shareSocialmedia/{any?}', 'SocialMediaController@shareSocialmedia');
 Route::any('/socialmedia/saveimage/', 'SocialMediaController@saveimage');

 Route::get('/aboutus', 'AboutusController@index');
 Route::get('/aboutus/privacypolicy', 'AboutusController@privacypolicy');
 Route::get('/aboutus/termsofuse', 'AboutusController@termsofuse');
 Route::get('/aboutus/commercial_policy', 'AboutusController@commercial_policy');
 Route::get('/helpdesk', 'HelpdeskController@index');
 Route::any('/helpdesk/post', 'HelpdeskController@post');
 Route::get('/products', 'ProductsController@index');
 Route::any('/aboutus/career/{params?}', 'AboutusController@career');
 Route::any('/contact', 'ContactController@index');
 Route::any('/search', 'SearchController@index');
 Route::any('/products/offerings', 'ProductsController@offerings');
 Route::any('/page/upload_document/{params?}', 'PageController@upload_document');
  Route::any('/page/admin_index', 'PageController@admin_index');
 Route::get('/user', 'UserController@index');
 Route::any('/user/signup', 'UserController@signup');
 Route::any('/user/updateCard', 'UserController@updateCard');
 Route::any('/user/completeregistration_success', 'UserController@completeregistration_success');
 Route::get('/user/confirmregistration/{id}', 'UserController@confirmregistration');
 Route::any('/user/login', 'UserController@login');
 Route::get('/user/premium_login', 'UserController@premium_login');
 Route::post('/user/loginbyajx', 'UserController@loginbyajx');
 Route::any('/user/forgotpassword', 'UserController@forgotpassword');
 Route::any('/user/linkedinProcess/{any?}', 'UserController@linkedinProcess');
 Route::any('/user/newsletters', 'UserController@newsletters');
 Route::any('/user/myaccount/{any?}/{ids?}', 'UserController@myaccount');
 Route::any('/user/user_type_upgrade', 'UserController@user_type_upgrade');
 Route::post('/user/editprofile', 'UserController@editprofile');
 Route::get('/user/logout', 'UserController@logout');
 Route::any('/user/changepassword', 'UserController@changepassword');
 Route::any('/user/user_request_info', 'UserController@user_request_info');
 Route::post('/user/mailAlertUpdate', 'UserController@mailAlertUpdate');
 Route::any('/user/dopayment', 'UserController@dopayment');
 Route::get('/user/payment_success', 'UserController@payment_success');
 Route::any('/user/user_pay_downgrade', 'UserController@user_pay_downgrade');
 Route::any('/user/cancelSubscription', 'UserController@cancelSubscription');
 Route::any('/user/unsubscribe_user/{any?}', 'UserController@unsubscribe_user');
 Route::any('/user/unsubscribe_user_encode/{any?}', 'UserController@unsubscribe_user_encode');
 Route::post('/user/mailAlertUpdateWithoutLogin', 'UserController@mailAlertUpdateWithoutLogin');
 Route::any('/user/unsubscribe_update_sccess', 'UserController@unsubscribe_update_sccess');
 Route::any('/user/registercompetition/{params?}', 'UserController@registercompetition');

 #Route::any('/user/paypal_success', 'UserController@paypal_success');
Route::any('/user/payment_done', 'UserController@payment_done');
Route::any('/user/dopayment_paypal', 'UserController@dopayment_paypal');
Route::any('/user/updatepaymentresponse_success', 'UserController@updatepaymentresponse_success');
Route::get('/user/updatepaymentresponse_cancel', 'UserController@updatepaymentresponse_cancel');



 
 
 Route::get('/seminar', 'SeminarController@index');
/* Route::get('/sitemap', 'SitemapController@index');
 Route::get('/sitemapnews', 'SitemapnewsController@index');*/
 
 Route::get('/page/category/economic-indicators', 'PageController@seo_category');
 Route::get('/page/category/economic-indicators/{titles}', 'PageController@seo_category');
Route::get('/page', 'PageController@index');
Route::get('/page/category/{main_cat?}/{sub_cat?}/{title?}/{future?}', 'PageController@category');
Route::get('/page/preview/{title}', 'PageController@preview');
Route::get('/page/ideapitchcompetition', 'PageController@ideapitchcompetition');



// Reports url Routing
Route::get('/reports', 'ReportsController@index');
Route::get('/reports/view/{main_cat?}/{sub_cat?}/{sub_cat1?}/{title?}/{future?}', 'ReportsController@view');
Route::get('/reports/preview/{title}', 'ReportsController@preview');



Route::any('/mycharts', 'MychartsController@index');
Route::any('/mycharts/about_my_chart', 'MychartsController@about_my_chart');
Route::any('/mycharts/folder/{param}', 'MychartsController@folder');
Route::any('/mycharts/chartbook/{param}', 'MychartsController@chartbook');
Route::any('/mycharts/chart/{param}', 'MychartsController@chart');
Route::any('/mycharts/single_chart_ppt', 'MychartsController@single_chart_ppt');
Route::any('/mycharts/power_point', 'MychartsController@power_point');


Route::any('/chart', 'ChartController@index');
Route::any('/chart/downloadxls', 'ChartController@downloadxls');
Route::any('/chart/getchartdata', 'ChartController@getchartdata');
Route::any('/chart/get_chart_fields_labels', 'ChartController@get_chart_fields_labels');
Route::any('/chart/getchartListdata', 'ChartController@getchartListdata');
Route::any('/chart/exportChartpptx', 'ChartController@exportChartpptx');
Route::any('/chart/exportChart', 'ChartController@exportChart');
Route::any('/chart/exportBulkChart', 'ChartController@exportBulkChart');
#});
 
/*  Route::get('/aboutus/{career}', function ($career) {
    return 'User '.$career; 
}); */
 
/*Route::get('user/{id}', function ($id) {
    return 'User '.$id;
});

Route::get('foo', function () {
    return 'Hello World';
}); */