<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $warehouses = [
            [
                'name' => 'Almacén principal',
                'location' => 'Calle Principal, Ciudad Principal'
            ],
            [
                'name' => 'Almacén secundario',
                'location' => 'Calle Secundaria, Ciudad Secundaria'
            ],
        ];
        
        foreach ($warehouses as $warehouse) {
            Warehouse::create($warehouse);
        }
    }
}
