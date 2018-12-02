<?php

namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;

class ClientImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        return new Client([
            'first_name' => isset($row[0]) ? $row[0] : '',
            'email' => isset($row[1]) ? $row[1] : '',
        ]);
    }
}
