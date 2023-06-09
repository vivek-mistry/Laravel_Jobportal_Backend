<div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <h6 style="float: left;" class="pull-left"><strong>All Category</strong></h6>
                        <button type="button" class="btn btn-primary pull-right" style="float: right;" data-toggle="modal"
                            data-target="#addCategoryModal"> ADD Category</button>
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
                                @foreach ($cat as $key => $value)
                                    <tr>
                                        <td>{{ $value->name }}</td>

                                        <td>
                                            <button class="btn btn-primary" data-toggle="modal"
                                                data-target="#editCategoryModal" wire:click="editCategory({{ $value->id }})">Edit</button>
                                            <button class="btn btn-danger" wire:click="categoryRemovePopUp({{ $value->id }})">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $cat->links('pagination::bootstrap-4') }}

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade " id="addCategoryModal" tabindex="-1" role="dialog"
        aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
                <form wire:submit.prevent='storeData'>
                    <div class="modal-body">

                        <div class="form-group row">
                            <label class="col-3">Name*</label>
                            <div class="col-9">
                                <input type="text" class="form-control" name="name" wire:model="name">
                                @error('name')
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
    <div wire:ignore.self class="modal fade " id="editCategoryModal" tabindex="-1" role="dialog"
        aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
                <form wire:submit.prevent='updateCategoryData'>
                    <div class="modal-body">

                        <div class="form-group row">
                            <label class="col-3">Name*</label>
                            <div class="col-9">
                                <input type="text" class="form-control" name="name" wire:model="name">
                                @error('name')
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
    <div wire:ignore.self class="modal fade " id="deleteModal" tabindex="-1" role="dialog"
        aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
                <form >
                    <div class="modal-body">

                        <p>Are you sure?</p>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger" wire:click="removeCategory">Delete</button>
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
            $('#addCategoryModal').modal('hide');
            $('#deleteModal').modal('hide');
        });

        window.addEventListener('close-edit-modal', event => {
            $('#editCategoryModal').modal('hide');
        });

        window.addEventListener('open-delete-modal', event => {
            $('#deleteModal').modal('show');
        });
    </script>
@endpush
