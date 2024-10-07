<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\kanvasing_aisyiah;
use App\Models\agamas;
use App\Models\pekerjaan;
use App\Models\data_ganda;

use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;

class KanvasingAisyiahController extends Controller
{
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware(['permission:KanvasingAisyiah index,admin'])->only(['indexAdmin']);
        $this->middleware(['permission:KanvasingAisyiah create,admin'])->only(['store']);
        $this->middleware(['permission:KanvasingAisyiah update,admin'])->only(['update']);
        $this->middleware(['permission:KanvasingAisyiah delete,admin'])->only('destroy');
    }

    public function index()
    {
        $userId = auth()->id();
        $kanvasing = kanvasing_aisyiah::with('agama', 'pekerjaan')
            ->where('user_id', $userId)
            ->get();

        $agamas = agamas::all();
        $pekerjaans = pekerjaan::all();

        return view('mobile.kanvasing_aisyiah.index', compact('kanvasing', 'agamas', 'pekerjaans'));
    }

    public function indexAdmin()
    {
        $kanvasing = kanvasing_aisyiah::with('agama', 'pekerjaan')->get();
        $agamas = agamas::all();
        $pekerjaans = pekerjaan::all();

        return view('admin.kanvasing_aisyiah.index', compact('kanvasing', 'agamas', 'pekerjaans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_responden' => 'required|string|max:100',
            // 'agama_id' => 'required|exists:agamas,id',
            'pekerjaan_id' => 'required|exists:pekerjaans,id',
            'alamat' => 'required|string',
            'no_ktp' => 'required|string|unique:kanvasing_aisyiah,no_ktp',
            'tgl_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'provinsi' => 'required|integer',
            'kabupaten' => 'required|integer',
            'kecamatan' => 'required|integer',
            'kelurahan' => 'required|integer',
            'no_kk' => 'nullable|string|max:16',
            'foto_kegiatan' => 'nullable|string',
            'brosur' => 'boolean',
            'stiker' => 'boolean',
            'kartu_coblos' => 'boolean',
            'longitude' => 'nullable|string',
            'latitude' => 'nullable|string',
        ]);

        $imagePath = $this->handleFileUpload($request, 'foto_kegiatan');

        $kanvasing = kanvasing_aisyiah::create($request->all() + [
            'user_id' => auth()->id(),
            'foto_kegiatan' => $imagePath,
        ]);

        // Simpan data ke model data_ganda
        data_ganda::create([
            'kecamatan' => $request->input('kecamatan'),
            'nagari' => $request->input('nagari'),
            'no_ktp' => $request->input('no_ktp'),
            'no_kk' => $request->input('no_kk'),
            'nama_responden' => $request->input('nama_responden'),
            'alamat' => $request->input('alamat'),
            'longitude' => $request->input('longitude'),
            'latitude' => $request->input('latitude'),
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }


    public function update(Request $request, $id)
    {
        $kanvasing = kanvasing_aisyiah::findOrFail($id);

        // Validasi update form
        $request->validate([
            'nama_responden' => 'required|string|max:100',
            // 'agama_id' => 'required|exists:agamas,id',
            'pekerjaan_id' => 'required|exists:pekerjaans,id',
            'alamat' => 'required|string',
            'no_ktp' => 'required|string|unique:kanvasing_aisyiah,no_ktp,' . $kanvasing->id,
            'tgl_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'provinsi' => 'required|integer',
            'kabupaten' => 'required|integer',
            'kecamatan' => 'required|integer',
            'kelurahan' => 'required|integer',
            'no_kk' => 'nullable|string|max:16',
            'foto_kegiatan' => 'nullable|string',
            'brosur' => 'boolean',
            'stiker' => 'boolean',
            'kartu_coblos' => 'boolean',
            'longitude' => 'nullable|string',
            'latitude' => 'nullable|string',
        ]);

        if ($request->hasFile('foto_kegiatan')) {
            $imagePath = $this->handleFileUpload($request, 'foto_kegiatan');
            $request->merge(['foto_kegiatan' => $imagePath]);
        }

        $kanvasing->update($request->all());

        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $kanvasing = kanvasing_aisyiah::findOrFail($id);
        $kanvasing->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
