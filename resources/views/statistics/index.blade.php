@extends('app')

@section('content-header')
<section class="content-header">
    <h1>Statistik Penyetoran</h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Statistik Penyetoran</li>
    </ol>
</section>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-4">
      <div class="form-group">
        <label>Pilih Cabang:</label>
        <select class="form-control" id="cabang">
          <option data-id="-">Semua</option>
          @foreach ($cabang as $cabang_item)
            <option data-id="{{ $cabang_item->nomor_registrasi }}">{{ $cabang_item->nama }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-sm-8">
      <!-- Date range -->
      <div class="form-group">
        <label>Pilih interval waktu:</label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <input type="text" class="form-control pull-right" id="daterange" value="{{ $default_start_date }} - {{ $default_end_date }}">
        </div><!-- /.input group -->
      </div><!-- /.form group -->
    </div>
  </div>
  <div class="row">
    <div class="col-sm-2 col-sm-offset-10">
      <button class="btn btn-block btn-success" id="filter">Submit</button>
    </div>
</div>
@include('statistics.massa')
@include('statistics.nasabah')
@include('statistics.setoran')
@include('statistics.uang')
<script>
  $(function () {
    $('.sidebar-menu a').filter(function() {
        return $(this).text() == $('.content-header h1').text();
    }).closest('li').addClass('active')
    
    $("#cabang option[data-id='{{ $default_cabang }}']").prop('selected', true);

    var startDate, endDate

    var picker = $('#daterange').daterangepicker().on('apply.daterangepicker', function (ev, picker) {
      startDate = picker.startDate.format("MM/DD/YYYY");
      endDate = picker.endDate.format("MM/DD/YYYY");
    });

    startDate = $('#daterange').data('daterangepicker').startDate._i
    endDate = $('#daterange').data('daterangepicker').endDate._i

    $('#filter').click(function(){
      var form = document.createElement("form");
      var start_date = document.createElement("input");
      var end_date = document.createElement("input");
      var token = document.createElement("input");
      var cabang = document.createElement("input");

      form.method = "POST";
      form.action = "/statistics/penyetoran";   

      start_date.value=startDate;
      start_date.name="start_date";
      form.appendChild(start_date);  

      end_date.value=endDate;
      end_date.name="end_date";
      form.appendChild(end_date);

      token.value="{{ csrf_token() }}";
      token.name="_token";
      token.type="hidden";
      form.appendChild(token);  

      var cabangId = $('#cabang').find(":selected").data('id');

      cabang.value=cabangId;
      cabang.name="cabang";
      form.appendChild(cabang);  

      document.body.appendChild(form);

      form.submit();
    })
  });
</script>
@endsection