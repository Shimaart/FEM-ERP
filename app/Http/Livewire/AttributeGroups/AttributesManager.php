<?php

namespace App\Http\Livewire\AttributeGroups;

use App\Models\Item;
use App\Models\AttributeGroup;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class AttributesManager extends Component
{
    public AttributeGroup $attributeGroup;

    public bool $managingAttribute = false;
    public ?Attribute $managedAttribute = null;

    protected $listeners = [
        'manageAttribute'
    ];

    public function rules(): array
    {
        return [
            'managedAttribute.name' => ['required', 'string']
        ];
    }

    public function getValidationAttributes(): array
    {
        return [
            'managedAttribute.name' => 'Вариация'
        ];
    }

    public function manageAttribute(Attribute $attribute): void
    {
        $this->clearValidation();

        $this->managedAttribute = $attribute;

        $this->managingAttribute = true;
    }

    public function saveAttribute(): void
    {
        if (! $this->managedAttribute) {
            return;
        }

        $this->validate();

        $this->attributeGroup->attributes()->save($this->managedAttribute);

        $this->emit('attributeSaved');

        $this->managingAttribute = false;
        $this->managedAttribute = null;
    }
}
