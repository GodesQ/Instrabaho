

<div class="card">
    <div class="card-header">
        <div class="modal-header">
            <label class="modal-title text-text-bold-600" id="create">Create User Type</label>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.user_types.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <label>User Type: </label>
                    <div class="form-group">
                        <input type="text" placeholder="User Type" name="user_type" id="user_type" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="text" placeholder="Slug" name="slug" id="slug" class="form-control">
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


