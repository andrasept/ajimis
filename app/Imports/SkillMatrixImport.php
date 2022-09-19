<?php

namespace App\Imports;

use App\Models\SkillMatrixDelivery;
use Maatwebsite\Excel\Concerns\ToModel;

class SkillMatrixImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SkillMatrixDelivery([
            'value' => $row['0'],
            'skill_id' => $row['1'],
            'user_id' => $row['2'],
            'category' => $row['3'],
        ]);
    }
}
