<ul class="nav">
  {if $oLoginAdmin->isAuthorized(array('AdminType','Admin','User','Subscriber'))}
  <li class="dropdown {if in_array($oMod->getModule(),array('AdminType','Admin','User','Subscriber'))}active{/if}">
  	<a class="dropdown-toggle" data-toggle="dropdown" href="{$oMod->getBasePage($oLoginAdmin->isAuthorized(array('AdminType','Admin','User','Subscriber')))}">
  		<i class="icon-user"></i> User <b class="caret"></b>
	</a>
	<ul class="dropdown-menu">
  	  {if in_array('AdminType',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'AdminType'}class="active"{/if}><a href="{$oMod->getBasePage('AdminType')}">Admin Type / Privileges</a></li>
	    {/if}
	    {if in_array('Admin',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Admin'}class="active"{/if}><a href="{$oMod->getBasePage('Admin')}">Admin</a></li>
	    {/if}
	    {if in_array('User',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'User'}class="active"{/if}><a href="{$oMod->getBasePage('User')}">{loc k=member}</a></li>
	    {/if}
	    {if in_array('Subscriber',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Subscriber'}class="active"{/if}><a href="{$oMod->getBasePage('Subscriber')}">{loc k=mailing_list}</a></li>
	    {/if}
	    {if in_array('Testimonial',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Testimonial'}class="active"{/if}><a href="{$oMod->getBasePage('Testimonial')}">{loc k=testimonial}</a></li>
	    {/if}
    </ul>
  </li>
  {/if}
  
  {if $oLoginAdmin->isAuthorized(array('Content','Page','Menu','News','Service','Event'))}
  <li class="dropdown {if in_array($oMod->getModule(),array('Content','Page','Menu','News','Service','Event'))}active{/if}">
  	<a class="dropdown-toggle" data-toggle="dropdown" href="{$oMod->getBasePage($oLoginAdmin->isAuthorized(array('Content','Page','Menu','News','Service','Event')))}">
  		<i class="icon-pencil"></i> Content <b class="caret"></b>
	</a>
	<ul class="dropdown-menu">
      {if in_array('Menu',$oLoginAdmin->getPrivilegesArray())}
      <li {if $oMod->getModule() == 'Menu' && $smarty.get.mode == 'main'}class="active"{/if}><a href="{$oMod->getBasePage('Menu','mode=main')}">Main Menu</a></li>
      {/if}
      {if in_array('Menu',$oLoginAdmin->getPrivilegesArray())}
      <li {if $oMod->getModule() == 'Menu' && $smarty.get.mode == 'quick-links'}class="active"{/if}><a href="{$oMod->getBasePage('Menu','mode=quick-links')}">Quick Links</a></li>
      {/if}
      {*
      {if in_array('Menu',$oLoginAdmin->getPrivilegesArray())}
      <li {if $oMod->getModule() == 'Menu' && $smarty.get.mode == 'quick'}class="active"{/if}><a href="{$oMod->getBasePage('Menu','mode=quick')}">Header Links</a></li>
      {/if}
      {if in_array('Menu',$oLoginAdmin->getPrivilegesArray())}
      <li {if $oMod->getModule() == 'Menu' && $smarty.get.mode == 'video'}class="active"{/if}><a href="{$oMod->getBasePage('Menu','mode=video')}">Migung VOD</a></li>
      {/if}    
      *}  
	    {if in_array('Page',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Page'}class="active"{/if}><a href="{$oMod->getBasePage('Page')}">{loc k=page}</a></li>
	    {/if}
	    {if in_array('Content',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Content'}class="active"{/if}><a href="{$oMod->getBasePage('Content')}">{loc k=content}</a></li>
	    {/if}
	    {if in_array('Service',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Service'}class="active"{/if}><a href="{$oMod->getBasePage('Service')}">Service</a></li>
	    {/if}
      {if in_array('News',$oLoginAdmin->getPrivilegesArray())}
      <li {if $oMod->getModule() == 'News' && $smarty.get.mode == 'news'}class="active"{/if}><a href="{$oMod->getBasePage('News', 'mode=news')}">{loc k=news}</a></li>
      {/if}
      {if in_array('News',$oLoginAdmin->getPrivilegesArray())}
      <li {if $oMod->getModule() == 'News' && $smarty.get.mode == 'service'}class="active"{/if}><a href="{$oMod->getBasePage('News', 'mode=service')}">Services</a></li>
      {/if}
	    {if in_array('Event',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Event'}class="active"{/if}><a href="{$oMod->getBasePage('Event')}">{loc k=event}</a></li>
	    {/if}
	    {if in_array('Seo',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Seo'}class="active"{/if}><a href="{$oMod->getBasePage('Seo')}">SEO</a></li>
	    {/if}
	</ul>
  </li>
  {/if}
  
  {if $oLoginAdmin->isAuthorized(array('Banner'))}
  <li class="dropdown {if in_array($oMod->getModule(),array('Banner','Gallery'))}active{/if}">
  	<a class="dropdown-toggle" data-toggle="dropdown" href="{$oMod->getBasePage($oLoginAdmin->isAuthorized(array('Banner','Gallery')))}">
  		<i class="icon-picture"></i> Picture <b class="caret"></b>
	</a>
	<ul class="dropdown-menu">
	    {*if in_array('Banner',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Banner' && !$smarty.get.mode}class="active"{/if}><a href="{$oMod->getBasePage('Banner')}">Sliding Banner</a></li>
	    {/if*}
	    {if in_array('Banner',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Banner' && ( $smarty.get.mode == 'sliding' || !$smarty.get.mode )}class="active"{/if}><a href="{$oMod->getBasePage('Banner','mode=sliding')}">Home Banner</a></li>
	    {/if}
	    {*if in_array('Gallery',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Gallery'}class="active"{/if}><a href="{$oMod->getBasePage('Gallery')}">Gallery</a></li>
	    {/if*}
	    {*if in_array('Banner',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Banner' && $smarty.get.mode == 'left'}class="active"{/if}><a href="{$oMod->getBasePage('Banner','mode=left')}">Left Banner</a></li>
	    {/if}
	    {if in_array('Banner',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Banner' && $smarty.get.mode == 'right'}class="active"{/if}><a href="{$oMod->getBasePage('Banner','mode=right')}">Right Banner</a></li>
	    {/if*}
	</ul>
  </li>
  {/if}
  
  {if $oLoginAdmin->isAuthorized(array('Product','Category','Featured','Promo'))}
  <li class="dropdown {if in_array($oMod->getModule(),array('Product','Category','Featured','Promo'))}active{/if}">
  	<a class="dropdown-toggle" data-toggle="dropdown" href="{$oMod->getBasePage($oLoginAdmin->isAuthorized(array('Product','Category','Featured','Promo')))}">
  		<i class="icon-gift"></i> {loc k=product} <b class="caret"></b>
	</a>
	<ul class="dropdown-menu">
	    {if in_array('Category',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Category'}class="active"{/if}><a href="{$oMod->getBasePage('Category')}">{loc k=product_category}</a></li>
	    {/if}
	    {if in_array('Product',$oLoginAdmin->getPrivilegesArray())}
	    <li {if ($oMod->getModule() == 'Product' && !$smarty.get.mode) || $oMod->getModule() == 'ProductTab' || $oMod->getModule() == 'ProductStock' || $oMod->getModule() == 'ProductTab'}class="active"{/if}><a href="{$oMod->getBasePage('Product')}">{loc k=product}</a></li>
	    {/if}
	    {if in_array('ProductUser',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'ProductUser'}class="active"{/if}><a href="{$oMod->getBasePage('ProductUser')}">Assign Property</a></li>
	    {/if}
	    {*
	    {if in_array('Featured',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Featured' && $smarty.get.mode == 'featured'}class="active"{/if}><a href="{$oMod->getBasePage('Featured')}?mode=featured">Featured Products</a></li>
	    {/if}
	    *}
	    {if in_array('Promo',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Promo'}class="active"{/if}><a href="{$oMod->getBasePage('Promo')}">{loc k=promo}</a></li>
	    {/if}
	</ul>
  </li>
  {/if}
  
  {if $oLoginAdmin->isAuthorized(array('Configuration'))}
  <li class="dropdown {if in_array($oMod->getModule(),array('Configuration'))}active{/if}">
  	<a class="dropdown-toggle" data-toggle="dropdown" href="{$oMod->getBasePage($oLoginAdmin->isAuthorized(array('Configuration')))}">
  		<i class="icon-wrench"></i> Configuration <b class="caret"></b>
	</a>
	<ul class="dropdown-menu">
	    {if in_array('Configuration',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Configuration' && !$smarty.get.mode}class="active"{/if}><a href="{$oMod->getBasePage('Configuration')}">Website Data</a></li>
	    {/if}
	    {if in_array('Configuration',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Configuration' && $smarty.get.mode == 'email'}class="active"{/if}><a href="{$oMod->getBasePage('Configuration')}?mode=email">Email Configuration</a></li>
	    {/if}
	    {if in_array('Configuration',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Configuration' && $smarty.get.mode == 'banner'}class="active"{/if}><a href="{$oMod->getBasePage('Configuration','mode=banner')}">Banner Image</a></li>
	    {/if}
	    {if in_array('Configuration',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Configuration' && $smarty.get.mode == 'social'}class="active"{/if}><a href="{$oMod->getBasePage('Configuration','mode=social')}">Social Media Link</a></li>
	    {/if}
	    {if in_array('Configuration',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Configuration' && $smarty.get.mode == 'script'}class="active"{/if}><a href="{$oMod->getBasePage('Configuration','mode=script')}">Custom Script</a></li>
	    {/if}
	</ul>
  </li>
  {/if}
</ul>