<?php

namespace App\Imports;

use App\Models\LgaState;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LgaStateImport implements ToCollection, WithHeadingRow
{
    use Importable;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            LgaState::create([
                'lga' => $row['lga'],
                'state' => $row['state'],
            ]);
        }
    }
}
