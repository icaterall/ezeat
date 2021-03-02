<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Facades\App\Models\Category;

class CategoryComponent extends Component
{
    public $data, $name, $selected_id;
    public $updateMode = false;

    public function render()
    {
        $this->data = Category::all();
        return view('livewire.categories.component');
    }

    private function resetInput()
    {
        $this->name = null;

    }

    public function store()
    {
        $this->validate([
            'name' => 'required|min:3'
        ]);

        Category::create([
            'name' => $this->name
        ]);

        $this->resetInput();
    }

    public function edit($id)
    {
        $record = Category::findOrFail($id);

        $this->selected_id = $id;
        $this->name = $record->name;

        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
            'selected_id' => 'required|numeric',
            'name' => 'required|min:3'
        ]);

        if ($this->selected_id) {
            $record = Category::find($this->selected_id);
            $record->update([
                'name' => $this->name
            ]);

            $this->resetInput();
            $this->updateMode = false;
        }

    }

    public function destroy($id)
    {
        if ($id) {
            $record = Category::where('id', $id);
            $record->delete();
        }
    }
}