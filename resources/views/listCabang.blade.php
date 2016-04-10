@extends('app')
@section('content')
<!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Daftar Cabang</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Kecamatan</th>
                        <th>Kelurahan</th>
                        <th>RW</th>
                        <th>RT</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($cabang as $cabang_item)
                        <tr>
                          <td>{{ $cabang_item->nama }}</td>
                          <td>{{ $cabang_item->nama }}</td>
                          <td>{{ $cabang_item->nama }}</td>
                          <td>{{ $cabang_item->nama }}</td>
                          <td>{{ $cabang_item->nama }}</td>
                          <td>{{ $cabang_item->nama }}</td>
                          <td>{{ $cabang_item->nama }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Kecamatan</th>
                        <th>Kelurahan</th>
                        <th>RW</th>
                        <th>RT</th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Cabang Baru</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="inputId">ID Cabang</label>
                      <input type="text" class="form-control" id="inputId" placeholder="masukkan id cabang">
                    </div>
                    <div class="form-group">
                      <label for="inputNama">Nama Cabang</label>
                      <input type="text" class="form-control" id="inputNama" placeholder="masukkan nama cabang">
                    </div>
                    <div class="form-group">
                      <label for="inputKecamatan">Kecamatan</label>
                      <input type="text" class="form-control" id="inputKecamatan" placeholder="masukkan kecamatan">
                    </div>
                    <div class="form-group">
                      <label for="inputKelurahan">Kelurahan</label>
                      <input type="text" class="form-control" id="inputKelurahan" placeholder="masukkan kelurahan">
                    </div>
                    <div class="form-group">
                      <label for="inputRW">RW</label>
                      <input type="text" class="form-control" id="inputRW" placeholder="masukkan rw">
                    </div>
                    <div class="form-group">
                      <label for="inputRT">RT</label>
                      <input type="text" class="form-control" id="inputRT" placeholder="masukkan rt">
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Tambah</button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
        <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- page script -->
    <script>
      $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
    </script>
@endsection