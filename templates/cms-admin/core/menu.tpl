<ul class="nav nav-tabs">
	{if in_array($oMod->getModule(),array('Admin','AdminType','User','Subscriber','Testimonial'))}
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
	{elseif in_array($oMod->getModule(),array('Configuration'))}
	    {if in_array('Configuration',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Configuration' && !$smarty.get.mode}class="active"{/if}><a href="{$oMod->getBasePage('Configuration')}">Website Data</a></li>
	    {/if}
	    {if in_array('Configuration',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Configuration' && $smarty.get.mode == 'email'}class="active"{/if}><a href="{$oMod->getBasePage('Configuration')}?mode=email">Email Configuration</a></li>
	    {/if}
	    {if in_array('Configuration',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Configuration' && $smarty.get.mode == 'currency'}class="active"{/if}><a href="{$oMod->getBasePage('Configuration')}?mode=currency">Currency Configuration</a></li>
	    {/if}
	    {if in_array('Configuration',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Configuration' && $smarty.get.mode == 'social'}class="active"{/if}><a href="{$oMod->getBasePage('Configuration','mode=social')}">Social Media Link</a></li>
	    {/if}
	    {if in_array('Configuration',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Configuration' && $smarty.get.mode == 'payment'}class="active"{/if}><a href="{$oMod->getBasePage('Configuration')}?mode=payment">Payment Configuration</a></li>
	    {/if}
	    {if in_array('Configuration',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Configuration' && $smarty.get.mode == 'script'}class="active"{/if}><a href="{$oMod->getBasePage('Configuration','mode=script')}">Custom Script</a></li>
	    {/if}
	{elseif in_array($oMod->getModule(),array('Banner','Gallery'))}
	    {*if in_array('Banner',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Banner' && !$smarty.get.mode}class="active single"{else}class="single"{/if}><a href="{$oMod->getBasePage('Banner')}">Sliding Banner</a></li>
	    {/if*}
	    {if in_array('Banner',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Banner' && ( $smarty.get.mode == 'consultants' || !$smarty.get.mode )}class="active single"{else}class="single"{/if}><a href="{$oMod->getBasePage('Banner','mode=consultants')}">Consultants Banner</a></li>
	    {/if}
	    {if in_array('Banner',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Banner' && $smarty.get.mode == 'school'}class="active single"{else}class="single"{/if}><a href="{$oMod->getBasePage('Banner','mode=school')}">School Banner</a></li>
	    {/if}
	    {if in_array('Banner',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Banner' && $smarty.get.mode == 'centre'}class="active single"{else}class="single"{/if}><a href="{$oMod->getBasePage('Banner','mode=centre')}">Centre Banner</a></li>
	    {/if}
	{elseif in_array($oMod->getModule(),array('Content','Page','Menu','News','Event'))}
	    {if in_array('Content',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Content'}class="active"{/if}><a href="{$oMod->getBasePage('Content')}">{loc k=content}</a></li>
	    {/if}
	    {if in_array('Page',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Page'}class="active"{/if}><a href="{$oMod->getBasePage('Page')}">{loc k=page}</a></li>
	    {/if}
	    {if in_array('Menu',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Menu' && $smarty.get.mode == 'consultants'}class="active"{/if}><a href="{$oMod->getBasePage('Menu','mode=consultants')}">Consultants Menu</a></li>
	    {/if}
	    {if in_array('Menu',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Menu' && $smarty.get.mode == 'main'}class="school"{/if}><a href="{$oMod->getBasePage('Menu','mode=school')}">School Menu</a></li>
	    {/if}
	    {if in_array('Menu',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Menu' && $smarty.get.mode == 'main'}class="centre"{/if}><a href="{$oMod->getBasePage('Menu','mode=centre')}">Centre Menu</a></li>
	    {/if}
	    {if in_array('Event',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Event'}class="active"{/if}><a href="{$oMod->getBasePage('Event')}">{loc k=event}</a></li>
	    {/if}
	    {if in_array('News',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'News'}class="active"{/if}><a href="{$oMod->getBasePage('News')}">{loc k=news}</a></li>
	    {/if}
	{elseif in_array($oMod->getModule(),array('Product','Category','ProductPicture','ProductStock','ProductTab','Promo','Featured','ProductPrice'))}
	    {if in_array('Category',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Category'}class="active"{/if}><a href="{$oMod->getBasePage('Category')}">{loc k=product_category}</a></li>
	    {/if}
	    {if in_array('Product',$oLoginAdmin->getPrivilegesArray())}
	    <li {if ($oMod->getModule() == 'Product' && !$smarty.get.mode) || $oMod->getModule() == 'ProductTab' || $oMod->getModule() == 'ProductStock' || $oMod->getModule() == 'ProductTab'}class="active"{/if}><a href="{$oMod->getBasePage('Product')}">{loc k=product}</a></li>
	    {/if}
	    {*
	    {if in_array('Featured',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Featured' && $smarty.get.mode == 'featured'}class="active"{/if}><a href="{$oMod->getBasePage('Featured')}?mode=featured">Featured Products</a></li>
	    {/if}
	    {if in_array('Featured',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Featured' && $smarty.get.mode == 'hot'}class="active"{/if}><a href="{$oMod->getBasePage('Featured')}?mode=hot">Hot Products</a></li>
	    {/if}
	    {if in_array('Promo',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Promo'}class="active"{/if}><a href="{$oMod->getBasePage('Promo')}">{loc k=promo}</a></li>
	    {/if}
	    *}
	{elseif in_array($oMod->getModule(),array('Order','Poa'))}
	    {if in_array('Order',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Order' && $smarty.get.mode == 'all'}class="active"{/if}><a href="{$oMod->getBasePage('Order')}?mode=all">{loc k=all_order}</a></li>
	    {/if}
	    {if in_array('Order',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Poa'}class="active"{/if}><a href="{$oMod->getBasePage('Poa')}">International Order</a></li>
	    {/if}
	    {if in_array('Order',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Order' && ($smarty.get.mode == '1' || $smarty.get.mode == null)}class="active"{/if}><a href="{$oMod->getBasePage('Order')}?mode=1">{loc k=pending} Payment</a></li>
	    {/if}
	    {if in_array('Order',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Order' && $smarty.get.mode == '2'}class="active"{/if}><a href="{$oMod->getBasePage('Order')}?mode=2">{loc k=paid}</a></li>
	    {/if}
	    {if in_array('Order',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Order' && $smarty.get.mode == '3'}class="active"{/if}><a href="{$oMod->getBasePage('Order')}?mode=3">{loc k=processed}</a></li>
	    {/if}
	    {if in_array('Order',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Order' && $smarty.get.mode == '4'}class="active"{/if}><a href="{$oMod->getBasePage('Order')}?mode=4">{loc k=delivered}</a></li>
	    {/if}
	    {if in_array('Order',$oLoginAdmin->getPrivilegesArray())}
	    <li {if $oMod->getModule() == 'Order' && $smarty.get.mode == '9'}class="active"{/if}><a href="{$oMod->getBasePage('Order')}?mode=9">{loc k=canceled}</a></li>
	    {/if}
	{/if}
</ul>
