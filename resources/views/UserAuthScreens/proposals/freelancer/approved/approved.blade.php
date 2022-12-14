@forelse ($approved_proposals as $proposal)
    <div class="row border-bottom p-2">
        <div class="col-md-3" style="font-size: 14px !important;">
            {{ date_format(new DateTime($proposal->created_at), "F d, Y") }}
        </div>
        <div class="col-md-5" style="font-size: 20px !important;">
            <a href="/proposal/info/{{ $proposal->id }}" class="primary">{{ optional($proposal->project)->title }}</a>
        </div>
        <div class="col-md-4">
            <a href="" class="warning">Cancel Project</a>
            <a href="/proposal/info/{{ $proposal->id }}?act=message" class="btn btn-primary ml-1">Message</a>
        </div>
    </div>
@empty
    <div>No Proposals Found</div>
@endforelse
