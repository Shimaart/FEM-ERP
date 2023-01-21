<?php

namespace Database\Seeders;

use App\Models\AttributeGroup;
use App\Models\Item;
use App\Models\ItemAttribute;
use App\Models\ItemType;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = Unit::all();

        $productItemTypes = ItemType::query()
            ->where('name', 'LIKE', 'Плитка')
            ->get();

        $materialItemTypes = ItemType::query()
            ->where('name', 'LIKE', 'Песок')
            ->orWhere('name', 'LIKE', 'Щебень')
            ->get();

        $productGroups = AttributeGroup::query()
            ->where('name', 'LIKE', 'Тип')
            ->orWhere('name', 'LIKE', 'Толщина')
            ->orWhere('name', 'LIKE', 'Цвет')
            ->get();

        $materialGroups = AttributeGroup::query()
            ->where('name', 'LIKE', 'Фракция')
            ->orWhere('name', 'LIKE', 'Вид')
            ->get();

        for ($i=9; $i <= 12; $i++) {
            $product = Item::factory()->ownProduct()->create([
                'item_type_id' => $productItemTypes->random()->id,
                'unit_id' => $units->random()->id
            ]);//make()
            foreach ($productGroups as $productGroup) {
                if ($productGroup->name === 'Тип') {
                    $attributeValue = 1;
                }
                if ($productGroup->name === 'Толщина') {
                    $attributeValue = 7;
                }
                if ($productGroup->name === 'Цвет') {
                    $attributeValue = $i;
                }
                ItemAttribute::factory()->create([
                    'item_id' => $product->id,
                    'group_id' => $productGroup->id,
                    'attribute_id' => $attributeValue,
                ]);
            }
            $productName = '';
            foreach ($product->attributes as $attribute) {
                $productName .= $attribute->attribute->name . ' ';
            }
            $product->update([
                'name' => $productName
            ]);
        }


        for ($i=0; $i <= 30; $i++) {
            $product = Item::factory()->ownProduct()->create([
                'item_type_id' => $productItemTypes->random()->id,
                'unit_id' => 1
            ]);//make()
            foreach ($productGroups as $productGroup) {
                ItemAttribute::factory()->create([
                    'item_id' => $product->id,
                    'group_id' => $productGroup->id,
                    'attribute_id' => $productGroup->attributes()->pluck('id')->random(),
                ]);
            }
        }

        for ($i=0; $i <= 30; $i++) {
            $product = Item::factory()->dealerProduct()->create([
                'item_type_id' => $productItemTypes->random()->id,
                'unit_id' => $units->random()->id
            ]);//make()
            foreach ($productGroups as $productGroup) {
                ItemAttribute::factory()->create([
                    'item_id' => $product->id,
                    'group_id' => $productGroup->id,
                    'attribute_id' => $productGroup->attributes()->pluck('id')->random(),
                ]);
            }
        }

        for ($i=0; $i <= 30; $i++) {
            $product = Item::factory()->material()->create([
                'item_type_id' => $materialItemTypes->random()->id,
                'unit_id' => $units->random()->id
            ]);//make()
            foreach ($materialGroups as $materialGroup) {
                ItemAttribute::factory()->create([
                    'item_id' => $product->id,
                    'group_id' => $materialGroup->id,
                    'attribute_id' => $materialGroup->attributes()->pluck('id')->random(),
                ]);
            }
        }

        Item::factory()->service()->create([
            'name' => 'Демонтаж асфальта, выемка грунта',
            'item_type_id' => null,
            'unit_id' => $units->random()->id
        ]);
        Item::factory()->service()->create([
            'name' => 'Демонтаж трубы',
            'item_type_id' => null,
            'unit_id' => $units->random()->id
        ]);
        Item::factory()->service()->create([
            'name' => 'Монтаж тактильной плитки',
            'item_type_id' => null,
            'unit_id' => $units->random()->id
        ]);
        Item::factory()->service()->create([
            'name' => 'Подготовительные работы',
            'item_type_id' => null,
            'unit_id' => $units->random()->id
        ]);
        Item::factory()->service()->create([
            'name' => 'Аренда кары',
            'item_type_id' => null,
            'unit_id' => $units->random()->id
        ]);
        Item::factory(25)->service()->create([
            'item_type_id' => null,
            'unit_id' => $units->random()->id
        ]);

//        Item::factory(30)->ownProduct()->make();//make()
//        Item::factory(30)->dealerProduct()->make();//make()
//        Item::factory(30)->material()->make();//make()
//        Item::factory(30)->service()->make();//make()
    }
}
