 
 @extends('master')
 @section('content')
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Setting Management
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('default') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Setting</a></li>
        <li class="active">General Setting</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">General Setting</h3>
             
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="margin-top:10px">
              <table id="setting_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="5%">ID</th>
                  <th width="*">Is Register</th>
                  <th width="300px">Action</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $setting->id }}</td>
                        <td>
                        @if($setting->is_register == 1)
                           <center><span class="label label-success">Active</span></center>
                        
                        @else 
                           <center><span class="label label-danger">Inactive</span></center>
                        
                        @endif
                        </td>
                        <td>
                            @if($setting->is_register == 1)
                            <center><a disabled style="margin-left:10px;" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-check"></i> Active</a><a onclick="inactiveData({{ $setting->id }})" style="margin-left:10px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i> Inactive</a></center></td>
                            @else 
                            
                            <center><a onclick="activeData({{ $setting->id }})" style="margin-left:10px;" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-check"></i> Active</a><a disabled style="margin-left:10px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i> Inactive</a></center></td>
                            @endif
                            
                    </tr>
                </tbody>
                
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
    @include('modal.modal_add_admin')

  </div>
  @endsection