<?php

namespace App\Http\Livewire;

use App\Models\Category as ModelsCategory;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;

class Category extends Component
{
    use WithPagination;

    public $category_id, $name;

    public $searchItem;

    public function render()
    {
        $cat = ModelsCategory::where(function($category){
            $category->where('name', 'like', '%'.$this->searchItem.'%');
        })->orderBy('id', 'DESC')->paginate(10);

        return view('livewire.category', compact('cat'))->layout('livewire.layout.master');
    }

    public function editCategory($id)
    {
        $category = ModelsCategory::find($id);
        $this->category_id = $id;
        $this->name = $category->name;
    }

    public function updateCategoryData(Request $request)
    {
        $this->validate([
            'name' => 'required'
        ]);

        $category = ModelsCategory::find($this->category_id);
        $category->name = $this->name;
        $category->save();

        $this->resetForm();

        session()->flash('message', 'Category has been updated successfully');

        // Close modal
        $this->dispatchBrowserEvent('close-edit-modal');
    }

    public function storeData(Request $request)
    {
        $this->validate([
            'name' => 'required'
        ]);

        $category = New ModelsCategory();
        $category->name = $this->name;
        $category->save();

        $this->resetForm();

        session()->flash('message', 'New category has been added successfully');

        // Close modal
        $this->dispatchBrowserEvent('close-modal');
    }

    public function categoryRemovePopUp($category_id)
    {
        $this->category_id = $category_id;

        $this->dispatchBrowserEvent('open-delete-modal');
    }

    public function removeCategory()
    {
        $category = ModelsCategory::find($this->category_id);
        $category->delete();
        $this->category_id = null;
        session()->flash('message', 'Category removed successfuly');

        // Close modal
        $this->dispatchBrowserEvent('close-modal');
    }

    public function resetForm(){
        $this->name = "";
    }
}
