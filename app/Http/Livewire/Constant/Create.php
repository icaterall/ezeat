<?php

namespace App\Http\Livewire\Constant;

use Livewire\Component;

class Create extends Component
{

    public $name, $model, $modelName;

 

    public function mount($model){
        $this->modelName = $model;

        $this->model = '\App\Models\\'.$model;
    }


    public function store()
    {
        $this->validate([
            'name' => 'required|unique:categories',
        ]);

        $record = ($this->model)::create([
            'name' => $this->name
        ]);

        $this->emit(('objectAdded_'.($this->modelName)), $record->id);

    }


    public function render()
    {
        return view('livewire.constant.create');
    }
}
