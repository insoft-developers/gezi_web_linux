 
 @extends('master')
 @section('content')
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Try Out
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('default') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Try Out</a></li>
        <li class="active">Laporan Try Out</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Laporan Try Out</h3>
             
               <div class="row" style="margin-top:30px;">
                   <div class="col-md-4">
                       <label>Kelas : </label>
                       <select id="id_kelas" name="id_kelas" class="form-control">
                           <option value=""> - Semua Kelas - </option>
                           @foreach($kelas as $key)
                                <option value="{{ $key->id }}">{{ $key->nama_kelas }}</option>
                           @endforeach
                       </select>
                   </div>
                   <div class="col-md-2">
                       <button onclick="tampilkan_laporan_tryout()" style="margin-top:27px; float:right;" class="btn btn-info btn-sm">Tampilkan Laporan</button>
                   </div>
                   <div class="col-md-2">
                        <a href="{{ url('export') }}"><button style="float:right;margin-top:27px;float:left;" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i> Export To Excel</button></a>
                   </div>
               </div> 
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="margin-top:10px">
              <div id="isi_laporan_tryout" class="table-responsive"></div>
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