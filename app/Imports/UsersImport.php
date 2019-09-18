<?php

namespace App\Imports;

use App\Grade;
use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UsersImport implements ToCollection
{
    /**
     * @param \Illuminate\Support\Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $k => $row) {
            if ( !$k) continue;
            $user = [
                'grade_id' => Grade::firstOrCreate(['name' => $row[0]])->id,
                'name'     => $row[1],
                'number'   => $row[2],
            ];

            User::firstOrCreate($user);
        }
    }
}
