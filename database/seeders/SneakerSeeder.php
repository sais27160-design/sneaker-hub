<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SneakerSeeder extends Seeder
{
    public function run(): void
    {
        $catalog = [
            'Nike' => [
                ['Air Force 1 Low', 119.99], ['Air Force 1 ’07', 119.99], ['Dunk Low', 119.99],
                ['Dunk Low Retro', 119.99], ['Air Max 90', 149.99], ['Air Max 95', 189.99],
                ['Air Max 97', 189.99], ['Air Max 1', 149.99], ['Air Max Plus', 189.99],
                ['P-6000', 129.99], ['Cortez', 89.99], ['Blazer Mid ’77', 109.99],
                ['Vomero 18', 159.99], ['Pegasus 42', 139.99], ['Structure 26', 149.99],
                ['Zoom Fly 6', 169.99], ['Invincible 3', 189.99], ['V2K Run', 119.99],
                ['Initiator', 79.99], ['Court Vision Low', 79.99],
            ],
            'Adidas' => [
                ['Samba OG', 120.00], ['Gazelle', 110.00], ['Handball Spezial', 110.00],
                ['Campus 00s', 120.00], ['Superstar', 120.00], ['Stan Smith', 110.00],
                ['SL 72 OG', 110.00], ['Gazelle Indoor', 130.00], ['Samba ADV', 110.00],
                ['Forum Low', 110.00], ['Rivalry Low', 100.00], ['Grand Court 2.0', 70.00],
                ['Adizero EVO SL', 150.00], ['Ultraboost 5', 180.00], ['Supernova Rise 3', 150.00],
                ['Adistar 3', 140.00], ['Response CL', 120.00], ['ZX 8000', 130.00],
                ['Country OG', 120.00], ['Tokyo', 100.00],
            ],
            'Puma' => [
                ['Suede Classic', 90.00], ['Palermo', 90.00], ['Speedcat OG', 110.00],
                ['RS-X', 120.00], ['Clyde', 100.00], ['Slipstream', 110.00],
                ['Basket Classic XXI', 70.00], ['CA Pro', 100.00], ['Rider FV', 100.00],
                ['Easy Rider', 100.00], ['Future Rider', 100.00], ['Teveris Nitro', 90.00],
                ['Deviate Nitro 3', 160.00], ['Deviate Nitro 4', 170.00], ['Velocity Nitro 3', 130.00],
                ['ForeverRun Nitro', 150.00], ['Magnify Nitro 2', 150.00], ['Fast-R Nitro Elite 2', 250.00],
                ['Voyage Nitro 3', 140.00], ['X-Ray 4', 60.00],
            ],
            'New Balance' => [
                ['574 Core', 120.00], ['530', 120.00], ['9060', 190.00], ['327', 130.00],
                ['550', 150.00], ['2002R', 150.00], ['1906R', 160.00], ['990v6', 250.00],
                ['991v2', 250.00], ['993', 240.00], ['Fresh Foam X 1080v14', 190.00],
                ['Fresh Foam X 880v14', 160.00], ['FuelCell Rebel v4', 160.00], ['FuelCell SuperComp Elite v4', 280.00],
                ['860v14', 160.00], ['Hierro v8', 160.00], ['725', 120.00], ['740', 120.00],
                ['1000', 170.00], ['480', 100.00],
            ],
            'ASICS' => [
                ['GEL-1130', 100.00], ['GEL-Kayano 14', 170.00], ['GEL-NYC', 150.00],
                ['GT-2160', 130.00], ['GEL-Quantum 360 VIII', 180.00], ['GEL-Cumulus 26', 150.00],
                ['GEL-Nimbus 26', 200.00], ['GEL-Kayano 31', 200.00], ['GEL-Lyte III', 130.00],
                ['GEL-Lyte V', 130.00], ['GEL-Quantum 90', 100.00], ['GEL-Excite 10', 90.00],
                ['GT-2000 12', 150.00], ['Novablast 4', 150.00], ['Novablast 5', 150.00],
                ['Superblast 2', 220.00], ['Magic Speed 4', 180.00], ['Gel-Trabuco 12', 150.00],
                ['Gel-Venture 9', 80.00], ['Gel-Pulse 15', 100.00],
            ],
            'Vans' => [
                ['Old Skool', 85.00], ['Old Skool Skate', 85.00], ['Old Skool 36', 110.00],
                ['Old Skool Premium', 110.00], ['Old Skool Stackform', 100.00],
                ['Authentic', 75.00], ['Authentic 44 DX', 90.00], ['Authentic Premium', 100.00],
                ['Classic Slip-On', 75.00], ['Checkerboard Slip-On', 80.00],
                ['Slip-On Premium', 100.00], ['Sk8-Hi', 95.00], ['Sk8-Hi Reissue', 110.00],
                ['Sk8-Mid', 85.00], ['Era', 75.00], ['Half Cab', 110.00],
                ['Knu Skool', 95.00], ['Hylane', 100.00], ['Rowley', 90.00],
                ['UltraRange Neo 2.0', 130.00],
            ],
        ];

        $euSizes = [38, 39, 40, 41, 42, 43, 44];

        foreach ($catalog as $brandName => $products) {
            DB::table('brands')->updateOrInsert(
                ['name' => $brandName],
                ['logo' => null]
            );
            $brandId = DB::table('brands')->where('name', $brandName)->value('id');

            foreach ($products as [$model, $price]) {
                $existing = DB::table('sneakers')
                    ->where('brand_id', $brandId)
                    ->where('model', $model)
                    ->first();

                $productValues = [
                    'name' => $model,
                    'price' => $price,
                    'description' => $brandName . ' ' . $model . ' sneakers.',
                    'stock_quantity' => count($euSizes) * 3,
                ];

                if ($existing) {
                    DB::table('sneakers')->where('id', $existing->id)->update($productValues);
                    $sneakerId = $existing->id;
                } else {
                    $sneakerId = DB::table('sneakers')->insertGetId($productValues + [
                        'brand_id' => $brandId,
                        'model' => $model,
                        'image' => null,
                    ]);
                }

                foreach ($euSizes as $size) {
                    DB::table('sneaker_sizes')->updateOrInsert(
                        ['sneaker_id' => $sneakerId, 'size' => $size],
                        ['stock_quantity' => 3]
                    );
                }
            }
        }
    }
}
