<?php

namespace App\Http\Livewire\ProductionRequests;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transport;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class ProductionRequestsTable extends Component
{
    public $values;

    public function render()
    {
        $results = [];
        $values = [];

        $products = OrderItem::query()
            ->whereHas('order', function (Builder $query){
                $query->whereIn('orders.status', [Order::STATUS_CREATED, Order::STATUS_ACTIVE]);
            })
            ->whereHas('item', function (Builder $query){
                $query->whereRaw('items.quantity < order_items.quantity');
            })
            ->get();

        foreach ($products as $product) {
            $startValue = isset($results[(int)$product->item_id]) ? $results[(int)$product->item_id] : 0;
            $results[(int)$product->item_id] = $startValue + $product->quantity;
        }

        foreach ($results as $key => $result) {
            $item = Item::query()->where('id', $key)->first();
            if ($item->quantity < $result) {
                $values[] = [
                    'item' => $item,
                    'need_quantity' => $result - $item->quantity,
                    'orders' => $products->where('item_id', $item->id)->pluck('order_id'),
                ];
            }
        }

        $this->values = $values;
        return view('production-requests.index-table');
    }
}
