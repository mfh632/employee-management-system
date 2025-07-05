<?php

use Livewire\Volt\Component;
use App\Models\Qualification;
use App\Enums\QualificationResultType;
use App\Models\Employee;
use Illuminate\Validation\Rules\Enum;
  

new class extends Component {
    public $qualificationId;
    public $institute_name;
    public $passing_year;
    public $board_name;
    public $exam_name;
    public $result_type;
    public $result;
    public $out_of;
    public $employee_id;

    public $employees = [];

    public function mount()
    {
        if ($this->qualificationId) {
            $qualification = Qualification::find($this->qualificationId);
            if ($qualification) {
                $this->institute_name = $qualification->institute_name;
                $this->passing_year = $qualification->passing_year;
                $this->board_name = $qualification->board_name;
                $this->exam_name = $qualification->exam_name;
                $this->result_type = $qualification->result_type;
                $this->result = $qualification->result;
                $this->out_of = $qualification->out_of;
                $this->employee_id = $qualification->employee_id;
            } else {
                $this->result_type = QualificationResultType::Division->value;
            }
        }

        $this->employees = Employee::select('id', 'first_name', 'last_name')->get();
    }

    public function save()
    {
        $validated = $this->validate([
            'institute_name' => 'required|string|max:255',
            'passing_year' => 'required|integer|digits:4',
            'board_name' => 'required|string|max:20',
            'exam_name' => 'required|string|max:20',
            'result_type' => ['integer', new Enum(QualificationResultType::class)],
            'result' => 'required',
            'out_of' => 'required|numeric',
            'employee_id' => 'required|integer'
        ]);

        Qualification::updateOrCreate(
            ['id' => $this->qualificationId],
            [
                'institute_name' => $this->institute_name,
                'passing_year' => $this->passing_year,
                'board_name' => $this->board_name,
                'exam_name' => $this->exam_name,
                'result_type' => $this->result_type,
                'result' => $this->result,
                'out_of' => $this->out_of,
                'employee_id' => $this->employee_id
            ]
        );

        session()->flash('message', __('Qualification created successfully.'));
        $this->resetFields();
        $this->dispatch('refreshQualifications');
        $this->dispatch('showMessage', message: 'Qualification created successfully.');
    }

    public function cancel()
    {
        $this->resetFields();
        $this->dispatch('refreshQualifications');
    }

    public function resetFields() {
        $this->reset(['institute_name', 'passing_year', 'board_name', 'exam_name', 'result_type', 'result', 'out_of']);
    }

}; ?>

<div>

    <form wire:submit.prevent="save" class="flex flex-col space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        @if ($errors->isNotEmpty())
            @dd($errors)
        @endif 

            <flux:select wire:model="employee_id" :label="__('Employee')" placeholder="Choose ...">
                <flux:select.option value="">Choose ...</flux:select.option>    
                @foreach($this->employees as $employee)
                    <flux:select.option :value="$employee->id">{{ $employee->name }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:input wire:model="institute_name" 
                :label="__('Institute Name')" 
                type="text" 
                required autofocus 
                :placeholder="__('Enter Institute Name')" />

            <flux:input wire:model="passing_year" 
                :label="__('Passing Year')" 
                type="text" 
                required autofocus 
                :placeholder="__('Enter Passing Year')" />

            <flux:input wire:model="board_name" 
                :label="__('Board Name')" 
                type="text" 
                required autofocus 
                :placeholder="__('Enter Board Name')" />

            <flux:input wire:model="exam_name" 
                :label="__('Exam Name')" 
                type="text" 
                required autofocus 
                :placeholder="__('Enter Exam Name')" />

            <flux:select wire:model="result_type" :label="__('Result Type')">
                <flux:select.option value="">Choose ...</flux:select.option>    
                @foreach(\App\Enums\QualificationResultType::cases() as $resultType)
                    <flux:select.option :value="$resultType->value">{{ $resultType->name }}</flux:select.option>
                @endforeach
                </flux:select>


            <flux:input wire:model="result" 
                :label="__('Result')" 
                type="text" 
                required autofocus 
                :placeholder="__('Enter Result')" />

            <flux:input wire:model="out_of" 
                :label="__('Out Of')" 
                type="text" 
                required autofocus 
                :placeholder="__('Enter Out Of')" />
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
