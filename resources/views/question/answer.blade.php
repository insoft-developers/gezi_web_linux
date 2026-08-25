 
 @extends('master')
 @section('content')
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Jawab Pertanyaan
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('default') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Tanya Soal</a></li>
        <li><a href="{{ url('question') }}">List Pertanyaan</a></li>
        <li class="active">Jawab Pertanyaan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Jawab Pertanyaan</h3>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="margin-top:10px">
              <div class="row">
                  <div class="col-md-12">
                    <table id="question_answer_table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                       <td colspan="3"><strong>Pertanyaan :</strong> <br> 
                       @if(! empty($pertanyaan->gambar_soal))
                            <img style="width:250px;border-radius:5px;" class="img-responsive" src="{{ asset('storage/images/question') }}/{{ $pertanyaan->gambar_soal }}">    
                      
                       @endif
                       {{ $pertanyaan->soal }}</td> 
                    </tr>    
                    <tr>
                      <th width="5%">ID</th>
                      <th width="*">Jawaban</th>
                      <th width="15%">Time <button onclick="addJawaban()" style="border-radius:30px;float:right;" class="btn btn-success btn-xs"><i class="fa fa-plus"> Add</i></button></th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                    
                  </table>
                  </div>
                  <!--<div class="col-md-1">-->
                  <!--    <button class="btn btn-success btn-xs"><i class="fa fa-plus"> Add</i></button>-->
                  <!--</div>-->
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
    @include('modal.modal_add_jawaban');
    @include('modal.modal_hapus')

  </div>
  @endsection