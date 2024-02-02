<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class DashboardController extends Controller
{
    public function index()
    {   
        $client = new Client();
        // get data from API
        $stunting = $client->request('GET', 'https://sipenting.langsakota.go.id/api/stunting');

        $perkecamatan = $client->request('GET', 'https://sipenting.langsakota.go.id/api/perkecamatan');

        // check if failed to get data
        if ($stunting->getStatusCode() == 200) {
            $stunting = json_decode($stunting->getBody()->getContents(), true);
            $stunting_total = $stunting['total_stunting'];
            $stunting_laki = $stunting['laki'];
            $stunting_perempuan = $stunting['perempuan'];
            $stunting_dibawah_32 = $stunting['stunting_dibawah_32'];
            $stunting_33_59 = $stunting['stunting_33_59'];
            $stunting_diatas_60 = $stunting['stunting_diatas_60'];
            $stunting_sangat_pendek = $stunting['stunting_sangat_pendek'];
        } else {
            $stunting_total = 0;
            $stunting_laki = 0;
            $stunting_perempuan = 0;
            $stunting_dibawah_32 = 0;
            $stunting_33_59 = 0;
            $stunting_diatas_60 = 0;
            $stunting_sangat_pendek = 0;
        }

        if ($perkecamatan->getStatusCode() == 200) {
            $perkecamatan = json_decode($perkecamatan->getBody()->getContents(), true);
        } else {
            $perkecamatan = [];
        }

        $catin = $client->request('GET', 'https://sipenting.langsakota.go.id/api/catin');
        // dd(json_decode($catin->getBody()->getContents(), true));
        if ($catin->getStatusCode() == 200) {
            $catin = json_decode($catin->getBody()->getContents(), true);
            $total_catin = $catin['total_catin'];
            $catin_berisiko = $catin['catin_berisiko'];
            $catin_ideal = $catin['catin_ideal'];
            $catin_dibawah_20 = $catin['catin_dibawah_20'];
            $catin_laki = $catin['catin_laki'];
            $catin_perempuan = $catin['catin_perempuan'];
        } else {
            $catin = [];
            $total_catin = 0;
            $catin_berisiko = 0;
            $catin_ideal = 0;
            $catin_dibawah_20 = 0;
            $catin_laki = 0;
            $catin_perempuan = 0;
        }

        $catin_perkecamatan = $client->request('GET', 'https://sipenting.langsakota.go.id/api/catin-perkecamatan');
        if ($catin_perkecamatan->getStatusCode() == 200) {
            $catin_perkecamatan = json_decode($catin_perkecamatan->getBody()->getContents(), true);
        } else {
            $catin_perkecamatan = [];
        }

        return view('dashboard', [
            'stunting_total' => $stunting_total,
            'stunting_laki' => $stunting_laki,
            'stunting_perempuan' => $stunting_perempuan,
            'stunting_dibawah_32' => $stunting_dibawah_32,
            'stunting_33_59' => $stunting_33_59,
            'stunting_diatas_60' => $stunting_diatas_60,
            'stunting_sangat_pendek' => $stunting_sangat_pendek,
            'perkecamatan' => $perkecamatan,
            'total_catin' => $total_catin,
            'catin_berisiko' => $catin_berisiko,
            'catin_ideal' => $catin_ideal,
            'catin_dibawah_20' => $catin_dibawah_20,
            'catin_laki' => $catin_laki,
            'catin_perempuan' => $catin_perempuan,
            'catin_perkecamatan' => $catin_perkecamatan
        ]);
    }
}
