{if $sAjax == 'product'}
	{foreach from=$aData item='aProduct'}
	{$aProduct|@json_encode}|{$aProduct.name}
	{/foreach}
{else if $sAjax == 'form'}
	<form id="form" action="{$oMod->getPage($oMod->getModule(),'select='|@cat:$oMenu->getPrimaryKey())}" method="POST">
	<div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">{loc k=form} {$oMod->getName()}</h3>
	</div>
	<div class="modal-body">
	{include file="core/feedback.tpl" source=$oMod->getModule()}
		<div class="form-unit form-horizontal">
		   <div class="control-group">
		     <label class="control-label">{loc k=index}
		     	<a href="#" data-toggle="tooltip" title="" data-original-title="{loc k=index_desc}" class="help"><i class="icon-question-sign"></i></a>
	     	</label>
		     <div class="controls">
		       <input type="text" name="oMenu-index" value="{$oMenu->getIndex()}" />
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=name}</label>
		     <div class="controls">
		       <input type="text" name="oMenu-name" value="{$oMenu->getName()}" id="menuName"/>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=type}</label>
		     <div class="controls">
		       <select name="oMenu-type" onchange="showMenuType(); return false;" id="menuType">
		       	<option value="1" {if $oMenu->getType() == 1}selected="selected"{/if}>Link to Url</option>
		       	<option value="2" {if $oMenu->getType() == 2}selected="selected"{/if}>Link to Page</option>
		       	<option value="3" {if $oMenu->getType() == 3}selected="selected"{/if}>Link to Module</option>
		       </select>
		     </div>
		   </div>
		   <div class="control-group" id="typeUrl">
		     <label class="control-label">{loc k=url}</label>
		     <div class="controls">
		       <input type="text" class="span12" name="oMenu-value" value="{$oMenu->getValue()}" />
		     </div>
		   </div>
		   <div id="typePage">
			   <div class="control-group">
			     <label class="control-label"></label>
			     <div class="controls">
			       <select onchange="showPageType(); return false;" id="pageType" name="pageType">
			       	<option value="1" {if $smarty.post.pageType == 1}selected="selected"{/if}>Existing Page</option>
			       	<option value="2" {if $smarty.post.pageType == 2}selected="selected"{/if}>New Page</option>
			       </select>
			     </div>
			   </div>
			   <div class="control-group" id="existingPage">
			     <label class="control-label">Search Page</label>
			     <div class="controls">
			       <input type="text" class="span12" id="name" name="name" value="{$oMenu->getPageName()}" />
			       <input type="hidden" id="productid" name="productid" value="{$oMenu->getValue()}" />
			     </div>
			   </div>
			   <div id="newPage">
				<div class="control-group">
			     	<label class="control-label">{loc k=name}</label>
				     <div class="controls">
				       <input type="text" name="pageName" id="pageName" value="{$smarty.post.pageName}" class="span12"/>
				     </div>
				   </div>
				   <div class="control-group">
				     <label class="control-label">{loc k=description}</label>
				     <div class="controls">
				     	<input type="hidden" id="fixPageDescription" value="1"/>
				       {fckeditor
							name=pageDescription
							value=$smarty.post.pageDescription
						}
				     </div>
				   </div>
		   	   </div>
		   </div>
		   <div class="control-group" id="typeModule">
		     <label class="control-label">Module Name</label>
		     <div class="controls">
				<select name="moduleName">
			       	<option value="Default" {if $oMenu->getValue() == 'Default'}selected="selected"{/if}>Home</option>
			       	<option value="ContactUs" {if $oMenu->getValue() == 'ContactUs'}selected="selected"{/if}>Contact Us</option>
			       	<option value="Articles" {if $oMenu->getValue() == 'Articles'}selected="selected"{/if}>Articles</option>
              <option value="News" {if $oMenu->getValue() == 'News'}selected="selected"{/if}>News</option>
              <option value="Gallery" {if $oMenu->getValue() == 'Gallery'}selected="selected"{/if}>Gallery</option>
              <option value="Testimonial" {if $oMenu->getValue() == 'Testimonial'}selected="selected"{/if}>Testimonials</option>
              {*<option value="Service" {if $oMenu->getValue() == 'Service'}selected="selected"{/if}>Service</option>*}
              {*<option value="Event" {if $oMenu->getValue() == 'Event'}selected="selected"{/if}>Event</option>*}
			       	{*
			       	<option value="Category" {if $oMenu->getValue() == 'Category'}selected="selected"{/if}>Products</option>
			       	<option value="MyProfile" {if $oMenu->getValue() == 'MyProfile'}selected="selected"{/if}>My Account</option>
			       	<option value="ShoppingCart" {if $oMenu->getValue() == 'ShoppingCart'}selected="selected"{/if}>Shopping Cart</option>
			       	<option value="Register" {if $oMenu->getValue() == 'Register'}selected="selected"{/if}>Login/Register</option>
			       	<option value="Logout" {if $oMenu->getValue() == 'Logout'}selected="selected"{/if}>Logout</option>
			       	*}
		        </select>
		     </div>
		   </div>
		   <div class="control-group" id="typeCategory">
		     <label class="control-label">Category Name</label>
		     <div class="controls">
				<select name="categoryId">
					<option value="0" {if $oMenu->getValue() == 0}selected="selected"{/if}>ALL</option>
			       	{foreach from=$aCategory item=oCategory}
			       	<option value="{$oCategory->getId()}" {if $oMenu->getValue() == $oCategory->getId()}selected="selected"{/if}>{$oCategory->getName()}</option>
			       	{/foreach}
		        </select>
		     </div>
		   </div>
		   <div class="control-group" id="typePromo">
		     <label class="control-label">Promo Name</label>
		     <div class="controls">
				<select name="promoId">
					<option value="0" {if $oMenu->getValue() == 0}selected="selected"{/if}>ALL</option>
			       	{foreach from=$aPromo item=oPromo}
			       	<option value="{$oPromo->getId()}" {if $oMenu->getValue() == $oPromo->getId()}selected="selected"{/if}>{$oPromo->getName()}</option>
			       	{/foreach}
		        </select>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label"></label>
		     <div class="controls">
		       <label class="checkbox">
					<input type="checkbox" name="oMenu-new_tab" value="true" {if $oMenu->getNewTab()}checked="checked"{/if}> {loc k=open_in_new_tab}
				</label>
		     </div>
		   </div>
		   <div class="clearfix"></div>
		</div>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="save" value="1"/>
		<input type="submit" value="{loc k=save}" class="btn btn-primary"/>
		{if !$oMenu->isNew()}<input name="delete" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oMenu->getPrimaryKey()}','{val v=$oMenu->getName() parsequote=true}')"/>{/if}
		<a href="{$sUri}" class="btn">Close</a>
	</div>
	</form>
	<script type="text/javascript">showMenuType();showPageType();updateProduct('{$oMod->getCurrentPage()}');</script>
{/if}