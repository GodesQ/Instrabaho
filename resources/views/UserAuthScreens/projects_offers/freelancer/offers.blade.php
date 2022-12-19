@forelse ($offers as $offer)
    <div class="row border-bottom p-2">
        <div class="col-md-4" style="font-size: 14px !important;">
            {{ date_format(new DateTime($offer->created_at), "F d, Y") }}
        </div>
        <div class="col-md-4" style="font-size: 20px !important;">
            <a href="/offer/info/{{ $offer->id }}" class="primary">{{ $offer->project->title }}</a>
        </div>
        <div class="col-md-4">
            <a href="/offer/info/{{ $offer->id }}?act=message" class="btn btn-primary ml-2">Message</a>
        </div>
    </div>
@empty
    <div>No Proposals Found</div>
@endforelse
