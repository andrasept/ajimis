<?php

namespace App\Exports;

use App\Models\Skills;
use Maatwebsite\Excel\Concerns\FromCollection;

class SkillMasterExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Skills::all()->makeHidden(['created_at', 'updated_at','skill','id']);
    }

    public function headings(): array
    {
        return [ "skill_code", "category"] ;								
    }
}
