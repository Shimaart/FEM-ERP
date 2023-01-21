<a class="underline cursor-pointer" title="{{ __('На складе') }}">{{ $model->quantity }} {{ $model->unit->symbol }}</a> / <a class="underline cursor-pointer" title="{{ __('Свободная') }}">{{ $model->unused_quantity }} {{ $model->unit->symbol }}</a> / <a class="underline cursor-pointer" title="{{ __('В заказах') }}">{{ $model->reserved_quantity }} {{ $model->unit->symbol }}</a>

<a class="underline cursor-pointer" title="{{ __('В доставках / Доступно') }}"><strong>({{ $model->shipment_used_quantity }} / {{ $model->shipment_available_quantity }} {{ $model->unit->symbol }})</strong></a>

