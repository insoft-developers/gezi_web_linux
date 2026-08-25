 
 @extends('master')
 @section('content')
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Contact Management
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('default') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Siswa Management</a></li>
        <li><a href="{{ url('siswa') }}">Data Siswa</a></li>
        <li class="active">Contact Management</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Contact Management</h3>
              <button onclick="addData()" style="float:right;" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="margin-top:10px">
              <div class="table-responsive">
              <table style="font-size:13px;" id="contact_table" class="table table-bordered table-striped nowrap">
                <thead>
                <tr>
                  <th width="5%">ID</th>
                  <th width="*">Nama Contact</th>
                  <th width="30%">Phone Number</th>
                 
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
    
  </div>
  @endsection