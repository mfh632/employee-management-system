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
    <table class="table">
        <tr>
            <th>ID</th>
            <th>FirstName</th>
            <th>LastName</th>
            <th>Email</th>
        </tr>
        @foreach ($this->employees as $employee)
            <tr>
                <th>{{ $employee->id }}</th>
                <th>{{ $employee->first_name}}</th>
                <th>{{ $employee->last_name }}</th>
                <th>{{ $employee->email }}</th>
            </tr>
        @endforeach


    </table>
</div>
