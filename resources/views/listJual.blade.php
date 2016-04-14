@extends('app')

@section('content-header')
<section class="content-header">
    <h1>Penjualan</h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Penjualan</li>
    </ol>
</section>
@endsection

@section('content')
<!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Daftar Nasabah</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Bank Sampah</th>
                        <th>Pengepul</th>
                        <th>Jenis Sampah</th>
                        <th>Berat Sampah</th>
                        <th>Total Harga</th>
                        <th>Tanggal Jual</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($jual as $index => $jual_item)
                        <tr>
                          <td>{{ $index + 1 }}</td>
                          <td>{{ $jual_item->id_cabang }}</td>
                          <td>{{ $jual_item->pengepul }}</td>
                          <td>{{ $jual_item->nama_item }}</td>
                          <td>{{ $jual_item->berat }} kg</td>
                          <td>Rp {{ $jual_item->harga }}</td>
                          <td>{{date('d F Y', strtotime($jual_item->tanggal))}}</td>
                        </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>No</th>
                        <th>Bank Sampah</th>
                        <th>Pengepul</th>
                        <th>Jenis Sampah</th>
                        <th>Berat Sampah</th>
                        <th>Total Harga</th>
                        <th>Tanggal Jual</th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Bank Sampah Baru</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form method="POST" action="{{ url('/jual') }}" role="form">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="inputId">Bank Sampah</label>
                      <select name="id_cabang" class="form-control m-b">
                        @foreach ($cabang as $cabang_item)
                        <option value="{{ $cabang_item->nomor_registrasi }}">{{ $cabang_item->nama }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="inputNama">Pengepul</label>
                      <input name="pengepul" type="text" class="form-control" id="inputNama" placeholder="masukkan nama pengepul">
                    </div>
                    <div class="form-group">
                      <label for="inputId">Jenis Sampah</label>
                      <select name="nama_item" class="form-control m-b">
                        @foreach ($item as $item_item)
                        <option value="{{ $item_item->nama }}">{{ $item_item->nama }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="inputNama">Berat Sampah (kg)</label>
                      <input name="berat" type="text" class="form-control" id="inputNama" placeholder="masukkan berat sampah">
                    </div>
                    <div class="form-group">
                      <label for="inputNama">Total Harga (Rp)</label>
                      <input name="harga" type="text" class="form-control" id="inputNama" placeholder="masukkan total harga">
                    </div>
                    <div class="form-group">
                      <label for="inputNama">Tanggal Penyetoran</label>
                      <input name="tanggal" type="date" class="form-control" id="inputNama" placeholder="masukkan tanggal penyetoran">
                    </div>
                  </div><!-- /.box-body -->
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
        $('.sidebar-menu a').filter(function() {
            return $(this).text() == $('.content-header h1').text();
        }).closest('li').addClass('active')

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