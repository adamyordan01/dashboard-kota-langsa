<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    public function index()
    {
        $dataAbsensi = DB::connection('presensi')
            ->table('daftar_mesin')
            ->get();

            // dd($dataAbsensi);

        // check connection
        foreach ($dataAbsensi as $absensi) {
            $absensi->status = $this->_testConnection($absensi->ip_address, $absensi->port) == true ? 'Online' : 'Offline';
        }
        
        return view('absensi.index', compact('dataAbsensi'));
    }

    private function _testConnection($ip, $port)
    {
        $timeout = 1;
        $socket = @fsockopen($ip, $port, $errno, $errstr, $timeout);

        if ($socket) {
            fclose($socket);
            return true;
        } else {
            return false;
        }
    }
}
