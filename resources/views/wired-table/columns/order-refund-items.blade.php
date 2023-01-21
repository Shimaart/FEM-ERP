<ul class="list-decimal">
    @foreach($model->products as $product)
        <li>
            {{ $product->orderItem->item->name }} ({{ $product->quantity }} {{ $product->orderItem->item->unit->symbol }})
        </li>
    @endforeach
</ul>
