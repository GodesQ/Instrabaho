@forelse($services as $service)
    @php
        $images = json_decode($service->attachments);
    @endphp
    <div class="col-md-4">
    <a href="/service/view/{{ $service->id }}">
        <div class="badge badge-info p-2 text-uppercase position-relative" style="margin-bottom: -200px; z-index: 10;"></div>
        <div class="fr-top-contents bg-white-color">
            <div class="fr-top-product">
            @if(count($images) > 0)
                <img height="250" width="100%" style="object-fit: cover;" src="../../../images/services/{{ $images[0] }}" alt="" class="img-responsive">
            @else
                <img height="250" width="100%" style="object-fit: cover;" src="../../../images/bg-image/default-cover.png" alt="" class="img-responsive">
            @endif
            <div class="fr-top-rating"> <a href="" class="save_service protip" data-fid="171" data-pt-position="top" data-pt-scheme="black" data-pt-title="Save Service" data-post-id="355"><i class="fa fa-heart" aria-hidden="true"></i></a> </div>
                @if($service->type == 'featured')
                <div class="fr-top-right-rating">Featured</div>
                @endif
            </div>
            <div class="fr-top-details">
                <span class="rating"> <i class="fa fa-star" aria-hidden="true"></i> No Reviews</span>
                <a href="/service/view/{{ $service->id }}" title="We’ll create graphic for 3d unity game with all component">
                <div class="fr-style-5">{{ substr($service->name, 0, 20) . '...' }}</div>
                </a>
                <p>Starting From<span class="style-6"><span class="currency">₱ </span><span class="price">{{ number_format($service->cost, 2) }}</span></span></p>
                <div class="fr-top-grid"> <a href=""><img src="img/freelancers-imgs/deo-profile.jpg" alt="" class="img-fluid"></a></div>
                @if($service->distance)
                <p>Distance <span class="style-6"><span class="price">{{ number_format($service->distance, 2) }} k/m</span></span></p>
                @endif
            </div>
        </div>
    </a>
    </div>
    @empty

@endforelse

<div class="fl-navigation">
    {!! $services->links() !!}
 </div>