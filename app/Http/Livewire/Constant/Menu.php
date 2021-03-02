<?php

namespace App\Http\Livewire\Constant;

use Livewire\Component;

class Menu extends Component
{

    public $menu, $model, $newId, $newName, $name, $modelName, $text, $selectedValue;
	
    protected function getListeners()
    {
        return [('objectAdded_'.($this->modelName)) => 'objectAdded'];
    }


	public function mount($model, $name, $text, $selectedValue){
		$this->modelName = $model;
		$this->text = $text;
		$this->selectedValue = $selectedValue;

		$model = '\App\Models\\'.$model;
		$this->menu = $model::pluck('name','id')->toArray();

		$this->name = $name;
		$this->model = $model;
	}

	 public function objectAdded($id)
    {
    	$data =  ($this->model)::find($id);
		$this->newId = $data->id;
		$this->newName = $data->name;
    }




    public function render()
    {
        return view('livewire.constant.menu');
    }
}
