<div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
        <tr>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Товар</th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Необходимое к-во</th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Номера заказов</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        @foreach($values as $value)
        <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $value['item']->name }} {{ $value['item']->id }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $value['need_quantity'] }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                {{--                            {{ $value['orders'] }}--}}
                @foreach($value['orders'] as $key => $order)
                <a style="color: blue" href="/orders/{{$order}}">{{ $order }}</a>{{ $key < count($value['orders']) - 1 ? ', ' : ''}}
                @endforeach
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

