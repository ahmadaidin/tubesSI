<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;

use App\Setor;
use App\Cabang;
use App\Jual;
use App\Item;
use DB;

class StatisticsController extends Controller
{
    function getStatistikPenyetoran(Request $request){
        $numberOfWeeksShown = 6;

        if ($request->isMethod('post')) {
            // Format : mm/dd/yy
            $end_date = explode("/", $request->input('end_date'));
            $start_date = explode("/", $request->input('start_date'));

            $checker = Carbon::create($end_date[2], $end_date[0], $end_date[1], 12, 0, 0);
            if ($checker->dayOfWeek != Carbon::SUNDAY){
                $end_date = explode("-", date('Y-m-d', strtotime('next Sunday', strtotime($end_date[1].'.'.$end_date[0].'.'.$end_date[2]))));
            } else {
                $temp = $end_date[0];
                $end_date[0] = $end_date[2];
                $end_date[2] = $end_date[1];
                $end_date[1] = $temp;
            }

            $checker = Carbon::create($start_date[2], $start_date[0], $start_date[1], 12, 0, 0);
            if ($checker->dayOfWeek != Carbon::SUNDAY){
                $start_date = explode("-", date('Y-m-d', strtotime('next Sunday', strtotime($start_date[1].'.'.$start_date[0].'.'.$start_date[2]))));
            } else {
                $temp = $start_date[0];
                $start_date[0] = $start_date[2];
                $start_date[2] = $start_date[1];
                $start_date[1] = $temp;
            }

            // Argument Format : yy/mm/dd
            $end_date = Carbon::createFromDate($end_date[0], $end_date[1], $end_date[2], 'Asia/Jakarta');
            $start_date = Carbon::createFromDate($start_date[0], $start_date[1], $start_date[2], 'Asia/Jakarta');

            // return $end_date;

            $numberOfWeeksShown = $end_date->diffInWeeks($start_date);

            $default_end_date = $end_date->format('m/d/Y');
            $default_start_date = $end_date->copy()->subWeeks($numberOfWeeksShown)->format('m/d/Y');
            $default_cabang = $request->input('cabang');
        } else if ($request->isMethod('get')) {
            // $end_date = Carbon::now('Asia/Jakarta');
            $end_date = Carbon::parse('last sunday', 'Asia/Jakarta');

            $default_end_date = $end_date->format('m/d/Y');
            $default_start_date = $end_date->copy()->subWeeks($numberOfWeeksShown)->format('m/d/Y');
            $default_cabang = '-';
        }

        $jumlah_setor_data = array();
        $jumlah_nasabah_data = array();
        $jumlah_massa_data = array();
        $jumlah_uang_data = array();
        $labels = array();
        $dataLabels = array();

        $items = Item::get();

        foreach ($items as $item){
            $dataLabels[] = $item;
        }

        for ($i=0;$i<=$numberOfWeeksShown;$i++){
            // Jumlah setoran per minggu
            $setor = Setor::where('tanggal', '<=', $end_date->copy()->subWeeks($i))
                        ->where('tanggal', '>', $end_date->copy()->subWeeks($i+1));

            if ($request->isMethod('post') && $request->input('cabang') != '-') {
                $setor->where('id_cabang', '=', $request->input('cabang'));
            }

            $count = $setor->count();

            $jumlah_setor_data[] = $count;
            $labels[] = $end_date->copy()->subWeeks($i)->format('d M Y');


            // Jumlah Nasabah yang menyetor per minggu
            $setor = Setor::where('tanggal', '<=', $end_date->copy()->subWeeks($i))
                        ->where('tanggal', '>', $end_date->copy()->subWeeks($i+1));

            if ($request->isMethod('post') && $request->input('cabang') != '-') {
                $setor->where('id_cabang', '=', $request->input('cabang'));
            }

            $count = $setor->distinct('nama_nasabah')->count('nama_nasabah');

            $jumlah_nasabah_data[] = $count;

            // Jumlah massa penyetoran tiap jenis sampah per minggu
            $jual = DB::table('jual')->select('nama_item', DB::raw('sum(berat) as total_massa'))
                        ->where('tanggal', '<=', $end_date->copy()->subWeeks($i))
                        ->where('tanggal', '>', $end_date->copy()->subWeeks($i+1));

            if ($request->isMethod('post') && $request->input('cabang') != '-') {
                $jual->where('id_cabang', '=', $request->input('cabang'));
            }

            $count = $jual->groupBy('nama_item')->get();

            $jumlah_massa_data[] = $count;

            // Jumlah uang penyetoran tiap jenis sampah per minggu
            $jual = DB::table('jual')->select('nama_item', DB::raw('sum(harga) as total_harga'))
                        ->where('tanggal', '<=', $end_date->copy()->subWeeks($i))
                        ->where('tanggal', '>', $end_date->copy()->subWeeks($i+1));

            if ($request->isMethod('post') && $request->input('cabang') != '-') {
                $jual->where('id_cabang', '=', $request->input('cabang'));
            }

            $count = $jual->groupBy('nama_item')->get();

            $jumlah_uang_data[] = $count;
        }

        $result_massa = array();
        $result_uang = array();

        // Jumlah massa penyetoran tiap jenis sampah per minggu
        foreach ($dataLabels as $label) {
            $result_massa[$label->nama] = array();
        }

        foreach ($jumlah_massa_data as $datum){
            foreach ($dataLabels as $label) {
                $result_massa[$label->nama][] = 0;
            }

            foreach ($datum as $atom) {
                array_pop($result_massa[$atom->nama_item]);
                $result_massa[$atom->nama_item][] = (int)$atom->total_massa;
            }
        }

        foreach ($result_massa as $key => $value) {
            $result_massa[$key] = json_encode(array_reverse($value));
        }

        // Jumlah uang penyetoran tiap jenis sampah per minggu
        foreach ($dataLabels as $label) {
            $result_uang[$label->nama] = array();
        }

        foreach ($jumlah_uang_data as $datum){
            foreach ($dataLabels as $label) {
                $result_uang[$label->nama][] = 0;
            }

            foreach ($datum as $atom) {
                array_pop($result_uang[$atom->nama_item]);
                $result_uang[$atom->nama_item][] = (int)$atom->total_harga;
            }
        }

        foreach ($result_uang as $key => $value) {
            $result_uang[$key] = json_encode(array_reverse($value));
        }

        $jumlah_setor_data = json_encode(array_reverse($jumlah_setor_data));
        $jumlah_nasabah_data = json_encode(array_reverse($jumlah_nasabah_data));
        $labels = json_encode(array_reverse($labels));

        $cabang = Cabang::get();

        return view('statistics.index', compact('jumlah_setor_data', 'jumlah_nasabah_data', 'dataLabels', 'labels', 'default_start_date', 'default_end_date', 'cabang', 'default_cabang', 'result_uang', 'result_massa'));
    }

    function getJumlahSetoran(Request $request){

        $numberOfWeeksShown = 6;

        if ($request->isMethod('post')) {
            // Format : mm/dd/yy
            $end_date = explode("/", $request->input('end_date'));
            $start_date = explode("/", $request->input('start_date'));

            $checker = Carbon::create($end_date[2], $end_date[0], $end_date[1], 12, 0, 0);
            if ($checker->dayOfWeek != Carbon::SUNDAY){
                $end_date = explode("-", date('Y-m-d', strtotime('next Sunday', strtotime($end_date[1].'.'.$end_date[0].'.'.$end_date[2]))));
            } else {
                $temp = $end_date[0];
                $end_date[0] = $end_date[2];
                $end_date[2] = $end_date[1];
                $end_date[1] = $temp;
            }

            $checker = Carbon::create($start_date[2], $start_date[0], $start_date[1], 12, 0, 0);
            if ($checker->dayOfWeek != Carbon::SUNDAY){
                $start_date = explode("-", date('Y-m-d', strtotime('next Sunday', strtotime($start_date[1].'.'.$start_date[0].'.'.$start_date[2]))));
            } else {
                $temp = $start_date[0];
                $start_date[0] = $start_date[2];
                $start_date[2] = $start_date[1];
                $start_date[1] = $temp;
            }

            // Argument Format : yy/mm/dd
            $end_date = Carbon::createFromDate($end_date[0], $end_date[1], $end_date[2], 'Asia/Jakarta');
            $start_date = Carbon::createFromDate($start_date[0], $start_date[1], $start_date[2], 'Asia/Jakarta');

            // return $end_date;

            $numberOfWeeksShown = $end_date->diffInWeeks($start_date);

            $default_end_date = $end_date->format('m/d/Y');
            $default_start_date = $end_date->copy()->subWeeks($numberOfWeeksShown)->format('m/d/Y');
            $default_cabang = $request->input('cabang');
        } else if ($request->isMethod('get')) {
            // $end_date = Carbon::now('Asia/Jakarta');
            $end_date = Carbon::parse('last sunday', 'Asia/Jakarta');

            $default_end_date = $end_date->format('m/d/Y');
            $default_start_date = $end_date->copy()->subWeeks($numberOfWeeksShown)->format('m/d/Y');
            $default_cabang = '-';
        }

        $data = array();
        $labels = array();

        for ($i=0;$i<=$numberOfWeeksShown;$i++){
            $setor = Setor::where('tanggal', '<=', $end_date->copy()->subWeeks($i))
                        ->where('tanggal', '>', $end_date->copy()->subWeeks($i+1));

            if ($request->isMethod('post') && $request->input('cabang') != '-') {
                $setor->where('id_cabang', '=', $request->input('cabang'));
            }

            $count = $setor->count();

            $data[] = $count;
            $labels[] = $end_date->copy()->subWeeks($i)->format('d M Y');
        }


        $data = json_encode(array_reverse($data));
        $labels = json_encode(array_reverse($labels));

        $cabang = Cabang::get();

        return view('statistics.setoran', compact('data', 'labels', 'default_start_date', 'default_end_date', 'cabang', 'default_cabang'));
    }

    function getJumlahNasabah(Request $request){

        $numberOfWeeksShown = 6;

        if ($request->isMethod('post')) {
            // Format : mm/dd/yy
            $end_date = explode("/", $request->input('end_date'));
            $start_date = explode("/", $request->input('start_date'));

            $checker = Carbon::create($end_date[2], $end_date[0], $end_date[1], 12, 0, 0);
            if ($checker->dayOfWeek != Carbon::SUNDAY){
                $end_date = explode("-", date('Y-m-d', strtotime('next Sunday', strtotime($end_date[1].'.'.$end_date[0].'.'.$end_date[2]))));
            } else {
                $temp = $end_date[0];
                $end_date[0] = $end_date[2];
                $end_date[2] = $end_date[1];
                $end_date[1] = $temp;
            }

            $checker = Carbon::create($start_date[2], $start_date[0], $start_date[1], 12, 0, 0);
            if ($checker->dayOfWeek != Carbon::SUNDAY){
                $start_date = explode("-", date('Y-m-d', strtotime('next Sunday', strtotime($start_date[1].'.'.$start_date[0].'.'.$start_date[2]))));
            } else {
                $temp = $start_date[0];
                $start_date[0] = $start_date[2];
                $start_date[2] = $start_date[1];
                $start_date[1] = $temp;
            }

            // Argument Format : yy/mm/dd
            $end_date = Carbon::createFromDate($end_date[0], $end_date[1], $end_date[2], 'Asia/Jakarta');
            $start_date = Carbon::createFromDate($start_date[0], $start_date[1], $start_date[2], 'Asia/Jakarta');

            // return $end_date;

            $numberOfWeeksShown = $end_date->diffInWeeks($start_date);

            $default_end_date = $end_date->format('m/d/Y');
            $default_start_date = $end_date->copy()->subWeeks($numberOfWeeksShown)->format('m/d/Y');
            $default_cabang = $request->input('cabang');
        } else if ($request->isMethod('get')) {
            // $end_date = Carbon::now('Asia/Jakarta');
            $end_date = Carbon::parse('last sunday', 'Asia/Jakarta');

            $default_end_date = $end_date->format('m/d/Y');
            $default_start_date = $end_date->copy()->subWeeks($numberOfWeeksShown)->format('m/d/Y');
            $default_cabang = '-';
        }

        $data = array();
        $labels = array();

        for ($i=0;$i<=$numberOfWeeksShown;$i++){
            $setor = Setor::where('tanggal', '<=', $end_date->copy()->subWeeks($i))
                        ->where('tanggal', '>', $end_date->copy()->subWeeks($i+1));

            if ($request->isMethod('post') && $request->input('cabang') != '-') {
                $setor->where('id_cabang', '=', $request->input('cabang'));
            }

            $count = $setor->distinct('nama_nasabah')->count('nama_nasabah');

            $data[] = $count;
            $labels[] = $end_date->copy()->subWeeks($i)->format('d M Y');
        }


        $data = json_encode(array_reverse($data));
        $labels = json_encode(array_reverse($labels));

        $cabang = Cabang::get();

        return view('statistics.nasabah', compact('data', 'labels', 'default_start_date', 'default_end_date', 'cabang', 'default_cabang'));
    }

    function getJumlahMassaTiapSampah(Request $request){
        $numberOfWeeksShown = 6;

        if ($request->isMethod('post')) {
            // Format : mm/dd/yy
            $end_date = explode("/", $request->input('end_date'));
            $start_date = explode("/", $request->input('start_date'));

            $checker = Carbon::create($end_date[2], $end_date[0], $end_date[1], 12, 0, 0);
            if ($checker->dayOfWeek != Carbon::SUNDAY){
                $end_date = explode("-", date('Y-m-d', strtotime('next Sunday', strtotime($end_date[1].'.'.$end_date[0].'.'.$end_date[2]))));
            } else {
                $temp = $end_date[0];
                $end_date[0] = $end_date[2];
                $end_date[2] = $end_date[1];
                $end_date[1] = $temp;
            }

            $checker = Carbon::create($start_date[2], $start_date[0], $start_date[1], 12, 0, 0);
            if ($checker->dayOfWeek != Carbon::SUNDAY){
                $start_date = explode("-", date('Y-m-d', strtotime('next Sunday', strtotime($start_date[1].'.'.$start_date[0].'.'.$start_date[2]))));
            } else {
                $temp = $start_date[0];
                $start_date[0] = $start_date[2];
                $start_date[2] = $start_date[1];
                $start_date[1] = $temp;
            }

            // Argument Format : yy/mm/dd
            $end_date = Carbon::createFromDate($end_date[0], $end_date[1], $end_date[2], 'Asia/Jakarta');
            $start_date = Carbon::createFromDate($start_date[0], $start_date[1], $start_date[2], 'Asia/Jakarta');

            // return $end_date;

            $numberOfWeeksShown = $end_date->diffInWeeks($start_date);

            $default_end_date = $end_date->format('m/d/Y');
            $default_start_date = $end_date->copy()->subWeeks($numberOfWeeksShown)->format('m/d/Y');
            $default_cabang = $request->input('cabang');
        } else if ($request->isMethod('get')) {
            // $end_date = Carbon::now('Asia/Jakarta');
            $end_date = Carbon::parse('last sunday', 'Asia/Jakarta');

            $default_end_date = $end_date->format('m/d/Y');
            $default_start_date = $end_date->copy()->subWeeks($numberOfWeeksShown)->format('m/d/Y');
            $default_cabang = '-';
        }

        $data = array();
        $dataLabels = array();
        $labels = array();

        $items = Item::get();

        foreach ($items as $item){
            $dataLabels[] = $item;
        }

        for ($i=0;$i<=$numberOfWeeksShown;$i++){
            $jual = DB::table('jual')->select('nama_item', DB::raw('sum(berat) as total_massa'))
                        ->where('tanggal', '<=', $end_date->copy()->subWeeks($i))
                        ->where('tanggal', '>', $end_date->copy()->subWeeks($i+1));

            if ($request->isMethod('post') && $request->input('cabang') != '-') {
                $jual->where('id_cabang', '=', $request->input('cabang'));
            }

            $count = $jual->groupBy('nama_item')->get();

            $data[] = $count;
            $labels[] = $end_date->copy()->subWeeks($i)->format('d M Y');
        }

        $result = array();

        foreach ($dataLabels as $label) {
            $result[$label->nama] = array();
        }

        foreach ($data as $datum){
            foreach ($dataLabels as $label) {
                $result[$label->nama][] = 0;
            }

            foreach ($datum as $atom) {
                array_pop($result[$atom->nama_item]);
                $result[$atom->nama_item][] = (int)$atom->total_massa;
            }
        }

        foreach ($result as $key => $value) {
            $result[$key] = json_encode(array_reverse($value));
        }

        $labels = json_encode(array_reverse($labels));
        $cabang = Cabang::get();

        return view('statistics.massa', compact('data', 'dataLabels', 'labels', 'default_start_date', 'default_end_date', 'cabang', 'default_cabang', 'result'));
    }

    function getJumlahUangTiapSampah(Request $request){
        $numberOfWeeksShown = 6;

        if ($request->isMethod('post')) {
            // Format : mm/dd/yy
            $end_date = explode("/", $request->input('end_date'));
            $start_date = explode("/", $request->input('start_date'));

            $checker = Carbon::create($end_date[2], $end_date[0], $end_date[1], 12, 0, 0);
            if ($checker->dayOfWeek != Carbon::SUNDAY){
                $end_date = explode("-", date('Y-m-d', strtotime('next Sunday', strtotime($end_date[1].'.'.$end_date[0].'.'.$end_date[2]))));
            } else {
                $temp = $end_date[0];
                $end_date[0] = $end_date[2];
                $end_date[2] = $end_date[1];
                $end_date[1] = $temp;
            }

            $checker = Carbon::create($start_date[2], $start_date[0], $start_date[1], 12, 0, 0);
            if ($checker->dayOfWeek != Carbon::SUNDAY){
                $start_date = explode("-", date('Y-m-d', strtotime('next Sunday', strtotime($start_date[1].'.'.$start_date[0].'.'.$start_date[2]))));
            } else {
                $temp = $start_date[0];
                $start_date[0] = $start_date[2];
                $start_date[2] = $start_date[1];
                $start_date[1] = $temp;
            }

            // Argument Format : yy/mm/dd
            $end_date = Carbon::createFromDate($end_date[0], $end_date[1], $end_date[2], 'Asia/Jakarta');
            $start_date = Carbon::createFromDate($start_date[0], $start_date[1], $start_date[2], 'Asia/Jakarta');

            // return $end_date;

            $numberOfWeeksShown = $end_date->diffInWeeks($start_date);

            $default_end_date = $end_date->format('m/d/Y');
            $default_start_date = $end_date->copy()->subWeeks($numberOfWeeksShown)->format('m/d/Y');
            $default_cabang = $request->input('cabang');
        } else if ($request->isMethod('get')) {
            // $end_date = Carbon::now('Asia/Jakarta');
            $end_date = Carbon::parse('last sunday', 'Asia/Jakarta');

            $default_end_date = $end_date->format('m/d/Y');
            $default_start_date = $end_date->copy()->subWeeks($numberOfWeeksShown)->format('m/d/Y');
            $default_cabang = '-';
        }

        $data = array();
        $dataLabels = array();
        $labels = array();

        $items = Item::get();

        foreach ($items as $item){
            $dataLabels[] = $item;
        }

        for ($i=0;$i<=$numberOfWeeksShown;$i++){
            $jual = DB::table('jual')->select('nama_item', DB::raw('sum(harga) as total_harga'))
                        ->where('tanggal', '<=', $end_date->copy()->subWeeks($i))
                        ->where('tanggal', '>', $end_date->copy()->subWeeks($i+1));

            if ($request->isMethod('post') && $request->input('cabang') != '-') {
                $jual->where('id_cabang', '=', $request->input('cabang'));
            }

            $count = $jual->groupBy('nama_item')->get();

            $data[] = $count;
            $labels[] = $end_date->copy()->subWeeks($i)->format('d M Y');
        }

        $result = array();

        foreach ($dataLabels as $label) {
            $result[$label->nama] = array();
        }

        foreach ($data as $datum){
            foreach ($dataLabels as $label) {
                $result[$label->nama][] = 0;
            }

            foreach ($datum as $atom) {
                array_pop($result[$atom->nama_item]);
                $result[$atom->nama_item][] = (int)$atom->total_harga;
            }
        }

        foreach ($result as $key => $value) {
            $result[$key] = json_encode(array_reverse($value));
        }

        $labels = json_encode(array_reverse($labels));
        $cabang = Cabang::get();

        return view('statistics.uang', compact('data', 'dataLabels', 'labels', 'default_start_date', 'default_end_date', 'cabang', 'default_cabang', 'result'));
    }

}
