<div class="card">
    <div class="card-header">
        <div class="modal-header">
            <label class="modal-title text-text-bold-600" id="myModalLabel33">Create Category</label>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.service_categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <label>Category: </label>
                    <div class="form-group">
                        <input type="text" placeholder="Category" name="category_name" id="category_name" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal" value="close">
                    <button class="btn btn-primary btn-lg">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>


