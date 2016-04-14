@extends('app')
@section('content')
<!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Daftar Jenis Sampah</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Jenis Sampah</th>
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($item as $index => $item_item)
                        <tr>
                          <td>{{ $index + 1 }}</td>
                          <td>{{ $item_item->nama }}</td>
                          <td class="tools">
                            <!-- Trigger the modal with a button -->
                            <a href="#">
                            <span class="glyphicon glyphicon-pencil" data-toggle="modal" data-target="#editModal"></span>
                            </a>
                          </td>
                          <td class="tools">
                           <a href="#">
                            <span class="glyphicon glyphicon-trash" data-toggle="modal" data-target="#deleteModal"></span>
                            </a>
                          </td>
                        </tr>


                        <!--Edit Modal -->
                      <div id="editModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Edit Item</h4>
                            </div>
                            <div class="modal-body">
                             <form method="POST" action="{{ url('/item') }}" role="form">
                              <input name="_method" type="hidden" value="PUT">
                              <input name="nama_lama" type="hidden" value="{{ $item_item->nama }}">
                              <div class="box-body">
                                <div class="form-group">
                                  <label for="inputNama">Nama Item</label>
                                  <input name="nama_baru" type="text" class="form-control" id="inputNama" value="{{ $item_item->nama }}">
                                </div>
                              </div><!-- /.box-body -->
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Edit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                              </div>
                            </form>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!--Delete Modal -->
                      <div id="deleteModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Perhatian !!!</h4>
                            </div>
                            <div class="modal-body">
                              <p>Jika anda menghapus item ini, semua data penjualan dan penyetoran sampah jenis {{$item_item->nama}} akan dihapus </p>
                              <p>Apakah anda yakin ingin menghapus item {{$item_item->nama}} ?</p>
                            </div>
                            <div class="modal-footer">
                            
                              <form method="POST" action="{{ url('/item') }}" role="form">
                                <input name="_method" type="hidden" value="DELETE">
                                <input name="nama" type="hidden" value="{{ $item_item->nama }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="box-footer">
                                  <button type="submit" class="btn btn-danger">Hapus</button>
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                </div>
                              </form>
                              
                            </div>
                          </div>
                        </div>
                      </div>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>No</th>
                        <th>Nama Jenis Sampah</th>
                         <th></th>
                        <th></th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Item Baru</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form method="POST" action="{{ url('/item') }}" role="form">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="inputId">Nama Jenis Sampah</label>
                      <input name="nama" type="text" class="form-control" id="inputId" placeholder="masukkan jenis sampah">
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