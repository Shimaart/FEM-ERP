<div>
    @foreach($model->productionItems as $productionItem)
        {{ $productionItem->item->name }} - {{ $productionItem->need_quantity }} {{ $productionItem->item->unit->symbol }};<br>
    @endforeach
</div>
