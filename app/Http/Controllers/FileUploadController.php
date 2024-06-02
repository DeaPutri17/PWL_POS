<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function fileUpload(){
        return view('file-upload');
    }

    public function prosesFileUpload(Request $request){

        $request->validate([
            'berkas'=>'required|file|image|max:500',
        ]);
        //$path = $request->berkas->store('uploads');
        $extfile = $request->berkas->getClientOriginalName();
        $namaFile = 'web-'.time().".". $extfile;

        $path = $request->berkas->move('gambar', $namaFile);
        $path = str_replace("\\","//",$path);
        echo "Variabel path berisi:$path <br>";

        $pathBaru = asset('gambar/' . $namaFile);
        echo "proses upload berhasil, file berada di : $path";
        echo "<br>";
        echo "Tampilkan link:<a href='$pathBaru'>$pathBaru</a>";
        //echo $request->berkas->getClientOriginalName()."lolos validasi";
        //dump($request->berkas);
        // return "Pemrosesan file upload di sini";
        // if($request->hasFile('berkas')){
        //     echo "path(): ".$request->berkas->path();
        //     echo "<br>";
        //     echo "extension(): ".$request->berkas->extension();
        //     echo "<br>";
        //     echo "getClientOriginalExtension(): ".
        //     $request->berkas->getClientOriginalExtension();
        //     echo "<br>";
        //     echo "getMimeType(): ".$request->berkas->getMimeType();
        //     echo "<br>";
        //     echo "getClientOriginalName(): ".
        //     $request->berkas->getClientOriginalName();
        //     echo "<br>";
        //     echo "getSize(): ".$request->berkas->getSize();
        // }else{
        //     echo "Tidak ada berkas yang diupload";
        // }
    }

    public function fileUploadRename(){
        return view('file-upload-rename');
    }

    public function prosesFileUploadRename(Request $request){
        $request->validate([
            'berkas'=>'required|file|image|max:500',
        ]);

        $ext_file = $request->berkas->getClientOriginalExtension();

        $nama_file = $request->input('namaFile');
        $namaFile = $nama_file .time() ."." .$ext_file;

        $path = $request->berkas->move('gambar', $namaFile);
        $path = str_replace("\\","//",$path);

        $pathBaru = asset('gambar/' . $namaFile);

        echo "Gambar berhasil diupload di <a href='$pathBaru'>$nama_file.$ext_file</a>";
        echo "<br><br>";
        echo "<img src='$pathBaru' alt='Gambar' style='max-width: 500px; max-height: 500px;'>";
    }
}
