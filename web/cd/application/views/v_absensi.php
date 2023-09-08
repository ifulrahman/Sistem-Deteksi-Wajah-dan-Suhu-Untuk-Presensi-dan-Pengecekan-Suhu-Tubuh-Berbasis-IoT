<?php
$this->load->View('include/header.php');

if ($set=="absensi") {
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Absensi
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/absensi"><i class="fa fa-book"></i> Absensi</a></li>
        <!-- <li class="active">Lihat Histori Device</li> -->
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <form action="<?=base_url();?>admin/lastabsensi" method="post">
                <div class="col-md-2">
                </div>
                <div class="form-group col-md-6">
                  <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" name="tanggal" class="form-control pull-right" id="reservation">
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="col-md-4">
                  <button type="submit" class="btn btn-danger">Ambil Data Absensi</button>
                </div>
              </form>
            </div>
            <div class="box-header">
              <?php echo "<br>"; echo $this->session->flashdata('pesan');?>
              <h1 class="box-title"><b>Absensi Masuk Hari ini</b> <b class="text-danger"><?php echo date("d M Y",time());?></b></h1>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="t1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="text-align:center">No</th>
                  <th style="text-align:center">Nama</th>
                  <th style="text-align:center">Kelas</th>
                  <th style="text-align:center">Absensi Masuk</th>
                  <th style="text-align:center">Suhu Masuk</th>
                  <th style="text-align:center">Ket Masuk</th>
                  <th style="text-align:center">Absensi Keluar</th>
                  <th style="text-align:center">Suhu Keluar</th>
                  <th style="text-align:center">Ket Keluar</th>
                  <th style="text-align:center">Terlambat (menit)</th>
                  <th style="text-align:center">Pulang Awal (menit)</th>
                  <th style="text-align:center">Tanggal</th>
                </tr>
                </thead>
                <tbody>
                <?php if(empty($absensi)){?>
                <tr>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                </tr>
                <?php } else{
                $no = 0;
                foreach($absensi as $row){ $no++;?>
                <tr>
                  <td style="text-align:center"><b class="text-success"><?php echo $no;?></b></td>
                  <td style="text-align:center"><?php echo $row->nama;?></td>
                  <td style="text-align:center"><?php echo $row->kelas;?></td>
                  <td style="text-align:center">
                    <?php 
                    if ($row->absensi_masuk > 0) {
                      if ($row->keterangan_masuk == "Tidak Masuk") {
                        echo "-";
                      }else{
                        echo date("H:i:s",$row->absensi_masuk);
                      }
                    }else{
                      echo "-";
                    }
                    ?>
                  </td>
                  <td style="text-align:center"><?php echo $row->suhu_masuk;?>C</td>
                  <td style="text-align:center"><?php echo $row->keterangan_masuk;?></td>
                  <td style="text-align:center">
                    <?php 
                    if ($row->absensi_keluar > 0) {
                      echo date("H:i:s",$row->absensi_keluar);
                    }else{
                      echo "-";
                    }
                    ?>
                  </td>
                  <td style="text-align:center"><?php echo $row->suhu_keluar;?>C</td>
                  <td style="text-align:center"><?php echo $row->keterangan_keluar;?></td>
                  <td style="text-align:center"><?php echo $row->keterlambatan;?></td>
                  <td style="text-align:center"><?php echo $row->pulang_awal;?></td>
                  <td style="text-align:center">
                    <?php 
                    if ($row->absensi_masuk > 0) {
                      echo date("d M Y",$row->absensi_masuk);
                    }
                    ?>
                  </td>
                </tr>
                <?php }}?>
                
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

  </div>
<?php
} else if ($set=="last-absensi") {
  if (!isset($tanggal)) {
    $tanggal = "";
  }

  if (!isset($waktuabsensi)) {
    $waktuabsensi = "";
  }
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Absensi <?php echo $tanggal;?>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/histori"><i class="fa fa-book"></i> Absensi</a></li>
        <li class="active">Ambil Data Absensi</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <div class="col-md-12">
                <div style="text-align:center;">
                  <a href="<?=base_url()?>admin/export2excel?tanggal=<?=$waktuabsensi;?>"><button class="btn btn-success">Download Laporan Excel</button></a>
                </div>
              </div>
            </div>
            <div class="box-header">
              <?php echo "<br>"; echo $this->session->flashdata('pesan');?>
              <h1 class="box-title"><b>Absensi Masuk</b> <b class="text-danger"><?php echo $tanggal;?></b></h1>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="t1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="text-align:center">No</th>
                  <th style="text-align:center">Nama</th>
                  <th style="text-align:center">Kelas</th>
                  <th style="text-align:center">Absensi Masuk</th>
                  <th style="text-align:center">Suhu Masuk</th>
                  <th style="text-align:center">Ket Masuk</th>
                  <th style="text-align:center">Absensi Keluar</th>
                  <th style="text-align:center">Suhu Keluar</th>
                  <th style="text-align:center">Ket Keluar</th>
                  <th style="text-align:center">Terlambat (menit)</th>
                  <th style="text-align:center">Pulang Awal (menit)</th>
                  <th style="text-align:center">Tanggal</th>
                </tr>
                </thead>
                <tbody>
                <?php if(empty($absensi)){?>
                <tr>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                  <td style="text-align:center">Data tidak ditemukan</td>
                </tr>
                <?php } else{
                $no = 0;
                foreach($absensi as $row){ $no++;?>
                <tr>
                  <td style="text-align:center"><b class="text-success"><?php echo $no;?></b></td>
                  <td style="text-align:center"><?php echo $row->nama;?></td>
                  <td style="text-align:center"><?php echo $row->kelas;?></td>
                  <td style="text-align:center">
                    <?php 
                    if ($row->absensi_masuk > 0) {
                      if ($row->keterangan_masuk == "Tidak Masuk") {
                        echo "-";
                      }else{
                        echo date("H:i:s",$row->absensi_masuk);
                      }
                    }else{
                      echo "-";
                    }
                    ?>
                  </td>
                  <td style="text-align:center"><?php echo $row->suhu_masuk;?>C</td>
                  <td style="text-align:center"><?php echo $row->keterangan_masuk;?></td>
                  <td style="text-align:center">
                    <?php 
                    if ($row->absensi_keluar > 0) {
                      echo date("H:i:s",$row->absensi_keluar);
                    }else{
                      echo "-";
                    }
                    ?>
                  </td>
                  <td style="text-align:center"><?php echo $row->suhu_keluar;?>C</td>
                  <td style="text-align:center"><?php echo $row->keterangan_keluar;?></td>
                  <td style="text-align:center"><?php echo $row->keterlambatan;?></td>
                  <td style="text-align:center"><?php echo $row->pulang_awal;?></td>
                  <td style="text-align:center">
                    <?php 
                    if ($row->absensi_masuk > 0) {
                      echo date("d M Y",$row->absensi_masuk);
                    }
                    ?>
                  </td>
                </tr>
                <?php }}?>
                
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

<!-- DataTables -->
<script src="<?=base_url();?>components/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url();?>components/plugins/datatables/dataTables.bootstrap.min.js"></script>

<!-- date-range-picker -->
<script src="<?=base_url();?>components/bower_components/moment/min/moment.min.js"></script>
<script src="<?=base_url();?>components/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- page script -->
<script>
  $(function () {
    $("#t1").DataTable();
    $('#t2').DataTable();
  });

  $(function () {
    //Date range picker
    $('#reservation').daterangepicker()

  })
</script>

</body>
</html>