<?php

use Livewire\Volt\Component;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
    public $gender;
    public $birth_date;
    public $marital_status;
    public $spouse_name;
    public $department_id;
    public $designation_id;
    public $status;
    public $started_at;
    public $retired_at;
    public $basic;
    public $house_rent;
    public $medical_allowance;
    public $transport;
    public $festival_bonus;
    public $image;
    public $signature;

    public $departments = [];

    public $designations = [];

    /**
     * @var \App\Models\Employee
     */
    public $employee;


    public function mount(Request $request)
    {

        $this->employee = \App\Models\Employee::find($request->id);
        
        if(!$this->employee) {
            abort(404);
        }

        $this->first_name = $this->employee->first_name;
        $this->last_name = $this->employee->last_name;
        $this->email = $this->employee->email;
        $this->phone = $this->employee->phone;
        $this->secondary_phone = $this->employee->secondary_phone;
        $this->father_name = $this->employee->father_name;
        $this->mother_name = $this->employee->mother_name;
        $this->guardian_name = $this->employee->guardian_name;
        $this->guardian_phone = $this->employee->guardian_phone;
        $this->blood_group = $this->employee->blood_group;
        $this->religion = $this->employee->religion;
        $this->gender = $this->employee->gender;
        $this->birth_date = $this->employee->birth_date;
        $this->marital_status = $this->employee->marital_status;
        $this->spouse_name = $this->employee->spouse_name;
        $this->department_id = $this->employee->department_id;
        $this->designation_id = $this->employee->designation_id;
        $this->status = $this->employee->status;
        $this->started_at = $this->employee->started_at;
        $this->retired_at = $this->employee->retired_at;
        $this->basic = $this->employee->basic;
        $this->house_rent = $this->employee->house_rent;
        $this->medical_allowance = $this->employee->medical_allowance;
        $this->transport = $this->employee->transport;
        $this->festival_bonus = $this->employee->festival_bonus;
        $this->signature = $this->employee->signature;    

        $this->departments = \App\Models\Department::pluck('name', 'id');
        $this->designations = \App\Models\Designation::pluck('name', 'id');
        $this->started_at = now()->format('Y-m-d');
        $this->gender = Employee::GENDER_MALE;
        $this->status = Employee::STATUS_DEACTIVE;
        $this->marital_status = Employee::MARITAL_STATUS_SINGLE;
        $this->blood_group = Employee::BLOOD_GROUP_A_POSITIVE;
        $this->religion = Employee::RELIGION_ISLAM;
    }

    public function create()
    {

        $validated = $this->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(Employee::class)->ignore($this->employee->id)  
            ],
            'phone' => 'required|string|max:20',
            'secondary_phone' => 'nullable|string|max:20',
            'father_name' => 'nullable|string|max:50',
            'mother_name' => 'nullable|string|max:50',
            'guardian_name' => 'nullable|string|max:50',
            'guardian_phone' => 'nullable|string|max:20',
            'blood_group' => 'nullable|string|max:10',
            'religion' => 'required|string|max:50',
            'gender' => 'required|string',
            'birth_date' => 'required|date',
            'marital_status' => 'nullable|string',
            'spouse_name' => 'nullable|string|max:255',
            'department_id' => 'required|integer|exists:departments,id',
            'designation_id' => 'required|integer|exists:designations,id',
            'status' => 'required|boolean',
            'started_at' => 'required|date',
            'retired_at' => 'nullable|date|after_or_equal:started_at',
            'basic' => 'required|numeric|min:0',
            'house_rent' => 'nullable|numeric|min:0',
            'medical_allowance' => 'nullable|numeric|min:0',
            'transport' => 'nullable|numeric|min:0',
            'festival_bonus' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'signature' => 'nullable'
        ]);


        if ($this->image) {
            $validated['image'] = $this->image->store('employees', 'public');
        }


        $this->employee->fill($validated);
        $this->employee->save();

        session()->flash('success', 'Employee Update successfully!');
        $this->reset(); // Clear form

        $this->redirect(route('employees.index'));
    }

}; ?>

<div>
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl">Edit Employee</h1>
        <a href="{{ route('employees.index') }}" >
            <x-button-primary>{{ __('Back') }}</x-button-primary>
        </a>
    </div>
    
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
            <flux:select wire:model="blood_group" :label="__('Blood Group')" placeholder="Choose ...">
                @foreach(App\Models\Employee::BLOOD_GROUP_ARRAY as $key => $label)
                    <flux:select.option :value="$key">{{ $label }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:select wire:model="religion" :label="__('Religion')" placeholder="Choose ...">
                @foreach(App\Models\Employee::RELIGION_ARRAY as $key => $label)
                    <flux:select.option :value="$key">{{ $label }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:input wire:model="birth_date" :label="__('Birth Date')" type="date" :placeholder="__('Birth Date')" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <flux:select wire:model="marital_status" :label="__('Merital Status')" placeholder="Choose ...">
                @foreach(App\Models\Employee::MARITAL_STATUS_ARRAY as $key => $label)
                    <flux:select.option :value="$key">{{ $label }}</flux:select.option>
                @endforeach
            </flux:select>
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

            <flux:input wire:model="started_at" :label="__('Joining Date')" type="date" :placeholder="__('Joining Date')" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <flux:select wire:model="gender" :label="__('Gender')" placeholder="Choose Gender...">
                @foreach(App\Models\Employee::GENDER_ARRAY as $key => $label)
                    <flux:select.option :value="$key">{{ $label }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:select wire:model="status" :label="__('Status')" placeholder="Choose ...">
                @foreach(App\Models\Employee::STATUS_ARRAY as $key => $label)
                    <flux:select.option :value="$key">{{ $label }}</flux:select.option>
                @endforeach
            </flux:select>
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
            <x-button-success type="submit">
                {{ __('Update') }}
            </x-button-success>
        </div>
    </form>
</div>
