

    <div class="form-group" style="width: 20%">
        <div class="font-weight-bold text-center" style="color: #000;">Rate</div>
        <div class="range-slider">
            <input type="text" class="services-range-slider" name="my_range" id="my_range" />
        </div>
        <div class="extra-controls">
            <input type="hidden" class="services-input-from form-control" value="" name="price-min">
            <input type="hidden" class="services-input-to form-control" value="" name="price-max">
        </div>
    </div>
    <div class="card" style="border: none !important;">
        <div class="card-body px-3">
            <div class="freelancer-search-container">
                <div class="freelancer-search-header">

                    <div class="row align-items-center">
                        <div class="col-xl-6 col-sm-12 my-1">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="freelancer-search-input" name="address" id="map-search" placeholder="Search by Location">
                                    <input type="hidden" name="latitude" class="form-control latitude">
                                    <input type="hidden" name="longitude" class="form-control longitude">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="radius" id="radius" class="select2">
                                            <option value="5">5 km</option>
                                            <option value="10">10 km</option>
                                            <option value="25">25 km</option>
                                            <option value="50">50 km</option>
                                            <option value="75">75 km</option>
                                            <option value="100">100 km</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 border-right">
                                    <div class="form-group">
                                        <select name="result" id="result" class="form-control">
                                            <option value="10">10 Result</option>
                                            <option value="25">25 Result</option>
                                            <option value="50">50 Result</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-sm-12 my-1">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" class="freelancer-search-input" name="title" id="title" placeholder="Search by Keyword">
                                </div>
                                <div class="col-md-4">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <button class="btn btn-primary btn-block p-3" style="font-size: 15px ">Find Freelancers</button>
        </div>
