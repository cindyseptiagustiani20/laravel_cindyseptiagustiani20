<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Hospital;

class PatientController extends Controller
{
    public function index() {
        $hospitals = Hospital::get();

        return view('patients/index', compact('hospitals'));
    }

    public function paginate(Request $request) {
        $paginate = $request->paginate;
        $page = $request->page;
        $search = $request->search;
        $search_hospital = $request->hospital_id;
        
        $patients = Patient::with('hospital')
            ->where(function($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('address', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%');
            })
            ->when($search_hospital != 'all', function($query) use ($search_hospital) {
                return $query->where('hospital_id', $search_hospital);
            })
            ->paginate($paginate, ['*'], 'page', $page);

        return response()->json($patients);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'hospital_id' => 'required',
        ]);

        if ($data) {
            Patient::create($data);
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        }

        return response()->json(['message' => 'Data gagal disimpan'], 500);
    }

    public function show($id) {
        $patient = Patient::find($id);
        return response()->json($patient);
    }

    public function update(Request $request, $id) {
        $data = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'hospital_id' => 'required',
        ]);

        if ($data) {
            $patient = Patient::find($id);
            $patient->update($data);
            return response()->json(['message' => 'Data berhasil diupdate'], 200);
        }

        return response()->json(['message' => 'Data gagal diupdate'], 500);
    }

    public function destroy($id) {
        $patient = Patient::find($id);
        $patient->delete();
        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }
}
