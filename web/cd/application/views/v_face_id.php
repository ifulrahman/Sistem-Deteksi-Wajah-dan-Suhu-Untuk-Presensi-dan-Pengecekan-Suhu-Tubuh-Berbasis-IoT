<?php
$this->load->View('include/header.php');

if ($set=="list") {
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Face ID
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-user"></i> Face ID</a></li>
        <li class="active">Data Face ID</li>
      </ol>
    </section>

        <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <?php echo "<br>"; echo $this->session->flashdata('pesan');?>
              <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal-success">Tambah Face ID</button>
              <br><br><br>
              <h1 class="box-title"></h1>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="t1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="text-align:center">No</th>
                  <th style="text-align:center">ID Alat</th>
                  <th style="text-align:center">Face ID</th>
                  <th style="text-align:center">Nama</th>
                  <th style="text-align:center">NIM</th>
                  <th style="text-align:center">Telp</th>
                  <th style="text-align:center">Gender</th>
                  <th style="text-align:center">Semester</th>
                  <th style="text-align:center">Kelas</th>
                  <th style="text-align:center">#</th>
                </tr>
                </thead>
                <tbody>
                <?php if(empty($face)){?>
                <tr>
                  <td>Data tidak ditemukan</td>
                  <td>Data tidak ditemukan</td>
                  <td>Data tidak ditemukan</td>
                  <td>Data tidak ditemukan</td>
                  <td>Data tidak ditemukan</td>
                  <td>Data tidak ditemukan</td>
                  <td>Data tidak ditemukan</td>
                  <td>Data tidak ditemukan</td>
                  <td>Data tidak ditemukan</td>
                  <td>Data tidak ditemukan</td>
                </tr>
                <?php } else{
                $no=0;
                foreach($face as $row){ 
                    $no++;?>
                <tr>
                  <td style="text-align:center"><?php echo $no;?></td>
                  <td style="text-align:center"><b class="text-danger"><?php echo $row->id_devices;?></b></td>
                  <td style="text-align:center"><b class="text-success"><?php echo $row->face_id;?></b></td>
                  <td style="text-align:center"><?php echo $row->nama;?></td>
                  <td style="text-align:center"><?php echo $row->nim;?></td>
                  <td style="text-align:center"><?php echo $row->telp;?></td>
                  <td style="text-align:center"><?php echo $row->gender;?></td>
                  <td style="text-align:center"><?php echo $row->semester;?></td>
                  <td style="text-align:center"><?php echo $row->kelas;?></td>
                  <td style="text-align:center">
                    <?php
                    if ($row->add_face_id == 1 || $row->del_face_id == 1) {
                      if ($row->add_face_id == 1) {
                        echo "<i class='text-success'>ID Baru blm sinkron dengan Alat</i> ";
                      }
                      if ($row->del_face_id == 1) {
                        echo "<i class='text-danger'>Hapus ID blm sinkron dengan Alat</i> ";
                      }
                    }else{
                    ?>
                      <a href="<?=base_url()?>admin/edit_face/<?=$row->id_face_table?>" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-pencil"></i></a>
                      <a href="<?=base_url()?>admin/hapus_face/<?=$row->id_face_table?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda Yakin menghapus data ini?')"><i class="glyphicon glyphicon-trash"></i></a>
                    <?php } ?>
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

      <div class="modal modal-primary fade" id="modal-success">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Tambah Face ID</h4>
            </div>
            <form action="<?=base_url()?>admin/add_face_id" method="post">
            <div class="modal-body">
              <div class="form-group">
                <label>Pilih ID Alat:</label>
                <select class="form-control" name="id_devices" required oninvalid="this.setCustomValidity('Pilih ID Alat')">
                  <option disabled>-- pilih --</option>
                  <?php
                    if (isset($devices)) {
                      foreach ($devices as $key => $value) {
                        echo "<option value='$value->id_devices'>".$value->id_devices."</option>";
                      }
                    }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label>Enter Face ID between 1 & 999:</label>
                <input type="number" name="face_id" min="1" max="999" class="form-control" placeholder="User Face ID" required>
              </div>
              <div class="form-group">
                <label>Nama:</label>
                <input type="text" name="nama" class="form-control" required>
              </div>
              <div class="form-group">
                <label>NIM:</label>
                <input type="text" name="nim" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Telp:</label>
                <input type="text" name="telp" class="form-control">
              </div>
              <div class="form-group">
                <label>Gender:</label>
                <input type="text" name="gender" class="form-control">
              </div>
              <div class="form-group">
                <label>Semester:</label>
                <input type="text" name="semester" class="form-control">
              </div>
              <div class="form-group">
                <label>Kelas:</label>
                <input type="text" name="kelas" class="form-control">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-outline">Tambah Face ID</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

    </section>
    <!-- /.content -->
  </div>
<?php
} else if ($set=="edit-face") {
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Data Face ID
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-user"></i> Data Face ID</a></li>
        <li class="active">Edit Data Face ID</li>
      </ol>
    </section>

        <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <?php echo $this->session->flashdata('pesan');?>
              <h1 class="box-title text-danger">ID Device <?php if(isset($id_devices)){echo $id_devices;}?></h1>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?=base_url();?>admin/save_edit_face" method="post">              
              <div class="box-body">
                <div class="form-group">
                  <input type="hidden" name="id_face_table" value="<?php if(isset($id_face_table)){echo $id_face_table;}?>">
                  <!-- <label>ID Device</label>
                  <input type="number" name="id" class="form-control" placeholder="Enter id" required> -->
                </div>
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" name="nama" class="form-control" placeholder="nama" value="<?php if(isset($nama)){echo $nama;}?>" required>
                </div>
                <div class="form-group">
                  <label>NIM</label>
                  <input type="text" name="nim" class="form-control" placeholder="nim" value="<?php if(isset($nim)){echo $nim;}?>" required>
                </div>
                <div class="form-group">
                  <label>Telp</label>
                  <input type="text" name="telp" class="form-control" placeholder="telp" value="<?php if(isset($telp)){echo $telp;}?>" required>
                </div>
                <div class="form-group">
                  <label>Gender</label>
                  <input type="text" name="gender" class="form-control" placeholder="gender" value="<?php if(isset($gender)){echo $gender;}?>" required>
                </div>
                <div class="form-group">
                  <label>Semester</label>
                  <input type="text" name="semester" class="form-control" placeholder="semester" value="<?php if(isset($semester)){echo $semester;}?>" required>
                </div>
                <div class="form-group">
                  <label>Kelas</label>
                  <input type="text" name="kelas" class="form-control" placeholder="kelas" value="<?php if(isset($kelas)){echo $kelas;}?>" required>
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
<!-- page script -->
<script>
  $(function () {
    $("#t1").DataTable();
  });
</script>

<script type="text/javascript">
    var ajax_call = function(){
      $.getJSON("<?=base_url();?>api/addrfid", function(result){
          //console.log(result);
          
          if (result.status == "1") {
            document.getElementById("rfid").value = result.rfid;
          }
      });
    };
    var interval = 1000; // where 1000 is 1 second

    setInterval(ajax_call, interval);
</script>

</body>
</html>