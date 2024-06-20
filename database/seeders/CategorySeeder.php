<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Arroz',
            'Azúcar',
            'Aceite',
            'Harina',
            'Leche',
            'Huevos',
            'Pan',
            'Pasta',
            'Galletas',
            'Cereales',
            'Limpieza',
            'Higiene Personal',
            'Bebidas Gaseosas',
            'Jugos',
            'Aguas',
            'Cervezas',
            'Vinos',
            'Licores',
            'Enlatados',
            'Conservas',
            'Lácteos',
            'Embutidos',
            'Frutas y Verduras',
            'Congelados',
            'Snacks',
            'Condimentos',
            'Salsas',
            'Mermeladas',
            'Dulces y Golosinas',
            'Productos de Mascotas',
        ];

        foreach ($categories as $category) {
            $createdAt = Carbon::now()->subDays(rand(0, 365));
            $updatedAt = Carbon::now()->subDays(rand(0, 365));

            DB::table('categories')->insert([
                'name' => $category,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ]);
        }
    }
}
