

<div class="card">
    <div class="card-header">
        <div class="modal-header">
            <label class="modal-title text-text-bold-600" id="create">Edit User Type</label>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.user_types.update') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="user_type_id">
                <div class="modal-body">
                    <label>User Type: </label>
                    <div class="form-group">
                        <input type="text" placeholder="User Type" name="user_type" id="edit_user_type" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="text" placeholder="Slug" name="slug" id="edit_slug" readonly class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal" value="close">
                    <button class="btn btn-primary btn-lg">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


