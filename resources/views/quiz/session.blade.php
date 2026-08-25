 
 @extends('master')
 @section('content')
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Quiz Session Implementation
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('default') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Quiz</a></li>
        <li><a href="{{ url('exquiz') }}">Session</a></li>
        <li class="active">Quiz Session Implementation</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Quiz Session Implementation </h3>
              
               
            </div>
            <div class="box-body">
                <div class="row" style="margin-top:10px;">
                  <div class="col-md-2">
                      <div class="form-group">
                          <label>Tanggal Awal:</label>
                          <input type="date" id="tanggal_awal" class="form-control">
                      </div>
                      
                         
                  </div>
                  <div class="col-md-2">
                      
                      <div class="form-group">
                          <label>Tanggal Akhir:</label>
                          <input type="date" id="tanggal_akhir" class="form-control">
                      </div>
                  </div>
                  <div class="col-md-2">
                      <button style="margin-top:26px;" onclick="count_records()" class="btn btn-warning btn-sm">Count Records</button>
                     
                  </div>
                  <div class="col-md-2">
                      <div class="form-group">
                          <label>First Record:</label>
                          <input type="number" id="start_record" class="form-control">
                      </div>
                   </div>
                   <div class="col-md-2">
                      <div class="form-group">
                          <label>Last Record:</label>
                          <input type="number" id="last_record" class="form-control">
                      </div>
                  </div>
                  <div class="col-md-2">
                       <button style="margin-top:26px;" onclick="tampilkan_laporan_session()" class="btn btn-info btn-sm">Tampilkan</button>
                  </div>
                  
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="margin-top:10px">
              <table style="font-size:12px;" id="sessquiz_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="5%">ID</th>
                  <th width="*">Judul</th>
                  <th width="15%">Siswa</th>
                  <th width="8%">NIS</th>
                  <th width="12%">Sekolah</th>
                  <th width="10%">Telp</th>
                  <th width="10%">Kelas</th>
                  <th width="10%">Target</th>
                  <th width="10%">Score</th>
                  <th width="10%">Time</th>
                  <th width="10%">Resume</th>
                  <th width="10%">Date</th>
                  <th width="10%">Detail</th>
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
    @include('modal.modal_hapus')
    @include('modal.modal_hapus_session')
  </div>
  @endsection