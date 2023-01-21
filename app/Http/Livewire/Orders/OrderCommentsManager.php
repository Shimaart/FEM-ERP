<?php

namespace App\Http\Livewire\Orders;

use App\Models\Order;
use App\Http\Livewire\Comments\ManagesComments;
use Livewire\Component;

class OrderCommentsManager extends Component
{
    use ManagesComments;

    public Order $order;

    protected $listeners = ['manageComment'];

    public function commentable()
    {
        return $this->order;
    }
}
