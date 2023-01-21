<?php

namespace App\Http\Livewire\AttributeGroups;

use App\Models\Attribute;
use App\Models\AttributeGroup;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class AttributeGroupForm extends Component
{
    public AttributeGroup $attributeGroup;
    public ?Attribute $newAttribute = null;
    public $newComment;

    protected $listeners = [
        'attributeSaved' => 'attributeSaved',
        'attributeDeleted' => '$refresh'
    ];

    public function mount(AttributeGroup $attributeGroup)
    {
        $this->attributeGroup = $attributeGroup;
        $this->attributeGroup->load([
            'attributes' => function ($query) {
                return $query->latest();
            }
        ]);

        $this->newAttribute = $this->newAttribute ??
            new Attribute(['group_id' => $this->attributeGroup->id]);
    }

    public function rules(): array
    {
        return [
            'attributeGroup.name' => ['required', 'string']
        ];
    }

    public function submit(): void
    {
        $this->validate();

        $this->attributeGroup->save();
        $this->emit('saved');

        if ($this->attributeGroup->wasRecentlyCreated) {
            $this->redirect('/attribute-groups/' . $this->attributeGroup->id . '/edit');
        }
    }

    public function addItem(): void
    {
        $validatedData = $this->validate([
            'newComment' => 'required|min:6'
        ]);

        Attribute::query()->create($validatedData);
    }

    public function attributeSaved(): void
    {
        $this->newAttribute = new Attribute(['group_id' => $this->attributeGroup->id]);

        $this->attributeGroup->load([
            'attributes' => function ($query) {
                return $query->latest();
            }
        ]);
    }

    public function editItem(Attribute $attribute): void
    {

    }

    public function removeAttribute(Attribute $attribute): void
    {
        $attribute->delete();
        $this->attributeGroup->load([
            'attributes'
        ])->latest();
    }
}
