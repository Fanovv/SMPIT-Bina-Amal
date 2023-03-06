<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', ["title" => "Dashboard",]);
    }

    public function addUser()
    {
        return view('admin.addUser', ['title' => 'Management User']);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $validatedData['level'] = 'wali';
        $validatedData['password'] = Hash::make($validatedData['password']);

        $check = User::create($validatedData);

        return redirect('/admin/manage')->with($check ? ['success' => 'Data Berhasil Ditambah'] : ['fail' => 'Data Gagal Ditambah']);
    }

    public function manage()
    {
        return view('admin.manageUser', [
            "title" => "Management User",
            "data" => User::orderBy('name', 'ASC')->get()
        ]);
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->get();
        return view('admin.editUser', [
            "title" => "Management User",
            "data" => $user,
            "id" => $id
        ]);
    }

    public function update(Request $request, $id)
    {
        if (isset($request->password)) {
            $validatedData = $request->validate([
                'email' => 'email',
                'password' => 'min:8',
            ]);

            $check = User::where('id', $id)->update([
                'password' => Hash::make($validatedData['password']),
                'name' => $request->name,
                'email' => $validatedData['email']
            ]);

            return redirect('/admin/manage')->with($check ? ['success' => 'Data berhasil diubah'] : ['fail' => 'Data gagal diubah']);
        } else {
            $validatedData = $request->validate([
                'email' => 'email',
            ]);

            $check = User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $validatedData['email']
            ]);

            return redirect('/admin/manage')->with($check ? ['success' => 'Data berhasil diubah'] : ['fail' => 'Data gagal diubah']);
        }
    }

    public function destroyUser(User $id)
    {
        $check = User::where('id', $id->id)->delete();
        return redirect('/admin/manage')->with($check ? ['success' => 'Data berhasil dihapus'] : ['fail' => 'Data gagal dihapus']);
    }
}
