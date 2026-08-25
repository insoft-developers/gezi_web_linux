 
 @extends('master')
 @section('content')
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Quiz Session
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('default') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Quiz</a></li>
        <li class="active">Quiz Session</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Quiz Session</h3>
             
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="margin-top:10px">
              <table id="tryout_session_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="5%">ID</th>
                  <th width="*">Judul</th>
                  <th width="13%">Kelas</th>
                  <th width="10%">Is Active</th>
                  <th width="12%">Tgt Score</th>
                  <th width="12%">Freq</th>
                  <th width="12%">Date</th>
                  <th width="6%">Action</th>
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
   
  </div>
  @endsection