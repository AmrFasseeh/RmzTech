<div class="col-xl-3 col-md-6 col-12">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="media d-flex">
                    <div class="media-body text-left">
                        <h3 class="danger">{{ $totalhrs ?? '' }}</h3>
                        <span>{{ $slot }}</span>
                    </div>
                    <div class="align-self-center">
                        <i class="la la-history danger font-large-2 float-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>