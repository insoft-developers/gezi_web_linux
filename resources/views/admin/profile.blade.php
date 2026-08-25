 
 @extends('master')
 @section('content')
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Profile Management
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('default') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Profile</a></li>
        <li class="active">Profile Management</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Profile Management</h3>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="margin-top:10px">
              <form id="form-profile">
              {{ csrf_field() }} 
              <div class="form-group">
                  <lable>User ID:</lable>
                  <input type="text" class="form-control" id="id" name="id" value="{{ $admin->id }}" readonly>
              </div>
              <div class="form-group">
                  <lable>Full Name:</lable>
                  <input type="text" class="form-control" id="name" required name="name" value="{{ $admin->name }}">
              </div>
              <div class="form-group">
                  <lable>Email:</lable>
                  <input type="text" value="{{ $admin->email }}" class="form-control" id="email" name="email" readonly>
              </div>
              <div class="form-group">
                  <lable>Password:</lable>
                  <input type="password" autocomplete="off" class="form-control" id="password" name="password">
              </div>
              <div class="form-group">
                  <lable>Level:</lable>
                  <input type="text" value="{{ $admin->level }}" class="form-control" id="level" name="level" readonly>
              </div>
              
              <div class="form-group">
                  <lable>Profile Image:</lable>
                  <img class="img-responsive" style="width:300px;border-radius:10px;margin:20px;"  src="{{ asset('storage/images/profil/'.$admin->profile_image) }}">
                  <input type="file" class="form-control" id="profile_image" name="profile_image">
              </div>
              
              <button type="submit" class="btn btn-success">Update Profile</button>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
  
  </div>
  @endsection