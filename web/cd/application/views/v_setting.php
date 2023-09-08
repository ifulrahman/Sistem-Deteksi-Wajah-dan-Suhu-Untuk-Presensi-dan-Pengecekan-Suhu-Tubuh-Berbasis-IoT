<?php
$this->load->View('include/header.php');

if ($set=="setting") {
  $skey = "";
  $waktumasuk = "";
  $waktukeluar = "";
  $jam_masuk = "";
  $keterlambatan = "";

  if (isset($waktuoperasional)) {
    foreach ($waktuoperasional as $d => $value) {
      if ($value->id_waktu_operasional == 1) {
        $waktumasuk = $value->waktu_operasional;
      }
      if ($value->id_waktu_operasional == 2) {
        $waktukeluar = $value->waktu_operasional;
      }
      if ($value->id_waktu_operasional == 3) {
        $jam_masuk = $value->waktu_operasional;
      }
      if ($value->id_waktu_operasional == 4) {
        $keterlambatan = $value->waktu_operasional;
      }
    }
  }

  $waktu_masuk = explode("-", $waktumasuk);
  if (isset($waktu_masuk[0])) {
    $waktu_masuk_1 = $waktu_masuk[0];
  }else{
    $waktu_masuk_1 = "";
  }

  if (isset($waktu_masuk[1])) {
    $waktu_masuk_2 = $waktu_masuk[1];
  }else{
    $waktu_masuk_2 = "";
  }

  $waktu_keluar = explode("-", $waktukeluar);
  if (isset($waktu_keluar[0])) {
    $waktu_keluar_1= $waktu_keluar[0];
  }else{
    $waktu_keluar_1 = "";
  }

  if (isset($waktu_keluar[1])) {
    $waktu_keluar_2 = $waktu_keluar[1];
  }else{
    $waktu_keluar_2 = "";
  }

  $token = "";
  $chat_id = "";
  if (isset($telegram)) {
    foreach ($telegram as $t => $val) {
      if ($val->id_telegram == 1) {
        $token = $val->token;
        $chat_id = $val->chat_id;
      }
    }
  }

?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Setting
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/setting"><i class="fa fa-gear"></i> Setting</a></li>
        <!-- <li class="active">Lihat Histori Device</li> -->
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <?php echo $this->session->flashdata('pesan');?>
              <form action="<?=base_url();?>admin/setwaktuoperasional" method="post">
              <div class="box-body col-md-12 text-center">
                <div class="col-md-6" style="margin-top:25px;">
                  <h3 class="box-title">Waktu Masuk</h3><br>
                  <div class="col-md12">
                    <div class="col-md-5">
                      <div class="input-group clockpicker">
                        <input type="text" name="waktu_masuk_1" class="form-control timepicker" style="text-align:center;" placeholder="Waktu Masuk 1" required autocomplete="off" value="<?php if(isset($waktu_masuk_1)){echo $waktu_masuk_1;}?>">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                      </div>
                    </div>
                    <div class="col-md-2 text-center">
                      _
                    </div>
                    <div class="col-md-5">
                      <div class="input-group clockpicker">
                        <input type="text" name="waktu_masuk_2" class="form-control timepicker" style="text-align:center;" placeholder="Waktu Masuk 2" required autocomplete="off" value="<?php if(isset($waktu_masuk_2)){echo $waktu_masuk_2;}?>">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6" style="margin-top:25px;">
                  <h3 class="box-title">Waktu Keluar</h3><br>
                  <div class="col-md12">
                    <div class="col-md-5">
                      <div class="input-group clockpicker">
                        <input type="text" name="waktu_keluar_1" class="form-control timepicker" style="text-align:center;" placeholder="Waktu Keluar 1" required autocomplete="off" value="<?php if(isset($waktu_keluar_1)){echo $waktu_keluar_1;}?>">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                      </div>
                    </div>
                    <div class="col-md-2 text-center">
                      _
                    </div>
                    <div class="col-md-5">
                      <div class="input-group clockpicker">
                        <input type="text" name="waktu_keluar_2" class="form-control timepicker" style="text-align:center;" placeholder="Waktu Keluar 2" required autocomplete="off" value="<?php if(isset($waktu_keluar_2)){echo $waktu_keluar_2;}?>">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3" style="margin-top:25px;">
                </div>
                <div class="col-md-6" style="margin-top:25px;">
                  <h3 class="box-title">Jam Masuk</h3><br>
                  <div class="col-md12">
                    <div class="input-group clockpicker">
                      <input type="text" name="jam_masuk" class="form-control timepicker" style="text-align:center;" placeholder="Jam Masuk" required autocomplete="off" value="<?php if(isset($jam_masuk)){echo $jam_masuk;}?>">
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-time"></span>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3" style="margin-top:25px;">
                </div>
                <div class="box-body col-md-12 text-center" style="margin-top:25px;">
                  <input class="btn btn-danger" type="submit" value="set waktu operasional">
                </div>
              </div>
              </form>
            </div>
            <!-- /.box-header -->

            <div class="box-header">
              <form action="<?=base_url();?>admin/set_telegram" method="post">
              <div class="box-body col-md-12 text-center">
                <div class="col-md-3">

                </div>
                <div class="col-md-6">
                  <h3 class="box-title">Token Telegram</h3><br>
                  <input class="form-control" type="text" name="token" value="<?=$token;?>" style="text-align:center;" placeholder="token">
                  <br><h3 class="box-title">ID Chat Telegram</h3><br>
                  <input class="form-control" type="text" name="idchat" value="<?=$chat_id;?>" style="text-align:center;" placeholder="ID chat">
                </div>
                <div class="col-md-3">

                </div>
                <div class="box-body col-md-12 text-center">
                  <input class="btn btn-danger" type="submit" value="simpan">
                </div>
                
              </div>
              </form>
            </div>

            <div class="box-body text-center">
            <?php
              if ($token != "" && $chat_id != "") {
                echo "<a href='".base_url()."api/tes_telegram' target='_blank'><button class='btn btn-primary'>Tes Telegram Bot</button></a>";
              }
            ?>
            </div>

            <div class="box-body table-responsive">
              <div class="callout callout-info">
                <h4><i class="icon fa fa-warning"></i> SECRET KEY</h4>

                <?php
                foreach ($key as $keys => $value) {
                  $skey = $value->key;
                  echo "<i class='icon fa fa-lock'></i> <b>".$skey."</b>";
                }
                ?>
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
  </div>
<?php
} 

$this->load->view('include/footer.php');
?>

</div>  <!-- penutup header -->

<!-- jQuery 3 -->
<script src="<?=base_url();?>components/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url();?>components/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url();?>components/dist/js/adminlte.min.js"></script>

<script type="text/javascript" src="<?=base_url();?>components/dist/js/bootstrap-clockpicker.min.js"></script>
<script type="text/javascript">
    $('.clockpicker').clockpicker();
</script>

</body>
</html>