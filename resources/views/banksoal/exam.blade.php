 
 @extends('master')
 @section('content')
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Bank Soal Implementation
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('default') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Try Out</a></li>
        <li><a href="{{ url('banksession') }}">Bank Soal Session</a></li>
        <li class="active">{{ $banksoal->judul }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">{{ $banksoal->judul }}</h3>
             
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="margin-top:10px">
              <table style="font-size:13px;" id="banksoal_exam_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="5%">ID</th>
                  <th width="*">Judul</th>
                  <th width="12%">Siswa</th>
                  <th width="12%">Lokasi</th>
                  <th width="8%">NIS</th>
                  <th width="12%">Sekolah</th>
                  <th width="10%">Telp</th>
                  <th width="10%">Kelas</th>
                  <th width="10%">Score</th>
                  <th width="10%">Target</th>
                  <th width="10%">Waktu</th>
                  <th width="10%">Resume</th>
                  <th width="10%">Date</th>
                  <th width="6%">Detail</th>
                </tr>
                </thead>
                <tbody></tbody>
                
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    @include('modal.modal_show_detail')
  </div>
  @endsection