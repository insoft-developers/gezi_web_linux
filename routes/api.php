<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v3')->group(function () {
    Route::post('tryout_subject', 'TryoutApiV3Controller@subject');
    Route::get('tryout/{id}/{subjectId}', 'TryoutApiV3Controller@tryout');
    Route::post('quiz_answer', 'QuizApiV3Controller@quiz_answer');
    Route::post('bank_soal_answer', 'BanksoalApiV3Controller@bankSoalAnswer');
    Route::post('/absensi/scan', 'AbsensiApiV3Controller@scan');
    Route::post('/take_qrcode', 'AbsensiApiV3Controller@takeQrcode');
    Route::get('/jadwal', 'AbsensiApiV3Controller@jadwal');
    Route::post('/status_absensi', 'AbsensiApiV3Controller@status');
    Route::post('/absensi_history', 'AbsensiApiV3Controller@history');
});

Route::prefix('v2')->group(function () {

    Route::post('login', 'UserController@login');
    Route::post('register', 'UserController@register');
    Route::get('logout/{id}', 'UserController@logout');
    Route::post('get_profil', 'UserController@getProfil');
    Route::post('update_profil', 'UserController@update');
    Route::post('upload_profil_image', 'UserController@upload');
    Route::post('change_password', 'UserController@changePassword');
    Route::post('pilih_kelas', 'UserController@pilihKelas');
    Route::post('pilih_sekolah', 'UserController@pilihSekolah');
    Route::post('pilih_lokasi', 'UserController@pilihLokasi');
    Route::post('register_user', 'UserController@registerUser');
    Route::post('setting_login', 'SettingController@settingLogin');

    Route::get('list_quiz/{id}', 'QuizController@list')->name('list.quiz');
    Route::post('quiz_session', 'QuizController@add_session');
    Route::post('quiz_answer', 'QuizController@quiz_answer');
    Route::post('quiz_hasil', 'QuizController@quiz_hasil');
    Route::get('quiz_detail/{id}', 'QuizController@detail');
    Route::post('quiz_list', 'QuizController@quizList');

    Route::get('main_slider/{id}', 'SliderController@main');
    Route::get('main_icon', 'SliderController@menu');
    Route::get('main_icon/{userid}', 'SliderController@menu2');
    Route::get('information', 'SliderController@information');
    Route::get('promo', 'SliderController@promo');
    Route::get('news', 'SliderController@news');
    Route::get('setting/{idkelas}', 'SettingController@setting');
    Route::post('mapel', 'MapelController@index');
    Route::post('bimbingan', 'MapelController@bimbingan');
    Route::post('category', 'CategoryController@index');

    Route::get('quiz_history/{id}', 'HistoryController@quiz');
    Route::get('tryout_history/{id}', 'HistoryController@tryout');
    Route::get('banksoal_history/{id}', 'HistoryController@banksoal');
    Route::get('lapor_history/{id}', 'HistoryController@lapor');
    Route::get('quiz_winning_list/{userid}', 'HistoryController@QuizWinningList');
    Route::get('bank_winning_list/{userid}', 'HistoryController@BankWinningList');

    Route::get('tryout_winning_list/{userid}', 'HistoryController@TryoutWinningList');
    Route::get('user_history_list/{userid}', 'HistoryController@userHistoryList');

    Route::post('comment', 'MapelController@comment');
    Route::post('add_comment', 'MapelController@addComment');
    Route::post('lihat_bimbingan', 'MapelController@lihatBimbingan');
    Route::post('like_post', 'MapelController@likePost');
    Route::post('materi_list', 'MapelController@materiList');
    Route::get('testing', 'MapelController@testing');
    Route::post('tobk', 'MapelController@tobkList');
    Route::post('tobk_video', 'MapelController@tobkVideoList');
    Route::post('lihat_tobk', 'MapelController@lihatTobk');

    Route::get('tryout/{id}', 'TryoutController@index');


    Route::get('tryout_detail/{id}', 'TryoutController@detail');
    Route::post('tryout_session', 'TryoutController@tryoutSession');
    Route::post('tryout_answer', 'TryoutController@tryoutAnswer');
    Route::post('tryout_hasil', 'TryoutController@tryoutHasil');
    Route::post('tryout_report_add', 'TryoutController@tryoutReportAdd');
    Route::post('tryout_check_answer', 'TryoutController@checkAnswer');
    Route::post('check_tryout', 'TryoutController@checkTryout');
    Route::post('tryout_answer_list', 'TryoutController@tryoutAnswerList');

    Route::post('mapel_list_bank_soal', 'MapelController@mapelListForBankSoal');
    Route::post('bank_soal_list', 'BankSoalController@index');
    Route::post('bank_soal_session', 'BankSoalController@addSession');
    Route::get('bank_soal_detail/{id}', 'BankSoalController@detail');
    Route::post('bank_soal_check_answer', 'BankSoalController@checkAnswer');
    Route::post('bank_soal_answer', 'BankSoalController@bankSoalAnswer');
    Route::post('bank_soal_hasil', 'BankSoalController@bankSoalHasil');
    Route::post('bank_soal_answer_list', 'BankSoalController@bankSoalAnswerList');

    Route::post('upload_question_image', 'QuestionController@upload');
    Route::post('question_list', 'QuestionController@list');
    Route::post('question_answer', 'QuestionController@answer');
    Route::post('question_add', 'QuestionController@add');
    Route::post('question_delete', 'QuestionController@delete');
    Route::post('question_update', 'QuestionController@update');

    Route::post('notif_send', 'NotifController@send');
    Route::post('notif_count', 'NotifController@count');
    Route::post('notif_read', 'NotifController@read');
    Route::post('notif_token', 'NotifController@fcmToken');
    Route::post('notif_chat', 'NotifController@chat');
    Route::post('user_chat', 'NotifController@userChat');
    Route::post('chat_room', 'NotifController@chatRoom');

    Route::post('add_contact', 'ContactController@add');
    Route::post('cek_urutan', 'ContactController@cekUrutan');
    Route::post('check_active_user', 'ContactController@checkActiveUser');

    Route::post('send_email', 'UserController@sendEmail');

    Route::post('ref_list', 'SliderController@refList');
    Route::post('user_detail', 'UserController@userDetail');

    Route::get('dms', 'UserController@dms');
});




Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');
Route::get('logout/{id}', 'UserController@logout');
Route::post('get_profil', 'UserController@getProfil');
Route::post('update_profil', 'UserController@update');
Route::post('upload_profil_image', 'UserController@upload');
Route::post('change_password', 'UserController@changePassword');
Route::post('pilih_kelas', 'UserController@pilihKelas');
Route::post('pilih_sekolah', 'UserController@pilihSekolah');
Route::post('pilih_lokasi', 'UserController@pilihLokasi');
Route::post('register_user', 'UserController@registerUser');
Route::post('setting_login', 'SettingController@settingLogin');

Route::get('list_quiz/{id}', 'QuizController@list')->name('list.quiz');
Route::post('quiz_session', 'QuizController@add_session');
Route::post('quiz_answer', 'QuizController@quiz_answer');
Route::post('quiz_hasil', 'QuizController@quiz_hasil');
Route::get('quiz_detail/{id}', 'QuizController@detail');
Route::post('quiz_list', 'QuizController@quizList');

Route::get('main_slider/{id}', 'SliderController@main');
Route::get('main_icon', 'SliderController@menu');
Route::get('main_icon/{userid}', 'SliderController@menu2');
Route::get('information', 'SliderController@information');
Route::get('promo', 'SliderController@promo');
Route::get('news', 'SliderController@news');
Route::get('setting/{idkelas}', 'SettingController@setting');
Route::post('mapel', 'MapelController@index');
Route::post('bimbingan', 'MapelController@bimbingan');
Route::post('category', 'CategoryController@index');

Route::get('quiz_history/{id}', 'HistoryController@quiz');
Route::get('tryout_history/{id}', 'HistoryController@tryout');
Route::get('banksoal_history/{id}', 'HistoryController@banksoal');
Route::get('lapor_history/{id}', 'HistoryController@lapor');
Route::get('quiz_winning_list/{userid}', 'HistoryController@QuizWinningList');
Route::get('bank_winning_list/{userid}', 'HistoryController@BankWinningList');
Route::get('user_history_list/{userid}', 'HistoryController@userHistoryList');

Route::post('comment', 'MapelController@comment');
Route::post('add_comment', 'MapelController@addComment');
Route::post('lihat_bimbingan', 'MapelController@lihatBimbingan');
Route::post('like_post', 'MapelController@likePost');
Route::post('materi_list', 'MapelController@materiList');
Route::get('testing', 'MapelController@testing');
Route::post('tobk', 'MapelController@tobkList');
Route::post('tobk_video', 'MapelController@tobkVideoList');
Route::post('lihat_tobk', 'MapelController@lihatTobk');

Route::get('tryout/{id}', 'TryoutController@index');
Route::get('tryout_detail/{id}', 'TryoutController@detail');
Route::post('tryout_session', 'TryoutController@tryoutSession');
Route::post('tryout_answer', 'TryoutController@tryoutAnswer');
Route::post('tryout_hasil', 'TryoutController@tryoutHasil');
Route::post('tryout_report_add', 'TryoutController@tryoutReportAdd');
Route::post('tryout_check_answer', 'TryoutController@checkAnswer');
Route::post('check_tryout', 'TryoutController@checkTryout');
Route::post('tryout_answer_list', 'TryoutController@tryoutAnswerList');

Route::post('mapel_list_bank_soal', 'MapelController@mapelListForBankSoal');
Route::post('bank_soal_list', 'BankSoalController@index');
Route::post('bank_soal_session', 'BankSoalController@addSession');
Route::get('bank_soal_detail/{id}', 'BankSoalController@detail');
Route::post('bank_soal_check_answer', 'BankSoalController@checkAnswer');
Route::post('bank_soal_answer', 'BankSoalController@bankSoalAnswer');
Route::post('bank_soal_hasil', 'BankSoalController@bankSoalHasil');
Route::post('bank_soal_answer_list', 'BankSoalController@bankSoalAnswerList');

Route::post('upload_question_image', 'QuestionController@upload');
Route::post('question_list', 'QuestionController@list');
Route::post('question_answer', 'QuestionController@answer');
Route::post('question_add', 'QuestionController@add');
Route::post('question_delete', 'QuestionController@delete');
Route::post('question_update', 'QuestionController@update');

Route::post('notif_send', 'NotifController@send');
Route::post('notif_count', 'NotifController@count');
Route::post('notif_read', 'NotifController@read');
Route::post('notif_token', 'NotifController@fcmToken');
Route::post('notif_chat', 'NotifController@chat');
Route::post('user_chat', 'NotifController@userChat');
Route::post('chat_room', 'NotifController@chatRoom');

Route::post('add_contact', 'ContactController@add');
Route::post('cek_urutan', 'ContactController@cekUrutan');
Route::post('check_active_user', 'ContactController@checkActiveUser');

Route::post('send_email', 'UserController@sendEmail');

Route::post('ref_list', 'SliderController@refList');

// ====================== new api v4 ========================================

Route::prefix('v4')->group(function () {

    Route::post('login', 'UserController@login');
    Route::post('register_user', 'UserController@registerUser');
    Route::post('send_email', 'UserController@sendEmail');
    Route::post('pilih_kelas', 'UserController@pilihKelas');
    Route::post('pilih_sekolah', 'UserController@pilihSekolah');
    Route::post('pilih_lokasi', 'UserController@pilihLokasi');
    Route::post('upload_profil_image', 'UserController@upload');

    Route::middleware('auth:api')->group(function () {
        Route::post('tryout_subject', 'TryoutApiV3Controller@subject');
        Route::get('tryout/{id}/{subjectId}', 'TryoutApiV3Controller@tryout');
        Route::post('quiz_answer', 'QuizApiV3Controller@quiz_answer');
        Route::post('bank_soal_answer', 'BanksoalApiV3Controller@bankSoalAnswer');
        Route::post('/absensi/scan', 'AbsensiApiV3Controller@scan');
        Route::post('/take_qrcode', 'AbsensiApiV3Controller@takeQrcode');
        Route::get('/jadwal', 'AbsensiApiV3Controller@jadwal');
        Route::post('/status_absensi', 'AbsensiApiV3Controller@status');
        Route::post('/absensi_history', 'AbsensiApiV3Controller@history');


        Route::get('logout/{id}', 'UserController@logout');
        Route::post('get_profil', 'UserController@getProfil');
        Route::post('update_profil', 'UserController@update');
        
        Route::post('change_password', 'UserController@changePassword');


        Route::post('setting_login', 'SettingController@settingLogin');

        Route::get('list_quiz/{id}', 'QuizController@list')->name('list.quiz');
        Route::post('quiz_session', 'QuizController@add_session');
        Route::post('quiz_hasil', 'QuizController@quiz_hasil');
        Route::get('quiz_detail/{id}', 'QuizController@detail');
        Route::post('quiz_list', 'QuizController@quizList');

        Route::get('main_slider/{id}', 'SliderController@main');
        Route::get('main_icon', 'SliderController@menu');
        Route::get('main_icon/{userid}', 'SliderController@menu2');
        Route::get('information', 'SliderController@information');
        Route::get('promo', 'SliderController@promo');
        Route::get('news', 'SliderController@news');
        Route::get('setting/{idkelas}', 'SettingController@setting');
        Route::post('mapel', 'MapelController@index');
        Route::post('bimbingan', 'MapelController@bimbingan');
        Route::post('category', 'CategoryController@index');

        Route::get('quiz_history/{id}', 'HistoryController@quiz');
        Route::get('tryout_history/{id}', 'HistoryController@tryout');
        Route::get('banksoal_history/{id}', 'HistoryController@banksoal');
        Route::get('lapor_history/{id}', 'HistoryController@lapor');
        Route::get('quiz_winning_list/{userid}', 'HistoryController@QuizWinningList');
        Route::get('bank_winning_list/{userid}', 'HistoryController@BankWinningList');
        Route::get('tryout_winning_list/{userid}', 'HistoryController@TryoutWinningList');
        Route::get('user_history_list/{userid}', 'HistoryController@userHistoryList');

        Route::post('comment', 'MapelController@comment');
        Route::post('add_comment', 'MapelController@addComment');
        Route::post('lihat_bimbingan', 'MapelController@lihatBimbingan');
        Route::post('like_post', 'MapelController@likePost');
        Route::post('materi_list', 'MapelController@materiList');
        Route::get('testing', 'MapelController@testing');
        Route::post('tobk', 'MapelController@tobkList');
        Route::post('tobk_video', 'MapelController@tobkVideoList');
        Route::post('lihat_tobk', 'MapelController@lihatTobk');

        Route::get('tryout_detail/{id}', 'TryoutController@detail');
        Route::post('tryout_session', 'TryoutController@tryoutSession');
        Route::post('tryout_answer', 'TryoutController@tryoutAnswer');
        Route::post('tryout_hasil', 'TryoutController@tryoutHasil');
        Route::post('tryout_report_add', 'TryoutController@tryoutReportAdd');
        Route::post('tryout_check_answer', 'TryoutController@checkAnswer');
        Route::post('check_tryout', 'TryoutController@checkTryout');
        Route::post('tryout_answer_list', 'TryoutController@tryoutAnswerList');

        Route::post('mapel_list_bank_soal', 'MapelController@mapelListForBankSoal');
        Route::post('bank_soal_list', 'BankSoalController@index');
        Route::post('bank_soal_session', 'BankSoalController@addSession');
        Route::get('bank_soal_detail/{id}', 'BankSoalController@detail');
        Route::post('bank_soal_check_answer', 'BankSoalController@checkAnswer');
        Route::post('bank_soal_hasil', 'BankSoalController@bankSoalHasil');
        Route::post('bank_soal_answer_list', 'BankSoalController@bankSoalAnswerList');

        Route::post('upload_question_image', 'QuestionController@upload');
        Route::post('question_list', 'QuestionController@list');
        Route::post('question_answer', 'QuestionController@answer');
        Route::post('question_add', 'QuestionController@add');
        Route::post('question_delete', 'QuestionController@delete');
        Route::post('question_update', 'QuestionController@update');

        Route::post('notif_send', 'NotifController@send');
        Route::post('notif_count', 'NotifController@count');
        Route::post('notif_read', 'NotifController@read');
        Route::post('notif_token', 'NotifController@fcmToken');
        Route::post('notif_chat', 'NotifController@chat');
        Route::post('user_chat', 'NotifController@userChat');
        Route::post('chat_room', 'NotifController@chatRoom');

        Route::post('add_contact', 'ContactController@add');
        Route::post('cek_urutan', 'ContactController@cekUrutan');
        Route::post('check_active_user', 'ContactController@checkActiveUser');
        Route::post('ref_list', 'SliderController@refList');
        Route::post('user_detail', 'UserController@userDetail');
        Route::get('dms', 'UserController@dms');
    });
});
