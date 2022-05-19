<?php

namespace App;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class Bookimport implements ToCollection
{
    use Importable;

    public function collection(Collection $collection)
    {

    }
    public function model(array $row)
    {

    }
}
