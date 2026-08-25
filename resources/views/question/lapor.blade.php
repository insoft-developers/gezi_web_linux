 
 @extends('master')
 @section('content')
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        List Laporan Soal
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('default') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Tanya Soal</a></li>
        <li class="active">Laporan Soal</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Laporan Soal</h3>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="margin-top:10px">
              <table id="lapor_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="5%">ID</th>
                  <th width="12%">Nama Siswa</th>
                  <th width="12%">Kelas</th>
                  <th width="*">Soal</th>
                  <th width="12%">Jenis</th>
                  <th width="10%">Status</th>
                  <th width="10%">Date</th>
                  <th width="12%">Action</th>
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
    @include('modal.modal_finish')
    @include('modal.modal_outstanding')

  </div>
  @endsection