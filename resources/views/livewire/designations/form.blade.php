<?php

use Livewire\Volt\Component;
use App\Models\Designation;

new class extends Component {
    public $designationId;
    public $name;
    public $description;

    public function mount()
    {
        if ($this->designationId) {
            $designation = Designation::find($this->designationId);
            if ($designation) {
                $this->name = $designation->name;
                $this->description = $designation->description;
            }
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:designations,name,' . $this->designationId,
            'description' => 'nullable|string|max:1000',
        ]);

        Designation::updateOrCreate(
            ['id' => $this->designationId],
            ['name' => $this->name, 'description' => $this->description]
        );

        session()->flash('message', __('Designation created successfully.'));
        $this->reset(['name', 'description', 'designationId']);
        $this->dispatch('refreshDesignations');
        $this->dispatch('showMessage', message: 'Designation created successfully.');
    }

    public function cancel()
    {
        $this->reset(['name', 'description', 'designationId']);
        $this->dispatch('refreshDesignations');
    }

}; ?>

<div>

    <form wire:submit.prevent="save" class="flex flex-col space-y-4">
        <div class="grid grid-cols-1 gap-4">
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus :placeholder="__('Name')" />
            <flux:textarea wire:model="description" :label="__('Description')" :placeholder="__('Description')" />
        </div>        
        <div class="flex justify-end">        
            <x-button-primary class="w-2xs" type="submit">
                {{ __('Save') }}
            </x-button-primary>
            <x-button-danger class="ml-3 w-2xs" wire:click="cancel">
                {{ __('Cancel') }}
            </x-button-danger>
        </div>
    </form>
</div>
