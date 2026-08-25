@php

$dashboard ="";
$home="";
$icon="";
$slider="";
$info="";
$promo="";
$news="";
$ref="";

$bimbingan="";

$tingkat = "";
$kelas="";
$mapel="";
$kategori="";
$video="";
$materi="";

$tryout="";
$try="";
$tryout_session="";
$tryout_laporan="";



$tanya="";
$pertanyaan="";
$lapor="";


$quiz="";
$kuis="";
$kuis_session="";

$banksoal="";
$bank="";
$banksoal_session="";


$pengumuman="";
$pengumum="";

$siswa="";
$school="";
$murid="";


$admin="";
$adm="";

$setting="";
$sett="";
$location="";
$dms = "";
$subject = "";
$jadwal = "";

@endphp

<?php
    if($view == 'dashboard') {
        $dashboard = "active"; 
    }
    
    if($view == 'school') {  
        $siswa = "active";
        $school = "active";
    }
    
    if($view == 'laporan-tryout') {
        $tryout ="active";
        $tryout_laporan = "active";
    }
    
     
    if($view == 'pengumuman') {
        $pengumuman = "active";
        $pengumum = "active";
    }
    
    
    if($view == 'main-menu') {
        $home = "active";
        $icon = "active";
    }
    
    
    if($view == 'lapor') {
        $tanya = "active";
        $lapor = "active";
    }
    
    
    if($view == 'question') {
        $tanya = "active";
        $pertanyaan = "active";
    }
    
    
    if($view == 'banksoal-exam') {
        $banksoal = "active";
        $banksoal_session =  "active";
    }
    
    
    if($view == 'banksoal-session') {
        $banksoal = "active";
        $banksoal_session = "active";
    }
    
    
    if($view == 'detail-bank-soal') {
        $banksoal= "active";
        $bank = "active";
    }
    
    
    if($view == 'banksoal') {
        $banksoal ="active";
        $bank ="active";
    }
    
    
    if($view == 'exquiz') {
        $quiz = "active";
        $kuis_session = "active";
    }
    
    
    if($view == 'quiz-header') {
        $quiz = "active";
        $kuis = "active";
    }
    
    
    if($view == 'quiz') {
        $quiz = "active";
        $kuis = "active";
    }
    
    
    if($view == 'slider') {
        $home = "active";
        $slider = "active";
    }
    
    
    if($view == 'admin') {
        $admin = "active";
        $adm= "active";
    }
    
     
    if($view == 'information') {
        $home = "active";
        $info = "active";
    }
    
    
    if($view == 'promo') {
        $home = "active";
        $promo = "active";
    }
    
    
    if($view == 'news') {
        $home = "active";
        $news = "active";
    }
    
    if($view == 'ref') {
        $home = "active";
        $ref = "active";
    }
    
    if($view == 'tingkat') {
        $bimbingan = "active";
        $tingkat = "active";
    }
    
    
    if($view == 'kelas') {
        $bimbingan = "active";
        $kelas = "active";
    }
    
    
    if($view == 'mapel') {
        $bimbingan = "active";
        $mapel = "active";
    }
    
    
    if($view == 'kategori') {
        $bimbingan = "active";
        $kategori = "active";
    }
    
    
    if($view == 'siswa') {
        $siswa = "active";
        $murid = "active";
    }
    
    
    if($view == 'bimbingan') {
        $bimbingan = "active";
        $video = "active";
    }
    
    
    if($view == 'tryout') {
        $tryout = "active";
        $try = "active";
       
    }
    
    if($view == 'subject') {
        $tryout = "active";
        $subject = "active";
       
    }
    
    
    if($view == 'detail') {
        $tryout = "active";
        $try = "active";
    }
    
    
    if($view == 'materi') {
        $bimbingan = "active";
        $materi = "active";
    }
    
    
    if($view == 'tryout-session') {
        $tryout = "active";
        $tryout_session = "active";
    }
    
    
    if($view == 'exam') {
        $tryout = "active";
        $tryout_session = "active";
    }
    
    if($view == 'setting') {
        $setting = "active";
        $sett = "active";
    }
    
    if($view == 'location') {
        $setting = "active";
        $location = "active";
    }
    
    if($view == 'jadwal') {
        $setting = "active";
        $jadwal = "active";
    }
    
    if($view == 'dashboard_menu_setting') {
        $setting = "active";
        $dms = "active";
    }
?>

<!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION {{ $school }}</li>
          <li class="{{ $dashboard }}">
          <a href="{{ route('default') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">genzi</small>
            </span>
          </a>
        </li>
        <li class="treeview {{$home}}">
          <a href="#">
            <i class="fa fa-home"></i>
            <span>Home Maintenance</span>
             <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
           
            <li class="{{$icon}}"><a href="{{ url('icon') }}"><i class="fa fa-circle-o"></i> Main Icon</a></li>
            <li class="{{$slider}}"><a href="{{ url('slider') }}"><i class="fa fa-circle-o"></i> Main Slider</a></li>
            <li class="{{$info}}"><a href="{{ url('information') }}"><i class="fa fa-circle-o"></i> Information</a></li>
            <li class="{{$promo}}"><a href="{{ url('promo') }}"><i class="fa fa-circle-o"></i> Promo</a></li>
            <li class="{{$news}}"><a href="{{ url('news') }}"><i class="fa fa-circle-o"></i> News</a></li>
            <li class="{{$ref}}"><a href="{{ url('ref') }}"><i class="fa fa-circle-o"></i> Reference</a></li>
          </ul>
        </li>
      
       
        <li class="treeview {{ $bimbingan }}">
          <a href="#">
            <i class="fa fa-building"></i>
            <span>Bimbingan Belajar</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li class="{{$tingkat}}"><a href="{{ url('tingkat') }}"><i class="fa fa-circle-o"></i> Tingkat</a></li>
            <li class="{{$kelas}}"><a href="{{ url('kelas') }}"><i class="fa fa-circle-o"></i> Kelas</a></li>
            <li class="{{$mapel}}"><a href="{{ url('mapel') }}"><i class="fa fa-circle-o"></i> Mapel</a></li>
            <li class="{{$kategori}}"><a href="{{ url('kategori') }}"><i class="fa fa-circle-o"></i> Kategori</a></li>
            <li class="{{$video}}"><a href="{{ url('bimbingan') }}"><i class="fa fa-circle-o"></i> Video Pembelajaran</a></li>
            <li class="{{$materi}}"><a href="{{ url('materi') }}"><i class="fa fa-circle-o"></i> Materi Pembelajaran</a></li>
          </ul>
        </li>
        
        
          <li class="treeview {{ $tryout }}">
          <a href="#">
            <i class="fa fa-graduation-cap"></i>
            <span>Quiz</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ $subject }}"><a href="{{ url('subject') }}"><i class="fa fa-circle-o"></i> Subject</a></li>
            <li class="{{$try}}"><a href="{{ url('tryout') }}"><i class="fa fa-circle-o"></i> Quiz</a></li>
            <li class="{{$tryout_session}}"><a href="{{ url('tryout_session') }}"><i class="fa fa-circle-o"></i> Session</a></li>
            <!--<li class="{{$tryout_laporan}}"><a href="{{ url('tryout_laporan') }}"><i class="fa fa-circle-o"></i> Laporan</a></li>-->
          
          </ul>
        </li>
        
          <li class="treeview {{ $tanya }}">
          <a href="#">
            <i class="fa fa-question-circle"></i>
            <span>Tanya Soal</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{$pertanyaan}}"><a href="{{ url('question') }}"><i class="fa fa-circle-o"></i> List Pertanyaan</a></li>
            <li class="{{$lapor}}"><a href="{{ url('lapor') }}"><i class="fa fa-circle-o"></i> Laporan Soal</a></li>
          </ul>
        </li>
       
         <li class="treeview {{ $quiz }}">
          <a href="#">
            <i class="fa fa-calculator"></i>
            <span>Kompetensi Dasar</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{$kuis}}"><a href="{{ url('quizheader') }}"><i class="fa fa-circle-o"></i> Kompetensi Dasar</a></li>
            <li class="{{$kuis_session}}"><a href="{{ url('exquiz') }}"><i class="fa fa-circle-o"></i> Session</a></li>
            
          </ul>
        </li>
        
          <li class="treeview {{ $banksoal }}">
          <a href="#">
            <i class="fa fa-bank"></i>
            <span>Bank Soal</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{$bank}}"><a href="{{ url('banksoal') }}"><i class="fa fa-circle-o"></i> Bank Soal</a></li>
            <li class="{{$banksoal_session}}"><a href="{{ url('banksession') }}"><i class="fa fa-circle-o"></i> Session</a></li>
            
          </ul>
        </li>
        
        
        <li class="treeview {{ $pengumuman }}">
          <a href="#">
            <i class="fa fa-bullhorn"></i>
            <span>Pengumuman</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{$pengumum}}"><a href="{{ url('pengumuman') }}"><i class="fa fa-circle-o"></i> Buat Pengumuman</a></li>
           
            
          </ul>
        </li>
     
         <li class="treeview {{ $siswa }}">
          <a href="#">
            <i class="fa fa-group"></i>
            <span>Siswa Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{$school}}"><a href="{{ url('school') }}"><i class="fa fa-circle-o"></i> Data Sekolah</a></li>
            <li class="{{$murid}}"><a href="{{ url('siswa') }}"><i class="fa fa-circle-o"></i> Data Siswa</a></li>
         </ul>
        </li>
         
          <li class="treeview {{ $admin }}">
          <a href="#">
            <i class="fa fa-database"></i>
            <span>Admin Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{$adm}}"><a href="{{ url('admin') }}"><i class="fa fa-circle-o"></i> Data Admin</a></li>
            
          </ul>
        </li>
    
      
         <li class="treeview {{ $setting }}">
          <a href="#">
            <i class="fa fa-gear"></i>
            <span>Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{$sett}}"><a href="{{ url('setting') }}"><i class="fa fa-circle-o"></i> General Setting</a></li>
            <li class="{{$location}}"><a href="{{ url('location') }}"><i class="fa fa-circle-o"></i> Location</a></li>
            
            
            <li class="{{$jadwal}}"><a href="{{ url('jadwal') }}"><i class="fa fa-circle-o"></i> Jadwal Absen</a></li>
            
            <li class="{{$dms}}"><a href="{{ url('dashboard_menu_setting') }}"><i class="fa fa-circle-o"></i> Dashboard Menu Setting</a></li>
            
          
          </ul>
        </li>
        
      </ul>