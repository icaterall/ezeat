<?php

namespace App\Http\Livewire\Constant;

use Livewire\Component;

class Cuisine extends Component
{

    public $menu, $model, $newId, $newName, $name, $modelName,$selectedValue;
	
    protected function getListeners()
    {
        return [('objectAdded_'.($this->modelName)) => 'objectAdded'];
    }


	public function mount($model,$selectedValue){
		$this->modelName = $model;
        $this->selectedValue = $selectedValue;
		$model = '\App\Models\\'.$model;
		$this->menu = $model::pluck('name','id')->toArray();

		$this->name = 'cuisine[]';
		$this->model = $model;
	}

	 public function objectAdded($id)
    {
    	$data = \App\Models\Cuisine::find($id);
		$this->newId = $data->id;
		$this->newName = $data->name;
    }




    public function render()
    {
        
        $cuisines = \App\Models\Cuisine::orderBy('id','DESC')->pluck('name','id')->all();

        return view('livewire.constant.cuisine',compact('cuisines'));
    }
}
