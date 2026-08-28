 
 @extends('master')
 @section('content')
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Bank Soal Management
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('default') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Bank Soal</a></li>
        <li class="active">Bank Soal</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Bank Soal</h3>
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
                                        Subject
                                    </label>

                                    <select
                                        id="filter_kategori"
                                        class="form-control input-sm">

                                        <option value="">
                                            Semua Kategori
                                        </option>

                                        

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
              <table style="font-size:13px;" id="banksoal_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="5%">ID</th>
                  <th>Urutan</th>
                  <th width="7%">Action</th>
                  <th width="*">Judul</th>
                  <th width="10%">Kategori</th>
                  <th width="10%">Kelas</th>
                  <th width="10%">Active</th>
                  <th width="10%">Repeated</th>
                  <th width="10%">Skipped</th>
                  <th width="10%">Target</th>
                  <th>Quest Random</th>
                  <th>Ans Random</th>
                  <th width="10%">Soal</th>
                 
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
    @include('modal.modal_add_bank_soal')
    @include('modal.modal_hapus')
    @include('modal.modal_copy_banksoal')
  </div>
  @endsection