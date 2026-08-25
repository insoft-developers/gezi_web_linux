 
 @extends('master')
 @section('content')
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Video Pembelajaran Management
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('default') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Bimbingan Belajar</a></li>
        <li class="active">Video Pembelajaran</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Video Pembelajaran</h3>
              <button onclick="addData()" style="float:right;" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="margin-top:10px">
              <div class="table-responsive">
              <table style="font-size:13px;" id="bimbingan_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="12%">Action</th>
                  <th width="5%">ID</th>
                  <th width="17%">Link</th>
                  <th width="*">Title</th>
                  <th width="15%">Kelas</th>
                  <th width="12%">Mapel</th>
                  <th width="12%">Category</th>
                  <th width="20%">Note</th>
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
    @include('modal.modal_add_bimbingan')
    @include('modal.modal_hapus')
  </div>
  @endsection