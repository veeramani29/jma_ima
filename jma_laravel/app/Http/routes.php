<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::match(['get', 'post'], 'loading-share/', function () {
    return '<h4 style="color:red"> Loading preview... </h4>';
});

Route::any('/lang', function () {
    return '<h4 style="color:red"> Loading preview... </h4>';
});
/*Route::get('/', function () {
    return view('templates.default');
});*/
#Route::resource('user', 'UserController');

Route::get('/mainatenace', 'MainatenaceController@index');

Route::any('/socialmedia/shareSocialmedia/{any?}', 'SocialMediaController@shareSocialmedia');
Route::any('/socialmedia/saveimage/', 'SocialMediaController@saveimage');
// Static pages or aboutus url Routing
Route::get('/aboutus', 'AboutusController@index');
Route::get('/aboutus/privacypolicy', 'AboutusController@privacypolicy');
Route::get('/aboutus/termsofuse', 'AboutusController@termsofuse');
Route::get('/aboutus/commercial_policy', 'AboutusController@commercial_policy');
Route::get('/aboutus/map_chart', 'AboutusController@map_chart');
Route::get('/aboutus/search', 'AboutusController@search');
// Briefseries url Routing
Route::get('/briefseries', 'BriefseriesController@index');
// Careers url Routing
Route::get('/careers', 'CareersController@index');
// Contact url Routing
Route::get('/contact', 'ContactController@index');
//Custom controoler for 
Route::any('/custom/dopayment', 'CustomController@dopayment');
Route::any('/custom/do_payment', 'CustomController@do_payment');
// Endpoint url Routing
Route::post('/endpoint/stripe', 'EndpointController@stripe');
Route::post('/endpoint/unitTest', 'EndpointController@unitTest');
Route::any('/paypalipn/stimulate', 'PaypalipnController@stimulate');
// Helpdesk url Routing
Route::get('/helpdesk', 'HelpdeskController@index');
Route::any('/helpdesk/post', 'HelpdeskController@post');
// Home url Routing
Route::post('/', 'HomeController@index');
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
// Materials url Routing
Route::any('/materials/category/{sub_cat?}/{title?}/{future?}', 'MaterialsController@category');
Route::any('/materials/download/{id}/{file}', 'MaterialsController@download');
// News url Routing
Route::get('/news', 'NewsController@index');
Route::get('/news/category/{main_cat?}/{sub_cat?}/{title?}/{future?}', 'NewsController@category');
Route::get('/news/view/{title}', 'NewsController@view');
// Page url Routing
Route::get('/page', 'PageController@index');
Route::get('/page/category/{main_cat?}/{sub_cat?}/{title?}/{future?}', 'PageController@category');
Route::get('/page/preview/{title}', 'PageController@preview');
// Products url Routing
Route::get('/products', 'ProductsController@index');
Route::get('/products/offerings', 'ProductsController@offerings');
Route::get('/products/about_premium_user', 'ProductsController@about_premium_user');
// Reports url Routing
Route::get('/reports', 'ReportsController@index');
Route::get('/reports/view/{main_cat?}/{sub_cat?}/{sub_cat1?}/{title?}/{future?}', 'ReportsController@view');
Route::get('/reports/preview/{title}', 'ReportsController@preview');
//RSS controoler 
Route::get('/rss', 'RssController@index');
//Sitemap controoler 
Route::get('/sitemap', 'SitemapController@index');
//Sitemap News controoler 
Route::get('/sitemap_news', 'Sitemap_newsController@index');
//Tools News controoler 
Route::get('/tools/topixcalculator', 'ToolsController@topixcalculator');
// Users url Routing
Route::get('/user', 'UserController@index');
Route::any('/user/signup', 'UserController@signup');
Route::post('/user/check_email', 'UserController@check_email');
Route::any('/user/completeregistration_success', 'UserController@completeregistration_success');
Route::get('/user/confirmregistration/{id}', 'UserController@confirmregistration');
Route::any('/user/login', 'UserController@login');
Route::any('/user/premium_login', 'UserController@premium_login');
Route::post('/user/loginbyajx', 'UserController@loginbyajx');
Route::any('/user/forgotpassword', 'UserController@forgotpassword');
Route::any('/user/linkedinProcess/{any?}', 'UserController@linkedinProcess');
Route::any('/user/newsletters', 'UserController@newsletters');
Route::any('/user/myaccount/{any?}/{ids?}', 'UserController@myaccount')->middleware('authenticated');
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
#Route::any('/user/paypal_success', 'UserController@paypal_success');
Route::any('/user/payment_done', 'UserController@payment_done');
Route::any('/user/dopayment_paypal', 'UserController@dopayment_paypal');
Route::any('/user/updatepaymentresponse_success', 'UserController@updatepaymentresponse_success');
Route::get('/user/updatepaymentresponse_cancel/{any?}', 'UserController@updatepaymentresponse_cancel');



Route::any('/mycharts', 'MychartsController@index');
Route::any('/mycharts/about_my_chart', 'MychartsController@about_my_chart');
Route::any('/mycharts/folder/{param}', 'MychartsController@folder');
Route::any('/mycharts/chartbook/{param}', 'MychartsController@chartbook');
Route::any('/mycharts/listChartBook', 'MychartsController@listChartBook');
Route::any('/mycharts/chart/{param}', 'MychartsController@chart');
Route::any('/mycharts/single_chart_ppt', 'MychartsController@single_chart_ppt');
Route::any('/mycharts/power_point', 'MychartsController@power_point');
Route::any('/mycharts/chartbookList/{param}', 'MychartsController@chartbookList');
Route::any('/mycharts/saveChartBookToMychart', 'MychartsController@saveChartBookToMychart');
Route::any('/mycharts/list_chartbook', 'MychartsController@list_chartbook');


Route::any('/chart', 'ChartController@index');
Route::any('/chart/downloadxls', 'ChartController@downloadxls');
Route::any('/chart/getchartdata', 'ChartController@getchartdata');
Route::any('/chart/get_chart_fields_labels', 'ChartController@get_chart_fields_labels');
Route::any('/chart/getchartListdata', 'ChartController@getchartListdata');
Route::any('/chart/exportChartpptx', 'ChartController@exportChartpptx');
Route::any('/chart/exportChart', 'ChartController@exportChart');
Route::any('/chart/exportBulkChart', 'ChartController@exportBulkChart');
Route::any('/chart/getchartBookListdata', 'ChartController@getchartBookListdata');
#Route::any('/mycharts/chart/{param}', 'MychartsController@chart');
#Route::any('/mycharts/single_chart_ppt', 'MychartsController@single_chart_ppt');











