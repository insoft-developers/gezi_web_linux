
<!--text/x-generic subject.blade.php ( HTML document, ASCII text )-->
 
 @extends('master')
 @section('content')
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Subject Management
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('default') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Quiz</a></li>
        <li class="active">Subject</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Subject</h3>
              <button onclick="addData()" style="float:right;" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="margin-top:10px">
              <table style="font-size:12px;" id="subject_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="5%">ID</th>
                  <th width="25%">Image</th>
                  <th width="*">Subject Name</th>
                  <th width="8%">Urutan</th>
                  <th width="8%">Status</th>
                  <th width="15%">Created_at</th>
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
    @include('modal.modal_add_subject')
    @include('modal.modal_hapus')
  </div>
  @endsection