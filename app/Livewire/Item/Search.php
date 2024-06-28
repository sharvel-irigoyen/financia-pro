<?php

namespace App\Livewire\Item;

use App\Models\Item;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Search extends Component
{
    #[Validate('required', as:'código del producto')]
    public $code='RC579';

    public ?Item $item=null;

    public function search()
    {
        $this->validate([
            'code' => 'required'
        ]);

        $this->item = Item::where('code', $this->code)->first();

        if ($this->item) {
            $this->dispatch('item-selected', item: $this->item)->to(Sell::class);
        } else {
            $this->item = null;
        }
    }

    public function render()
    {
        $data=[
            'items'=>$this->item,
        ];
        return view('livewire.item.search', $data);
    }
}
