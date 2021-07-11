<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(){
        return Siswa::all();
    }

    public function create(request $request){
        $siswa = new Siswa;
        $siswa->nama = $request->nama;
        $siswa->alamat = $request->alamat;
        $siswa->save();

        return "Data berhasil masuk";
    }


    public function update(request $request, $id){
        $nama = $request->nama;
        $alamat = $request->alamat;

        $siswa = Siswa::find($id);
        $siswa->nama = $nama;
        $siswa->alamat = $alamat;
        $siswa->save();

        return "Data berhasil diupdate";
    }

    public function delete($id)
    {
        $siswa = Siswa::find($id);
        $siswa->delete();

        return "Data berhasil dihapus";
    }
}
