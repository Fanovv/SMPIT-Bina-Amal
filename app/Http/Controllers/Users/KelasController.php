<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Imports\KelasImport;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class KelasController extends Controller
{

    public function showAddClass()
    {
        return view('classes.addClasses', ['title' => 'Management Kelas']);
    }

    private function getUserID($name)
    {
        return User::where('name', 'LIKE', '%' . $name . '%')->firstOrFail()->id;
    }

    public function addClasses(Request $request)
    {
        $validateData = $request->validate([
            'class_name' => 'required',
            'wali_1' => 'required',
        ]);

        $validateData['wali_1'] = $this->getUserID($request->input('wali_1'));

        if (isset($request->wali_2)) {
            $validateData['wali_2'] = $this->getUserID($request->input('wali_2'));
        }

        $check = Kelas::create($validateData);

        if (Auth::user()->level == 'admin') {
            return redirect()->route('classes.manageClass')->with($check ? ['success' => 'Data Berhasil Ditambah'] : ['fail' => 'Data Gagal Ditambah']);
        } else if (Auth::user()->level == 'tu') {
            return redirect()->route('tu.classes.manageClass')->with($check ? ['success' => 'Data Berhasil Ditambah'] : ['fail' => 'Data Gagal Ditambah']);
        }
    }

    public function manage()
    {
        return view('classes.manageClass', [
            "title" => "Management Kelas",
            "data" => Kelas::orderBy('class_name', 'ASC')->get()
        ]);
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        $wali_1 = User::where('id', $kelas->wali_1)->value('name');
        $wali_2 = $kelas->wali_2 ? User::where('id', $kelas->wali_2)->value('name') : null;

        return view('classes.editClass', [
            "title" => "Management Kelas",
            "data" => $kelas,
            "id" => $id,
            "wali_1" => $wali_1,
            "wali_2" => $wali_2
        ]);
    }

    public function update(Request $request, $id)
    {
        if (isset($request->wali_2)) {
            $check = Kelas::where('id', $id)->update([
                'class_name' => $request->class_name,
                'wali_1' => $this->getUserID($request->input('wali_1')),
                'wali_2' => $this->getUserID($request->input('wali_2')),
            ]);

            if (Auth::user()->level == 'admin') {
                return redirect()->route('classes.manageClass')->with($check ? ['success' => 'Data berhasil diubah'] : ['fail' => 'Data gagal diubah']);
            } else if (Auth::user()->level == 'tu') {
                return redirect()->route('tu.classes.manageClass')->with($check ? ['success' => 'Data berhasil diubah'] : ['fail' => 'Data gagal diubah']);
            }
        } else if (empty($wali_2) && empty($request->wali_2)) {
            $check = Kelas::where('id', $id)->update([
                'class_name' => $request->class_name,
                'wali_1' => $this->getUserID($request->input('wali_1')),
                'wali_2' => null
            ]);

            if (Auth::user()->level == 'admin') {
                return redirect()->route('classes.manageClass')->with($check ? ['success' => 'Data berhasil diubah'] : ['fail' => 'Data gagal diubah']);
            } else if (Auth::user()->level == 'tu') {
                return redirect()->route('tu.classes.manageClass')->with($check ? ['success' => 'Data berhasil diubah'] : ['fail' => 'Data gagal diubah']);
            }
        } else {
            $check = Kelas::where('id', $id)->update([
                'class_name' => $request->class_name,
                'wali_1' => $this->getUserID($request->input('wali_1')),
            ]);

            if (Auth::user()->level == 'admin') {
                return redirect()->route('classes.manageClass')->with($check ? ['success' => 'Data berhasil diubah'] : ['fail' => 'Data gagal diubah']);
            } else if (Auth::user()->level == 'tu') {
                return redirect()->route('tu.classes.manageClass')->with($check ? ['success' => 'Data berhasil diubah'] : ['fail' => 'Data gagal diubah']);
            }
        }
    }

    public function destroyKelas(Kelas $id)
    {
        $check = Kelas::where('id', $id->id)->delete();

        if (Auth::user()->level == 'admin') {
            return redirect()->route('classes.manageClass')->with($check ? ['success' => 'Data berhasil dihapus'] : ['fail' => 'Data gagal dihapus']);
        } else if (Auth::user()->level == 'tu') {
            return redirect()->route('tu.classes.manageClass')->with($check ? ['success' => 'Data berhasil dihapus'] : ['fail' => 'Data gagal dihapus']);
        }
    }

    public function showImport()
    {
        return view('classes.importClass', ['title' => 'Management Kelas']);
    }

    public function import_excel(Request $request)
    {
        $this->validate($request, [
            'file_kelas' => 'required|mimes:csv,xls,xlsx',
        ]);

        $file = $request->file('file_kelas');
        $nama_file = rand() . $file->getClientOriginalName();
        $file->move('file_kelas', $nama_file);
        $check = FacadesExcel::import(new KelasImport, public_path('/file_kelas/' . $nama_file));
        unlink(public_path('/file_kelas/' . $nama_file));

        if (Auth::user()->level == 'admin') {
            return redirect()->route('classes.manageClass')->with($check ? ['success' => 'Data berhasil diimport'] : ['fail' => 'Data gagal diimport']);
        } else if (Auth::user()->level == 'tu') {
            return redirect()->route('tu.classes.manageClass')->with($check ? ['success' => 'Data berhasil diimport'] : ['fail' => 'Data gagal diimport']);
        }
    }
}
