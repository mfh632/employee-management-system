<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\Department;
use Livewire\Attributes\On; 

new #[Layout('components.layouts.app')] class extends Component {
    use WithPagination;

    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $perPage = 10;
    public $search = '';

    public $isForm = false;

    public $departmentId;


    public function sort($column) {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[On('refreshDepartments')] 
    public function getDepartmentsProperty()
    {
        return Department::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function delete($id)
    {
        $department = Department::find($id);
        if ($department) {
            $department->delete();        
            $this->dispatch('showMessage', message: 'Department deleted successfully.');
            $this->dispatch('refreshDepartments');
        } else {
            session()->flash('message', __('Department not found.'));
        }
    }
   
    public function createDepartment($departMentId = null)
    {
        if ($departMentId) {
            $this->departmentId = $departMentId;
        } else {
            $this->departmentId = null;
        }
        $this->isForm = true;
    }
   
    #[On('refreshDepartments')]
    public function closeForm()
    {
        $this->isForm = false;
        $this->departmentId = null;
    }

}; ?>

<div class="flex flex-col space-y-4 p-6">
    <div class="flex justify-between items-center ">
        <h1>{{ __('Departments') }}</h1>        
    </div>
    @session('message')
        <div class="bg-green-100 text-green-800 p-4 rounded-md">
            {{ session('message') }}
        </div>
    @endsession
    

    @if ($this->isForm)
        <livewire:departments.form :departmentId="$this->departmentId"/>
    @endif
    
    @if (!$isForm)
        <div class="flex flex-col md:flex-row md:items-center md:justify-center space-3 bg-gray-100 p-4 rounded-md shadow-md">
            <!-- Per Page Dropdown -->
            <div class="flex items-center shrink-0">
                <label for="perPage" class="mr-2 text-sm font-medium text-gray-700">Per Page:</label>
                <select wire:model.live="perPage" id="perPage" class="border border-gray-300 rounded-md p-2 text-sm focus:ring focus:ring-blue-300">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                </select>
            </div>

            <!-- Search Department -->
            <div class="flex items-center justify-center w-full">
                <input
                type="text"
                wire:model.live="search"
                id="searchDepartment"
                placeholder="Search Department By Name"
                class="w-full xl:w-2xl border border-gray-300 rounded-md p-2 text-sm focus:ring focus:ring-blue-300"
                />
            </div>

            <!-- Create Action Button -->
            <button
                class="shrink-0 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:ring focus:ring-blue-300 cursor-pointer"
                wire:click="createDepartment"
            >
                {{ __('New Department') }}
            </button>
            </div>
        
        <div class="department-list">
            @if($this->departments->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach ($this->departments as $department)
                        <div class="rounded-lg bg-gray-200 p-4 dark:bg-indigo-800 dark:text-indigo-400">
                            <h4><span class="font-semibold">{{ __('ID:') }}</span> {{ $department->id }}</h4>
                            <p><span class="font-semibold">{{ __('Name:') }}</span> {{ $department->name }}</p>
                            <p><span class="font-semibold">{{ __('Description:') }}</span> {{ $department->description }}</p>
                            <p><span class="font-semibold">{{ __('Created At:') }}</span> {{ $department->created_at->format('Y-m-d H:i:s') }}</p>
                            <p><span class="font-semibold">{{ __('Updated At:') }}</span> {{ $department->updated_at->format('Y-m-d H:i:s') }}</p>
                            <div class="flex justify-end mt-2">
                                <button
                                    class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 focus:ring focus:ring-blue-300"
                                    wire:click="createDepartment({{ $department->id }})"
                                >
                                    {{ __('Edit') }}
                                </button>
                                <button
                                    class="bg-red-500 text-white px-3 py-1 ml-2 rounded-md hover:bg-red-600 focus:ring focus:ring-red-300"
                                    wire:click="delete({{ $department->id }})"
                                >
                                    {{ __('Delete') }}
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $this->departments->links() }}
            @else
                <h1 class="text-2xl text-center font-medium">{{ __('Not found') }}</h1>
            @endif
            
        </div>
    @endif
    
</div>

