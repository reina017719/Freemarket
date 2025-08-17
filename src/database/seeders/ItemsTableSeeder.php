<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Item;
use App\Models\Category;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'image' => 'Armani+Mens+Clock.jpg',
                'category' => ['ファッション','メンズ','アクセサリー'],
                'condition' => '良好',
                'name' => '腕時計',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'price' => '15000',
            ],
            [
                'image' => 'HDD+Hard+Disk.jpg',
                'category' => ['家電'],
                'condition' => '目立った傷や汚れなし',
                'name' => 'HDD',
                'description' => '高速で信頼性の高いハードディスク',
                'price' => '5000',
            ],
            [
                'image' => 'iLoveIMG+d.jpg',
                'category' => ['キッチン'],
                'condition' => 'やや傷や汚れあり',
                'name' => '玉ねぎ3束',
                'description' => '新鮮な玉ねぎ3束のセット',
                'price' => '300',
            ],
            [
                'image' => 'Leather+Shoes+Product+Photo.jpg',
                'category' => ['メンズ','ファッション'],
                'condition' => '状態が悪い',
                'name' => '革靴',
                'description' => 'クラシックなデザインの革靴',
                'price' => '4000',
            ],
            [
                'image' => 'Living+Room+Laptop.jpg',
                'category' => ['家電', 'ゲーム'],
                'condition' => '良好',
                'name' => 'ノートPC',
                'description' => '高性能なノートパソコン',
                'price' => '45000',
            ],
            [
                'image' => 'Music+Mic+4632231.jpg',
                'category' => ['家電','ゲーム'],
                'condition' => '目立った傷や汚れなし',
                'name' => 'マイク',
                'description' => '高音質のレコーディング用マイク',
                'price' => '8000',
            ],
            [
                'image' => 'Purse+fashion+pocket.jpg',
                'category' => ['ファッション','レディース','アクセサリー'],
                'condition' => 'やや傷や汚れあり',
                'name' => 'ショルダーバッグ',
                'description' => 'おしゃれなショルダーバッグ',
                'price' => '3500',
            ],
            [
                'image' => 'Tumbler+souvenir.jpg',
                'category' => ['キッチン'],
                'condition' => '状態が悪い',
                'name' => 'タンブラー',
                'description' => '使いやすいタンブラー',
                'price' => '500',
            ],
            [
                'image' => 'Waitress+with+Coffee+Grinder.jpg',
                'category' => ['キッチン'],
                'condition' => '良好',
                'name' => 'コーヒーミル',
                'description' => '手動のコーヒーミル',
                'price' => '4000',
            ],
            [
                'image' => '外出メイクアップセット.jpg',
                'category' => ['レディース','コスメ'],
                'condition' => '目立った傷や汚れなし',
                'name' => 'メイクセット',
                'description' => '便利なメイクアップセット',
                'price' => '2500',
            ],
        ];

        foreach ($products as $product) {
            $sourcePath = database_path('seeders/sample_images/' . $product['image']);

            $newFileName = Str::random(10) . '_' . $product['image'];

            if (file_exists($sourcePath)) {
                Storage::disk('public')->put(
                    'img/' . $newFileName,
                    file_get_contents($sourcePath)
                );
            } else {
                dump("画像ファイルが見つかりません: " . $sourcePath);
                continue;
            }

            $item = Item::create([
                'profile_id' => 1,
                'image' => 'storage/img/' . $newFileName,
                'condition' =>$product['condition'],
                'name' => $product['name'],
                'description' => $product['description'],
                'price' => $product['price'],
            ]);

            $categoryIds = [];
            foreach ($product['category'] as $categoryName) {
                $category = Category::where('category', $categoryName)->first();
                if ($category) {
                    $categoryIds[] = $category->id;
                }
            }

            if (!empty($categoryIds)) {
                $item->categories()->attach($categoryIds);
            }
        }
    }
}
