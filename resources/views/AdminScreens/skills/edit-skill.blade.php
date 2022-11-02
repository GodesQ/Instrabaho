

<div class="card">
    <div class="card-header">
        <div class="modal-header">
            <label class="modal-title text-text-bold-600" id="myModalLabel33">Edit Skill</label>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.skills.update') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="skill_id">
                <div class="modal-body">
                    <label>Skill: </label>
                    <div class="form-group">
                        <input type="text" placeholder="Skill" name="skill_name" id="skill_name" class="form-control">
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


