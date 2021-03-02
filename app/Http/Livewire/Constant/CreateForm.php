<?php

namespace App\Http\Livewire\Constant;

use Livewire\Component;

class CreateForm extends Component
{

    public   $model, $newId, $newName, $name, $modelName, $text;
	
    protected function getListeners()
    {
        return [('objectAdded_'.($this->modelName)) => 'objectAdded'];
    }


	public function mount($model, $name, $text){
		$this->modelName = $model;
		$this->text = $text;

		$model = '\App\Models\\'.$model;

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
        return view('livewire.constant.create-form');
    }
}
