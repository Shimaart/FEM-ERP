<ul class="list-decimal">
    @foreach($model->shipmentItems as $shipmentItem)
        <li>{{ $shipmentItem->orderItem->item->name }} ({{ $shipmentItem->quantity }} {{ $shipmentItem->orderItem->item->unit->symbol }})</li>
    @endforeach
</ul>
