<?php 
 
namespace App\Http\Controllers; 
 
use App\Models\Mahasiswa; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use App\Models\Kelas;
 
class MahasiswaController extends Controller 
{ 
   /** 
*	Display a listing of the resource. 
     * 
*	@return \Illuminate\Http\Response 
     */ 
    public function index() 
    { 
          //fungsi eloquent menampilkan data menggunakan pagination
        // $mahasiswa = DB::table('mahasiswa')->paginate(4);
        // return view('mahasiswa.index', compact('mahasiswa'));
        $mahasiswa = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(3);         
        return view('mahasiswa.index', ['mahasiswa' => $mahasiswa,'paginate'=>$paginate]);
    }
    public function create() 
    { 
        $kelas = Kelas::all();//mendapatkan data dari tabel kelas
        return view('mahasiswa.create',['kelas' => $kelas]); 
    } 
    public function store(Request $request) 
    { 
    //melakukan validasi data 
        $request->validate([ 
            'Nim' => 'required', 
            'Nama' => 'required', 
            'Kelas' => 'required', 
            'Jurusan' => 'required', 
            // 'Email' => 'required',
            // 'Alamat' => 'required',
            // 'Tanggal_lahir' => 'required',
        ]); 

        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');
 
        //fungsi eloquent untuk menambah data dengan relasi belongsTo
       $mahasiswa->kelas()->associate($kelas);
       $mahasiswa->save();
        // Mahasiswa::create($request->all()); 

 

        //jika data berhasil ditambahkan, akan kembali ke halaman utama         
        return redirect()->route('mahasiswa.index') 
            ->with('success', 'Mahasiswa Berhasil Ditambahkan'); 
    } 
 
    public function show($nim) 
    { 
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa 
            //   $Mahasiswa = Mahasiswa::where('nim', $nim)->first();   
            $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
              return view('mahasiswa.detail', ['Mahasiswa' => $mahasiswa]); 
    } 
 
    public function edit($nim) 
    { 
 
 //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit 
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first(); 
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas        
        return view('mahasiswa.edit', compact('Mahasiswa')); 
    } 
 
    public function update(Request $request, $nim) 
    { 
 
 //melakukan validasi data 
        $request->validate([ 
            'Nim' => 'required', 
            'Nama' => 'required', 
            'Kelas' => 'required', 
            'Jurusan' => 'required', 
                    
        ]); 

        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');
 
 //fungsi eloquent untuk mengupdate data dengan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();
       
 
 
//jika data berhasil diupdate, akan kembali ke halaman utama 
        return redirect()->route('mahasiswa.index') 
            ->with('success', 'Mahasiswa Berhasil Diupdate'); 
    } 
    public function destroy( $nim) 
     { 
 //fungsi eloquent untuk menghapus data 
         Mahasiswa::where('nim', $nim)->delete(); 
 
        return redirect()->route('mahasiswa.index')             -> with('success', 'Mahasiswa Berhasil Dihapus'); 
     } 
     public function search(Request $request)
    {
        $keyword = $request->search;
        $mahasiswa = Mahasiswa::where('Nama', 'like', '%' . $keyword . '%')->paginate(4);
        return view('mahasiswa.index', compact('mahasiswa'));
    }
}; 