<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Jobs;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;

class Job extends Component
{

    use WithPagination;

    public $category_id, $title, $job_type, $skills, $location, $description, $job_id;

    public $searchItem;

    public function render()
    {
        $jobs = Jobs::with(['category'])->where(function($job){
            $job->where('title', 'like', '%'.$this->searchItem.'%');
        })->orderBy('id', 'DESC')->paginate(10);

        $category = Category::all();

        return view('livewire.job', compact('jobs', 'category'))->layout('livewire.layout.master');
    }

    public function editJob($id)
    {
        $jobs = Jobs::find($id);
        $this->job_id = $jobs->id;
        $this->category_id = $jobs->category_id;
        $this->title = $jobs->title;
        $this->job_type = $jobs->job_type;
        $this->skills = $jobs->skills;
        $this->location = $jobs->location;
        $this->description = $jobs->description;
    }

    public function updateJobData(Request $request)
    {
        $this->validate([
            'category_id' => 'required',
            'title' => 'required',
            'job_type' => 'required',
            'skills' => 'required',
            'location' => 'required',
            'description' => 'required'
        ]);

        $jobs = Jobs::find($this->job_id);
        $jobs->category_id = $this->category_id;
        $jobs->title = $this->title;
        $jobs->job_type = $this->job_type;
        $jobs->skills = $this->skills;
        $jobs->location = $this->location;
        $jobs->description = $this->description;
        $jobs->save();

        $this->resetForm();

        session()->flash('message', 'Job has been updated successfully');

        // Close modal
        $this->dispatchBrowserEvent('close-edit-modal');
    }

    public function storeData(Request $request)
    {
        $this->validate([
            'category_id' => 'required',
            'title' => 'required',
            'job_type' => 'required',
            'skills' => 'required',
            'location' => 'required',
            'description' => 'required'
        ]);

        $jobs = new Jobs();
        $jobs->category_id = $this->category_id;
        $jobs->title = $this->title;
        $jobs->job_type = $this->job_type;
        $jobs->skills = $this->skills;
        $jobs->location = $this->location;
        $jobs->description = $this->description;
        $jobs->save();

        $this->resetForm();

        session()->flash('message', 'New job has been added successfully');

        // Close modal
        $this->dispatchBrowserEvent('close-modal');
    }

    public function resetForm(){
        $this->category_id = "";
        $this->title = "";
        $this->job_type = "";
        $this->skills = "";
        $this->location = "";
        $this->description = "";
    }
}
