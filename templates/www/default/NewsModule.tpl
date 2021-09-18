	<!-- Limo Car Breatcume -->
<div class="background-img text-center text-uppercase">
    <img src="/contents/images/{$aConfig.news}" class="img-responsive" alt="">
    <div class="overlay"></div>
    <h2 class="background-text">News{if $news} / {$news->getName()} {/if}</h2>
</div>
	<!-- End of Limo Car Breatcume -->
<!--# content #-->
<div class="page-container">
  <div class="container">
    {if $news}
      <div class="col-md-offset-3 col-md-8 col-lg-offset-1 col-lg-9">
        <div class="single-post">
          <div class="post-thumb">
            <img src="{$news->getPictureUrl()}" class="img-responsive" alt="post Image">
          </div>
          <article>
            {$news->getDescription()}
          </article>
        </div>
      </div>
    {else}
      {if count($news_list) > 0}
        {foreach $news_list as $news}  
        <div class="col-md-6">
          <div class="post-container padding-top100">
            <div class="single-post">
              <div class="post-thumb">
                <img src="{$news->getPictureUrl()}" class="img-responsive" alt="news picture">
              </div>
              <arcticle>
                <h2>{$news->getName()}</h2>
                <div class="entry-meta">
                  <span>{$news->getDate()}</span>
                </div>
                {$news->getShortDescription()}
                <div class="link">
                  <a href="{$news->getUrl()}" class="more-btn">Read More</a>
                </div>
              </arcticle>
            </div>
          </div>
        </div>
        {/foreach}
      {else}
      <div class="col-md-12">
        <p class="text-center">No News found</p>
      </div>
      {/if}
    {/if}
  </div>
</div>