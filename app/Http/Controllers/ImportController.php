<?php

namespace App\Http\Controllers;

use App\Http\Resources\LgaStateResource;
use App\Models\LgaState;
use Illuminate\Http\Request;
use App\Imports\LgaStateImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function index()
    {
        $records = LgaState::all();
        $records = collect($records)->keyBy('state')->tapEach(function ($records) {
            return [
                // 'quantity' => $product['quantity'] + $this->getCurrentQuantity($product['id'])
              $records['lga'],
            ];
        })->toArray();

        // $records = $records->groupBy('state');
        // $records = $records->all();

         $data = [
            'status' => 'success',
            'data' => $records,
        ];
        
        return response()->json($data, 200);

        // return $records;
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required', 'mimes:xlsx,xls']
        ]);

        $file = $request->file('file'); 
        $import = new LgaStateImport;
        $import->import($file);

        // Excel::import(new LgaStateImport, $file);

        return "Okay";
    }
}
