<div class="background-img text-center text-uppercase">
    <img src="./contents/images/{$aConfig.product}" class="img-responsive" alt="">
    <div class="overlay"></div>
    <h2 class="background-text">Products</h2>
</div>

<div class="limo-list dark-bg padding-top100">
    <div class="container">
        {foreach $products as $product}
        <div class="col-md-4 wow fadeInUp animated" data-wow-duration=".8s" data-wow-delay="0.3s">
            <div class="colmd4">
                <div class="list-single-item">
                    <div class="list-img"><img src="{$product->getPictureUrl()}" class="img-responsive" alt="List Image"></div>
                    <div class="car-info">
                        <div class="name-price">
                            <span class="name">{$product->getName()}</span>
                            <!-- <span class="price">$1350 <sub>/Hour</sub> </span> -->
                        </div>
                        <div class="feature-lsit">
                            {$product->getDescription()}
                        </div>
                    </div><!-- /.car-info -->
                </div><!-- /.list-single-item -->
            </div>
        </div><!-- /.col-md-4 -->
        {/foreach}
    </div>
</div>