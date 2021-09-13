
<div class="heading-page heading-page-1 bg-cover" style="background: url('/contents/images/{$aConfig.page}') center center no-repeat;">
  <div class="container">
    <h3 class="title">{$page->getName()}</h3>
  </div>
</div>
<div class="page-content p-b-50">
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        {if $page->haveSub()}
        <section class="section post-section-1 m-b-30 p-r-15">
          <p>&nbsp;</p>
          {foreach $page_tabs as $tab}
          <div class="accordion-description {if $tab@index eq 0}active{else}hide{/if}"  id="{$tab->getId()}">
            {$tab->getDescription()}
          </div>
          {/foreach}
        </section>
      </div>
      <div class="col-md-3">
        <p>&nbsp;</p>
        <h4 class="text-bold text-bold text-black text-med m-t-0 m-b-30">Who We Are</h4>
        <ul class="post-tabs post-tabs-1 m-b-40">
          {foreach $page_tabs as $tab}
            <li >
                <a href="#{$tab->getId()}">{$tab->getName()}</a>
            </li>
            {/foreach}
        </ul>
      </div>
      {else}
      <div class="col-md-9">
        <section class="section post-section-1 m-b-30 p-r-15">
          <p>&nbsp;</p>
          <div class="accordion-description" >
            {$page->getDescription()}
          </div>
        </section>
      </div>
      <div class="col-md-3">
        {*<p>&nbsp;</p>
        <h4 class="text-bold text-bold text-black text-med m-t-0 m-b-30">Who We Are</h4>
        <ul class="post-tabs post-tabs-1 m-b-40">
          {foreach $page_tabs as $tab}
            <li >
                <a href="#{$tab->getId()}">{$tab->getName()}</a>
            </li>
            {/foreach}
        </ul>*}
      </div>
      {/if}
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
  $('.post-tabs-1 > li:first-child').addClass('active');
  $('.post-tabs-1 > li > a').click(function(event){
    event.preventDefault();
    var tab_selector= $('.post-tabs-1 > li.active > a').attr('href');
    var actived_nav= $('.post-tabs-1 > li.active');
    actived_nav.removeClass('active');
    
    $(this).parent('li').addClass('active');

    $(tab_selector).removeClass('active');
    $(tab_selector).addClass('hide');

    var target_tab = $(this).attr('href');
    $(target_tab).removeClass('hide');
    $(target_tab).addClass('active');
  });
});
</script>
