 
 @extends('master')
 @section('content')
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reference Management
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('default') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Home Maintenance</a></li>
        <li class="active">Reference</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Reference</h3>
              <button onclick="addData()" style="float:right;" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="margin-top:10px">
              <table id="ref_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="5%">ID</th>
                  <th width="10%">Ref Image</th>
                  <th width="*">URL</th>
                  <th width="10%">Title</th>
                  <th width="10%">Kelas</th>
                  <th width="10%">Status</th>
                  <th width="15%">Date</th>
                  <th width="15%">Action</th>
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
    @include('modal.modal_add_ref')
    @include('modal.modal_hapus')
  </div>
  @endsection