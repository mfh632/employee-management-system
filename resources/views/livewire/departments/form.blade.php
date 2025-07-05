<?php

use Livewire\Volt\Component;
use App\Models\Department;

new class extends Component {
    public $departmentId;
    public $name;
    public $description;

    public function mount()
    {
        if ($this->departmentId) {
            $department = Department::find($this->departmentId);
            if ($department) {
                $this->name = $department->name;
                $this->description = $department->description;
            }
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $this->departmentId,
            'description' => 'nullable|string|max:1000',
        ]);

        Department::updateOrCreate(
            ['id' => $this->departmentId],
            ['name' => $this->name, 'description' => $this->description]
        );

        session()->flash('message', __('Department created successfully.'));
        $this->reset(['name', 'description', 'departmentId']);
        $this->dispatch('refreshDepartments');
        $this->dispatch('showMessage', message: 'Department created successfully.');
    }

    public function cancel()
    {
        $this->reset(['name', 'description', 'departmentId']);
        $this->dispatch('refreshDepartments');
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
