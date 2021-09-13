        <!--# content #-->
        <div class="heading-page heading-page-1 bg-cover" style="background: url('/contents/images/{$aConfig.testimonial}') center center no-repeat;">
            <div class="container">
              <h3 class="title">Testimonials</h3>
            </div>
          </div>
        <section class="section bg-grey-light p-t-70 p-b-50">
        <div class="container">
            <div class="relative section-testimonials-wrapper-1">
                <div class="heading-section heading-section-1 dark">
                    <h3>Testimonials</h3>
                </div>
                <div class=" dark nav-style-1" >
                  {if count($testimonials) > 0}
                    {foreach $testimonials as $data}
                    {if $data->getActive()}
                    <div class="image-card image-card-2">
                        <div class="card-top">
                            <div class="avatar">
                                <a href="#">
                                    <img src="{$data->getPictureUrl()}" alt="{$data->getName()}" />
                                </a>
                            </div>
                            <div class="info">
                                <span class="name">{$data->getName()}</span>
                                {*<span class="job-title">Chief Executive Officer, Envato</span>*}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="content">
                                {$data->getDescription()}
                            </div>
                        </div>
                    </div>
                    {/if}
                    {/foreach}
                    {/if}
                </div>
            </div>
        </div>
    </section>
        {*<div class="content">

          <div class="page-title">
            <div class="title-overlay">
              <h1>{$oMod->getName()}</h1>
            </div>
            <img src="{#IMAGE_PATH#}/default-title-bg.jpg" class="img-fluid">
          </div>

          <div class="container news-list">
          <br><br>
          {if count($testimonials) > 0}
            {foreach $testimonials as $data}
            <div class="row">
              <div class="col-md-12">
                <div class="entry-content">
                  {$data->getDescription()}
                  <div class="news-title text-right" style="font-size: 16px">- {$data->getName()}</div>
                </div>
              </div>
            </div>
            <br>
            {/foreach}
          {else}
            <div class="text-center">
              No Testimonial Found
            </div>
          {/if}
          <br>
          </div>

        </div>*}
        <!--# content #-->