<div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <h6 style="float: left;" class="pull-left"><strong>All Jobs</strong></h6>
                        <button type="button" class="btn btn-primary pull-right" style="float: right;" data-toggle="modal"
                            data-target="#addJobModal"> ADD Job</button>
                    </div>
                    <div class="card-body">
                        @if (session()->has('message'))
                            <div class="alert alert-success text-center">{{ session('message') }}</div>
                        @endif
                        <div class="row mb-2">
                            <div class="col-8"></div>
                            <div class="col-4 pull-right">
                                <div class="">
                                    <input type="text"  class="form-control" placeholder="Search" wire:model="searchItem" />
                                </div>
                            </div>

                        </div>
                        <table class="table table-borderd">
                            <thead>
                                <th>Name</th>

                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($jobs as $key => $value)
                                    <tr>
                                        <td>{{ $value->title }}</td>

                                        <td>
                                            <button class="btn btn-primary" data-toggle="modal"
                                                data-target="#editJobModal" wire:click="editJob({{ $value->id }})">Edit</button>
                                            {{-- <button class="btn btn-danger">Delete</button> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $jobs->links('pagination::bootstrap-4') }}

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade " id="addJobModal" tabindex="-1" role="dialog"
        aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Job</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
                <form wire:submit.prevent='storeData'>
                    <div class="modal-body">

                        <div class="form-group row">
                            <label class="col-3">Name*</label>
                            <div class="col-9">
                                <input type="text" class="form-control" wire:model="title">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-3">Category*</label>
                            <div class="col-9">
                                <select class="form-control" wire:model='category_id'>
                                    <option value="">Select Category</option>
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-3">Job Type*</label>
                            <div class="col-9">
                                <input type="radio" wire:model="job_type" name="job_type" value="Part Time"> Part Time
                                <input type="radio"  wire:model="job_type" name="job_type" value="Full Time"> Full Time
                                <input type="radio"  wire:model="job_type" name="job_type" value="Internship"> Internship
                                @error('job_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-3">Skills*</label>
                            <div class="col-9">
                                <input type="text" class="form-control" wire:model="skills">
                                @error('skills')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-3">Location*</label>
                            <div class="col-9">
                                <input type="text" class="form-control" wire:model="location">
                                @error('location')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-3">Description*</label>
                            <div class="col-9">
                                <input type="text" class="form-control" wire:model="description">
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div wire:ignore.self class="modal fade " id="editJobModal" tabindex="-1" role="dialog"
        aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
                <form wire:submit.prevent='updateJobData'>
                    <div class="modal-body">

                        <div class="form-group row">
                            <label class="col-3">Name*</label>
                            <div class="col-9">
                                <input type="text" class="form-control" wire:model="title">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-3">Category*</label>
                            <div class="col-9">
                                <select class="form-control" wire:model='category_id'>
                                    <option value="">Select Category</option>
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-3">Job Type*</label>
                            <div class="col-9">
                                <input type="radio" wire:model="job_type" name="job_type" value="Part Time"> Part Time
                                <input type="radio"  wire:model="job_type" name="job_type" value="Full Time"> Full Time
                                <input type="radio"  wire:model="job_type" name="job_type" value="Internship"> Internship
                                @error('job_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-3">Skills*</label>
                            <div class="col-9">
                                <input type="text" class="form-control" wire:model="skills">
                                @error('skills')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-3">Location*</label>
                            <div class="col-9">
                                <input type="text" class="form-control" wire:model="location">
                                @error('location')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-3">Description*</label>
                            <div class="col-9">
                                <input type="text" class="form-control" wire:model="description">
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // window.addEventListener('close-modal')
        // {
        //     $('#addCustomerModal').modal('hide');
        // }

        window.addEventListener('close-modal', event => {
            $('#addJobModal').modal('hide');
        });

        window.addEventListener('close-edit-modal', event => {
            $('#editJobModal').modal('hide');
        });
    </script>
@endpush
