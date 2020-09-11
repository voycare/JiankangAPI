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

$router->post('/import-country', 'CountryController@import');
$router->get('/list-country', 'CountryController@index');
$router->get('/cities', 'CountryController@cities');
$router->get('/appointment/metas', 'AppointmentController@metas');
$router->post('/list-faq', 'FAQController@getFAQs');
$router->post('/review/get', 'ReviewController@getReviews');
$router->post('/feedback/create', 'FeedBackController@create');
$router->post('/list-clinic', 'Admin\AdminController@getListClinic');
$router->post('/clinic-detail', 'UserController@getClinicDetail');
$router->post('/review/summary', 'Clinic\ClinicController@getReviewSummary');
$router->get('settings', 'SettingController@show');
$router->get('admin/interpreters', 'Admin\InterpreterController@index');
$router->get('admin/appointments/{id}/documents', 'Admin\AppointmentController@documents');
$router->get('news', 'NewsController@index');
$router->post('news', 'NewsController@show');
$router->get('clinics', 'ClinicController@index');
$router->post('clinics', 'ClinicController@store');
$router->post('subscribers', 'SubscriberController@store');
$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('register', 'RegisterController@register');
    $router->post('register-social', 'RegisterController@registerSocial');
    $router->post('login', 'LoginController@login');
    $router->post('doctor/login', 'LoginController@loginDoctor');
    $router->post('admin/login', 'LoginController@loginAdmin');
    $router->post('login-social', 'LoginController@loginSocial');
    $router->post('forgot-pass', 'UserController@forgotPass');
    $router->post('change-password', 'UserController@changePassword');
    $router->get('setting-notification', 'SettingNotificationController@show');
    $router->post('setting-notification', 'SettingNotificationController@updateSetting');
    $router->get('settings/basic', 'SettingController@basic');
    $router->post('settings/basic', 'SettingController@postBasic');
    $router->post('logout', 'UserController@logout');
});
$router->group(['middleware' => ['auth', 'jwt.auth', 'is_admin']], function () use ($router) {
    $router->group(['prefix' => 'admin'], function () use ($router) {
        $router->get('clinic-applicants', 'Admin\ClinicController@applicants');
        $router->get('clinic-approved', 'Admin\ClinicController@approved');
        $router->get('clinics/{id}', 'Admin\ClinicController@show');
        $router->post('clinics/{id}', 'Admin\ClinicController@update');
        $router->post('clinics/{id}/approve', 'Admin\ClinicController@approve');
        $router->post('clinics/{id}/decline', 'Admin\ClinicController@decline');
        $router->post('clinics/{id}/delete', 'Admin\ClinicController@destroy');
        $router->post('clinic-languages/{id}', 'Admin\ClinicController@updateLanguage');
        $router->post('clinic-languages/{id}/remove', 'Admin\ClinicController@removeLanguage');
        $router->get('clinics-top', 'Admin\ClinicController@top');
        $router->get('clinics/{id}/services', 'Admin\ClinicServiceController@show');
        $router->post('clinics/{id}/services', 'Admin\ClinicServiceController@update');
        $router->get('clinics/{id}/availables', 'Admin\ClinicAvailableController@show');
        $router->post('clinics/{id}/availables', 'Admin\ClinicAvailableController@update');
        $router->post('clinics/{id}/availables-remove', 'Admin\ClinicAvailableController@remove');
        $router->get('clinics/{id}/photos', 'Admin\ClinicPhotoController@show');
        $router->post('clinics/{id}/photos', 'Admin\ClinicPhotoController@uploadPhoto');
        $router->post('clinics/{id}/photos-remove', 'Admin\ClinicPhotoController@remove');
        $router->get('clinics/{id}/doctors', 'Admin\ClinicController@doctors');
        $router->post('clinics/{id}/doctors', 'Admin\ClinicController@updateDoctors');
        $router->post('clinics/{id}/doctor-remove', 'Admin\ClinicController@removeDoctor');
        $router->get('clients', 'Admin\ClientController@index');
        $router->get('clients/{id}', 'Admin\ClientController@show');
        $router->post('clients/{id}', 'Admin\ClientController@update');
        $router->post('clients/{id}/remove', 'Admin\ClientController@remove');
        $router->get('doctors', 'Admin\DoctorController@index');
        $router->post('doctors/{id}/remove', 'Admin\DoctorController@remove');
        $router->get('translators', 'Admin\TranslatorController@index');
        $router->get('translators/{id}', 'Admin\TranslatorController@show');
        $router->post('translators', 'Admin\TranslatorController@create');
        $router->get('translator-languages', 'Admin\TranslatorController@languages');
        $router->post('translators/{id}/remove', 'Admin\TranslatorController@remove');
        $router->get('messages', 'Admin\MessageController@index');
        $router->post('messages', 'Admin\MessageController@save');
        $router->post('messages-delete-all', 'Admin\MessageController@deleteAll');
        $router->post('messages-deletes', 'Admin\MessageController@deletes');
        $router->post('messages/{id}/delete', 'Admin\MessageController@delete');
        $router->get('payments', 'Admin\PaymentController@index');
        $router->get('payments/{id}', 'Admin\PaymentController@show');
        $router->post('payments', 'Admin\PaymentController@store');
        $router->post('payments/{id}/remove-item', 'Admin\PaymentController@removeItem');
        $router->get('statements', 'Admin\StatementController@index');
        $router->get('statements/{id}', 'Admin\StatementController@show');
        $router->post('statements', 'Admin\StatementController@store');
        $router->post('statements/{id}/remove-item', 'Admin\StatementController@removeItem');
        $router->get('reviews', 'Admin\ReviewController@index');
        $router->get('reviews/{id}', 'Admin\ReviewController@show');
        $router->post('reviews/{id}/approve', 'Admin\ReviewController@approve');
        $router->post('reviews/{id}/decline', 'Admin\ReviewController@decline');
        $router->get('news', 'Admin\NewsController@index');
        $router->post('news', 'Admin\NewsController@store');
        $router->get('news/{id}', 'Admin\NewsController@show');
        $router->post('news/{id}/delete', 'Admin\NewsController@delete');
        $router->get('news-categories', 'Admin\NewsController@categories');
        $router->post('news-categories', 'Admin\NewsController@storeCategory');
        $router->get('subscribers', 'SubscriberController@index');

        $router->post('create-clinic', 'Admin\AdminController@createClinic');
        $router->post('create-doctor', 'Clinic\ClinicController@createDoctor');
        $router->post('list-clinic', 'Admin\AdminController@getListClinic');
        $router->post('list-doctor', 'Admin\AdminController@getListDoctor');
        $router->post('list-client', 'Admin\AdminController@getListClient');
        $router->post('delete-clinic', 'Admin\AdminController@deleteClinic');
        $router->post('delete-doctor', 'Admin\AdminController@deleteDoctor');
        $router->get('appointments', 'Admin\AdminController@getAppointments');
        $router->post('logout', 'Admin\AdminController@logout');
        $router->post('create-news', 'Admin\AdminController@createNews');
        $router->post('create-faq', 'Admin\AdminController@createFAQ');
        $router->get('appointments', 'Admin\AppointmentController@index');
        $router->get('appointments-cr', 'Admin\AppointmentCancellationController@index');
        $router->get('appointments-cr/{id}', 'Admin\AppointmentCancellationController@show');
        $router->post('appointments-cr/{id}', 'Admin\AppointmentCancellationController@store');
        $router->post('appointments-cr/{id}/refund', 'Admin\AppointmentCancellationController@storeRefund');
        $router->post('appointment/notify-all', 'Admin\AppointmentController@notifyAll');
        $router->get('appointments/{id}', 'Admin\AppointmentController@show');
        $router->post('appointments/{id}/notify', 'Admin\AppointmentController@notify');
        $router->post('appointments/{id}/upload-document', 'Admin\AppointmentController@uploadDocument');
        $router->post('appointments/{id}/note', 'Admin\AppointmentController@updateNote');
        $router->post('appointments/{id}/note_admin', 'Admin\AppointmentController@updateNoteAdmin');
        $router->post('appointments/{id}/interpreter', 'Admin\AppointmentController@updateInterpreter');
        $router->post('appointments/{id}/status', 'Admin\AppointmentController@updateStatus');
        $router->post('appointment-documents/{id}/remove', 'Admin\AppointmentDocumentController@remove');
        $router->get('appointment-totals', 'Admin\AppointmentController@totals');
        $router->get('dashboard/totals', 'Admin\DashboardController@totals');
        $router->get('feedbacks', 'Admin\FeedbackController@index');
    });
});
$router->group(['middleware' => ['auth', 'jwt.auth', 'is_clinic']], function () use ($router) {
    $router->group(['prefix' => 'clinic'], function () use ($router) {
        $router->post('create-doctor', 'Clinic\ClinicController@createDoctor');
        $router->get('appointments', 'Clinic\AppointmentController@index');
        $router->get('appointment-totals', 'Clinic\AppointmentController@totals');
        $router->get('appointments/{id}', 'Clinic\AppointmentController@show');
        $router->post('appointments/{id}/status', 'Clinic\AppointmentController@updateStatus');
        $router->post('appointments/{id}/reschedule', 'Clinic\AppointmentController@reschedule');

        $router->get('statements', 'Clinic\StatementController@index');
        $router->get('statements/{id}', 'Clinic\StatementController@show');
        $router->get('reviews', 'Clinic\ReviewController@index');
        $router->get('reviews/{id}', 'Clinic\ReviewController@show');
        $router->get('profile', 'Clinic\ProfileController@show');
        $router->post('profile', 'Clinic\ProfileController@update');
        $router->post('profile-languages', 'Clinic\ProfileController@updateLanguage');
        $router->post('profile-languages/{id}/remove', 'Clinic\ProfileController@removeLanguage');
        $router->get('profile-doctors', 'Clinic\ProfileController@doctors');
        $router->post('profile-doctors', 'Clinic\ProfileController@updateDoctors');
        $router->post('profile-doctors/{id}/remove', 'Clinic\ProfileController@removeDoctor');
        $router->get('profile-services', 'Clinic\ProfileController@services');
        $router->post('profile-services', 'Clinic\ProfileController@updateServices');
        $router->get('profile-availables', 'Clinic\ClinicAvailableController@show');
        $router->post('profile-availables', 'Clinic\ClinicAvailableController@update');
        $router->post('profile-availables/remove', 'Clinic\ClinicAvailableController@remove');
        $router->get('profile-photos', 'Clinic\ClinicPhotoController@show');
        $router->post('profile-photos', 'Clinic\ClinicPhotoController@uploadPhoto');
        $router->post('profile-photos/remove', 'Clinic\ClinicPhotoController@remove');
        $router->get('dashboard/totals', 'Clinic\DashboardController@totals');
        $router->get('messages', 'Clinic\MessageController@index');
        $router->post('messages-read', 'Clinic\MessageController@markAsRead');
        $router->post('messages-unread', 'Clinic\MessageController@markAsUnread');
    });
});
$router->group(['middleware' => ['auth', 'jwt.auth', 'is_client']], function () use ($router) {
    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->post('change-pass', 'UserController@changePass');
        $router->post('edit-profile', 'UserController@editProfile');
        $router->post('create-review', 'ReviewController@createReview');
        $router->post('appointment/create', 'AppointmentController@createAppointment');
        $router->get('setting-localization', 'SettingController@getLocalization');
        $router->post('setting-localization', 'SettingController@postLocalization');
        $router->get('appointments', 'AppointmentController@index');
        $router->get('appointments/{id}', 'AppointmentController@show');
        $router->post('appointments/{id}/status', 'AppointmentController@updateStatus');
        $router->post('appointments/{id}/cancel', 'AppointmentController@cancellationRequest');
        $router->post('appointments/{id}/check_cancel', 'AppointmentController@checkCancelable');
        $router->get('payments', 'PaymentController@index');
        $router->get('payments/{id}', 'PaymentController@show');
        $router->get('payments/{id}/items', 'PaymentController@getItems');
        $router->get('reviews', 'ReviewController@index');
        $router->get('reviews/{id}', 'ReviewController@show');
        $router->post('reviews/{id}', 'ReviewController@createReview');
        $router->get('top-clinics', 'UserController@topClinicReviews');
        $router->get('my-favourites', 'UserController@clientClinicFavouries');
        $router->get('messages', 'MessageController@index');
        $router->post('messages/reads', 'MessageController@markReads');
        $router->post('messages/unreads', 'MessageController@markUnreads');
        $router->post('messages/deletes', 'MessageController@markUnrea ds');
    });
    $router->post('list-doctor', 'Admin\AdminController@getListDoctor');
});

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
