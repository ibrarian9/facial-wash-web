<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $criteriaData = [
            ['code' => 'C1', 'name' => 'Harga', 'weight' => 187, 'type' => 'cost'],
            ['code' => 'C2', 'name' => 'Kandungan Bahan Aktif', 'weight' => 200, 'type' => 'benefit'],
            ['code' => 'C3', 'name' => 'Review Pengguna', 'weight' => 158, 'type' => 'benefit'],
            ['code' => 'C4', 'name' => 'Kemasan Produk', 'weight' => 168, 'type' => 'benefit'],
            ['code' => 'C5', 'name' => 'Ketersediaan Produk', 'weight' => 154, 'type' => 'benefit'],
        ];
        DB::table('criterias')->insert($criteriaData);

        // 2. Insert Alternatif (Sesuai Excel)
        $alternatives = [
            ['code' => 'A1', 'name' => 'Cetaphil Oily Skin Cleanser'],
            ['code' => 'A2', 'name' => 'COSRX Low Ph Good Morning Gel'],
            ['code' => 'A3', 'name' => 'Senka Perfect Whip Acne Care'],
            ['code' => 'A4', 'name' => 'Skintific Pathenol Gentle Wash'],
            ['code' => 'A5', 'name' => 'SCORA Salicylic Acid Gentle'],
        ];

        foreach ($alternatives as $alt) {
            DB::table('alternatives')->insert($alt);
        }

        $scores = [
            'A1' => [4, 5, 3, 3, 3],
            'A2' => [4, 5, 4, 3, 4],
            'A3' => [5, 5, 4, 5, 2],
            'A4' => [5, 5, 4, 4, 4],
            'A5' => [1, 1, 3, 3, 1],
        ];

        foreach ($scores as $altCode => $values) {
            $altId = DB::table('alternatives')->where('code', $altCode)->value('id');
            $criteriaIds = DB::table('criterias')->orderBy('code')->pluck('id');

            foreach ($values as $index => $val) {
                DB::table('scores')->insert([
                    'alternative_id' => $altId,
                    'criteria_id' => $criteriaIds[$index],
                    'value' => $val,
                ]);
            }
        }
    }
}
