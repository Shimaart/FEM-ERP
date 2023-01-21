<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\ConsumedMaterial;
use App\Models\Item;
use App\Models\Production;
use App\Models\ProductionItem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Builder;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $materials = Item::query()
            ->whereHas('itemCategory', function (Builder $query) {
                $query->where('name', '=', 'Сырье');
            })
            ->get();

        ConsumedMaterial::factory()->create();//make()

        $chains = [
            [
                Production::STATUS_CREATED
            ],
            [
                Production::STATUS_CREATED,
                Production::STATUS_PROCESSED
            ],
            [
                Production::STATUS_CREATED,
                Production::STATUS_PROCESSED,
                Production::STATUS_RECEIVED
            ]
        ];


        for($i = 0; $i <= 100; $i++) {
            $production = Production::factory()
                ->create([
                    'creator_id' => $users->random()->id
                ]);

//            $products =                 ->hasProductionItems( mt_rand(1, 2));
            for ($j=0;$j <= mt_rand(1, 2); $j++) {
                $productionItem = ProductionItem::factory()->create([
                    'production_id' => $production->id
                ]);

                for ($k=0;$k <= mt_rand(2, 3); $k++) {
                    $materialId = $materials->pluck('id')->random();

                    $consumedMaterial = ConsumedMaterial::query()
                        ->where('material_id',$materialId)
                        ->where('production_item_id',$productionItem->id)
                        ->first();

                    if (!$consumedMaterial) {
                        $consumedMaterial = ConsumedMaterial::factory()->create([
                            'production_item_id' => $productionItem->id,
                            'material_id' => $materialId
                        ]);
                    }
                }
            }

            $chain = collect($chains)->random();

            foreach ($chain as $step) {
                Comment::factory()->production()->state([
                    'author_id' => $users->random()->id,
                    'status' => $step,
                ])->create([
                    'commentable_id' => $production->id
                ]);
            }

            $production->update([
                'status' => $step
            ]);
        }
    }
}
