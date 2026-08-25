 
 @extends('master')
 @section('content')
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Quiz Management
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('default') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Quiz</a></li>
        <li class="active">Quiz</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Quiz</h3>
              <button onclick="addData()" style="float:right;" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="margin-top:10px">
              <div class="table-responsive">
              <table style="font-size:12px;" id="quiz_header_table" class="table table-bordered table-striped nowrap">
                <thead>
                <tr>
                  <th width="5%">ID</th>
                  <th width="12%">Kelas</th>
                  <th width="*">Keterangan</th>
                  <th width="12%">Jumlah Soal</th>
                  <th width="12%">Waktu</th>
                  <th width="12%">Target</th>
                   <th width="8%">Status</th>
                   <th width="8%">Urutan</th>
                  <th width="10%">Created_at</th>
                  <th width="12%">Action</th>
                </tr>
                </thead>
                <tbody></tbody>
                
              </table>
              </div>
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
    @include('modal.modal_add_quiz_header')
    @include('modal.modal_copy_quiz_header')
    @include('modal.modal_hapus')
  </div>
  @endsection