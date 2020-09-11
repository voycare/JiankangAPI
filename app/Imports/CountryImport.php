<?php


namespace App\Imports;


use App\Models\Country;
use Maatwebsite\Excel\Concerns\ToModel;

class CountryImport implements ToModel
{

    /**
     * @inheritDoc
     */
    public function model(array $row)
    {
        return Country::create([
            'name' => $row[0],
        ]);
    }
}
