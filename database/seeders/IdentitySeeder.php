<?php

namespace Database\Seeders;

use App\Models\Identity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IdentitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $identities = [
            [
                'name' => 'DOC.TRIB.NO.DOM.SIN.RUC',
                'code' => '0',
            ],
            [
                'name' => 'DNI',
                'code' => '1',
            ],
            [
                'name' => 'CARNET DE EXTRANJERIA',
                'code' => '4',
            ],
            [
                'name' => 'RUC',
                'code' => '6',
            ],
            [
                'name' => 'PASAPORTE',
                'code' => '7',
            ],
        ];

        foreach ($identities as $identity) {
            Identity::create($identity);
        }
    }
}
