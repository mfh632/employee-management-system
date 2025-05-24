<?php

use Livewire\Volt\Component;
use App\Models\Employee;

new class extends Component {
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $secondary_phone;
    public $father_name;
    public $mother_name;
    public $guardian_name;
    public $guardian_phone;
    public $blood_group;
    public $religion;
    public $gender = 'male';
    public $birth_date;
    public $marital_status = 'false';
    public $spouse_name;
    public $department_id;
    public $designation_id;
    public $status = 'false';
    public $start_date;
    public $end_date;
    public $basic;
    public $house_rent;
    public $medical_allowance;
    public $transport;
    public $festival_bonus;
    public $image;

    public $departments = [];

    public $designations = [];


    public function mount()
    {
        $this->departments = \App\Models\Department::pluck('name', 'id');
        $this->designations = \App\Models\Designation::pluck('name', 'id');
    }

    public function create()
    {
        $validated = $this->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|string|max:20',
            'secondary_phone' => 'nullable|string|max:20',
            'father_name' => 'nullable|string|max:50',
            'mother_name' => 'nullable|string|max:50',
            'guardian_name' => 'nullable|string|max:50',
            'guardian_phone' => 'nullable|string|max:20',
            'blood_group' => 'nullable|string|max:10',
            'religion' => 'nullable|string|max:50',
            'gender' => 'nullable|string|in:male,female,other',
            'birth_date' => 'nullable|date',
            'marital_status' => 'nullable|string|in:true,false',
            'spouse_name' => 'nullable|string|max:255',
            'department_id' => 'required|integer|exists:departments,id',
            'designation_id' => 'required|integer|exists:designations,id',
            'status' => 'required|string|in:true,false',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'basic' => 'required|numeric|min:0',
            'house_rent' => 'nullable|numeric|min:0',
            'medical_allowance' => 'nullable|numeric|min:0',
            'transport' => 'nullable|numeric|min:0',
            'festival_bonus' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);


        if ($this->image) {
            $validated['image'] = $this->image->store('employees', 'public');
        }

        Employee::create($validated);

        session()->flash('success', 'Employee created successfully!');
        $this->reset(); // Clear form

        $this->redirect(route('employees.index'));
    }

}; ?>

<div>
    <h1 class="text-2xl mb-4">New Employee</h1>
    <hr class="mb-4" />
    <form wire:submit="create" class="flex flex-col gap-6">
        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="first_name" :label="__('First Name')" type="text" required autofocus :placeholder="__('First Name')" />
            <flux:input wire:model="last_name" :label="__('Last Name')" type="text" required :placeholder="__('Last Name')" />
        </div>
        <div class="grid grid-cols-3 gap-4">
            <flux:input wire:model="email" :label="__('Email')" type="email" required :placeholder="__('Email')" />
            <flux:input wire:model="phone" :label="__('Phone')" type="text" required :placeholder="__('Phone')" />
            <flux:input wire:model="secondary_phone" :label="__('Secondary Phone')" type="text" :placeholder="__('Secondary Phone')" />
        </div>
        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="father_name" :label="__('Father Name')" type="text" :placeholder="__('Father Name')" />
            <flux:input wire:model="mother_name" :label="__('Mother Name')" type="text" :placeholder="__('Mother Name')" />
        </div>
        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="guardian_name" :label="__('Guardian Name')" type="text" :placeholder="__('Guardian Name')" />
            <flux:input wire:model="guardian_phone" :label="__('Guardian Phone')" type="text" :placeholder="__('Guardian Phone')" />
        </div>
        <div class="grid grid-cols-3 gap-4">
            <flux:input wire:model="blood_group" :label="__('Blood Group')" type="text" :placeholder="__('Blood Group')" />
            <flux:input wire:model="religion" :label="__('Religion')" type="text" :placeholder="__('Religion')" />

            <flux:input wire:model="birth_date" :label="__('Birth Date')" type="date" :placeholder="__('Birth Date')" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <flux:radio.group wire:model="marital_status" :label="__('Marital Status')">
                <flux:radio value='true' label="Marrid" checked />
                <flux:radio value='false' label="Single" />
            </flux:radio.group>
            <flux:input wire:model="spouse_name" :label="__('Spouse Name')" type="text" :placeholder="__('Spouse Name')" />
        </div>

        <div class="grid grid-cols-3 gap-4">

            <flux:select wire:model="department_id" :label="__('Department')" placeholder="Choose department...">
                <flux:select.option value="">{{ __('Select') }}</flux:select.option>
                @foreach($departments as $id => $name)
                    <flux:select.option :value="$id">{{ $name }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:select wire:model="designation_id" :label="__('Designation')" placeholder="Choose Designation...">
                <flux:select.option value="">{{ __('Select') }}</flux:select.option>
                @foreach($designations as $id => $name)
                    <flux:select.option :value="$id">{{ $name }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:input wire:model="start_date" :label="__('Start Date')" type="date" :placeholder="__('Start Date')" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <flux:radio.group wire:model="gender" label="Gender">
                <flux:radio value="male" label="Male" checked />
                <flux:radio value="female" label="Female" />
            </flux:radio.group>
            <flux:radio.group wire:model="status" label="Status">
                <flux:radio value="true" label="Active" checked />
                <flux:radio value="false" label="Deactive" />
            </flux:radio.group>
        </div>

        <div class="grid grid-cols-5 gap-4">
            <flux:input wire:model="basic" :label="__('Basic')" type="number" :placeholder="__('Basic')" />
            <flux:input wire:model="house_rent" :label="__('House Rent')" type="number" :placeholder="__('House Rent')" />
            <flux:input wire:model="medical_allowance" :label="__('Medical Allowance')" type="number" :placeholder="__('Medical Allowance')" />
            <flux:input wire:model="transport" :label="__('Transport')" type="number" :placeholder="__('Transport')" />
            <flux:input wire:model="festival_bonus" :label="__('Festival Bonus')" type="number" :placeholder="__('Festival Bonus')" />
        </div>

        <flux:input wire:model="image" :label="__('Image')" type="file" :placeholder="__('Image')" />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>
</div>
