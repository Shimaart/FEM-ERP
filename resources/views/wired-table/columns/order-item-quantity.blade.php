{{ $model->quantity }} {{ $model->item->unit->symbol }}
(<a class="underline cursor-pointer" title="{{ __('На складе') }}">{{ $model->item->quantity }} {{ $model->item->unit->symbol }}</a> / <a class="underline cursor-pointer" title="{{ __('Свободная') }}">{{ $model->item->unused_quantity }} {{ $model->item->unit->symbol }}</a> / <a class="underline cursor-pointer" title="{{ __('В заказах') }}">{{ $model->item->reserved_quantity }} {{ $model->item->unit->symbol }}</a>)


<a class="underline cursor-pointer" title="{{ __('В доставках / Доступно') }}"><strong>({{ $model->item->shipment_used_quantity }} / {{ $model->item->shipment_available_quantity }} {{ $model->item->unit->symbol }})</strong></a>
