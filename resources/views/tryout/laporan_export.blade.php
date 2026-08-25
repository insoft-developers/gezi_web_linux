<!DOCTYPE HTML>
<html lang="pl">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="pl" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<title>Tryout Report</title>
<link rel="stylesheet" href="{{ asset('theme') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>


<body>
            <!-- /.box-header -->
            <div class="box-body" style="margin-top:10px">
           
                 
              <table style="font-size:13px;width:500%;" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="vertical-align:middle" rowspan="2" width="5%">ID</th>
                  <th style="vertical-align:middle" rowspan="2" width="50">Username</th>
                  <th style="vertical-align:middle;width:300px;" rowspan="2"><span style="white-space:nowrap;">Nama_Peserta</span></th>
                  @foreach($tryout as $t)
                  <?php $detail = \App\TryoutDetail::where('id_tryout', $t->id)->get(); 
                  foreach($detail as $d)  { ?>
                        <th style="width:60px;">{{ $d->no_soal }}</th>
                  <?php } ?>
                  @endforeach
                </tr>
                <tr>
                  
                  @foreach($tryout as $t)
                  <?php
                   $detail = \App\TryoutDetail::where('id_tryout', $t->id)->get();
                   foreach($detail as $d)  { ?>
                        <th style="width:60px;">{{ $t->short_name }}</th>
                  <?php }
                  ?>
                  @endforeach
                </tr>
                
                </thead>
                <tbody>
                    @foreach($utama as $key)
                    <tr>
                        <td>{{ $key->id }}</td>
                        <td>{{ $key->email }}</td>
                        <td>{{ $key->name }}</td>
                        @foreach($tryout as $t)
                          <?php
                           $detail = \App\TryoutDetail::where('id_tryout', $t->id)->get();
                           foreach($detail as $d)  { 
                                $ans = \App\TryoutAnswer::where('id_soal', $d->id)->where('id_user', $key->id)->get();
                                if($ans->count() > 0) { 
                                    if($ans[0]->hasil_jawaban == 'benar') { ?>
                                        <td style="background-color:green;color:white;" width="60px"><center>1</center></td>
                                    <?php } else { ?>
                                        <td style="width:60px;"><center>0</center></td>
                                    <?php } ?>
                                    
                                <?php } else  { ?>
                                    <td style="width:60px;"><center>0</center></td>
                                <?php } ?>    
                           <?php } ?>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
                
              </table>
             
            </div>
          </body>
          </html>