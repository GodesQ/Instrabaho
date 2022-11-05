<div class="card">
    <div class="card-header">
        <h4 class="card-title" id="repeat-form">Skills</h4>
        <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                <li><a data-action="reload"><i class="feather icon-rotate-cw"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse show">
        <div class="card-body">
            <div class="repeater-default">
                <form action="/store_skills" method="POST">
                    @csrf
                    @if(session()->get('role') == 'admin')
                        <input type="number" hidden name="user_id" value="{{ $freelancer->user_id }}">
                    @endif
                    <div data-repeater-list="skills">
                        @forelse($freelancer->skills as $freelancer_skill)
                            <div data-repeater-item="">
                                <div class="form row">
                                    <div class="form-group mb-1 col-sm-12 col-md-5">
                                        <label for="email-addr">Skill</label>
                                        <br>
                                        <select name="skill" class=" form-control" required id="profession">
                                            <option value="">Select Skills</option>
                                            @foreach($skills as $skill)
                                                <option {{ $skill->id == $freelancer_skill->skill_id ? 'selected' : null }} value="{{ $skill->id }}">{{ $skill->skill_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger danger">@error('skill'){{ $message }}@enderror</span>
                                    </div>
                                    <div class="form-group mb-1 col-sm-12 col-md-5">
                                        <label for="pass">Skill Percentage
                                            <span class="text-primary" style="font-size: 12px; font-style: italic;">(Up to 100%)</span>
                                        </label>
                                        <br>
                                        <input type="number" max="100" value="{{ $freelancer_skill->skill_percentage }}" class="form-control" required id="pass" name="skill_percentage" placeholder="Skill Percentage">
                                        <span class="text-danger danger">@error('skill_percentage'){{ $message }}@enderror</span>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-2 text-center mt-2">
                                        <button type="button" class="btn btn-danger" data-repeater-delete=""> <i class="feather icon-x"></i> Delete</button>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        @empty
                            <div data-repeater-item="">
                                <div class="form row">
                                    <div class="form-group mb-1 col-sm-12 col-md-5">
                                        <label for="email-addr">Skill</label>
                                        <br>
                                        <select name="skill" class="select2 form-control" required id="profession">
                                            <option value="">Select Skills</option>
                                            @foreach($skills as $skill)
                                                <option value="{{ $skill->id }}">{{ $skill->skill_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger danger">@error('skill'){{ $message }}@enderror</span>
                                    </div>
                                    <div class="form-group mb-1 col-sm-12 col-md-5">
                                        <label for="pass">Skill Percentage
                                            <span class="text-primary" style="font-size: 12px; font-style: italic;">(Up to 100%)</span>
                                        </label>
                                        <br>
                                        <input type="number" max="100" class="form-control" required id="pass" name="skill_percentage" placeholder="Skill Percentage">
                                        <span class="text-danger danger">@error('skill_percentage'){{ $message }}@enderror</span>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-2 text-center mt-2">
                                        <button type="button" class="btn btn-danger" data-repeater-delete=""> <i class="feather icon-x"></i> Delete</button>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        @endforelse
                    </div>
                    <div class="form-group overflow-hidden">
                        <div class="col-12">
                            <button type="button" data-repeater-create="" class="btn btn-dark btn-solid">
                                <i class="icon-plus4"></i> Add Skill
                            </button>
                            <button type="submit" class="btn btn-primary btn-solid">
                                <i class="icon-plus4"></i> Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
