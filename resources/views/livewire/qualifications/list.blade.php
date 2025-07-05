<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Qualification;

new class extends Component {
    use WithPagination;

    public $sortBy = 'institute_name';
    public $sortDirection = 'asc';
    public $perPage = 10;
    public $search = '';

    public $qualificationId;

    public $isForm = false;

    public function sort($column) {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[On('refreshQualifications')] 
    public function getQualificationsProperty()
    {
        return Qualification::query()
            ->whereAny([
                'institute_name', 
                'passing_year',
                'board_name',
                'exam_name'
            ], 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function create($qualicationId = null)
    {
        if ($qualicationId) {
            $this->qualicationId = $qualicationId;
        } else {
            $this->qualicationId = null;
        }
        $this->isForm = true;
    }
   
    #[On('refreshQualifications')]
    public function closeForm()
    {
        $this->isForm = false;
        $this->qualificationId = null;
    }

}; ?>

<div>
    @if ($this->isForm)
        <livewire:qualifications.form :qualificationId="$this->qualificationId"/>
    @else
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl">Qualifications</h1>
            <x-button-primary wire:click="create">
                {{ __('New Qualification') }}
            </x-button-primary>
        </div>
        
        <hr class="mb-4" />
        <div class="qualification-list">
                @if($this->qualifications->count())
                    <div class="grid grid-cols-1 gap-4">
                        @foreach ($this->qualifications as $qualification)
                            <div class="rounded-lg bg-gray-200 p-4 dark:bg-indigo-800 dark:text-indigo-400">
                                <h4><span class="font-semibold">{{ __('ID:') }}</span> {{ $qualification->id }}</h4>
                                <p><span class="font-semibold">{{ __('Institute Name:') }}</span> {{ $qualification->institute_name }}</p>
                                <p><span class="font-semibold">{{ __('Passing Year:') }}</span> {{ $qualification->passing_year }}</p>
                                <p><span class="font-semibold">{{ __('Board Name:') }}</span> {{ $qualification->board_name }}</p>
                                <p><span class="font-semibold">{{ __('Exam Name:') }}</span> {{ $qualification->exam_name }}</p>
                                <p><span class="font-semibold">{{ __('Rsult Type:') }}</span> {{ $qualification->result_type->label() }}</p>
                                <p><span class="font-semibold">{{ __('Passing Year:') }}</span> {{ $qualification->passing_year }}</p>
                                <p><span class="font-semibold">{{ __('Result:') }}</span> {{ $qualification->result }}</p>
                                <p><span class="font-semibold">{{ __('Out of:') }}</span> {{ $qualification->out_of }}</p>
                                <p><span class="font-semibold">{{ __('Created At:') }}</span> {{ $qualification->created_at->format('Y-m-d H:i:s') }}</p>
                                <p><span class="font-semibold">{{ __('Updated At:') }}</span> {{ $qualification->updated_at->format('Y-m-d H:i:s') }}</p>
                                <div class="flex justify-end mt-2">
                                    <button
                                        class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 focus:ring focus:ring-blue-300"
                                        wire:click="create({{ $qualification->id }})"
                                    >
                                        {{ __('Edit') }}
                                    </button>
                                    <button
                                        class="bg-red-500 text-white px-3 py-1 ml-2 rounded-md hover:bg-red-600 focus:ring focus:ring-red-300"
                                        wire:click="delete({{ $qualification->id }})"
                                    >
                                        {{ __('Delete') }}
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $this->qualifications->links() }}
                @else
                    <h1 class="text-2xl text-center font-medium">{{ __('Not found') }}</h1>
                @endif
                
        </div> 
    @endif
    
</div>
