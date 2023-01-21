<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\ItemType;
use App\Models\Unit;
use App\Repositories\UnitRepository;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $units = Unit::all();
        $itemTypes = ItemType::all();
        $itemCategories = ItemCategory::all();

        return [
            //'group_id' => AttributeGroups::factory(),
            'item_type_id' => $itemTypes->random()->id,
            'category_id' => $itemCategories->random()->id,
            'unit_id' => $units->random()->id, //
            'name' => function () {
                $faker = \Faker\Factory::create();
                $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));  $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));
                return $faker->productName;
            },
            'price' => $this->faker->numberBetween(0, 10000),
            'is_preferential' => false,
            'weight' => $this->faker->numberBetween(0, 1000),
            'quantity' => $this->faker->numberBetween(0, 10000),
        ];
    }

    public function ownProduct() {
        $category = ItemCategory::query()->where('name','Собственная')->first();
        return $this->state([
            'category_id' => $category ? $category->id : null
        ]);
    }

    public function dealerProduct() {
        $category = ItemCategory::query()->where('name','Дилерская')->first();
        return $this->state([
            'category_id' => $category ? $category->id : null
        ]);
    }

    public function material() {
        $category = ItemCategory::query()->where('name','Сырье')->first();
        return $this->state([
            'category_id' => $category ? $category->id : null
        ]);
    }

    public function service() {
        $category = ItemCategory::query()->where('name','Услуги')->first();
        return $this->state([
            'category_id' => $category ? $category->id : null
        ]);
    }
}
