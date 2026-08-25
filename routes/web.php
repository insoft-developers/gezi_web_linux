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

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('default');
Route::resource('/location', 'LocationController');
Route::get('/location_table', 'LocationController@locationTable')->name('location.table');
Route::resource('/tingkat', 'TingkatController');
Route::get('/tingkat_table', 'TingkatController@tingkatTable')->name('tingkat.table');
Route::get('slider_table', 'WebSliderController@sliderTable')->name('sliderTable');
Route::resource('slider', 'WebSliderController');
Route::resource('information', 'WebInformationController');
Route::get('information_table', 'WebInformationController@informationTable')->name('informationTable');
Route::resource('promo', 'WebPromoController');
Route::get('promo_table', 'WebPromoController@promoTable')->name('promoTable');
Route::resource('news', 'WebNewsController');
Route::get('news_table', 'WebNewsController@newsTable')->name('newsTable');
Route::resource('kelas', 'WebKelasController');
Route::get('kelas_table', 'WebKelasController@kelasTable')->name('kelasTable');
Route::resource('kategori', 'WebKategoriController');
Route::get('kategori_table', 'WebKategoriController@kategoriTable')->name('kategoriTable');
Route::get('get_kelas_by_mapel/{id}', 'WebKategoriController@getKelasByMapel');
Route::get('kategori_kelas/{id}', 'WebKategoriController@kategoriKelas');

Route::resource('mapel', 'WebMapelController');
Route::get('mapel_table', 'WebMapelController@mapelTable')->name('mapelTable');

Route::resource('subject', 'SubjectController');
Route::get('subject_table', 'SubjectController@table')->name('subject.table');
Route::get('generate_urutan_subject', 'SubjectController@generateUrutan')->name('generate.urutan');

Route::resource('bimbingan', 'WebBimbinganController');
Route::get('bimbingan_table', 'WebBimbinganController@bimbinganTable')->name('bimbinganTable');
Route::post('set_kategori_bimbingan', 'WebBimbinganController@setKategori');
Route::get('category_bimbel/{id}', 'WebBimbinganController@categoryBimbel');
Route::get('kelas_select_bimbingan/{id}', 'WebBimbinganController@kelasSelectBimbingan');


Route::resource('tryout', 'WebTryoutController');
Route::get('tryout_table', 'WebTryoutController@tryoutTable')->name('tryoutTable');
Route::get('tryout_detail/{id}', 'WebTryoutController@tryoutDetail');
Route::get('detail_table/{id}', 'WebTryoutController@detailTable')->name('detailTable');
Route::post('detail_add', 'WebTryoutController@detailAdd');
Route::get('detail_edit/{id}', 'WebTryoutController@detailEdit');
Route::patch('detail_update/{id}', 'WebTryoutController@detailUpdate');
Route::post('delete_image', 'WebTryoutController@deleteImage');
Route::post('detail_delete', 'WebTryoutController@deleteDetail');


Route::resource('materi', 'WebMateriController');
Route::get('materi_table', 'WebMateriController@materiTable')->name('materiTable');
Route::get('kelas_materi_select/{id}', 'WebMateriController@kelasMateriSelect');
Route::get('tryout_session', 'WebTryoutSessionController@index');
Route::get('session_table', 'WebTryoutSessionController@sessionTable')->name('sessionTable');
Route::get('session_detail/{id}', 'WebTryoutSessionController@sessionDetail');
Route::get('exam_table/{id}', 'WebTryoutSessionController@examTable')->name('examTable');
Route::post('reset_tryout', 'WebTryoutSessionController@resetTryout');

Route::get('detail_exam/{id}', 'WebTryoutSessionController@detailExam');
Route::get('get_jenis_copy/{jenis}', 'WebTryoutController@getJenisCopy');
Route::post('copy_tryout', 'WebTryoutController@copyTryout');
Route::post('detail_delete_all', 'WebTryoutController@detailDeleteAll');
Route::get('tryout_laporan', 'WebTryoutController@laporan');
Route::get('export', 'WebTryoutController@export');
Route::post('display_tryout_report', 'WebTryoutController@displayReport');

Route::resource('siswa', 'WebSiswaController');
Route::get('siswa_table', 'WebSiswaController@siswaTable')->name('siswaTable');

Route::get('siswa_export','WebSiswaController@export')->name('siswa.export');


Route::resource('admin', 'WebAdminController');
Route::get('admin_table', 'WebAdminController@adminTable')->name('adminTable');
Route::get('login', 'WebLoginController@index')->name('login');
Route::post('login_proses', 'WebLoginController@proses')->name('proses');
Route::get('contact_list/{id}', 'WebSiswaController@contactList');
Route::get('contact_table/{id}', 'WebSiswaController@contactTable')->name('contactTable');
Route::get('logout_data_user/{id}', 'WebSiswaController@logoutUser');
Route::post('siswa-activate', 'WebSiswaController@siswaActivate')->name('siswa.activate');
Route::post('siswa-deactivate', 'WebSiswaController@siswaDeactivate')->name('siswa.deactivate');

Route::resource('quiz', 'WebQuizController')->except(['index']);
Route::get('quizes/{id}', 'WebQuizController@index');
Route::get('quiz_table/{id}', 'WebQuizController@quizTable')->name('quizTable');
Route::post('generate_nomor_kuis', 'WebQuizController@generateNomor');
Route::post('delete_quiz_image', 'WebQuizController@deleteImage');

Route::resource('quizheader', 'QuizHeaderController');
Route::get('quizheader_table', 'QuizHeaderController@quizHeaderTable')->name('quizHeaderTable');
Route::post('copy_quiz', 'QuizHeaderController@copyQuiz');

Route::resource('exquiz', 'ExquizController');
Route::get('exquizTable', 'ExquizController@exquizTable')->name('exquizTable');
Route::get('sess_quiz/{id}', 'ExquizController@sess_quiz');
Route::get('sess_quizes/{id}/{awal}/{akhir}', 'ExquizController@sess_quizes');
Route::get('sessquizTable/{id}/{awal}/{akhir}/{offset}/{limit}', 'ExquizController@sessquizTable');
Route::post('quiz_result', 'ExquizController@quiz_result');
Route::post('quiz_session_delete', 'ExquizController@deleteSession');

Route::resource('banksoal', 'WebBankSoalController');
Route::get('banksoal_table', 'WebBankSoalController@bankSoalTable')->name('bankSoalTable');
Route::get('kelas_by_bank_soal/{id}', 'WebBankSoalController@kelasBankSoal');
Route::get('bank_soal_detail/{id}', 'WebBankSoalController@bankSoalDetail');
Route::get('bank_soal_detail_table/{id}', 'WebBankSoalController@bankSoalDetailTable')->name('bankSoalDetailTable');
Route::post('generate_nomor_bank_soal', 'WebBankSoalController@generateNomor');
Route::post('banksoal_detail_add', 'WebBankSoalController@detailAdd');
Route::post('delete_banksoal_image', 'WebBankSoalController@deleteImage');
Route::get('banksoal_detail_edit/{id}', 'WebBankSoalController@detailEdit');
Route::patch('banksoal_detail_update/{id}', 'WebBankSoalController@detailUpdate');
Route::post('banksoal_detail_delete', 'WebBankSoalController@deleteDetail');
Route::get('banksession', 'WebBankSessionController@index');
Route::post('copy_banksoal', 'WebBankSoalController@copyBankSoal');
Route::post('detailbanksoal_delete_all', 'WebBankSoalController@deleteAll');
Route::get('/banksoal_get_kategori_by_kelas/{id}', 'WebBankSoalController@getKategori');

Route::get('banksoal_session_table', 'WebBankSessionController@bankSoalSessionTable')->name('bankSoalSessionTable');
Route::get('list_ikut_banksoal/{id}', 'WebBankSessionController@ikutBankSoal');
Route::get('bank_soal_exam_table/{id}', 'WebBankSessionController@bankSoalExamTable')->name('bankSoalExamTable');
Route::get('banksoal_detail_exam/{id}', 'WebBankSessionController@detailExam');

Route::resource('question', 'WebQuestionController');
Route::get('question_table', 'WebQuestionController@questionTable')->name('questionTable');
Route::get('edit_status_question/{id}', 'WebQuestionController@editStatusQuestion');
Route::patch('update_question_status/{id}', 'WebQuestionController@updateQuestionStatus');
Route::get('answer_question/{id}', 'WebQuestionController@answerQuestion');
Route::get('question_answer_table/{id}', 'WebQuestionController@questionAnswerTable')->name('questionAnswerTable');
Route::post('jawaban_add', 'WebQuestionController@jawabanAdd');
Route::patch('jawaban_update/{id}', 'WebQuestionController@jawabanUpdate');
Route::get('jawaban_edit/{id}', 'WebQuestionController@jawabanEdit');
Route::delete('jawaban_delete/{id}', 'WebQuestionController@jawabanDelete');
Route::post('delete_answer_image', 'WebQuestionController@deleteImage' );

Route::get('lapor', 'LaporController@index');
Route::get('lapor_table', 'LaporController@laporTable')->name('laporTable');
Route::post('lapor_finish', 'LaporController@laporFinish');
Route::post('lapor_outstanding', 'LaporController@laporOutstanding');

Route::resource('icon', 'IconController');
Route::get('icon_table', 'IconController@iconTable')->name('iconTable');

Route::post('simpan_item', 'IconController@simpanItem')->name('simpan.item');
Route::delete('delete_items/{id}', 'IconController@deleteItem');


Route::get('logout', 'WebLoginController@logout');

Route::resource('pengumuman', 'WebNotifController');
Route::get('notif_table', 'WebNotifController@notifTable')->name('notifTable');

Route::get('setting', 'SettingController@index');
Route::get('setting_active/{id}', 'SettingController@active');
Route::get('setting_inactive/{id}', 'SettingController@inactive');
Route::resource('dashboard_menu_setting', 'DashboardMenuSettingController');
Route::get('dashboard_menu_setting_table', 'DashboardMenuSettingController@table')->name('dashboard.menu.setting.table');

Route::resource('school', 'SchoolController');
Route::get('school_table', 'SchoolController@schoolTable')->name('schoolTable');

Route::get('profile', 'ProfilController@index');
Route::post('profile_update', 'ProfilController@update');

Route::resource('ref', 'RefController');
Route::get('ref_table', 'RefController@refTable')->name('refTable');
Route::post('count_quiz_record', 'ExquizController@countRecord')->name('count.quiz.record');

Route::get('privacy_policy', function(){
   return view('privacy'); 
});

Route::get('reset_password/{id}', 'WebSiswaController@resetPassword');
Route::get('account_deletion', 'WebLoginController@accountDeletion');
Route::post('send_deletion', 'WebLoginController@sendDeletion');
Route::get('/export/users', 'WebSiswaController@exportExcel')->name('export.users');
Route::post('/siswa_session_delete', 'WebSiswaController@siswaSessionDelete');

Route::post('/generate_location_code', 'LocationController@generate');


Route::resource('/jadwal', 'JadwalController');
Route::get('/jadwal_table', 'JadwalController@table')->name('jadwal.table');

Route::resource('/absensi', 'AbsensiController');
Route::get('/absensi_table', 'AbsensiController@table')->name('absensi.table');


