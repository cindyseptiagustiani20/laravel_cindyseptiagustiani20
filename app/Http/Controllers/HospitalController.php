<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;

class HospitalController extends Controller
{
    public function index() {
        return view('hospitals/index');
    }

    public function paginate(Request $request) {
        $paginate = $request->paginate;
        $page = $request->page;
        $search = $request->search;

        $hospitals = Hospital::where('name', 'like', '%'.$search.'%')
            ->orWhere('address', 'like', '%'.$search.'%')
            ->orWhere('email', 'like', '%'.$search.'%')
            ->orWhere('phone', 'like', '%'.$search.'%')
            ->paginate($paginate, ['*'], 'page', $page);

        return response()->json($hospitals);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'email' => ['required', 'email', 'unique:hospitals,email'],
            'phone' => 'required',
        ]);

        if ($data) {
            $hospital = Hospital::create($data);
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        }

        return response()->json(['message' => 'Data gagal disimpan'], 500);
    }

    public function show($id) {
        $hospital = Hospital::find($id);
        return response()->json($hospital);
    }

    public function update(Request $request, $id) {
        $data = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'email' => ['required', 'email', 'unique:hospitals,email,'.$id],
            'phone' => 'required',
        ]);

        if ($data) {
            $hospital = Hospital::find($id);
            $hospital->update($data);
            return response()->json(['message' => 'Data berhasil diupdate'], 200);
        }

        return response()->json(['message' => 'Data gagal diupdate'], 500);
    }

    public function destroy($id) {
        $hospital = Hospital::find($id);
        $hospital->delete();
        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }
}
