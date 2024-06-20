<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $descriptions = [
            "Perfecto para acompañar cualquier comida.",
            "Producto de alta calidad, ideal para toda la familia.",
            "Apto para todas las edades, fácil de usar.",
            "Rico en nutrientes esenciales y vitaminas.",
            "Fresco y delicioso, directo del productor.",
            "Ideal para acompañar tus platos favoritos.",
            "Empaque fácil de abrir y almacenar.",
            "Larga duración garantizada, sin conservantes.",
            "Aporta energía y vitalidad a tu día.",
            "Sabor irresistible, ¡pruébalo hoy!",
            "Natural y saludable, sin aditivos.",
            "Perfecto para una dieta equilibrada.",
            "Calidad garantizada, producto seleccionado.",
            "Versátil y fácil de preparar.",
            "Ingredientes naturales, sin colorantes.",
            "Fuente de fibra y proteínas.",
            "Apto para dietas especiales.",
            "Sin gluten, ideal para celíacos.",
            "Conserva su sabor y frescura por más tiempo.",
            "Producto local, apoya a los productores de la región.",
            "Hecho con ingredientes frescos y naturales.",
            "Gran valor nutricional en cada porción.",
            "Sabor auténtico, como hecho en casa.",
            "Perfecto para llevar en tus viajes.",
            "Rápido y fácil de preparar, ideal para días ocupados.",
            "Sin azúcar añadido, saludable y delicioso.",
            "Certificado orgánico, cultivo sostenible.",
            "Textura suave y cremosa, un deleite para tu paladar.",
            "Enriquecido con vitaminas y minerales esenciales.",
            "Perfecto para compartir con amigos y familiares."
        ];

        for ($i = 0; $i < 50; $i++) {
            $createdAt = Carbon::now()->subDays(rand(0, 365));
            $updatedAt = Carbon::now()->subDays(rand(0, 365));

            DB::table('items')->insert([
                'code' => strtoupper($faker->bothify('??###')),
                'price' => $faker->randomFloat(2, 1, 100),
                'description' => $descriptions[array_rand($descriptions)],
                'category_id' => $faker->numberBetween(1, 30),
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ]);
        }
    }
}
