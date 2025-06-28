<?php

use Livewire\Volt\Component;

new class extends Component {

    use \Livewire\WithPagination;

    public $sortBy = 'first_name';

    public $sortDirection = 'asc';

    public function sort($column) {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[\Livewire\Attributes\Computed]
    public function employees()
    {
        return \App\Models\Employee::query()
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(5);
    }
}; ?>

<div>
    <h1>{{ __('Employees') }}</h1>

    <div class="employee-list">
        @if($this->employees->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($this->employees as $employee)
                    <div class="rounded-lg bg-indigo-300 p-4 dark:bg-indigo-800 dark:text-indigo-400">
                        <h4>{{ $employee->id }}</h4>
                        <p>{{ $employee->full_name}}</p>
                        <p>{{ $employee->email }}</p>
                        <p>{{ $employee->gross_salary }}</p>
                        <div class="flex justify-end mt-2">
                            <a href="{{ route('employees.edit', $employee->id) }}" wire:navigate>
                                <x-button-primary>{{ __('Edit') }}</x-button-primary>
                            </a>
                            
                            <x-button-danger wire:click="delete({{ $employee->id }})">
                                {{ __('Delete') }}  
                            </x-button-danger>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <h1 class="text-2xl text-center font-medium">{{ __('Not found') }}</h1>
        @endif
    </div>

</div>
