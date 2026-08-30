 @extends('master')
 @section('content')
 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>
       Quiz Implementation

     </h1>
     <ol class="breadcrumb">
       <li><a href="{{ route('default') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
       <li><a href="#">Quiz</a></li>
       <li><a href="{{ url('tryout_session') }}">Quiz Session</a></li>
       <li class="active">{{ $tryout->judul }}</li>
     </ol>
   </section>

   <!-- Main content -->
   <section class="content">
     <div class="row">
       <div class="col-xs-12">

         <div class="box">
           <div class="box-header">
             <h3 class="box-title">{{ $tryout->judul }}</h3>

           </div>
           <!-- /.box-header -->
           <div class="box-body" style="margin-top:10px">
             <div class="row" style="margin-bottom:15px;">

               <div class="col-md-2">
                 <label>Tanggal Dari</label>
                 <input
                   type="date"
                   id="filter_date_start"
                   class="form-control input-sm">
               </div>

               <div class="col-md-2">
                 <label>Tanggal Sampai</label>
                 <input
                   type="date"
                   id="filter_date_end"
                   class="form-control input-sm">
               </div>

               <div class="col-md-2">
                 <label>Nama Siswa</label>
                 <select id="filter_siswa" class="form-control input-sm">
                   <option value="">Semua Siswa</option>
                   @foreach($siswa as $item)
                   <option value="{{ $item->id }}">{{ $item->name }}</option>
                   @endforeach

                 </select>
               </div>


               <div class="col-md-2">
                 <label>Lokasi</label>
                 <select id="filter_lokasi" class="form-control input-sm">
                   <option value="">Semua Lokasi</option>

                   @foreach($location as $item)
                   <option value="{{ $item->id }}">{{ $item->name }}</option>
                   @endforeach
                 </select>
               </div>

               <div class="col-md-2">
                 <label>Sekolah</label>
                 <select id="filter_sekolah" class="form-control input-sm">
                   <option value="">Semua Sekolah</option>
                   @foreach($sekolah as $item)
                   <option value="{{ $item->id }}">{{ $item->school_name }}</option>
                   @endforeach

                 </select>
               </div>


               <div class="col-md-2">
                 <label>Kelas</label>
                 <select id="filter_kelas" class="form-control input-sm">
                   <option value="">Semua Kelas</option>
                   @foreach($kelas as $item)
                   <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                   @endforeach

                 </select>
               </div>



             </div>

             <div class="row" style="margin-bottom:15px;">

               <div class="col-md-2">
                 <label>Hasil Ujian</label>
                 <select id="filter_lulus" class="form-control input-sm">
                   <option value="">Semua</option>
                   <option value="lulus">Lulus</option>
                   <option value="tidak">Tidak Lulus</option>


                 </select>
               </div>
             </div>


             <div class="row" style="margin-bottom:15px;">
               <div class="col-md-12">
                 <button
                   type="button"
                   id="btn_filter"
                   class="btn btn-primary btn-sm">
                   <i class="fa fa-filter"></i>
                   Filter
                 </button>

                 <button
                   type="button"
                   id="btn_reset_filter"
                   class="btn btn-default btn-sm">
                   <i class="fa fa-refresh"></i>
                   Reset
                 </button>

                 <button style="margin-left:10px;"
                   type="button"
                   onclick="exportExcel()"
                   class="btn btn-success btn-sm">
                   <i class="fa fa-file-excel-o"></i>
                   Export ke Excel
                 </button>


               </div>
             </div>
             <div class="table-responsive">
               <table style="font-size:13px;" id="exam_table" class="table table-bordered table-striped nowrap">
                 <thead>
                   <tr>
                     <th width="5%">ID</th>
                     <th width="6%">Detail</th>
                     <th width="10%">Date</th>

                     <th width="*">Judul</th>
                     <th width="12%">Siswa</th>
                     <th width="12%">Lokasi</th>
                     <th width="8%">NIS</th>
                     <th width="12%">Sekolah</th>
                     <th width="10%">Telp</th>
                     <th width="10%">Kelas</th>
                     <th width="10%">Score</th>
                     <th width="10%">Target</th>
                     <th width="10%">Resume</th>

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
   @include('modal.modal_show_detail')
 </div>
 @endsection