 @extends('master')
 @section('content')
 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>
       Kompetensi Dasar Management

     </h1>
     <ol class="breadcrumb">
       <li><a href="{{ route('default') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
       <li><a href="#">Kompetensi Dasar</a></li>
       <li class="active">Kompetensi Dasar</li>
     </ol>
   </section>

   <!-- Main content -->
   <section class="content">
     <div class="row">
       <div class="col-xs-12">

         <div class="box">
           <div class="box-header">
             <h3 class="box-title">Kompetensi Dasar</h3>
             <button onclick="addData()" style="float:right;" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add</button>
           </div>
           <!-- /.box-header -->
           <div class="box-body" style="margin-top:10px">

             <!-- =========================
                         FILTER
                    ========================== -->
             <div class="box-body"
               style="
                            padding-bottom:5px;
                            border-bottom:1px solid #eee;
                         ">

               <div class="row">

                 <!-- FILTER KELAS -->
                 <div class="col-md-3 col-sm-4 col-xs-12">

                   <div class="form-group"
                     style="margin-bottom:10px;">

                     <label style="font-size:13px;">
                       Kelas
                     </label>

                     <select
                       id="filter_kelas"
                       class="form-control input-sm">

                       <option value="">
                         Semua Kelas
                       </option>

                       @foreach($kelas ?? [] as $item)

                       <option value="{{ $item->id }}">
                         {{ $item->nama_kelas }}
                       </option>

                       @endforeach

                     </select>

                   </div>

                 </div>



                 <!-- FILTER SUBJECT -->
                 <div class="col-md-3 col-sm-4 col-xs-12">

                   <div class="form-group"
                     style="margin-bottom:10px;">

                     <label style="font-size:13px;">
                       Status
                     </label>

                     <select
                       id="filter_status"
                       class="form-control input-sm">

                       <option value="">
                         Semua Status
                       </option>

                       <option value="1">Aktif</option>
                       <option value="0">Tdk Aktif</option>

                     </select>

                   </div>

                 </div>


                 <!-- RESET -->
                 <div class="col-md-2 col-sm-4 col-xs-12">

                   <div
                     style="
                                        margin-top:25px;
                                        display:flex;
                                        gap:5px;
                                    ">

                     <button
                       type="button"
                       id="btn_filter"
                       class="btn btn-primary btn-sm">

                       <i class="fa fa-filter"></i>
                       Filter

                     </button>

                     <button
                       type="button"
                       id="btn_reset"
                       class="btn btn-default btn-sm">

                       <i class="fa fa-refresh"></i>
                       Reset

                     </button>

                   </div>

                 </div>

               </div>

             </div>
             <div class="table-responsive">
               <table style="font-size:12px;" id="quiz_header_table" class="table table-bordered table-striped nowrap">
                 <thead>
                   <tr>
                     <th width="5%">ID</th>
                     <th width="12%">Action</th>
                     <th width="12%">Kelas</th>
                     <th width="*">Keterangan</th>
                     <th width="12%">Jumlah Soal</th>
                     <th width="12%">Waktu</th>
                     <th width="12%">Target</th>
                     <th width="8%">Status</th>
                     <th width="8%">Urutan</th>
                     <th width="8%">Is Skipped</th>
                     <th width="10%">Created_at</th>

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
   @include('modal.modal_add_quiz_header')
   @include('modal.modal_copy_quiz_header')
   @include('modal.modal_hapus')
 </div>
 @endsection