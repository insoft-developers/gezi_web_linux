@php

/*
|--------------------------------------------------------------------------
| VIEW / ACTIVE MENU
|--------------------------------------------------------------------------
|
| Mengambil segment pertama dari URL.
|
| Contoh:
| /tryout
| => tryout
|
| /subject
| => subject
|
| /tryout_session
| => tryout_session
|
*/

$view = request()->segment(1);


/*
|--------------------------------------------------------------------------
| HELPER MENU
|--------------------------------------------------------------------------
|
| parentMenu() :
| Untuk menentukan parent menu terbuka atau tidak.
|
| childMenu() :
| Untuk menentukan submenu aktif atau tidak.
|
*/

$parentMenu = function ($menus) use ($view) {
return in_array($view, $menus) ? 'active menu-open' : '';
};

$childMenu = function ($menus) use ($view) {
return in_array($view, $menus) ? 'active' : '';
};


/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

$home = $parentMenu([
'icon',
'slider',
'information',
'promo',
'news',
'ref',
]);


/*
|--------------------------------------------------------------------------
| ABSENSI
|--------------------------------------------------------------------------
*/

$absensiMenu = $parentMenu([
'jadwal',
'absensi',
]);


/*
|--------------------------------------------------------------------------
| BIMBINGAN BELAJAR
|--------------------------------------------------------------------------
*/

$bimbingan = $parentMenu([
'tingkat',
'kelas',
'mapel',
'kategori',
'bimbingan',
'materi',
]);


/*
|--------------------------------------------------------------------------
| QUIZ / TRYOUT
|--------------------------------------------------------------------------
*/

$tryout = $parentMenu([
'tryout',
'subject',
'tryout_session',
'exam',
'detail',
'laporan-tryout',
]);


/*
|--------------------------------------------------------------------------
| TANYA SOAL
|--------------------------------------------------------------------------
*/

$tanya = $parentMenu([
'question',
'lapor',
]);


/*
|--------------------------------------------------------------------------
| KOMPETENSI DASAR
|--------------------------------------------------------------------------
*/

$quiz = $parentMenu([
'quiz',
'quizheader',
'exquiz',
]);


/*
|--------------------------------------------------------------------------
| BANK SOAL
|--------------------------------------------------------------------------
*/

$banksoal = $parentMenu([
'banksoal',
'banksession',
'banksoal-exam',
'banksoal-session',
'detail-bank-soal',
]);


/*
|--------------------------------------------------------------------------
| PENGUMUMAN
|--------------------------------------------------------------------------
*/

$pengumuman = $parentMenu([
'pengumuman',
]);


/*
|--------------------------------------------------------------------------
| SISWA MANAGEMENT
|--------------------------------------------------------------------------
*/

$siswa = $parentMenu([
'school',
'siswa',
]);


/*
|--------------------------------------------------------------------------
| ADMIN MANAGEMENT
|--------------------------------------------------------------------------
*/

$admin = $parentMenu([
'admin',
]);


/*
|--------------------------------------------------------------------------
| SETTINGS
|--------------------------------------------------------------------------
*/

$setting = $parentMenu([
'setting',
'location',
'dashboard_menu_setting',
]);


/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

$dashboard = $childMenu([
'',
'dashboard',
]);


/*
|--------------------------------------------------------------------------
| SUBMENU HOME
|--------------------------------------------------------------------------
*/

$icon = $childMenu(['icon']);
$slider = $childMenu(['slider']);
$info = $childMenu(['information']);
$promo = $childMenu(['promo']);
$news = $childMenu(['news']);
$ref = $childMenu(['ref']);


/*
|--------------------------------------------------------------------------
| SUBMENU ABSENSI
|--------------------------------------------------------------------------
*/

$jadwal = $childMenu(['jadwal']);
$absensi = $childMenu(['absensi']);


/*
|--------------------------------------------------------------------------
| SUBMENU BIMBINGAN
|--------------------------------------------------------------------------
*/

$tingkat = $childMenu(['tingkat']);
$kelas = $childMenu(['kelas']);
$mapel = $childMenu(['mapel']);
$kategori = $childMenu(['kategori']);
$video = $childMenu(['bimbingan']);
$materi = $childMenu(['materi']);


/*
|--------------------------------------------------------------------------
| SUBMENU TRYOUT / QUIZ
|--------------------------------------------------------------------------
*/

$subject = $childMenu(['subject']);
$try = $childMenu(['tryout']);
$tryout_session = $childMenu(['tryout_session']);
$tryout_laporan = $childMenu(['laporan-tryout']);


/*
|--------------------------------------------------------------------------
| SUBMENU TANYA SOAL
|--------------------------------------------------------------------------
*/

$pertanyaan = $childMenu(['question']);
$lapor = $childMenu(['lapor']);


/*
|--------------------------------------------------------------------------
| SUBMENU KOMPETENSI DASAR
|--------------------------------------------------------------------------
*/

$kuis = $childMenu([
'quiz',
'quizheader',
]);

$kuis_session = $childMenu([
'exquiz',
]);


/*
|--------------------------------------------------------------------------
| SUBMENU BANK SOAL
|--------------------------------------------------------------------------
*/

$bank = $childMenu([
'banksoal',
'detail-bank-soal',
]);

$banksoal_session = $childMenu([
'banksession',
'banksoal-exam',
'banksoal-session',
]);


/*
|--------------------------------------------------------------------------
| SUBMENU PENGUMUMAN
|--------------------------------------------------------------------------
*/

$pengumum = $childMenu([
'pengumuman',
]);


/*
|--------------------------------------------------------------------------
| SUBMENU SISWA
|--------------------------------------------------------------------------
*/

$school = $childMenu([
'school',
]);

$murid = $childMenu([
'siswa',
]);


/*
|--------------------------------------------------------------------------
| SUBMENU ADMIN
|--------------------------------------------------------------------------
*/

$adm = $childMenu([
'admin',
]);


/*
|--------------------------------------------------------------------------
| SUBMENU SETTINGS
|--------------------------------------------------------------------------
*/

$sett = $childMenu([
'setting',
]);

$location = $childMenu([
'location',
]);

$dms = $childMenu([
'dashboard_menu_setting',
]);

@endphp


<!--
|--------------------------------------------------------------------------
| SIDEBAR MENU
|--------------------------------------------------------------------------
-->

<ul class="sidebar-menu" data-widget="tree">

    <li class="header">
        MAIN NAVIGATION
    </li>


    <!-- ========================================================= -->
    <!-- DASHBOARD -->
    <!-- ========================================================= -->

    <li class="{{ $dashboard }}">

        <a href="{{ route('default') }}">

            <i class="fa fa-dashboard"></i>

            <span>Dashboard</span>

            <span class="pull-right-container">

                <small class="label pull-right bg-green">
                    genzi
                </small>

            </span>

        </a>

    </li>


    <!-- ========================================================= -->
    <!-- HOME MAINTENANCE -->
    <!-- ========================================================= -->

    <li class="treeview {{ $home }}">

        <a href="#">

            <i class="fa fa-home"></i>

            <span>Home Maintenance</span>

            <span class="pull-right-container">

                <i class="fa fa-angle-left pull-right"></i>

            </span>

        </a>


        <ul class="treeview-menu">

            <li class="{{ $icon }}">

                <a href="{{ url('icon') }}">

                    <i class="fa fa-circle-o"></i>

                    Main Icon

                </a>

            </li>


            <li class="{{ $slider }}">

                <a href="{{ url('slider') }}">

                    <i class="fa fa-circle-o"></i>

                    Main Slider

                </a>

            </li>


            <li class="{{ $info }}">

                <a href="{{ url('information') }}">

                    <i class="fa fa-circle-o"></i>

                    Information

                </a>

            </li>


            <li class="{{ $promo }}">

                <a href="{{ url('promo') }}">

                    <i class="fa fa-circle-o"></i>

                    Promo

                </a>

            </li>


            <li class="{{ $news }}">

                <a href="{{ url('news') }}">

                    <i class="fa fa-circle-o"></i>

                    News

                </a>

            </li>


            <li class="{{ $ref }}">

                <a href="{{ url('ref') }}">

                    <i class="fa fa-circle-o"></i>

                    Reference

                </a>

            </li>

        </ul>

    </li>


    <!-- ========================================================= -->
    <!-- ABSENSI -->
    <!-- ========================================================= -->

    <li class="treeview {{ $absensiMenu }}">

        <a href="#">

            <i class="fa fa-qrcode"></i>

            <span>Absensi</span>

            <span class="pull-right-container">

                <i class="fa fa-angle-left pull-right"></i>

            </span>

        </a>


        <ul class="treeview-menu">

            <li class="{{ $jadwal }}">

                <a href="{{ url('jadwal') }}">

                    <i class="fa fa-circle-o"></i>

                    Jadwal Absen

                </a>

            </li>


            <li class="{{ $absensi }}">

                <a href="{{ url('absensi') }}">

                    <i class="fa fa-circle-o"></i>

                    Absensi List

                </a>

            </li>

        </ul>

    </li>


    <!-- ========================================================= -->
    <!-- BIMBINGAN BELAJAR -->
    <!-- ========================================================= -->

    <li class="treeview {{ $bimbingan }}">

        <a href="#">

            <i class="fa fa-building"></i>

            <span>Bimbingan Belajar</span>

            <span class="pull-right-container">

                <i class="fa fa-angle-left pull-right"></i>

            </span>

        </a>


        <ul class="treeview-menu">

            <li class="{{ $tingkat }}">

                <a href="{{ url('tingkat') }}">

                    <i class="fa fa-circle-o"></i>

                    Tingkat

                </a>

            </li>


            <li class="{{ $kelas }}">

                <a href="{{ url('kelas') }}">

                    <i class="fa fa-circle-o"></i>

                    Kelas

                </a>

            </li>


            <li class="{{ $mapel }}">

                <a href="{{ url('mapel') }}">

                    <i class="fa fa-circle-o"></i>

                    Mapel

                </a>

            </li>


            <li class="{{ $kategori }}">

                <a href="{{ url('kategori') }}">

                    <i class="fa fa-circle-o"></i>

                    Kategori

                </a>

            </li>


            <li class="{{ $video }}">

                <a href="{{ url('bimbingan') }}">

                    <i class="fa fa-circle-o"></i>

                    Video Pembelajaran

                </a>

            </li>


            <li class="{{ $materi }}">

                <a href="{{ url('materi') }}">

                    <i class="fa fa-circle-o"></i>

                    Materi Pembelajaran

                </a>

            </li>

        </ul>

    </li>


    <!-- ========================================================= -->
    <!-- QUIZ -->
    <!-- ========================================================= -->

    <li class="treeview {{ $tryout }}">

        <a href="#">

            <i class="fa fa-graduation-cap"></i>

            <span>Quiz</span>

            <span class="pull-right-container">

                <i class="fa fa-angle-left pull-right"></i>

            </span>

        </a>


        <ul class="treeview-menu">

            <li class="{{ $subject }}">

                <a href="{{ url('subject') }}">

                    <i class="fa fa-circle-o"></i>

                    Subject

                </a>

            </li>


            <li class="{{ $try }}">

                <a href="{{ url('tryout') }}">

                    <i class="fa fa-circle-o"></i>

                    Quiz

                </a>

            </li>


            <li class="{{ $tryout_session }}">

                <a href="{{ url('tryout_session') }}">

                    <i class="fa fa-circle-o"></i>

                    Session

                </a>

            </li>

            @if(false)

            <li class="{{ $tryout_laporan }}">

                <a href="{{ url('tryout_laporan') }}">

                    <i class="fa fa-circle-o"></i>

                    Laporan

                </a>

            </li>

            @endif

        </ul>

    </li>


    <!-- ========================================================= -->
    <!-- TANYA SOAL -->
    <!-- ========================================================= -->

    <li class="treeview {{ $tanya }}">

        <a href="#">

            <i class="fa fa-question-circle"></i>

            <span>Tanya Soal</span>

            <span class="pull-right-container">

                <i class="fa fa-angle-left pull-right"></i>

            </span>

        </a>


        <ul class="treeview-menu">

            <li class="{{ $pertanyaan }}">

                <a href="{{ url('question') }}">

                    <i class="fa fa-circle-o"></i>

                    List Pertanyaan

                </a>

            </li>


            <li class="{{ $lapor }}">

                <a href="{{ url('lapor') }}">

                    <i class="fa fa-circle-o"></i>

                    Laporan Soal

                </a>

            </li>

        </ul>

    </li>


    <!-- ========================================================= -->
    <!-- KOMPETENSI DASAR -->
    <!-- ========================================================= -->

    <li class="treeview {{ $quiz }}">

        <a href="#">

            <i class="fa fa-calculator"></i>

            <span>Kompetensi Dasar</span>

            <span class="pull-right-container">

                <i class="fa fa-angle-left pull-right"></i>

            </span>

        </a>


        <ul class="treeview-menu">

            <li class="{{ $kuis }}">

                <a href="{{ url('quizheader') }}">

                    <i class="fa fa-circle-o"></i>

                    Kompetensi Dasar

                </a>

            </li>


            <li class="{{ $kuis_session }}">

                <a href="{{ url('exquiz') }}">

                    <i class="fa fa-circle-o"></i>

                    Session

                </a>

            </li>

        </ul>

    </li>


    <!-- ========================================================= -->
    <!-- BANK SOAL -->
    <!-- ========================================================= -->

    <li class="treeview {{ $banksoal }}">

        <a href="#">

            <i class="fa fa-bank"></i>

            <span>Bank Soal</span>

            <span class="pull-right-container">

                <i class="fa fa-angle-left pull-right"></i>

            </span>

        </a>


        <ul class="treeview-menu">

            <li class="{{ $bank }}">

                <a href="{{ url('banksoal') }}">

                    <i class="fa fa-circle-o"></i>

                    Bank Soal

                </a>

            </li>


            <li class="{{ $banksoal_session }}">

                <a href="{{ url('banksession') }}">

                    <i class="fa fa-circle-o"></i>

                    Session

                </a>

            </li>

        </ul>

    </li>


    <!-- ========================================================= -->
    <!-- PENGUMUMAN -->
    <!-- ========================================================= -->

    <li class="treeview {{ $pengumuman }}">

        <a href="#">

            <i class="fa fa-bullhorn"></i>

            <span>Pengumuman</span>

            <span class="pull-right-container">

                <i class="fa fa-angle-left pull-right"></i>

            </span>

        </a>


        <ul class="treeview-menu">

            <li class="{{ $pengumum }}">

                <a href="{{ url('pengumuman') }}">

                    <i class="fa fa-circle-o"></i>

                    Buat Pengumuman

                </a>

            </li>

        </ul>

    </li>


    <!-- ========================================================= -->
    <!-- SISWA MANAGEMENT -->
    <!-- ========================================================= -->

    <li class="treeview {{ $siswa }}">

        <a href="#">

            <i class="fa fa-group"></i>

            <span>Siswa Management</span>

            <span class="pull-right-container">

                <i class="fa fa-angle-left pull-right"></i>

            </span>

        </a>


        <ul class="treeview-menu">

            <li class="{{ $school }}">

                <a href="{{ url('school') }}">

                    <i class="fa fa-circle-o"></i>

                    Data Sekolah

                </a>

            </li>


            <li class="{{ $murid }}">

                <a href="{{ url('siswa') }}">

                    <i class="fa fa-circle-o"></i>

                    Data Siswa

                </a>

            </li>

        </ul>

    </li>


    <!-- ========================================================= -->
    <!-- ADMIN MANAGEMENT -->
    <!-- ========================================================= -->

    <li class="treeview {{ $admin }}">

        <a href="#">

            <i class="fa fa-database"></i>

            <span>Admin Management</span>

            <span class="pull-right-container">

                <i class="fa fa-angle-left pull-right"></i>

            </span>

        </a>


        <ul class="treeview-menu">

            <li class="{{ $adm }}">

                <a href="{{ url('admin') }}">

                    <i class="fa fa-circle-o"></i>

                    Data Admin

                </a>

            </li>

        </ul>

    </li>


    <!-- ========================================================= -->
    <!-- SETTINGS -->
    <!-- ========================================================= -->

    <li class="treeview {{ $setting }}">

        <a href="#">

            <i class="fa fa-gear"></i>

            <span>Settings</span>

            <span class="pull-right-container">

                <i class="fa fa-angle-left pull-right"></i>

            </span>

        </a>


        <ul class="treeview-menu">

            <li class="{{ $sett }}">

                <a href="{{ url('setting') }}">

                    <i class="fa fa-circle-o"></i>

                    General Setting

                </a>

            </li>


            <li class="{{ $location }}">

                <a href="{{ url('location') }}">

                    <i class="fa fa-circle-o"></i>

                    Location

                </a>

            </li>


            <li class="{{ $dms }}">

                <a href="{{ url('dashboard_menu_setting') }}">

                    <i class="fa fa-circle-o"></i>

                    Dashboard Menu Setting

                </a>

            </li>

        </ul>

    </li>

</ul>