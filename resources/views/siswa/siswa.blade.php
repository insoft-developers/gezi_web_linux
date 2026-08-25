 
 @extends('master')
 @section('content')
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Siswa Management
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('default') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Siswa Management</a></li>
        <li class="active">Data Siswa</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Siswa</h3>
              <button onclick="addData()" style="float:right;" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add</button>
              
             
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="margin-top:10px">
                
                <div class="row" style="margin-bottom:15px;">

                    <div class="col-md-2">
                        <label>Lokasi</label>
                        <select id="filter_location" class="form-control input-sm">
                            <option value="">Semua Lokasi</option>
                
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}">
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                
                    <div class="col-md-2">
                        <label>Kelas</label>
                        <select id="filter_kelas" class="form-control input-sm">
                            <option value="">Semua Kelas</option>
                
                            @foreach($kelas as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                
                    <div class="col-md-2">
                        <label>Group Kelas</label>
                        <select id="filter_group_kelas" class="form-control input-sm">
                            <option value="">Semua Group</option>
                
                            @foreach($groups as $group)
                                <option value="{{ $group->class_group }}">
                                    {{ $group->class_group }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                
                    <div class="col-md-2">
                        <label>Sekolah</label>
                        <select id="filter_school" class="form-control input-sm">
                            <option value="">Semua Sekolah</option>
                
                            @foreach($sekolah as $school)
                                <option value="{{ $school->id }}">
                                    {{ $school->school_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                
                    <div class="col-md-2">
                        <label>Tanggal Pendaftaran</label>
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
                        
                        
            <!--             <button-->
            <!--    onclick="exportExcel()"-->
            <!--    style="float:right;margin-right:5px;"-->
            <!--    class="btn btn-primary btn-xs">-->
            
            <!--    <i class="fa fa-file-excel-o"></i>-->
            <!--    Export Excel-->
            
            <!--</button>-->
                    </div>
                </div>
              <div class="table-responsive">
              <table style="font-size:13px;" id="siswa_table" class="table table-bordered table-striped nowrap">
                <thead>
                <tr>
                  <th width="10%">Action</th>
                  <th width="5%">ID</th>
                  <th width="5%">VERSI</th>
                  <th width="15%">Foto</th>
                  <th width="10%">Status</th>
                  <th width="13%">Date</th>
                  <th width="*">Nama Siswa</th>
                  <th width="8%">Skor Kuis</th>
                  <th width="8%">Skor Bank Soal</th>
                  <th width="8%">L.A</th>
                  <th width="8%">Lokasi</th>
                  <th width="8%">NIS</th>
                  <th width="10%">Kelas</th>
                  <th width="10%">Grup Kelas</th>
                  <th width="10%">HP Ayah</th>
                  <th width="10%">HP Ibu</th>
                  <th width="10%">Sekolah</th>
                  <th width="10%">Email</th>
                  <th width="10%">Telepon</th>
                  <th width="10%">Lama</th>
                  
                  
                  
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
    @include('modal.modal_add_siswa')
    @include('modal.modal_hapus')
    <!-- Modal Hapus Sesi -->
    <div class="modal fade" id="modalHapusSesi" tabindex="-1" role="dialog" aria-labelledby="modalHapusSesiLabel">
        <div class="modal-dialog modal-sm" role="document">
    
            <div class="modal-content">
    
                <div class="modal-header">
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
    
                    <h4 class="modal-title" id="modalHapusSesiLabel">
                        <i class="fa fa-trash"></i>
                        Hapus Sesi
                    </h4>
                </div>
    
                <div class="modal-body text-center">
    
                    <p style="margin-bottom:20px;">
                        Pilih sesi yang ingin dihapus:
                    </p>
    
                    <!-- Hapus Kompetensi Dasar -->
                    <input type="hidden" id="siswa_hapus_sesi_id">
                    <button type="button"
                            class="btn btn-warning btn-block"
                            onclick="hapusSesi('kompetensi_dasar')">
                        <i class="fa fa-trash"></i>
                        Hapus Sesi Kompetensi Dasar
                    </button>
    
                    <!-- Hapus Quiz -->
                    <button type="button"
                            class="btn btn-danger btn-block"
                            onclick="hapusSesi('quiz')">
                        <i class="fa fa-trash"></i>
                        Hapus Sesi Quiz
                    </button>
    
                    <!-- Hapus Bank Soal -->
                    <button type="button"
                            class="btn btn-primary btn-block"
                            onclick="hapusSesi('bank_soal')">
                        <i class="fa fa-trash"></i>
                        Hapus Sesi Bank Soal
                    </button>
    
                </div>
    
                <div class="modal-footer">
    
                    <button type="button"
                            class="btn btn-default btn-block"
                            data-dismiss="modal">
                        <i class="fa fa-times"></i>
                        Batal
                    </button>
    
                </div>
    
            </div>
    
        </div>
    </div>
  </div>
  @endsection