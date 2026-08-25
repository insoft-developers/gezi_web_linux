
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>GENZI | Admin Panel</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap 3.3.7 -->
  <link rel="icon" type="image/x-icon" href="{{ asset('images/playstore.png') }}">
  <link rel="stylesheet" href="{{ asset('theme') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('theme') }}/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('theme') }}/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('theme') }}/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('theme') }}/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{ asset('theme') }}/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('theme') }}/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset('theme') }}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('theme') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('theme') }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="{{ asset('theme') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="{{ asset('theme') }}/bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="{{ asset('theme') }}/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
 

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
    #loadingProgress { position: absolute; width:80px; height:80px; top: 25%; left: 50%;  z-index: 99999; }
    .t-urutan{
        background: darkorange;
        padding: 3px 7px 3px 7px;
        font-weight: bold;
        margin: 0px;
        border-radius: 19px;
        color: white;
    }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{ route('default') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>G&</b>Z</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>GEN</b>ZI</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          
          <!-- Notifications: style can be found in dropdown.less -->
          <!--<li class="dropdown notifications-menu">-->
          <!--  <a href="#" class="dropdown-toggle" data-toggle="dropdown">-->
          <!--    <i class="fa fa-bell-o"></i>-->
          <!--    <span class="label label-warning">10</span>-->
          <!--  </a>-->
          <!--  <ul class="dropdown-menu">-->
          <!--    <li class="header">You have 10 notifications</li>-->
          <!--    <li>-->
                <!-- inner menu: contains the actual data -->
          <!--      <ul class="menu">-->
          <!--        <li>-->
          <!--          <a href="#">-->
          <!--            <i class="fa fa-users text-aqua"></i> 5 new members joined today-->
          <!--          </a>-->
          <!--        </li>-->
          <!--        <li>-->
          <!--          <a href="#">-->
          <!--            <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the-->
          <!--            page and may cause design problems-->
          <!--          </a>-->
          <!--        </li>-->
          <!--        <li>-->
          <!--          <a href="#">-->
          <!--            <i class="fa fa-users text-red"></i> 5 new members joined-->
          <!--          </a>-->
          <!--        </li>-->
          <!--        <li>-->
          <!--          <a href="#">-->
          <!--            <i class="fa fa-shopping-cart text-green"></i> 25 sales made-->
          <!--          </a>-->
          <!--        </li>-->
          <!--        <li>-->
          <!--          <a href="#">-->
          <!--            <i class="fa fa-user text-red"></i> You changed your username-->
          <!--          </a>-->
          <!--        </li>-->
          <!--      </ul>-->
          <!--    </li>-->
          <!--    <li class="footer"><a href="#">View all</a></li>-->
          <!--  </ul>-->
          <!--</li>-->
          <!-- Tasks: style can be found in dropdown.less -->
          @php
            $admin = \App\Admin::findorFail(Session::get('id'));
          @endphp
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('/storage/images/profil/'.$admin->profile_image) }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Session::get('name') }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                
                <img src="{{ asset('/storage/images/profil/'.$admin->profile_image) }}" class="img-circle" alt="User Image">

                <p>
                  {{ Session::get('name') }} - <?php if(Session::get('level') == 1) { echo 'Super Admin';} else { echo 'Admin'; } ?>
                  <small>{{ Session::get('email') }}</small>
                </p>
              </li>
              <!-- Menu Body -->
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ url('profile') }}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ url('logout') }}" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('/storage/images/profil/'.$admin->profile_image) }}" class="img-circle img-responsive" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Session::get('name') }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> <?php if(Session::get('level') == 1) { echo 'Super Admin';} else { echo 'Admin'; } ?> </a>
        </div>
      </div>
      <div style="margin-top:20px;"></div>
      
      @include('sidemenu');
      
    </section>
    <!-- /.sidebar -->
  </aside>

  @yield('content')
  
  
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; {{ date('Y') }} <a href="">Generasi Zenius Indonesia (GENZI)</a>.</strong> All rights
    reserved.
  </footer>
<div id="loadingProgress" style="display:none;">
        <img src="{{ asset('images') }}/ajax-loader.gif" class="ajax-loader">
    </div>  
 
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ asset('theme') }}/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('theme') }}/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('theme') }}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

@if($view == 'dashboard')

<!-- Morris.js charts -->
<script src="{{ asset('theme') }}/bower_components/raphael/raphael.min.js"></script>
<script src="{{ asset('theme') }}/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="{{ asset('theme') }}/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="{{ asset('theme') }}/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="{{ asset('theme') }}/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('theme') }}/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="{{ asset('theme') }}/bower_components/moment/min/moment.min.js"></script>
<script src="{{ asset('theme') }}/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="{{ asset('theme') }}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('theme') }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
@endif

@if($view == 'subject' ||$view == 'dashboard_menu_setting' || $view == 'ref' || $view == 'school' || $view == 'laporan-tryout' || $view == 'pengumuman' || $view == 'contact' || $view == 'main-menu' || $view == 'lapor' || $view == 'question' || $view == 'banksoal-exam' || $view == 'banksoal-session' || $view == 'detail-bank-soal' || $view == 'banksoal' || $view == 'exquiz' || $view == 'quiz-header' || $view == 'quiz' || $view == 'slider' || $view == 'admin' || $view == 'information' || $view == 'promo' || $view == 'news' || $view == 'kelas' || $view == 'mapel' || $view == 'kategori' || $view == 'siswa' || $view == 'bimbingan' || $view == 'tryout' || $view == 'detail' || $view == 'materi' || $view == 'tryout-session' || $view == 'exam' || $view == 'location' || $view == 'tingkat' || $view == 'jadwal')

<!-- DataTables -->
<script src="{{ asset('theme') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('theme') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>


@endif



<!-- Slimscroll -->
<script src="{{ asset('theme') }}/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="{{ asset('theme') }}/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('theme') }}/dist/js/adminlte.min.js"></script>
<script src="{{ asset('theme') }}/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="{{ asset('theme') }}/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
@if($view == 'dashboard')
<script src="{{ asset('theme') }}/dist/js/pages/dashboard.js"></script>
@endif
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('theme') }}/dist/js/demo.js"></script>


@if($view == 'laporan-tryout')
    <script>
        function tampilkan_laporan_tryout() {
            var id = $("#id_kelas").val();
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            $("#loadingProgress").show();
            $.ajax({
                url : "{{ url('display_tryout_report') }}",
                type : "POST",
                dataType : "HTML",
                data : {'id':id, '_token': csrf_token},
                success : function(data) {
                    $("#loadingProgress").hide();
                    $("#isi_laporan_tryout").html(data);
                } 
            })
        }
        
    </script>

@endif

@if($view == 'profile')
 <script>
  $("#form-profile").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        $.ajax({
          url : "{{ url('profile_update') }}",
          type : "POST",
          data : new FormData($('form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
                
              $("#loadingProgress").hide();
              window.location = "{{ url('profile') }}";
            }
          }

        });
    });
 </script>
@endif

@if($view == 'setting')
<script>
  function activeData(id) {
      $.ajax({
          url : "{{ url('setting_active') }}"+"/"+id,
          type : "GET",
          dataType : "JSON",
          success : function(data) {
              window.location = "{{ url('setting') }}";
          } 
      })
  }
  
  
  function inactiveData(id) {
      $.ajax({
          url : "{{ url('setting_inactive') }}"+"/"+id,
          type : "GET",
          dataType : "JSON",
          success : function(data) {
              window.location = "{{ url('setting') }}";
          } 
      })
  }
</script>
@endif

@if($view == 'pengumuman')
<script>
    var table = $('#pengumuman_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('notifTable') }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'admin', name: 'admin'},
            {data:'content', name: 'content'},
            {data:'created_at', name: 'created_at'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });
    
    function addData() {
        resetForm();
        
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Pengumuman");
        $("#modal-add").modal("show");
    }
    
    
  
    
    $("#form-simpan").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('pengumuman') }}";
        else url = "{{ url('pengumuman') .'/'}}"+ id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal-add form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('pengumuman') }}" + '/'+id,
            type : "POST",
            data : {'_method':'DELETE', '_token':csrf_token},
            success : function($data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    
    function resetForm() {
        $("#title").val("");
        $("#content").val("");
        
    }
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
    
</script>

@endif

@if($view == 'lapor')
<script>
     var table = $('#lapor_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('laporTable') }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'nama', name: 'nama'},
            {data:'kelas', name: 'kelas'},
            {data:'soal', name: 'soal'},
            {data:'jenis', name: 'jenis'},
            {data:'status', name: 'status'},
            {data:'created_at', name: 'created_at'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });
    
    function finishData(id) {
        $("#id_finish").val(id);
        $("#modal-finish").modal("show");
    }
    
    function finishDataConfirm() {
        $("#loadingProgress").show();
        var id = $("#id_finish").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url : "{{ url('lapor_finish') }}",
            type : "POST",
            dataType : "JSON",
            data : {'id': id, '_token': csrf_token},
            success : function(data) {
                $("#loadingProgress").hide();
                table.ajax.reload(null, false);
                $("#modal-finish").modal("hide");
            }
        })
    }
    
    
    
    function outstandData(id) {
        $("#id_outstanding").val(id);
        $("#modal-outstanding").modal("show");
    }
    
    function outstandDataConfirm() {
        $("#loadingProgress").show();
        var id = $("#id_outstanding").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url : "{{ url('lapor_outstanding') }}",
            type : "POST",
            dataType : "JSON",
            data : {'id': id, '_token': csrf_token},
            success : function(data) {
                $("#loadingProgress").hide();
                table.ajax.reload(null, false);
                $("#modal-outstanding").modal("hide");
            }
        })
    }
    
    
    
</script>
@endif

@if($view == 'question')
<script>
    
    function jawabData(id) {
        window.location = "{{ url('answer_question') }}"+"/"+id;
    }
    
    
    function editData(id) {
        $("#loadingProgress").show();
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        
        $.ajax({
            url : "{{ url('edit_status_question') }}"+"/"+id,
            type : "GET",
            dataType : "JSON",
            success: function(data) {
                $("#loadingProgress").hide();
                $("#id").val(data.id);
                $("#status").val(data.status);
                $(".modal-title").text("Edit Status");
                $("#modal-add").modal("show");
                
            }
        });
    }
    
    
    $("#form-simpan").submit(function(e){
        e.preventDefault();
        $("#loadingProgress").show();
        var id = $("#id").val();
        $.ajax({
            url : "{{ url('update_question_status') }}"+"/"+id,
            type : "POST",
            dataType : "JSON",
            data: $(this).serialize(),
            success : function(data) {
                  $('#modal-add').modal('hide');
                  table.ajax.reload(null, false);
                  $("#loadingProgress").hide();
            }
        })
    })
    
    var table = $('#question_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('questionTable') }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'id_user', name: 'id_user'},
            {data:'id_kelas', name: 'id_kelas'},
            {data:'soal', name: 'soal'},
            {data:'jawaban', name: 'jawaban'},
            {data:'is_active', name: 'is_active'},
            {data:'created_at', name: 'created_at'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });
    
    
    var table2 = $('#question_answer_table').DataTable({
        processing:true,
        serverSide:true,
        ajax: "{{ route('questionAnswerTable', $ids) }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'jawaban', name: 'jawaban'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });
    
    function addJawaban() {
        resetForm();
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Jawaban");
        $("#modal-add-jawaban").modal("show");
    }
    
    
    $("#form-simpan-jawaban").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('jawaban_add') }}";
        else url = "{{ url('jawaban_update') .'/'}}"+ id;
        
        var form_data = new FormData($('#modal-add-jawaban form')[0]);
        $.ajax({
          url : url,
          type : "POST",
          data : form_data,
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add-jawaban').modal('hide');
              table2.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    
    function editJawaban(id) {
        $("#loadingProgress").show();
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add-jawaban form')[0].reset();
        $.ajax({
              url: "{{ url('jawaban_edit') }}" +"/"+id,
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  $("#loadingProgress").hide();
                  $('#modal-add-jawaban').modal("show");
                  $('.modal-title').text("Edit Jawaban");
                  $('#id').val(data.id);
                  $("#id_soal").val(data.id_soal);
                  $("#id_guru").val(data.id_guru);
                  $("#jawaban").val(data.jawaban);
                 
                                     
            }
        })
    }
    
    
    function deleteJawaban(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('jawaban_delete') }}" + '/'+id,
            type : "POST",
            data : {'_method':'DELETE', '_token':csrf_token},
            success : function($data){
                table2.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    function deleteImage(id) {
        var hapus = confirm('Hapus Gambar Ini...?');
        if(hapus === true) {
            confirmHapusImage(id);
        }
    }
    
    function confirmHapusImage(id) {
        $("#loadingProgress").show();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url : "{{ url('delete_answer_image') }}",
            type : "POST",
            dataType : "JSON",
            data : {'id':id,'_token': csrf_token},
            success : function(data) {
                $("#loadingProgress").show();
                table2.ajax.reload(null, false);
                
            }
        })
    }
    
    function resetForm() {
        
    }
    
</script>
@endif


@if($view == 'banksoal-exam')
<script>
    var table = $('#banksoal_exam_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('bankSoalExamTable', $banksoal->id) }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'judul', name: 'judul'},
            {data:'id_user', name: 'id_user'},
            {data:'location', name: 'location'},
            {data:'nis', name: 'nis'},
            {data:'school_id', name: 'school_id'},
            {data:'phone', name: 'phone'},
            {data:'id_kelas', name: 'id_kelas'},
            {data:'score', name: 'score'},
            {data:'target', name: 'target'},
            {data:'time', name: 'time'},
            {data:'resume', name: 'resume'},
            {data:'created_at', name: 'created_at'},
            {data:'detail', name: 'detail', orderable:false, searchable:false}
        ]
    });
    
    
    function listData(id){
        $("#loadingProgress").show();
        $.ajax({
            url : "{{ url('banksoal_detail_exam') }}"+"/"+id,
            type : "GET",
            success : function(data) {
                console.log(data);
                $("#loadingProgress").hide();
                $(".modal-title").text('Show Detail');
                $("#modal-show-detail").modal("show");
                
                $("#content-text").html(data);
            }
        });
    }
    
    
</script>

@endif



@if($view == 'banksoal-session')
<script>
     
     function listData(id) {
         window.location = "{{ url('list_ikut_banksoal') }}"+"/"+id;
     }    

     var table = $('#banksoal_session_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('bankSoalSessionTable') }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'judul', name: 'judul'},
            {data:'id_kelas', name: 'id_kelas'},
            {data:'is_active', name: 'is_active'},
            {data:'target_score', name: 'target_score'},
            {data:'freq', name: 'freq'},
            {data:'created_at', name: 'created_at'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });
</script>
@endif

@if($view == 'detail-bank-soal')
<script>
    function generateNomor() {
        var idbanksoal = $("#id_bank_soal").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
           url : "{{ url('generate_nomor_bank_soal') }}",
           type : "POST",
           dataType : "JSON",
           data : {'idbanksoal': idbanksoal, '_token': csrf_token},
           success : function(data) {
               console.log("no kuis", data);
               $("#no_soal").val(data);
           } 
        }); 
    }
    
    var table = $('#bank_soal_detail_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('bankSoalDetailTable', $ids) }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'no_soal', name: 'no_soal'},
            {data:'soal', name: 'soal'},
            {data: 'jawaban_a', name: 'jawaban_a'},
            {data:'kunci_jawaban', name: 'kunci_jawaban'},
            {data:'score', name: 'score'},
            
            {data:'youtube_link', name: 'youtube_link'},
            {data:'is_active', name: 'is_active'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });
    
    
    function addData() {
        resetForm();
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Bank Soal Detail");
        generateNomor();
        $("#modal-add").modal("show");
    }
    
    
    function editData(id) {
        showLoading();
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
              url: "{{ url('banksoal_detail_edit') }}" +"/"+id,
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  console.log(data);
                  hideLoading();
                  $('#modal-add').modal("show");
                  $('.modal-title').text("Edit Detail Bank Soal");
                  $('#id').val(data.id);
                  $("#id_bank_soal").val(data.id_bank_soal);
                  $("#no_soal").val(data.no_soal);
                  $("#soal").val(data.soal);
                  $("#jawaban_a").val(data.jawaban_a);
                  $("#jawaban_b").val(data.jawaban_b);
                  $("#jawaban_c").val(data.jawaban_c);
                  $("#jawaban_d").val(data.jawaban_d);
                  $("#jawaban_e").val(data.jawaban_e);
                  $("#score").val(data.score);
                  $("#is_active").val(data.is_active);
                  $("#kunci_jawaban").val(data.kunci_jawaban);
                  
                  $("#youtube_link").val(data.youtube_link);
                  
                                     
            }
        })
    }
    
    
    $("#form-simpan").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('banksoal_detail_add') }}";
        else url = "{{ url('banksoal_detail_update') .'/'}}"+ id;
        
        var form_data = new FormData($('#modal-add form')[0]);
        $.ajax({
          url : url,
          type : "POST",
          data : form_data,
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    
    function deleteImage(id, ind) {
        var hapus = confirm('Hapus Gambar Ini...?');
        if(hapus === true) {
            confirmHapusImage(id, ind);
        }
    }
    
    function confirmHapusImage(id, type) {
        showLoading();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url : "{{ url('delete_banksoal_image') }}",
            type : "POST",
            dataType : "JSON",
            data : {'id':id, 'type': type, '_token': csrf_token},
            success : function(data) {
                hideLoading();
                table.ajax.reload(null, false);
                
            }
        })
    }
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('banksoal_detail_delete') }}",
            type : "POST",
            data : {'id': id,'_token':csrf_token},
            success : function(data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    
    function deleteDataAll() {
        $("#modal-hapus-semua").modal("show");
    }
    
    function deleteAllDataConfirm() {
        var id = $("#id_hapus_semua").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('detailbanksoal_delete_all') }}",
            type : "POST",
            data : {'id': id,'_token':csrf_token},
            success : function(data){
                table.ajax.reload(null, false);
                $("#modal-hapus-semua").modal("hide");
            }
        });
    }
    
    
    
    
    function resetForm() {
        $("#id").val("");
        $("#no_soal").val("");
        $("#gambar_soal").val(null);
        $("#soal").val("")
        $("#gambar_a").val(null);
        $("#jawaban_a").val("");
        $("#gambar_b").val(null);
        $("#jawaban_b").val("");
        $("#gambar_c").val(null);
        $("#jawaban_c").val("");
        $("#gambar_d").val(null);
        $("#jawaban_d").val("");
        $("#gambar_e").val(null);
        $("#jawaban_e").val("");
        $("#kunci_jawaban").val("");
        $("#score").val("");
        $("#is_active").val("");
        $("#youtube_link").val("");
    }
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
</script>
@endif


@if($view == 'banksoal')
    <script>
    
        $("#btn_filter").click(function(){
            table.ajax.reload(null, false); 
        });
    
        $('#btn_reset').click(function () {
    
            $('#filter_kelas').val('');
            $('#filter_kategori').val('');
            $("#filter_status").val('');
            table.ajax.reload();
        });
        $("#filter_kelas").change(function(){
            var kelasId = $(this).val();
            $.ajax({
               url: "{{ url('banksoal_get_kategori_by_kelas') }}"+"/"+kelasId,
               type: "GET",
               dataType: "JSON",
               success: function(data) {
                   console.log(data);
                   var html = '';
                   html += '<option value="">Semua Kategori</option>';
                   data.forEach(function(item){
                       html += `<option value="${item.id}">${item.category_name}</option>`;
                   });
                   
                   $("#filter_kategori").html(html);
               }
            });
        });
        
         $('.my-colorpicker2').colorpicker();
        function copyData(id) {
            $("#dari").val(id);
            $("#modal-copy").modal("show");
            $(".modal-title").text("Copy Soal Bank Soal");
            $("#jenis").val("");
            $("#tujuan").html("");
        }
        
        
        $("#jenis").change(function(){
            var jenis = $(this).val();
            $.ajax({
                url: "{{ url('get_jenis_copy') }}"+"/"+jenis,
                type : "GET",
                dataType : "HTML",
                success : function(data){
                    $("#tujuan").html(data);
                }
            })
        })
        
        
        $("#form-copy").submit(function(e){
            e.preventDefault();
            $("#loadingProgress").show();
            $.ajax({
                url : "{{ url('copy_banksoal') }}",
                type : "POST",
                dataType : "JSON",
                data : $(this).serialize(),
                success : function(data) {
                    console.log(data);
                    $("#loadingProgress").hide();
                    $("#modal-copy").modal("hide");
                    table.ajax.reload(null, false);
                    
                 
                }
            })
        })
        
    
        function detailSoal(id) {
            window.location = "{{ url('bank_soal_detail') }}"+"/"+id;
        }
        
        $("#id_kelas").select2({closeOnSelect:false}).on('select2:selecting', function(e) {
              var cur = e.params.args.data.id;
              var old = (e.target.value == '') ? [cur] : $(e.target).val().concat([cur]);
              $(e.target).val(old).trigger('change');
              $(e.params.args.originalEvent.currentTarget).attr('aria-selected', 'true');
            return false;
        });
        
        $("#id_kategori").select2({
            dropdownParent: $('#modal-add')
        });
        
        $("#id_kategori").change(function(){
           var id = $(this).val();
           $.ajax({
              url : "{{ url('category_bimbel') }}"+"/"+id,
              type : "GET",
              success : function(data) {
                  $("#id_kelas").html(data.kelas);
              }
           });
        });
        
        var table = $('#banksoal_table').DataTable({
            dom: 'Blfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            processing:true,
            serverSide:true,
            ajax: {
                url: "{{ route('bankSoalTable') }}",
                type: "GET",
                data: function (d) {
                    d.kelas_id = $('#filter_kelas').val();
                    d.kategori_id = $('#filter_kategori').val();
                    d.status_id = $("#filter_status").val();
                }
            },
            order: [[ 1, "asc" ]],
            columns: [
                {data:'id', name: 'id'},
                {data:'urutan', name: 'urutan', visible:false},
                {data:'action', name: 'action', orderable:false, searchable:false},
                {data:'judul', name: 'judul'},
                {data:'id_kategori', name: 'id_kategori'},
                {data:'id_kelas', name: 'id_kelas'},
                {data:'is_active', name: 'is_active'},
                {data:'is_repeated', name: 'is_repeated'},
                {data:'is_skipped', name: 'is_skipped'},
                
                {data:'target_score', name: 'target_score'},
                {data:'jumlah_soal', name: 'jumlah_soal'},
               
                
                
            ]
        });
        
        
        function addData() {
            resetForm();
            save_method = "add";
            $('input[name=_method]').val('POST');
            $(".modal-title").text("Add Bank Soal");
            $("#modal-add").modal("show");
        }
        
        
        function editData(id) {
            showLoading();
            save_method = "edit";
            $('input[name=_method]').val('PATCH');
            $('#modal-add form')[0].reset();
            $.ajax({
                  url: "{{ url('banksoal') }}" +"/"+id+"/edit",
                  type :"GET",
                  dataType : "JSON",
                  success:function(data){
                      hideLoading();
                      $('#modal-add').modal("show");
                      $('.modal-title').text("Edit Bank Soal");
                      $('#id').val(data.data.id);
                      $("#judul").val(data.data.judul);
                      $("#id_kategori").val(data.data.id_kategori).trigger('change');
                      $("#target_score").val(data.data.target_score);
                      $("#is_active").val(data.data.is_active);
                      $("#is_repeated").val(data.data.is_repeated);
                      $("#is_skipped").val(data.data.is_skipped);
                      $("#warna_soal").val(data.data.warna_soal).trigger('change');
                      $("#warna_tulisan").val(data.data.warna_tulisan).trigger('change');
                      $("#short_name").val(data.data.short_name);
                      $("#warna_jawaban").val(data.data.warna_jawaban).trigger('change');
                      $("#warna_tulisan_jawaban").val(data.data.warna_tulisan_jawaban).trigger('change');
                      $("#urutan").val(data.data.urutan);
                      
                      $("#id_kelas").html(data.kelas);
                      
                      $.ajax({
                          url : "{{ url('kelas_by_bank_soal') }}"+"/"+id,
                          type : "GET",
                          dataType : "JSON",
                          success : function(data) {
                              $("#id_kelas").val(data).trigger('change');
                          }
                      })
                      
                },
                
            })
        }
        
        
        
        $("#form-simpan").submit(function(e){
            $("#loadingProgress").show();
            e.preventDefault();
            var id = $('#id').val();
            if(save_method == "add")  url = "{{ url('banksoal') }}";
            else url = "{{ url('banksoal') .'/'}}"+ id;
            $.ajax({
              url : url,
              type : "POST",
              data : new FormData($('#modal-add form')[0]),
              contentType:false,
              processData:false,
              success : function(data){
                if(data.success == true){
                  $('#modal-add').modal('hide');
                  table.ajax.reload(null, false);
                  $("#loadingProgress").hide();
                 
                }
              }
    
            });
        });
        
        
        function deleteData(id) {
            $("#id_hapus").val(id);
            $("#modal-hapus").modal("show");
        }
        
        function deleteDataConfirm(){
            var id = $("#id_hapus").val();
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url  : "{{ url('banksoal') }}" + '/'+id,
                type : "POST",
                data : {'_method':'DELETE', '_token':csrf_token},
                success : function(data){
                    table.ajax.reload(null, false);
                    $("#modal-hapus").modal("hide");
                }
            });
        }
        
        
        function copyData(id) {
            $("#dari").val(id);
            $("#modal-copy").modal("show");
        }
        
        $("#form-copy").submit(function(e){
            e.preventDefault();
            $.ajax({
                url : "{{ url('copy_quiz') }}",
                type : "POST",
                dataType : "JSON",
                data : $(this).serialize(),
                success: function(data) {
                    console.log(data);
                    table.ajax.reload(null, false);
                    $("#modal-copy").modal("hide");
                }
            })
        })
        
        
        function resetForm() {
            $("#judul").val("");
            $("#id_kategori").val("");
            $("#id_kelas").html("");
            $("#target_score").val("");
            $("#is_active").val("");
            $("#is_repeated").val("");
            $("#is_skipped").val("");
            $("#warna_soal").val("#FFFFFF").trigger('change');
            $("#warna_tulisan").val("#000000").trigger('change');
                      
        }
        
        function showLoading() {
            $("#loadingProgress").show();
        }
        
        
        function hideLoading() {
            $("#loadingProgress").hide();
        }
        
    </script>
@endif

@if($view == 'exquiz')
<script>

    function count_records() {
        var id = "{{ Request::segment(2) }}";
        var awal = $("#tanggal_awal").val();
        var akhir = $("#tanggal_akhir").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        if(awal == '' || akhir == '') {
            alert('Tanggal awal atau tanggal akhir tidak boleh kosong... ');
        } else {
            $("#loadingProgress").show();
            $.ajax({
                url: "{{ route('count.quiz.record') }}",
                dataType : "JSON",
                type : "POST",
                data: {"id":id, "awal":awal, "akhir":akhir, "_token":csrf_token},
                success : function(data) {
                    $("#loadingProgress").hide();
                    console.log(data);
                    $("#start_record").val(0);
                    $("#last_record").val(data);
                }
            })
        }
    }
    
    function detailData(id) {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url : "{{ url('quiz_result') }}",
            type : "POST",
            data : {'id':id, '_token': csrf_token },
            success : function(data) {
                $(".modal-title").text('Detail Quiz Answer');
                $("#content-text").html(data);
                $("#modal-show-detail").modal("show");
            }
        })
        
        
    }
    
    function sessData(id) {
        window.location = "{{ url('sess_quiz') }}"+"/"+id;
    }
    
    // initTable("0","0");
    
    function tampilkan_laporan_session() {
        
        var awal = $("#tanggal_awal").val();
        var akhir = $("#tanggal_akhir").val();
        
        if(awal == '') {
            awal = 0;
        } else {
            awal = $("#tanggal_awal").val();
        }
        
        if(akhir == '') {
            akhir = 0;
        } else {
            akhir = $("#tanggal_akhir").val();
        }
        
        var offset = $("#start_record").val();
        var limit = $("#last_record").val();
        if(offset == '' || limit == '') {
            alert('first record atau last record tidak boleh kosong!!');
        } else {
            $("#sessquiz_table").dataTable().fnDestroy();
            initTable(awal, akhir, offset, limit);
        }
        
        
        
        
    }
    
    
    function initTable(awal, akhir, offset, limit) {
        
        var ids = "{{ $ids }}";
        var table = $('#sessquiz_table').DataTable({
            dom: 'Blfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            processing:true,
            serverSide:true,
            ajax: "{{ url('sessquizTable') }}"+"/"+ids+"/"+awal+"/"+akhir+'/'+offset+'/'+limit,
            order: [[ 0, "desc" ]],
            columns: [
                {data:'id', name: 'id'},
                {data:'judul', name: 'judul'},
                {data:'siswa', name: 'siswa'},
                {data:'nis', name: 'nis'},
                {data:'school_id', name: 'school_id'},
                {data:'phone', name: 'phone'},
                {data:'id_kelas', name: 'id_kelas'},
                {data:'target_score', name: 'target_score'},
                {data:'score', name: 'score'},
                {data:'time', name: 'time'},
                {data:'resume', name: 'resume'},
                {data:'created_at', name: 'created_at'},
                {data:'action', name: 'action', orderable:false, searchable:false}
            ]
        });
    }
    
    
    
    function soalData(id) {
        window.location = "{{ url('quizes') }}"+"/"+id;    
    }
    
    
    var table = $('#exquiz_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('exquizTable') }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'judul', name: 'judul'},
            {data:'id_kelas', name: 'id_kelas'},
            {data:'jumlah', name: 'jumlah'},
            {data:'created_at', name: 'created_at'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });


    function addData() {
        resetForm();
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Judul Quiz");
        $("#modal-add").modal("show");
    }
    
    
    function editData(id) {
        showLoading();
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
              url: "{{ url('quizheader') }}" +"/"+id+"/edit",
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  hideLoading();
                  $('#modal-add').modal("show");
                  $('.modal-title').text("Edit Judul Quiz");
                  $('#id').val(data.id);
                  $("#id_kelas").val(data.id_kelas);
                  $("#judul").val(data.judul);
            },
            
        })
    }
    
    
    
    $("#form-simpan").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('quizheader') }}";
        else url = "{{ url('quizheader') .'/'}}"+ id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal-add form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            } else {
              alert("Terjadi Kesalahan Atau Kelas Sudah Ada..!");    
              $("#loadingProgress").hide();    
            }
          }

        });
    });
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteSession(id) {
       
        $("#id_session").val(id);
        $("#modal-hapus-session").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('quizheader') }}" + '/'+id,
            type : "POST",
            data : {'_method':'DELETE', '_token':csrf_token},
            success : function(data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    function deleteSessionConfirm() {
        var id = $("#id_session").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('quiz_session_delete') }}",
            type : "POST",
            data : {'id':id, '_token':csrf_token},
            success : function(data){
                table.ajax.reload(null, false);
                $("#modal-hapus-session").modal("hide");
            }
        });
    }
    
    
    function copyData(id) {
        $("#dari").val(id);
        $("#modal-copy").modal("show");
    }
    
    $("#form-copy").submit(function(e){
        e.preventDefault();
        $.ajax({
            url : "{{ url('copy_quiz') }}",
            type : "POST",
            dataType : "JSON",
            data : $(this).serialize(),
            success: function(data) {
                console.log(data);
                table.ajax.reload(null, false);
                $("#modal-copy").modal("hide");
            }
        })
    })
    
    
    function resetForm() {
    
        $("#id_kelas").val("");
        $("#judul").val("");
        
    }
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
    
</script>
@endif

@if($view == 'quiz-header')
<script>

   $("#id_kelas").select2({closeOnSelect:false}).on('select2:selecting', function(e) {
          var cur = e.params.args.data.id;
          var old = (e.target.value == '') ? [cur] : $(e.target).val().concat([cur]);
          $(e.target).val(old).trigger('change');
          $(e.params.args.originalEvent.currentTarget).attr('aria-selected', 'true');
        return false;
    });
    $(".my-colorpicker2").colorpicker();

    function soalData(id) {
        window.location = "{{ url('quizes') }}"+"/"+id;    
    }
    
    
    var table = $('#quiz_header_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('quizHeaderTable') }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'id_kelas', name: 'id_kelas'},
            {data:'judul', name: 'judul'},
            {data:'jumlah', name: 'jumlah'},
            {data:'waktu_kuis', name: 'waktu_kuis'},
            {data:'target_score', name: 'target_score'},
            {data:'is_active', name: 'is_active'},
            {data:'urutan', name: 'urutan'},
            {data:'created_at', name: 'created_at'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });


    function addData() {
        resetForm();
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Judul Quiz");
        $("#modal-add").modal("show");
    }
    
    
    function editData(id) {
        showLoading();
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
              url: "{{ url('quizheader') }}" +"/"+id+"/edit",
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  hideLoading();
                  $('#modal-add').modal("show");
                  $('.modal-title').text("Edit Judul Quiz");
                  $('#id').val(data.data.id);
                  $("#id_kelas").val(data.kelas).trigger('change');
                  $("#judul").val(data.data.judul);
                  $("#waktu_kuis").val(data.data.waktu_kuis);
                  $("#target_score").val(data.data.target_score);
                  $("#urutan").val(data.data.urutan);
                  $("#is_active").val(data.data.is_active);
                  $("#short_name").val(data.data.short_name);
                  $("#warna_soal").val(data.data.warna_soal).trigger('change');
                  $("#warna_tulisan_soal").val(data.data.warna_tulisan_soal).trigger('change');
                  $("#warna_jawaban").val(data.data.warna_jawaban).trigger('change');
                  $("#warna_tulisan_jawaban").val(data.data.warna_tulisan_jawaban).trigger('change');
            },
            
        })
    }
    
    
    
    $("#form-simpan").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('quizheader') }}";
        else url = "{{ url('quizheader') .'/'}}"+ id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal-add form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            } else {
              alert("Terjadi Kesalahan Atau Kelas Sudah Ada..!");    
              $("#loadingProgress").hide();    
            }
          }

        });
    });
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('quizheader') }}" + '/'+id,
            type : "POST",
            data : {'_method':'DELETE', '_token':csrf_token},
            success : function(data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    
    function copyData(id) {
        $("#dari").val(id);
        $("#modal-copy").modal("show");
    }
    
    $("#form-copy").submit(function(e){
        e.preventDefault();
        $.ajax({
            url : "{{ url('copy_quiz') }}",
            type : "POST",
            dataType : "JSON",
            data : $(this).serialize(),
            success: function(data) {
                console.log(data);
                table.ajax.reload(null, false);
                $("#modal-copy").modal("hide");
            }
        })
    })
    
    
    function resetForm() {
    
        $("#id_kelas").val("");
        $("#judul").val("");
        $("#urutan").val("");
        $("#waktu_kuis").val("");
        $("#target_score").val("");
        $("#is_active").val("");
        $("#short_name").val("");
        $("#warna_soal").val("#FFFFFF").trigger("change");
        $("#warna_tulisan_soal").val("#000000").trigger("change");
        $("#warna_jawaban").val("#FFFFFF").trigger("change");
        $("#warna_tulisan_jawaban").val("#000000").trigger("change");
        
    }
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
    
</script>
@endif

@if($view == 'quiz')
<script>
    var table = $('#quiz_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('quizTable', $idquiz) }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'judul', name: 'judul'},
            {data:'no_kuis', name: 'no_kuis'},
            {data:'soal_kuis', name: 'soal_kuis'},
            {data:'jawaban_a', name: 'jawaban_a'},
            {data:'kunci_jawaban', name: 'kunci_jawaban'},
            
            {data:'score', name: 'score'},
            {data:'created_at', name: 'created_at'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });


    function addData() {
        resetForm();
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Soal Quiz");
        $("#modal-add").modal("show");
        generateNomor();
    }
    
    function generateNomor() {
        var idquiz = $("#id_quiz").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
           url : "{{ url('generate_nomor_kuis') }}",
           type : "POST",
           dataType : "JSON",
           data : {'idquiz': idquiz, '_token': csrf_token},
           success : function(data) {
               console.log("no kuis", data);
               $("#no_kuis").val(data);
           } 
        }); 
    }
    
    
    function editData(id) {
        showLoading();
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
              url: "{{ url('quiz') }}" +"/"+id+"/edit",
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  hideLoading();
                  $('#modal-add').modal("show");
                  $('.modal-title').text("Edit Soal Quiz");
                  $('#id').val(data.id);
                  $("#no_kuis").val(data.no_kuis);
                  $("#id_kelas").val(data.id_kelas);
                  $("#soal_kuis").val(data.soal_kuis);
                  $("#jawaban_a").val(data.jawaban_a);
                  $("#jawaban_b").val(data.jawaban_b);
                  $("#jawaban_c").val(data.jawaban_c);
                  $("#jawaban_d").val(data.jawaban_d);
                  $("#jawaban_e").val(data.jawaban_e);
                  $("#kunci_jawaban").val(data.kunci_jawaban);
                  $("#score").val(data.score);
                  
                                     
            }
        })
    }
    
    
    
    $("#form-simpan").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('quiz') }}";
        else url = "{{ url('quiz') .'/'}}"+ id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal-add form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('quiz') }}" + '/'+id,
            type : "POST",
            data : {'_method':'DELETE', '_token':csrf_token},
            success : function($data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    
    function deleteImage(id, ind) {
        var hapus = confirm('Hapus Gambar Ini...?');
        if(hapus === true) {
            confirmHapusImage(id, ind);
        }
    }
    
    function confirmHapusImage(id, type) {
        showLoading();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url : "{{ url('delete_quiz_image') }}",
            type : "POST",
            dataType : "JSON",
            data : {'id':id, 'type': type, '_token': csrf_token},
            success : function(data) {
                hideLoading();
                table.ajax.reload(null, false);
                
            }
        })
    }
    
    
    
    
    
    function resetForm() {
        $("#no_kuis").val("");
        $("#soal_kuis").val("");
        $("#jawaban_a").val("");
        $("#jawaban_b").val("");
        $("#jawaban_c").val("");
        $("#jawaban_d").val("");
        $("#jawaban_e").val("");
        $("#kunci_jawaban").val("");
        $("#score").val("");
        $("#gambar_soal").val(null);
        $("#gambar_a").val(null);
        $("#gambar_b").val(null);
        $("#gambar_c").val(null);
        $("#gambar_d").val(null);
        $("#gambar_e").val(null);
        
        
    }
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
    
</script>
@endif

@if($view == 'admin')
<script>
   
    var table = $('#admin_table').DataTable({
         dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('adminTable') }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'profile_image', name: 'profile_image'},
            {data:'name', name: 'name'},
            {data:'level', name: 'level'},
            {data:'email', name: 'email'},
            {data:'created_at', name: 'created_at'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });


    function addData() {
        resetForm();
        $("#password").attr("required", true);
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Data Admin");
        $("#modal-add").modal("show");
    }
    
    
    function editData(id) {
        showLoading();
        save_method = "edit";
        $("#password").removeAttr("required");
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
              url: "{{ url('admin') }}" +"/"+id+"/edit",
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  hideLoading();
                  $('#modal-add').modal("show");
                  $('.modal-title').text("Edit Data Admin");
                  $('#id').val(data.id);
                  $("#name").val(data.name);
                  $("#email").val(data.email);
                  $("#level").val(data.level);
                                     
            }
        })
    }
    
    
    
    $("#form-simpan").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('admin') }}";
        else url = "{{ url('admin') .'/'}}"+ id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal-add form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('admin') }}" + '/'+id,
            type : "POST",
            data : {'_method':'DELETE', '_token':csrf_token},
            success : function($data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    
    function resetForm() {
        $("#profile_image").val(null);
        $("#name").val("");
        $("#email").val("");
        $("#password").val("");
    }
    
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
    
</script>
@endif

@if($view == 'siswa')
<script>
    
    function resetSession(id) {
        $("#siswa_hapus_sesi_id").val(id);
        $("#modalHapusSesi").modal("show");
    }
    
    function hapusSesi(tipe) 
    {
        var siswaId = $("#siswa_hapus_sesi_id").val();
        var ujian = '';
        if(tipe == 'kompetensi_dasar') {
            ujian = 'Kompetensi Dasar';
        } else if(tipe == 'quiz') {
            ujian = 'Quiz';
        } else if(tipe == 'bank_soal') {
            ujian = 'Bank Soal';
        }
        var kon = confirm('Yakin ingin menghapus data sesi '+ujian+' dengan ID Siswa : '+siswaId+'...?');
        if(kon === true) {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                url: "{{ url('siswa_session_delete') }}",
                type: "POST",
                dataType : "JSON",
                data: {
                    "id":siswaId,
                    "tipe": tipe,
                    "_token" :csrf_token
                },
                success: function(data) {
                    
                    alert("Berhasil Hapus Data Sesi Siswa");
                    table.ajax.reload(null, false);
                    $("#modalHapusSesi").modal("hide");
                }
            })
        }
    }

    $('#btn_filter').click(function () {
        table.ajax.reload();
    })
    
    
    function exportExcel() {

        var params = $.param({
    
            location_id: $('#filter_location').val(),
    
            id_kelas: $('#filter_kelas').val(),
    
            class_group: $('#filter_group_kelas').val(),
    
            school_id: $('#filter_school').val(),
    
            date_start: $('#filter_date_start').val(),
    
            date_end: $('#filter_date_end').val()
    
        });
    
        window.location.href =
            "{{ route('siswa.export') }}?" + params;
    }
    
    
    
    $('#btn_reset_filter').click(function () {

        $('#filter_location').val('');
        $('#filter_kelas').val('');
        $('#filter_group_kelas').val('');
        $('#filter_school').val('');
    
        $('#filter_date_start').val('');
        $('#filter_date_end').val('');
    
        table.ajax.reload();
    });
    
    var table = $('#siswa_table').DataTable({
       
        lengthMenu: [
            [10, 25, 50, 100,  -1],
            [10, 25, 50, 100, 'All'],
        ],
        processing:true,
        serverSide:true,
        
        ajax: {
            url: "{{ route('siswaTable') }}",
            type: "GET",
    
            data: function (d) {
    
                d.location_id = $('#filter_location').val();
                d.id_kelas = $('#filter_kelas').val();
                d.group_kelas_id = $('#filter_group_kelas').val();
                d.school_id = $('#filter_school').val();
    
                d.date_start = $('#filter_date_start').val();
                d.date_end = $('#filter_date_end').val();
            }
        },
        order: [[ 1, "desc" ]],
        columns: [
            {data:'action', name: 'action', orderable:false, searchable:false},
            {data:'id', name: 'id'},
            {data:'version', name: 'version'},
            {data:'profile_image', name: 'profile_image'},
            {data:'is_active', name: 'is_active'},
            {data:'created_at', name: 'created_at'},
            {data:'name', name: 'name'},
            {data:'quiz_score', name: 'quiz_score'},
            {data:'bank_score', name: 'bank_score'},
            {data:'last_action', name: 'last_action'},
            {data:'location_id', name: 'location_id'},
            {data:'nis', name: 'nis'},
            {data:'id_kelas', name: 'id_kelas'},
            {data:'class_group', name: 'class_group'},
            {data:'fathers_phone', name: 'fathers_phone'},
            {data:'mothers_phone', name: 'mothers_phone'},
            {data:'school_id', name: 'school_id'},
            {data:'email', name: 'email'},
            {data:'phone', name: 'phone'},
            {data:'lama', name: 'lama'},
            
            
        ],
    });
    
    
    function reset(id) {
        var popup = confirm('Reset password untuk data ini ?');
        if(popup == true) {
            $.ajax({
                url : "{{ url('reset_password') }}"+"/"+id,
                type : "GET",
                dataType : "JSON",
                success : function(data) {
                    alert("Reset password berhasil...");
                }
            });
        }
    }


    function addData() {
        resetForm();
        save_method = "add";
        $("#password").attr("required", true);
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Siswa");
        $("#modal-add").modal("show");
    }
    
    
    function editData(id) {
        showLoading();
        save_method = "edit";
        $("#password").removeAttr("required");
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
              url: "{{ url('siswa') }}" +"/"+id+"/edit",
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  hideLoading();
                  $('#modal-add').modal("show");
                  $('.modal-title').text("Edit Data Siswa");
                  $('#id').val(data.id);
                  $("#name").val(data.name);
                  $("#id_kelas").val(data.id_kelas);
                  $("#class_group").val(data.class_group);
                  $("#fathers_phone").val(data.fathers_phone);
                  $("#mothers_phone").val(data.mothers_phone);
                  $("#email").val(data.email);
                  $("#phone").val(data.phone);
                  $("#is_active").val(data.is_active);
                  $("#school_id").val(data.school_id);
                  $("#nis").val(data.nis);
                  $("#location_id").val(data.location_id);
                  $("#is_qrcode").val(data.is_qrcode);
                                     
            }
        })
    }
    
    
    
    $("#form-simpan").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('siswa') }}";
        else url = "{{ url('siswa') .'/'}}"+ id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal-add form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('siswa') }}" + '/'+id,
            type : "POST",
            data : {'_method':'DELETE', '_token':csrf_token},
            success : function($data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    function activate(id) {
        var pop = confirm('Apakah anda yakin akan mengaktivasi akun ini...?');
        if(pop === true) {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url  : "{{ route('siswa.activate') }}",
                type : "POST",
                data : {'id':id, '_token':csrf_token},
                success : function($data){
                    table.ajax.reload(null, false);
                    
                }
            });
        }
    }
    
    
    function deactivate(id) {
        var pop = confirm('Apakah anda yakin akan menonaktifkan akun ini...?');
        if(pop === true) {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url  : "{{ route('siswa.deactivate') }}",
                type : "POST",
                data : {'id':id, '_token':csrf_token},
                success : function($data){
                    table.ajax.reload(null, false);
                    
                }
            });
        }
    }
    
    
    
    
    function resetForm() {
        $("#profile_image").val(null);
        $("#name").val("");
        $("#id_kelas").val("");
        $("#email").val("");
        $("#phone").val("");
        $("#password").val("");
        $("#nis").val("");
        $("#location_id").val("");
    }
    
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
    function logoutData(id) {
        var popup = confirm('Apakah anda ingin ubah status user menjadi logout..?');
        if(popup===true) {
            logoutDataConfirm(id);
        }
    }
    
    function logoutDataConfirm(id) {
        $.ajax({
            url : "{{ url('logout_data_user') }}"+"/"+id,
            type : "GET",
            dataType : "JSON",
            success : function(data) {
                table.ajax.reload(null, false);
            }
        });
    }
    
    
</script>
@endif

@if($view == 'exam')
<script>
    var table = $('#exam_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('examTable', $tryout->id) }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'judul', name: 'judul'},
            {data:'id_user', name: 'id_user'},
            {data:'nis', name: 'nis'},
            {data:'school_id', name: 'school_id'},
            {data:'phone', name: 'phone'},
            {data:'id_kelas', name: 'id_kelas'},
            {data:'score', name: 'score'},
            {data:'target', name: 'target'},
            {data:'resume', name: 'resume'},
            {data:'created_at', name: 'created_at'},
            {data:'detail', name: 'detail', orderable:false, searchable:false}
        ]
    });
    
    
    function resetData(id) {
        var popup = confirm('Hapus / Reset data tryout ini..?');
        if(popup === true) {
            resetDataConfirm(id);
        }
    }
    
    function resetDataConfirm(id) {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ url('reset_tryout') }}",
            type: "POST",
            dataType: "JSON",
            data: {"id":id, "_token":csrf_token},
            success: function(data) {
                table.ajax.reload(null, false);
            }
        })
    }
    
    function listData(id){
        $("#loadingProgress").show();
        $.ajax({
            url : "{{ url('detail_exam') }}"+"/"+id,
            type : "GET",
            success : function(data) {
                console.log(data);
                $("#loadingProgress").hide();
                $(".modal-title").text('Show Detail');
                $("#modal-show-detail").modal("show");
                
                $("#content-text").html(data);
            }
        });
    }
    
    
</script>
@endif


@if($view == 'tryout-session')
<script>
    var table = $('#tryout_session_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('sessionTable') }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'judul', name: 'judul'},
            {data:'id_kelas', name: 'id_kelas'},
            {data:'is_active', name: 'is_active'},
            {data:'target_score', name: 'target_score'},
            {data:'freq', name: 'freq'},
            {data:'created_at', name: 'created_at'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });
    
    
    function listData(id) {
        window.location = "{{ url('session_detail') }}"+"/"+id;
    }
</script>
@endif


@if($view == 'materi')
<script>

    // $("#id_kelas").change(function(){
    //   var idKelas = $(this).val();
    //   $("#id_mapel").val("");
    //   $("#id_kategori").val("");
       
    // });
    
    // $("#id_mapel").change(function(){
    //   var idMapel = $(this).val();
    //   var idKelas = $("#id_kelas").val();
    //   var csrf_token = $('meta[name="csrf-token"]').attr('content');
    //   if(idKelas == '') {
    //       alert("Kelas Belum Dipilih...");
    //   } else {
    //       $.ajax({
    //           url : "{{ url('set_kategori_bimbingan') }}",
    //           type : "POST",
    //           dataType : "JSON",
    //           data : {'idKelas':idKelas, 'idMapel':idMapel, '_token': csrf_token},
    //           success : function(data) {
    //               console.log(data);
    //               var html = '';
    //               html += '<option value=""> - Pilih Kategori - </option>';
    //               for(var i=0; i<data.length; i++) {
    //                     html += '<option value="'+data[i].id+'">'+data[i].category_name+'</option>';     
    //               }
    //               $("#id_kategori").html(html);
                   
                   
    //           }
    //       })
    //   }
    // });
    
    
    $("#id_kelas").select2({closeOnSelect:false}).on('select2:selecting', function(e) {
          var cur = e.params.args.data.id;
          var old = (e.target.value == '') ? [cur] : $(e.target).val().concat([cur]);
          $(e.target).val(old).trigger('change');
          $(e.params.args.originalEvent.currentTarget).attr('aria-selected', 'true');
        return false;
    });
    
    
    $("#id_kategori").select2();
    
    $("#id_kategori").change(function(){
       var id = $(this).val();
       $.ajax({
          url : "{{ url('category_bimbel') }}"+"/"+id,
          type : "GET",
          success : function(data) {
              console.log(data);
              $("#id_mapel").html(data.mapel);
              $("#id_kelas").html(data.kelas);
          }
       });
    });
    
    
    var table = $('#materi_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('materiTable') }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'link_file', name: 'link_file'},
            {data:'judul', name: 'judul'},
            {data:'nama_kelas', name: 'nama_kelas'},
            {data:'mapel_name', name: 'mapel_name'},
            {data:'category_name', name: 'category_name'},
            {data:'is_active', name: 'is_active'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });


    function addData() {
        resetForm();
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Materi Pelajaran");
        $("#modal-add").modal("show");
    }
    
    
    function editData(id) {
        showLoading();
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
              url: "{{ url('materi') }}" +"/"+id+"/edit",
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  console.log(data);
                  hideLoading();
                  $('#modal-add').modal("show");
                  $('.modal-title').text("Edit Materi Pelajaran");
                  $('#id').val(data.data.id);
                  $("#judul").val(data.data.judul);
                  $("#link_file").val(data.data.link_file);
                  $("#is_active").val(data.data.is_active);
                  $("#id_kategori").val(data.data.id_kategori).trigger('change');
                  $("#id_mapel").html('<option value="'+data.mapel.id+'">'+data.mapel.mapel_name+'</option>');
                  $("#id_kelas").html(data.kelas);
                  
                  $.ajax({
                      url : "{{ url('kelas_materi_select') }}"+"/"+id,
                      type : "GET",
                      dataType: "JSON",
                      success : function(data) {
                          $("#id_kelas").val(data).trigger('change');
                      }
                  })
                                     
            }
        })
    }
    
    
    
    $("#form-simpan").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('materi') }}";
        else url = "{{ url('materi') .'/'}}"+ id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal-add form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('materi') }}" + '/'+id,
            type : "POST",
            data : {'_method':'DELETE', '_token':csrf_token},
            success : function($data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    
    function resetForm() {
        $("#judul").val("");
        $("#link_file").val("");
        $("#id_kelas").val("");
        $("#id_mapel").val("");
        $("#id_kategori").val("");
        $("#is_active").val("");
        
    }
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
    
</script>
@endif

@if($view == 'detail')
<script>
   
    var table = $('#detail_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('detailTable', $ids) }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'no_soal', name: 'no_soal'},
            {data:'soal', name: 'soal'},
            {data: 'jawaban_a', name: 'jawaban_a'},
            {data:'kunci_jawaban', name: 'kunci_jawaban'},
            {data:'score', name: 'score'},
            {data:'is_active', name: 'is_active'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });
    
    
    function addData() {
        resetForm();
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Quiz Detail");
        $("#modal-add").modal("show");
    }
    
    
    function editData(id) {
        showLoading();
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
              url: "{{ url('detail_edit') }}" +"/"+id,
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  console.log(data);
                  hideLoading();
                  $('#modal-add').modal("show");
                  $('.modal-title').text("Edit Detail Quiz");
                  $('#id').val(data.id);
                  $("#id_tryout").val(data.id_tryout);
                  $("#no_soal").val(data.no_soal);
                  $("#soal").val(data.soal);
                  $("#jawaban_a").val(data.jawaban_a);
                  $("#jawaban_b").val(data.jawaban_b);
                  $("#jawaban_c").val(data.jawaban_c);
                  $("#jawaban_d").val(data.jawaban_d);
                  $("#jawaban_e").val(data.jawaban_e);
                  $("#score").val(data.score);
                  $("#is_active").val(data.is_active);
                  $("#kunci_jawaban").val(data.kunci_jawaban);
                  
                                     
            }
        })
    }
    
    
    $("#form-simpan").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('detail_add') }}";
        else url = "{{ url('detail_update') .'/'}}"+ id;
        
        var form_data = new FormData($('#modal-add form')[0]);
        $.ajax({
          url : url,
          type : "POST",
          data : form_data,
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    
    function deleteImage(id, ind) {
        var hapus = confirm('Hapus Gambar Ini...?');
        if(hapus === true) {
            confirmHapusImage(id, ind);
        }
    }
    
    function confirmHapusImage(id, type) {
        showLoading();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url : "{{ url('delete_image') }}",
            type : "POST",
            dataType : "JSON",
            data : {'id':id, 'type': type, '_token': csrf_token},
            success : function(data) {
                hideLoading();
                table.ajax.reload(null, false);
                
            }
        })
    }
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('detail_delete') }}",
            type : "POST",
            data : {'id': id,'_token':csrf_token},
            success : function(data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    function deleteDataAll() {
        $("#modal-hapus-semua").modal("show");
    }
    
    function deleteAllDataConfirm() {
        var id = $("#id_hapus_semua").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('detail_delete_all') }}",
            type : "POST",
            data : {'id': id,'_token':csrf_token},
            success : function(data){
                table.ajax.reload(null, false);
                $("#modal-hapus-semua").modal("hide");
            }
        });
    }
    
    
    function resetForm() {
        $("#id").val("");
        $("#no_soal").val("");
        $("#gambar_soal").val(null);
        $("#soal").val("")
        $("#gambar_a").val(null);
        $("#jawaban_a").val("");
        $("#gambar_b").val(null);
        $("#jawaban_b").val("");
        $("#gambar_c").val(null);
        $("#jawaban_c").val("");
        $("#gambar_d").val(null);
        $("#jawaban_d").val("");
        $("#gambar_e").val(null);
        $("#jawaban_e").val("");
        $("#kunci_jawaban").val("");
        $("#score").val("");
        $("#is_active").val("");
    }
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
</script>
@endif


@if($view == 'tryout')
<script>
    $("#btn_filter").click(function(){
        table.ajax.reload(null, false); 
    });

    $('#btn_reset').click(function () {

        $('#filter_kelas').val('');
        $('#filter_subject').val('');
        $("#filter_status").val('');
        table.ajax.reload();
    });
    
    $('.my-colorpicker2').colorpicker();
    
    function listData(id) {
        window.location = "{{ url('tryout_detail') }}"+"/"+id;
    }
    
    // $("#id_kelas").select2();
    
    $("#id_kelas").select2({closeOnSelect:false}).on('select2:selecting', function(e) {
          var cur = e.params.args.data.id;
          var old = (e.target.value == '') ? [cur] : $(e.target).val().concat([cur]);
          $(e.target).val(old).trigger('change');
          $(e.params.args.originalEvent.currentTarget).attr('aria-selected', 'true');
        return false;
    });
    
    function copyData(id) {
        $("#dari").val(id);
        $("#modal-copy").modal("show");
        $(".modal-title").text("Copy Soal Quiz");
        $("#jenis").val("");
        $("#tujuan").html("");
    }
    
    
    $("#jenis").change(function(){
        var jenis = $(this).val();
        $.ajax({
            url: "{{ url('get_jenis_copy') }}"+"/"+jenis,
            type : "GET",
            dataType : "HTML",
            success : function(data){
                $("#tujuan").html(data);
            }
        })
    })
    
    
    $("#form-copy").submit(function(e){
        e.preventDefault();
        $("#loadingProgress").show();
        $.ajax({
            url : "{{ url('copy_tryout') }}",
            type : "POST",
            dataType : "JSON",
            data : $(this).serialize(),
            success : function(data) {
                console.log(data);
                $("#loadingProgress").hide();
                $("#modal-copy").modal("hide");
                table.ajax.reload(null, false);
                
             
            }
        })
    })
    
    
    var table = $('#tryout_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: {
            url: "{{ route('tryoutTable') }}",
            type: "GET",
            data: function (d) {
                d.kelas_id = $('#filter_kelas').val();
                d.subject_id = $('#filter_subject').val();
                d.status_id = $("#filter_status").val();
            }
        },
        order: [[ 1, "asc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'urutan', name: 'urutan', visible:false},
            {data:'action', name: 'action', orderable:false, searchable:false},
            {data:'judul', name: 'judul'},
            {data:'subject_id', name: 'subject_id'},
            {data:'nama_kelas', name: 'nama_kelas'},
            {data:'is_active', name: 'is_active'},
            {data:'is_repeated', name: 'is_repeated'},
            {data:'is_skipped', name: 'is_skipped'},
            {data:'time_limit', name: 'time_limit'},
            {data:'target_score', name: 'target_score'},
            {data:'jumlah_soal', name: 'jumlah_soal'},
          
        ]
    });


    function addData() {
        resetForm();
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Quiz");
        $("#modal-add").modal("show");
    }
    
    
    function editData(id) {
        showLoading();
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
              url: "{{ url('tryout') }}" +"/"+id+"/edit",
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  console.log(data);
                  hideLoading();
                  $('#modal-add').modal("show");
                  $('.modal-title').text("Edit Quiz");
                  $('#id').val(data.data.id);
                  $("#judul").val(data.data.judul);
                  $("#short_name").val(data.data.short_name);
                  $("#id_kelas").val(data.kelas).trigger('change');
                  $("#is_repeated").val(data.data.is_repeated);
                  $("#is_skipped").val(data.data.is_skipped);
                  $("#target_score").val(data.data.target_score);
                  $("#time_limit").val(data.data.time_limit);
                  $("#is_active").val(data.data.is_active);
                  $("#subject_id").val(data.data.subject_id);
                  
                  $("#warna_soal").val(data.data.warna_soal).trigger('change');
                  $("#warna_tulisan").val(data.data.warna_tulisan).trigger('change');
                  $("#warna_jawaban").val(data.data.warna_jawaban).trigger('change');
                  $("#warna_tulisan_jawaban").val(data.data.warna_tulisan_jawaban).trigger('change');
                  $("#urutan").val(data.data.urutan);
                                     
            }
        })
    }
    
    
    
    $("#form-simpan").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('tryout') }}";
        else url = "{{ url('tryout') .'/'}}"+ id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal-add form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('tryout') }}" + '/'+id,
            type : "POST",
            data : {'_method':'DELETE', '_token':csrf_token},
            success : function($data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    
    
    
    function resetForm() {
        $("#judul").val("");
        $("#id_kelas").val("");
        $("#target_score").val("");
        $("#time_limit").val("");
        $("#is_repeated").val("");
        $("#is_skipped").val("");
        $("#is_active").val("");
        $("#warna_soal").val("#ffffff").trigger('change');
        $("#warna_tulisan").val("#000000").trigger('change');
        $("#warna_jawaban").val("#ffffff").trigger('change');
        $("#warna_tulisan_jawaban").val("#000000").trigger('change');
        
    }
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
    
    
    
</script>
@endif


@if($view == 'bimbingan')
<script>
    
    // $("#id_kelas").change(function(){
    //   var idKelas = $(this).val();
    //   $("#id_mapel").val("");
    //   $("#id_kategori").val("");
       
    // });
    
    // $("#id_mapel").change(function(){
    //   var idMapel = $(this).val();
    //   var idKelas = $("#id_kelas").val();
    //   var csrf_token = $('meta[name="csrf-token"]').attr('content');
    //   if(idKelas == '') {
    //       alert("Kelas Belum Dipilih...");
    //   } else {
    //       $.ajax({
    //           url : "{{ url('set_kategori_bimbingan') }}",
    //           type : "POST",
    //           dataType : "JSON",
    //           data : {'idKelas':idKelas, 'idMapel':idMapel, '_token': csrf_token},
    //           success : function(data) {
    //               console.log(data);
    //               var html = '';
    //               html += '<option value=""> - Pilih Kategori - </option>';
    //               for(var i=0; i<data.length; i++) {
    //                     html += '<option value="'+data[i].id+'">'+data[i].category_name+'</option>';     
    //               }
    //               $("#id_kategori").html(html);
                   
                   
    //           }
    //       })
    //   }
    // });
    
    
    $("#id_kelas").select2({closeOnSelect:false}).on('select2:selecting', function(e) {
          var cur = e.params.args.data.id;
          var old = (e.target.value == '') ? [cur] : $(e.target).val().concat([cur]);
          $(e.target).val(old).trigger('change');
          $(e.params.args.originalEvent.currentTarget).attr('aria-selected', 'true');
        return false;
    });
    
    
    $("#id_kategori").select2();
    
    
    $("#id_kategori").change(function(){
       var id = $(this).val();
       $.ajax({
          url : "{{ url('category_bimbel') }}"+"/"+id,
          type : "GET",
          success : function(data) {
              console.log(data);
              $("#id_mapel").html(data.mapel);
              $("#id_kelas").html(data.kelas);
          }
       });
    });

    var table = $('#bimbingan_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('bimbinganTable') }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'action2', name: 'action2', orderable:false, searchable:false},
            {data:'id', name: 'id'},
            {data:'link_video', name: 'link_video'},
            {data:'judul', name: 'judul'},
            {data:'nama_kelas', name: 'nama_kelas'},
            {data:'mapel_name', name: 'mapel_name'},
            {data:'category_name', name: 'category_name'},
            {data:'is_active', name: 'is_active'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });


    function addData() {
        resetForm();
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Bimbingan");
        $("#modal-add").modal("show");
    }
    
    
    function editData(id) {
        showLoading();
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
              url: "{{ url('bimbingan') }}" +"/"+id+"/edit",
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  console.log(data);
                  hideLoading();
                  $('#modal-add').modal("show");
                  $('.modal-title').text("Edit Bimbingan");
                  $('#id').val(data.data.id);
                  $("#judul").val(data.data.judul);
                  $("#link_video").val(data.data.link_video);
                  $("#is_active").val(data.data.is_active);
                  $("#id_kategori").val(data.data.id_kategori).trigger('change');
                  
                  $("#id_mapel").html('<option value="'+data.mapel.id+'">'+data.mapel.mapel_name+'</option>');
                  $("#id_kelas").html(data.kelas);
                  $.ajax({
                      url : "{{ url('kelas_select_bimbingan') }}"+"/"+id,
                      type : "GET",
                      dataType : "JSON",
                      success : function(data) {
                          $("#id_kelas").val(data).trigger('change');
                      }
                  })
                  
                  
                  
                                     
            }
        })
    }
    
    
    
    $("#form-simpan").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('bimbingan') }}";
        else url = "{{ url('bimbingan') .'/'}}"+ id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal-add form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('bimbingan') }}" + '/'+id,
            type : "POST",
            data : {'_method':'DELETE', '_token':csrf_token},
            success : function($data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    
    function resetForm() {
        $("#judul").val("");
        $("#link_video").val("");
        $("#id_kelas").val("");
        $("#id_mapel").val("");
        $("#id_kategori").val("");
        $("#is_active").val("");
        
    }
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
    
</script>
@endif

@if($view == 'kategori')
<script>
    $("#id_kelas").select2({closeOnSelect:false}).on('select2:selecting', function(e) {
          var cur = e.params.args.data.id;
          var old = (e.target.value == '') ? [cur] : $(e.target).val().concat([cur]);
          $(e.target).val(old).trigger('change');
          $(e.params.args.originalEvent.currentTarget).attr('aria-selected', 'true');
        return false;
    });
    
    $("#id_mapel").select2();
    
    $("#id_mapel").change(function(){
       var idMapel = $(this).val();
       $.ajax({
           url : "{{ url('get_kelas_by_mapel') }}"+"/"+idMapel,
           type : "GET",
           success : function(data) {
              $("#id_kelas").html(data);        
           }
       })
       
    });

    var table = $('#category_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('kategoriTable') }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'category_image', name: 'category_image'},
            {data:'category_name', name: 'category_name'},
            {data:'nama_kelas', name: 'nama_kelas'},
            {data:'mapel_name', name: 'mapel_name'},
            {data:'is_active', name: 'is_active'},
            {data:'urutan', name: 'urutan'},
            {data:'created_at', name: 'created_at'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });


    function addData() {
        resetForm();
        $("#category_image").attr("required", true);
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Category");
        $("#modal-add").modal("show");
    }
    
    
    function editData(id) {
        showLoading();
        $("#category_image").removeAttr("required");
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
              url: "{{ url('kategori') }}" +"/"+id+"/edit",
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  hideLoading();
                  $('#modal-add').modal("show");
                  $('.modal-title').text("Edit Category");
                  $('#id').val(data.data.id);
                  $("#category_name").val(data.data.category_name);
                  $("#id_mapel").val(data.data.id_mapel).trigger('change');
                  $("#is_active").val(data.data.is_active);
                  $("#urutan").val(data.data.urutan);
                  $("#id_kelas").html(data.kelas);
                  $.ajax({
                      url : "{{ url('kategori_kelas') }}"+"/"+id,
                      type: "GET",
                      dataType : "JSON",
                      success : function(data) {
                          $("#id_kelas").val(data).trigger('change');
                      }
                  })
                                     
            }
        })
    }
    
    
    
    
    
    $("#form-simpan").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('kategori') }}";
        else url = "{{ url('kategori') .'/'}}"+ id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal-add form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('kategori') }}" + '/'+id,
            type : "POST",
            data : {'_method':'DELETE', '_token':csrf_token},
            success : function($data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    
    function resetForm() {
        $("#category_image").val(null);
        $("#category_name").val("");
        $("#id_kelas").html("");
        $("#id_mapel").val("");
        $("#is_active").val("");
        $("#urutan").val("");
        
    }
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
    
</script>
@endif


@if($view == 'mapel')
<script>
    $("#id_kelas").select2({closeOnSelect:false}).on('select2:selecting', function(e) {
          var cur = e.params.args.data.id;
          var old = (e.target.value == '') ? [cur] : $(e.target).val().concat([cur]);
          $(e.target).val(old).trigger('change');
          $(e.params.args.originalEvent.currentTarget).attr('aria-selected', 'true');
        return false;
    });
    
    var table = $('#mapel_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('mapelTable') }}",
        order: [[ 5, "asc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'mapel_image', name: 'mapel_image'},
            {data:'mapel_name', name: 'mapel_name'},
            {data:'id_kelas', name: 'id_kelas'},
            {data:'is_active', name: 'is_active'},
            {data:'urutan', name: 'urutan'},
            {data:'created_at', name: 'created_at'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });


    function addData() {
        resetForm();
        $("#mapel_image").attr("required", true);
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Mapel");
        $("#modal-add").modal("show");
    }
    
    
    function editData(id) {
        showLoading();
        $("#mapel_image").removeAttr("required");
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
              url: "{{ url('mapel') }}" +"/"+id+"/edit",
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  hideLoading();
                  $('#modal-add').modal("show");
                  $('.modal-title').text("Edit Mapel");
                  $('#id').val(data.data.id);
                  $("#mapel_name").val(data.data.mapel_name);
                  $("#is_active").val(data.data.is_active);
                  $("#id_kelas").val(data.kelas).trigger("change");
                  $("#urutan").val(data.data.urutan);
                                     
            }
        })
    }
    
    
    
    $("#form-simpan").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('mapel') }}";
        else url = "{{ url('mapel') .'/'}}"+ id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal-add form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('mapel') }}" + '/'+id,
            type : "POST",
            data : {'_method':'DELETE', '_token':csrf_token},
            success : function($data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    
    function resetForm() {
        $("#mapel_image").val(null);
        $("#mapel_name").val("");
        $("#is_active").val("");
        $("#urutan").val("");
    }
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
    
</script>
@endif


@if($view == 'subject')
<script>
    
    var table = $('#subject_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('subject.table') }}",
        order: [[ 3, "asc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'image', name: 'image'},
            {data:'subject_name', name: 'subject_name'},
            {data:'urutan', name: 'urutan'},
            {data:'is_active', name: 'is_active'},
            {data:'created_at', name: 'created_at'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });


    function addData() {
        resetForm();
        $("#image").attr("required", true);
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Subject Data");
        
        generateUrutan();
    }
    
    function generateUrutan() {
        $.ajax({
           url: "{{ route('generate.urutan') }}",
           type: "GET",
           dataType: "JSON",
           success:function(data) {
               $("#urutan").val(data);
               $("#modal-add").modal("show");
           }
        });
    }
    
    
    function editData(id) {
        showLoading();
        $("#image").removeAttr("required");
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
              url: "{{ url('subject') }}" +"/"+id+"/edit",
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  hideLoading();
                  $('#modal-add').modal("show");
                  $('.modal-title').text("Edit Subject Data");
                  $('#id').val(data.id);
                  $("#subject_name").val(data.subject_name);
                  $("#is_active").val(data.is_active);
                  $("#urutan").val(data.urutan);
                                     
            }
        })
    }
    
    
    
    $("#form-simpan").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('subject') }}";
        else url = "{{ url('subject') .'/'}}"+ id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal-add form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('subject') }}" + '/'+id,
            type : "POST",
            data : {'_method':'DELETE', '_token':csrf_token},
            success : function($data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    
    function resetForm() {
        $("#image").val(null);
        $("#subject_name").val("");
        $("#is_active").val("");
        
    }
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
    
</script>
@endif

@if($view == 'kelas')
<script>
    var table = $('#kelas_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('kelasTable') }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'nama_kelas', name: 'nama_kelas'},
            {data:'tingkat_id', name: 'tingkat_id'},
            {data:'created_at', name: 'created_at'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });


    function addData() {
        resetForm();
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Kelas");
        $("#modal-add").modal("show");
    }
    
    
    function editData(id) {
        showLoading();
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
              url: "{{ url('kelas') }}" +"/"+id+"/edit",
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  hideLoading();
                  $('#modal-add').modal("show");
                  $('.modal-title').text("Edit Kelas");
                  $('#id').val(data.id);
                  $("#nama_kelas").val(data.nama_kelas);
                  $("#tingkat_id").val(data.tingkat_id);
                                     
            }
        })
    }
    
    
    
    $("#form-simpan").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('kelas') }}";
        else url = "{{ url('kelas') .'/'}}"+ id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal-add form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('kelas') }}" + '/'+id,
            type : "POST",
            data : {'_method':'DELETE', '_token':csrf_token},
            success : function($data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    
    function resetForm() {
        $("#nama_kelas").val("");
         $("#tingkat_id").val("");
        
    }
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
    
</script>
@endif

@if($view == 'news')
<script>
    var table = $('#news_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('newsTable') }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'news_title', name: 'news_title'},
            {data:'news_image', name: 'news_image'},
            {data:'news_content', name: 'news_content'},
            {data:'is_active', name: 'is_active'},
            {data:'created_at', name: 'created_at'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });


    function addData() {
        resetForm();
        $("#news_image").attr("required", true);
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add News");
        $("#modal-add").modal("show");
    }
    
    
    function editData(id) {
        showLoading();
        $("#news_image").removeAttr("required");
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
              url: "{{ url('news') }}" +"/"+id+"/edit",
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  hideLoading();
                  $('#modal-add').modal("show");
                  $('.modal-title').text("Edit News");
                  $('#id').val(data.id);
                  $("#news_title").val(data.news_title);
                  $("#news_content").val(data.news_content);
                  $("#is_active").val(data.is_active);
                                     
            }
        })
    }
    
    
    
    $("#form-simpan").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('news') }}";
        else url = "{{ url('news') .'/'}}"+ id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal-add form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('news') }}" + '/'+id,
            type : "POST",
            data : {'_method':'DELETE', '_token':csrf_token},
            success : function($data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    
    function resetForm() {
        $("#promo_title").val("");
        $("#promo_image").val(null);
        $("#promo_content").val("");
        $("#is_active").val("");
    }
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
    
</script>
@endif

@if($view == 'tingkat')
<script>
    var table = $('#tingkat_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('tingkat.table') }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'name', name: 'name'},
            {data:'description', name: 'description'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });


    function addData() {
        resetForm();
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Tingkat");
        $("#modal-add").modal("show");
    }
    
    
    function editData(id) {
        showLoading();
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
              url: "{{ url('tingkat') }}" +"/"+id+"/edit",
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  hideLoading();
                  $('#modal-add').modal("show");
                  $('.modal-title').text("Edit Tingkat");
                  $('#id').val(data.id);
                  $("#name").val(data.name);
                  $("#description").val(data.description);
                                      
            }
        })
    }
    
    
    
    $("#form-simpan").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('tingkat') }}";
        else url = "{{ url('tingkat') .'/'}}"+ id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal-add form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('tingkat') }}" + '/'+id,
            type : "POST",
            data : {'_method':'DELETE', '_token':csrf_token},
            success : function($data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    
    function resetForm() {
        $("#name").val("");
        $("#description").val("");
        
    }
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
    
</script>
@endif


@if($view == 'location')
<script>

    function generate(id) {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ url('generate_location_code') }}",
            type: "POST",
            dataType: "JSON",
            data: {"id":id, "_token":csrf_token},
            success: function(data) {
                table.ajax.reload(null, false);
            }
        }) 
    }
    
    
    var table = $('#location_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('location.table') }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'name', name: 'name'},
            {data:'qrcode', name: 'qrcode'},
            {data:'description', name: 'description'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });


    function addData() {
        resetForm();
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Location");
        $("#modal-add").modal("show");
    }
    
    
    function editData(id) {
        showLoading();
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
              url: "{{ url('location') }}" +"/"+id+"/edit",
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  hideLoading();
                  $('#modal-add').modal("show");
                  $('.modal-title').text("Edit Location");
                  $('#id').val(data.id);
                  $("#name").val(data.name);
                  $("#description").val(data.description);
                                      
            }
        })
    }
    
    
    
    $("#form-simpan").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('location') }}";
        else url = "{{ url('location') .'/'}}"+ id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal-add form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('location') }}" + '/'+id,
            type : "POST",
            data : {'_method':'DELETE', '_token':csrf_token},
            success : function($data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    
    function resetForm() {
        $("#name").val("");
        $("#description").val("");
        
    }
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
    
</script>
@endif


@if($view == 'dashboard_menu_setting')
<script>
    var table = $('#table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('dashboard.menu.setting.table') }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'name', name: 'name'},
            {data:'display_text', name: 'display_text'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });


    function addData() {
        resetForm();
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Location");
        $("#modal-add").modal("show");
    }
    
    
    function editData(id) {
        showLoading();
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
              url: "{{ url('dashboard_menu_setting') }}" +"/"+id+"/edit",
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  hideLoading();
                  $('#modal-add').modal("show");
                  $('.modal-title').text("Edit Dashboard Menu Setting");
                  $('#id').val(data.id);
                  $("#name").val(data.name);
                  $("#slug").val(data.slug);
                  $("#display_text").val(data.display_text);
                                      
            }
        })
    }
    
    
    
    $("#form-simpan").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('dashboard_menu_setting') }}";
        else url = "{{ url('dashboard_menu_setting') .'/'}}"+ id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal-add form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('location') }}" + '/'+id,
            type : "POST",
            data : {'_method':'DELETE', '_token':csrf_token},
            success : function($data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    
    function resetForm() {
        $("#name").val("");
        $("#description").val("");
        
    }
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
    
</script>
@endif



@if($view == 'promo')
<script>
    var table = $('#promo_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('promoTable') }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'promo_title', name: 'promo_title'},
            {data:'promo_image', name: 'promo_image'},
            {data:'promo_content', name: 'promo_content'},
            {data:'is_active', name: 'is_active'},
            {data:'created_at', name: 'created_at'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });
    
    function addData() {
        resetForm();
        $("#promo_image").attr("required", true);
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Promo");
        $("#modal-add").modal("show");
    }
    
    
    function editData(id) {
        showLoading();
        $("#promo_image").removeAttr("required");
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
              url: "{{ url('promo') }}" +"/"+id+"/edit",
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  hideLoading();
                  $('#modal-add').modal("show");
                  $('.modal-title').text("Edit Promo");
                  $('#id').val(data.id);
                  $("#promo_title").val(data.promo_title);
                  $("#promo_content").val(data.promo_content);
                  $("#is_active").val(data.is_active);
                                     
            }
        })
    }
    
    
    
    $("#form-simpan").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('promo') }}";
        else url = "{{ url('promo') .'/'}}"+ id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal-add form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('promo') }}" + '/'+id,
            type : "POST",
            data : {'_method':'DELETE', '_token':csrf_token},
            success : function($data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    
    function resetForm() {
        $("#promo_title").val("");
        $("#promo_image").val(null);
        $("#promo_content").val("");
        $("#is_active").val("");
    }
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
    
</script>
@endif

@if($view == 'information')
<script>
    var table = $('#information_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('informationTable') }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'information_title', name: 'information_title'},
            {data:'information_image', name: 'information_image'},
            {data:'information_content', name: 'information_content'},
            {data:'is_active', name: 'is_active'},
            {data:'created_at', name: 'created_at'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });
    
    function addData() {
        resetForm();
        $("#information_image").attr("required", true);
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Information");
        $("#modal-add").modal("show");
    }
    
    
    function editData(id) {
        showLoading();
        $("#information_image").removeAttr("required");
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
              url: "{{ url('information') }}" +"/"+id+"/edit",
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  hideLoading();
                  $('#modal-add').modal("show");
                  $('.modal-title').text("Edit Information");
                  $('#id').val(data.id);
                  $("#information_title").val(data.information_title);
                  $("#information_content").val(data.information_content);
                  $("#is_active").val(data.is_active);
                                     
            }
        })
    }
    
    
    
    $("#form-information").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('information') }}";
        else url = "{{ url('information') .'/'}}"+ id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal-add form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('information') }}" + '/'+id,
            type : "POST",
            data : {'_method':'DELETE', '_token':csrf_token},
            success : function($data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    
    function resetForm() {
        $("#information_title").val("");
        $("#information_image").val(null);
        $("#information_content").val("");
        $("#is_active").val("");
    }
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
    
</script>
@endif

@if($view == 'ref')
<script>

     $("#id_kelas").select2();
     var table = $('#ref_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('refTable') }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'ref_image', name: 'ref_image'},
            {data:'ref_url', name: 'ref_url'},
            {data:'ref_title', name: 'ref_title'},
            {data:'id_kelas', name: 'id_kelas'},
            {data:'is_active', name: 'is_active'},
            {data:'created_at', name: 'created_at'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });
    
    
     function addData() {
        resetForm();
        $("#ref_image").attr("required", true);
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Reference");
        $("#modal-add").modal("show");
    }
    
    
    function editData(id) {
        showLoading();
        $("#ref_image").removeAttr("required");
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
              url: "{{ url('ref') }}" +"/"+id+"/edit",
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  hideLoading();
                  $('#modal-add').modal("show");
                  $('.modal-title').text("Edit Reference");
                  $('#id').val(data.data.id);
                  $("#ref_title").val(data.data.ref_title);
                  $("#ref_url").val(data.data.ref_url);
                  $("#id_kelas").val(data.kelas).trigger('change');
                  $("#is_active").val(data.data.is_active);
                                     
            }
        })
    }
    
    
    
    $("#form-add").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('ref') }}";
        else url = "{{ url('ref') .'/'}}"+ id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal-add form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('ref') }}" + '/'+id,
            type : "POST",
            data : {'_method':'DELETE', '_token':csrf_token},
            success : function($data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    
    function resetForm() {
        $("#ref_image").val(null);
        $("#id_kelas").val("").trigger('change');
        $("#ref_title").val("");
        $("#ref_url").val("");
        $("#is_active").val("");
    }
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
</script>
@endif

@if($view == 'slider')
<script>
    var table = $('#slider_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('sliderTable') }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'slider_image', name: 'slider_image'},
            {data:'slider_description', name: 'slider_description'},
            {data:'is_active', name: 'is_active'},
            {data:'created_at', name: 'created_at'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });
    
    function addData() {
        resetForm();
        $("#slider_image").attr("required", true);
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Slider");
        $("#modal-add-slider").modal("show");
    }
    
    
    function editData(id) {
        showLoading();
        $("#slider_image").removeAttr("required");
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add-slider form')[0].reset();
        $.ajax({
              url: "{{ url('slider') }}" +"/"+id+"/edit",
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  hideLoading();
                  $('#modal-add-slider').modal("show");
                  $('.modal-title').text("Edit Slider");
                  $('#id').val(data.id);
                  $("#slider_description").val(data.slider_description);
                  $("#is_active").val(data.is_active);
                                     
            }
        })
    }
    
    
    
    $("#form-slider").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('slider') }}";
        else url = "{{ url('slider') .'/'}}"+ id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal-add-slider form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add-slider').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('slider') }}" + '/'+id,
            type : "POST",
            data : {'_method':'DELETE', '_token':csrf_token},
            success : function($data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    
    function resetForm() {
        $("#slider_image").val(null);
        $("#slider_description").val("");
        $("#is_active").val("");
    }
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
    
</script>
@endif

@if($view == 'main-menu')
<script>

    var tingkatOptions = `
        <option value="">-- Pilih Tingkat --</option>
        <?php foreach($tingkats as $tingkat): ?>
            <option value="<?= $tingkat['id'] ?>"><?= $tingkat['name'] ?></option>
        <?php endforeach; ?>
    `;
    
    
    
    function add_row(menu_id) {
        let tableId = '#table-items-' + menu_id;
        let tbody = $(tableId + ' tbody');

        let newRow = `
            <tr>
                <td></td>
                <td><input type="text" name="link[]" class="form-control" placeholder="Link"></td>
                <td>
                    <select name="tingkat[]" class="form-control">
                        ${tingkatOptions}
                    </select>
                </td>
                <td>
                   
                    <i class="fa fa-remove btn btn-danger" style="margin-left:5px;" onclick="remove_row(this, '${tableId}')"></i>
                </td>
            </tr>
        `;

        tbody.append(newRow);
        update_row_numbers(tableId);
    }

    function remove_row(el, tableId) {
        $(el).closest('tr').remove();
        update_row_numbers(tableId);
    }

    function update_row_numbers(tableId) {
        $(tableId + ' tbody tr').each(function(index) {
            $(this).find('td:first').text(index + 1);
        });
    }

     function save_items(menu_id) {
        let tableId = '#table-items-' + menu_id;
        let data = [];

        $(tableId + ' tbody tr').each(function() {
            let link = $(this).find('input[name="link[]"]').val();
            let tingkat = $(this).find('select[name="tingkat[]"]').val();

            if (link && tingkat) {
                data.push({
                    link: link,
                    tingkat_id: tingkat
                });
            }
        });

        if (data.length === 0) {
            alert("Isi minimal satu baris dengan lengkap.");
            return;
        }

        $.ajax({
            url: "{{ route('simpan.item') }}", // sesuaikan dengan route-mu
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // jika pakai Laravel
                menu_id: menu_id,
                items: data
            },
            success: function(response) {
                alert("Data berhasil disimpan!");
                location.reload(); // <-- reload halaman
                // optionally reload data / clear table
            },
            error: function(xhr) {
                alert("Gagal menyimpan data");
                console.error(xhr.responseText);
            }
        });
    }
    
    function delete_row(item_id, el, tableId) {
    if (!confirm('Yakin ingin menghapus data ini?')) return;

        $.ajax({
            url: "{{ url('delete_items') }}" +"/"+ item_id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                alert('Data berhasil dihapus!');
                $(el).closest('tr').remove(); // hapus baris dari DOM
                update_row_numbers(tableId); // update nomor baris
            },
            error: function(err) {
                alert('Gagal menghapus data!');
                console.error(err.responseText);
            }
        });
    }    

    var table = $('#icon_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('iconTable') }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'icon_image', name: 'icon_image'},
            {data:'name', name: 'name'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });
    
    
    function editData(id) {
        showLoading();
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
              url: "{{ url('icon') }}" +"/"+id+"/edit",
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  hideLoading();
                  $('#modal-add').modal("show");
                  $('.modal-title').text("Edit Icon Menu");
                  $('#id').val(data.id);
                  $("#name").val(data.name);
                
            }
        })
    }
    
    
    
    $("#form-save").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('icon') }}";
        else url = "{{ url('icon') .'/'}}"+ id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal-add form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
    
</script>
@endif

@if($view == 'contact')
<script>
    var table = $('#contact_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('contactTable', $ids) }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'name', name: 'name'},
            {data:'phone_number', name: 'phone_number'},
           
        ]
    });
</script>

@endif


@if($view == 'school')
<script>
    var table = $('#school_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('schoolTable') }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'school_name', name: 'school_name'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });
    
    function addData() {
        resetForm();
        
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add School Data");
        $("#modal-add").modal("show");
    }
    
    
    function editData(id) {
        showLoading();
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
              url: "{{ url('school') }}" +"/"+id+"/edit",
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  hideLoading();
                  $('#modal-add').modal("show");
                  $('.modal-title').text("Edit School Data");
                  $('#id').val(data.id);
                  $("#school_name").val(data.school_name);
                  
                                     
            }
        })
    }
    
    
    
    $("#form-save").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('school') }}";
        else url = "{{ url('school') .'/'}}"+ id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal-add form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('school') }}" + '/'+id,
            type : "POST",
            data : {'_method':'DELETE', '_token':csrf_token},
            success : function($data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    
    function resetForm() {
        $("#school_name").val("");
    }
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
    
</script>
@endif


@if($view == 'jadwal')
<script>

   
    
    var table = $('#jadwal_table').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing:true,
        serverSide:true,
        ajax: "{{ route('jadwal.table') }}",
        order: [[ 0, "desc" ]],
        columns: [
            {data:'id', name: 'id'},
            {data:'name', name: 'name'},
            {data:'jam_masuk', name: 'jam_masuk'},
            {data:'jam_pulang', name: 'jam_pulang'},
            {data:'is_active', name: 'is_active'},
            {data:'action', name: 'action', orderable:false, searchable:false}
        ]
    });


    function addData() {
        resetForm();
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Tambah Jadwal");
        $("#modal-add").modal("show");
    }
    
    
    function editData(id) {
        showLoading();
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $('#modal-add form')[0].reset();
        $.ajax({
              url: "{{ url('jadwal') }}" +"/"+id+"/edit",
              type :"GET",
              dataType : "JSON",
              success:function(data){
                  hideLoading();
                  $('#modal-add').modal("show");
                  $('.modal-title').text("Edit Jadwal");
                  $('#id').val(data.id);
                  $("#name").val(data.name);
                  $("#jam_masuk").val(data.jam_masuk);
                  $("#jam_pulang").val(data.jam_pulang);
                  $("#is_active").val(data.is_active);
                                      
            }
        })
    }
    
    
    
    $("#form-simpan").submit(function(e){
        $("#loadingProgress").show();
        e.preventDefault();
        var id = $('#id').val();
        if(save_method == "add")  url = "{{ url('jadwal') }}";
        else url = "{{ url('jadwal') .'/'}}"+ id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($('#modal-add form')[0]),
          contentType:false,
          processData:false,
          success : function(data){
            if(data.success == true){
              $('#modal-add').modal('hide');
              table.ajax.reload(null, false);
              $("#loadingProgress").hide();
             
            }
          }

        });
    });
    
    
    function deleteData(id) {
        $("#id_hapus").val(id);
        $("#modal-hapus").modal("show");
    }
    
    function deleteDataConfirm(){
        var id = $("#id_hapus").val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url  : "{{ url('jadwal') }}" + '/'+id,
            type : "POST",
            data : {'_method':'DELETE', '_token':csrf_token},
            success : function($data){
                table.ajax.reload(null, false);
                $("#modal-hapus").modal("hide");
            }
        });
    }
    
    
    function resetForm() {
        $("#name").val("");
        $("#jam_masuk").val("");
        $("#jam_pulang").val("");
        $("#is_active").val("");
        
    }
    
    function showLoading() {
        $("#loadingProgress").show();
    }
    
    
    function hideLoading() {
        $("#loadingProgress").hide();
    }
    
    
</script>
@endif


</body>
</html>
