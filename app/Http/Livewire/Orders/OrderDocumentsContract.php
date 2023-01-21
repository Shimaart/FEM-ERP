<?php

namespace App\Http\Livewire\Orders;

use App\Models\Order;
use App\Models\ItemCategory;
use App\Office\Documents\OrderContractDocument;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderDocumentsContract extends Component
{
    public Order $order;
    public string $tax = Order::TAX_VAT;
    public array $selectedCategories = [];

    public bool $managingDocumentParameters = false;

    public function mount(Order $order)
    {
        $this->order = $order;
        $this->tax = $this->order->tax;
    }

    public function rules(): array
    {
        return [
            'tax' => ['required', 'string'],
            'selectedCategories' => ['required', 'array'],
        ];
    }

    public function generate(): StreamedResponse
    {
        $this->validate();

        $document = new OrderContractDocument([
            'tax' => $this->tax,
            'selectedCategories' => $this->selectedCategories
        ], $this->order);
        $filename = 'Order_' . $this->order->number . '_' . date('Y-m-d') . '.doc';

        $word = $document->getDocument();
        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($word, 'Word2007');

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename);
    }

    public function getItemCategoriesProperty(): Collection
    {
        return ItemCategory::query()->get();
    }
}
