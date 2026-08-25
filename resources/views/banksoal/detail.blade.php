 
 @extends('master')
 @section('content')
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Bank Soal Details
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('default') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Bank Soal</a></li>
        <li><a href="{{ url('banksoal') }}">Bank Soal</a></li>
        <li class="active">Bank Soal Detail</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">{{ $banksoal->judul }}</h3>
              <button onclick="addData()" style="float:right;" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add</button><button onclick="deleteDataAll()" style="float:right;margin-right:80px;" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete All</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="margin-top:10px">
              <div class="table-responsive">    
              <table id="bank_soal_detail_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="5%">ID</th>
                  <th width="8%">No Soal</th>
                  <th width="25%">Soal</th>
                  <th width="20%">Jawaban</th>
                  <th width="10%">Kunci </th>
                  <th width="10%">Score</th>
                  <th width="10%">Link</th>
                  <th width="10%">Is Active</th>
                  <th width="*">Action</th>
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
    @include('modal.modal_add_banksoal_detail')
    @include('modal.modal_hapus')
    @include('modal.modal_hapus_semua')
  </div>
  @endsection