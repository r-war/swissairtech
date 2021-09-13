        <!--# content #-->

          {if $news}
          <div class="heading-page heading-page-1 bg-cover" style="background: url('/contents/images/{$aConfig.news}') center center no-repeat;">
            <div class="container">
              {*<h3 class="title">{$news->getName()}</h3>*}
            </div>
          </div>
          <div class="page-content p-b-70">
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <section class="section post-section-2 p-r-40">
                            <div class="post-header">
                                <h3 class="text-block text-black text-bold text-med-large m-b-25">{$news->getName()}</h3>
                                <div class="post-info m-b-30">
                                    <p class="text-block">{$news->getDate('F d, Y')}
                                    </p>
                                </div>
                            </div>
                            <div class="post-content">
                              <img src="{$news->getPictureUrl()}" class="img-responsive">
                              <br>
                              {$news->getDescription()}
                            </div>
                        </section>
                    </div>
                    <br>
                    <div class="col-md-3">
                        <h4 class="text-block text-bold text-med m-b-40">Latest News</h4>
                        {foreach $latest_news as $data}
                        <div class="image-card image-card-9">
                          <div class="image">
                            <a href="blog-single.html">
                                <img src="{$data->getThumbnailURL(50,30)}" alt="{$data->getName()}" />
                            </a>
                          </div>
                          <div class="content">
                            <h3 class="title">
                                <a href="blog-single.html">{$data->getName()}</a>
                            </h3>
                            <span class="subtitle">{$data->getDate('F d, Y')}</span>
                          </div>
                        </div>
                        {/foreach}
                  </div>
                </div>
            </div>
          </div>
          {else}
          <br>
          <div class="section p-t-0 p-b-70 bg-white">
            <div class="container">
              <div class="row">
              {if count($news_list) > 0}
              {foreach $news_list as $data}
                <div class="col-md-4">
                    <div class="image-card image-card-4">
                        <div class="image">
                            <a href="{$oMod->getBasePage('News',$data->getUrl())}">
                                <img src="{$data->getThumbnailURL(500,300)}" alt="{$data->getName()}" />
                            </a>
                        </div>
                        <div class="date">
                            <span>{$data->getDate('F d, Y')}</span>
                        </div>
                        <h3 class="title">
                            <a href="{$oMod->getBasePage('News',$data->getUrl())}">{$data->getName()}</a>
                        </h3>
                        <div class="content">
                          {if $data->getShortDescription()!=''}
                            {$data->getShortDescription()}
                          {else}
                            {$data->getDescription()|truncate:300}
                          {/if}
                        </div>
                        <div class="link">
                            <a href="{$oMod->getBasePage('News',$data->getUrl())}">Continue reading</a>
                        </div>
                    </div>
                </div>
              {/foreach}
              </div>
              {else}
                <div class="text-center">
                  No News Found
                </div>
                {/if}
            </div>
          </div>

          {/if}
        <!--# content #-->