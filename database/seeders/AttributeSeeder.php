<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeGroup;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\ItemType;
use App\Models\ItemTypeGroup;
use Database\Factories\ItemTypeGroupFactory;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(30)->create();
        $typeGroup = AttributeGroup::factory()->create([
            'name' => 'Тип'
        ]);
        $thicknessGroup = AttributeGroup::factory()->create([
            'name' => 'Толщина'
        ]);
        $colorGroup = AttributeGroup::factory()->create([
            'name' => 'Цвет'
        ]);
        $fractionGroup = AttributeGroup::factory()->create([
            'name' => 'Фракция'
        ]);
        $kindGroup = AttributeGroup::factory()->create([
            'name' => 'Вид'
        ]);

        Attribute::factory()->create([
            'group_id' => $typeGroup,
            'name' => 'Кирпичик'
        ]);

        Attribute::factory()->create([
            'group_id' => $typeGroup,
            'name' => 'Старый город'
        ]);

        Attribute::factory()->create([
            'group_id' => $typeGroup,
            'name' => 'Поребрик'
        ]);

        Attribute::factory()->create([
            'group_id' => $typeGroup,
            'name' => 'Дорожний бордюр'
        ]);


        Attribute::factory()->create([
            'group_id' => $thicknessGroup,
            'name' => '30'
        ]);
        Attribute::factory()->create([
            'group_id' => $thicknessGroup,
            'name' => '40'
        ]);
        Attribute::factory()->create([
            'group_id' => $thicknessGroup,
            'name' => '50'
        ]);
        Attribute::factory()->create([
            'group_id' => $thicknessGroup,
            'name' => '750'
        ]);


        Attribute::factory()->create([
            'group_id' => $colorGroup,
            'name' => 'Красный'
        ]);
        Attribute::factory()->create([
            'group_id' => $colorGroup,
            'name' => 'Желтый'
        ]);
        Attribute::factory()->create([
            'group_id' => $colorGroup,
            'name' => 'Зеленый'
        ]);
        Attribute::factory()->create([
            'group_id' => $colorGroup,
            'name' => 'Синий'
        ]);
        Attribute::factory()->create([
            'group_id' => $colorGroup,
            'name' => 'Черный'
        ]);
        Attribute::factory()->create([
            'group_id' => $colorGroup,
            'name' => 'Белый'
        ]);
        Attribute::factory()->create([
            'group_id' => $colorGroup,
            'name' => 'Фиолетовый'
        ]);
        Attribute::factory()->create([
            'group_id' => $colorGroup,
            'name' => 'Оранжевый'
        ]);



        Attribute::factory()->create([
            'group_id' => $fractionGroup,
            'name' => 'Отсев'
        ]);
        Attribute::factory()->create([
            'group_id' => $fractionGroup,
            'name' => '5-10'
        ]);
        Attribute::factory()->create([
            'group_id' => $fractionGroup,
            'name' => '10-20'
        ]);
        Attribute::factory()->create([
            'group_id' => $fractionGroup,
            'name' => '20-40'
        ]);
        Attribute::factory()->create([
            'group_id' => $fractionGroup,
            'name' => 'Бутовый камень'
        ]);


        Attribute::factory()->create([
            'group_id' => $kindGroup,
            'name' => 'Речной'
        ]);
        Attribute::factory()->create([
            'group_id' => $kindGroup,
            'name' => 'Карьерный'
        ]);
        Attribute::factory()->create([
            'group_id' => $kindGroup,
            'name' => 'Морской'
        ]);
        Attribute::factory()->create([
            'group_id' => $kindGroup,
            'name' => 'Искусственный'
        ]);


        $typeTile = ItemType::factory()->create([
            'name' => 'Плитка'
        ]);
        ItemTypeGroup::factory()->create([
            'item_type_id' => $typeTile,
            'group_id' => $typeGroup,
            'is_main' => true,
            'sort' => 1
        ]);
        ItemTypeGroup::factory()->create([
            'item_type_id' => $typeTile,
            'group_id' => $thicknessGroup,
            'is_main' => true,
            'sort' => 2
        ]);
        ItemTypeGroup::factory()->create([
            'item_type_id' => $typeTile,
            'group_id' => $colorGroup,
            'sort' => 3
        ]);

        $typeSand = ItemType::factory()->create([
            'name' => 'Песок',
            'in_title' => true
        ]);
        ItemTypeGroup::factory()->create([
            'item_type_id' => $typeSand,
            'group_id' => $kindGroup,
            'is_main' => true,
            'sort' => 1
        ]);
        ItemTypeGroup::factory()->create([
            'item_type_id' => $typeSand,
            'group_id' => $fractionGroup,
            'sort' => 2
        ]);

        $typeStone = ItemType::factory()->create([
            'name' => 'Щебень',
            'in_title' => true
        ]);
        ItemTypeGroup::factory()->create([
            'item_type_id' => $typeStone,
            'group_id' => $fractionGroup,
            'is_main' => true,
            'sort' => 1
        ]);
        ItemTypeGroup::factory()->create([
            'item_type_id' => $typeStone,
            'group_id' => $kindGroup,
            'sort' => 2
        ]);

        $typeService = ItemType::factory()->create([
            'name' => 'Услуги'
        ]);



        ItemCategory::factory()->create([
            'name' => 'Собственная',
            'slug' => 'own',
            'display_in_items' => true,
            'display_in_orders' => true,
            'sort' => 1
        ]);

        ItemCategory::factory()->create([
            'name' => 'Дилерская',
            'slug' => 'dealer',
            'display_in_items' => true,
            'display_in_orders' => true,
            'sort' => 2
        ]);

        ItemCategory::factory()->create([
            'name' => 'Сырье',
            'slug' => 'material',
            'display_in_items' => true,
            'display_in_orders' => true,
            'sort' => 3
        ]);

        ItemCategory::factory()->create([
            'name' => 'Услуги',
            'slug' => 'service',
            'display_in_items' => true,
            'display_in_orders' => true,
            'sort' => 4
        ]);

        ItemCategory::factory()->create([
            'name' => 'Поддоны',
            'slug' => 'pallets',
            'display_in_items' => true,
            'display_in_orders' => true,
            'sort' => 5
        ]);
    }
}
