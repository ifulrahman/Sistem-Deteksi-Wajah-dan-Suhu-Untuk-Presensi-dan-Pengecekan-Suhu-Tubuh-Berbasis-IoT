<?php
$this->load->View('include/header.php');

if ($set=="devices") {
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Alat
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-gears"></i> Data Alat</a></li>
        <!-- <li class="active">Dashboard</li> -->
      </ol>
    </section>

        <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <?php echo $this->session->flashdata('pesan');?>
              <br>
              <a href="<?php base_url()?>add_devices"><button type="button" class="btn btn-primary btn-lg">Tambah Alat</button></a>
              <br><br><br>
              <h1 class="box-title">Data Alat</h1>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="t1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="text-align:center">No</th>
                  <th style="text-align:center">ID Alat</th>
                  <th style="text-align:center">Nama Device</th>
                  <!-- <th style="text-align:center">Mode</th>
                  <th style="text-align:center">#</th> -->
                </tr>
                </thead>
                <tbody>
                <?php if(empty($devices)){?>
                <tr>
                  <td>Data tidak ditemukan</td>
                  <td>Data tidak ditemukan</td>
                  <td>Data tidak ditemukan</td>
                  <!-- <td>Data tidak ditemukan</td>
                  <td>Data tidak ditemukan</td> -->
                </tr>
                <?php } else{
                $no=0;
                foreach($devices as $row){ $no++;?>
                <tr>
                  <td style="text-align:center"><?php echo $no;?></td>
                  <td style="text-align:center"><b class="text-success"><?php echo $row->id_devices;?></b></td>
                  <td style="text-align:center"><?php echo $row->nama_devices;?></td>
                  <!-- <td style="text-align:center">
                    <?php
                    if ($row->mode == "SCAN") {
                      echo "ABSENSI";
                    } else if ($row->mode == "ADD") {
                      echo "Tambah Face ID";
                    } else if ($row->mode == "DEL") {
                      echo "Hapus Face ID";
                    } else{
                      echo "UNKNOWN";
                    }
                    ?>
                  </td>
                  <td style="text-align:center">
                    <a href="<?=base_url()?>admin/edit_devices_mode/<?=$row->id_devices?>" class="btn btn-warning btn-sm" title="rubah mode"><i class="glyphicon glyphicon-cog"></i></a>
                    <a href="<?=base_url()?>admin/edit_devices/<?=$row->id_devices?>" class="btn btn-info btn-sm" title="rubah nama"><i class="glyphicon glyphicon-pencil"></i></a>
                    <a href="<?=base_url()?>admin/hapus_devices/<?=$row->id_devices?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda Yakin menghapus alat ini?')"><i class="glyphicon glyphicon-trash"></i></a>
                  </td> -->
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
} else if ($set=="add-devices") {
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tambah Alat
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-gears"></i> Data Alat</a></li>
        <li class="active">Tambah Alat</li>
      </ol>
    </section>

        <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <?php echo "<br>"; echo $this->session->flashdata('pesan');?>
              <h1 class="box-title">Tambah Alat</h1>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?=base_url();?>admin/save_devices" method="post">
              <div class="box-body">
                <!-- <div class="form-group"> -->
                  <!-- <input type="hidden" name="id" value=""> -->
                  <!-- <label>ID Alat</label>
                  <input type="number" name="id" class="form-control" placeholder="id (number)" required>
                </div> -->
                <div class="form-group">
                  <label>Nama Alat</label>
                  <input type="text" name="nama" class="form-control" placeholder="input nama alat" required>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>       
            </form>
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
} else if ($set=="edit-devices") {
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Alat
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-gears"></i> Data Alat</a></li>
        <li class="active">Edit Alat</li>
      </ol>
    </section>

        <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <?php echo "<br>"; echo $this->session->flashdata('pesan');?>
              <br>
              <h1 class="box-title">Edit Alat</h1>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?=base_url();?>admin/save_edit_devices" method="post">              
              <div class="box-body">
                <div class="form-group">
                  <input type="hidden" name="id" value="<?php if(isset($id)){echo $id;}?>">
                  <!-- <label>ID Device</label>
                  <input type="number" name="id" class="form-control" placeholder="Enter id" required> -->
                </div>
                <div class="form-group">
                  <label>Nama Alat</label>
                  <input type="text" name="nama" value="<?php if(isset($nama_devices)){echo $nama_devices;}?>" class="form-control" placeholder="nama bus" required>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>              
            </form>
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
} else if ($set=="edit-devices-mode") {
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Mode Alat
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-gears"></i> Data Alat</a></li>
        <li class="active">Edit Mode Alat</li>
      </ol>
    </section>

        <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <?php echo $this->session->flashdata('pesan');?>
              <br>
              <h1 class="box-title">Edit Mode Alat</h1>

              <form action="<?=base_url();?>/admin/save_edit_devices_mode" method="post">
              <input type="hidden" name="id" value="<?php if(isset($id)){echo $id;}?>">
              <div class="col-md-12 text-center">
                <div class="form-group">
                  <label>
                    <input type="radio" name="mode" class="flat-red" value="ADD" <?php if($mode=="ADD") echo "checked";?>>
                    Tambah Face ID &nbsp; 
                  </label>

                  <label>
                    <input type="radio" name="mode" class="flat-red" value="SCAN" <?php if($mode=="SCAN") echo "checked";?>>
                    Absensi Face Recognition &nbsp; 
                  </label>

                  <label>
                    <input type="radio" name="mode" class="flat-red" value="DEL" <?php if($mode=="DEL") echo "checked";?>>
                    Hapus Face ID &nbsp; 
                  </label>
                </div>
              </div>
              <div class="col-md-12 text-center" style="padding-top:30px; padding-bottom:30px;">
                <input type="submit" class="btn btn-danger" value="Set Mode">
              </div>
              </form>
            </div>
            <!-- /.box-header -->
            
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
<!-- iCheck 1.0.1 -->
<script src="<?=base_url();?>components/plugins/iCheck/icheck.min.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#t1").DataTable();
  });

  //Flat red color scheme for iCheck
  $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
    checkboxClass: 'icheckbox_flat-green',
    radioClass   : 'iradio_flat-green'
  });
</script>

</body>
</html>