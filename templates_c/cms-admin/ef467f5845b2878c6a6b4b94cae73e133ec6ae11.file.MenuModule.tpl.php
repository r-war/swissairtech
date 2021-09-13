<?php /* Smarty version Smarty-3.1.8, created on 2021-09-13 15:02:22
         compiled from "templates/cms-admin\ajax\MenuModule.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20069613f058e12fb48-52836213%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ef467f5845b2878c6a6b4b94cae73e133ec6ae11' => 
    array (
      0 => 'templates/cms-admin\\ajax\\MenuModule.tpl',
      1 => 1527250292,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20069613f058e12fb48-52836213',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'sAjax' => 0,
    'aData' => 0,
    'aProduct' => 0,
    'oMod' => 0,
    'oMenu' => 0,
    'aCategory' => 0,
    'oCategory' => 0,
    'aPromo' => 0,
    'oPromo' => 0,
    'sUri' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_613f058e8209e8_77258440',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_613f058e8209e8_77258440')) {function content_613f058e8209e8_77258440($_smarty_tpl) {?><?php if (!is_callable('smarty_function_loc')) include 'D:\\laragon\\www\\swissairtech\\classes\\smarty\\plugins\\function.loc.php';
if (!is_callable('smarty_function_fckeditor')) include 'D:\\laragon\\www\\swissairtech\\classes\\smarty\\plugins\\function.fckeditor.php';
if (!is_callable('smarty_function_val')) include 'D:\\laragon\\www\\swissairtech\\classes\\smarty\\plugins\\function.val.php';
?><?php if ($_smarty_tpl->tpl_vars['sAjax']->value=='product'){?>
	<?php  $_smarty_tpl->tpl_vars['aProduct'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['aProduct']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['aData']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['aProduct']->key => $_smarty_tpl->tpl_vars['aProduct']->value){
$_smarty_tpl->tpl_vars['aProduct']->_loop = true;
?>
	<?php echo json_encode($_smarty_tpl->tpl_vars['aProduct']->value);?>
|<?php echo $_smarty_tpl->tpl_vars['aProduct']->value['name'];?>

	<?php } ?>
<?php }elseif($_smarty_tpl->tpl_vars['sAjax']->value=='form'){?>
	<form id="form" action="<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getPage($_smarty_tpl->tpl_vars['oMod']->value->getModule(),('select=').($_smarty_tpl->tpl_vars['oMenu']->value->getPrimaryKey()));?>
" method="POST">
	<div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel"><?php echo smarty_function_loc(array('k'=>'form'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['oMod']->value->getName();?>
</h3>
	</div>
	<div class="modal-body">
	<?php echo $_smarty_tpl->getSubTemplate ("core/feedback.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('source'=>$_smarty_tpl->tpl_vars['oMod']->value->getModule()), 0);?>

		<div class="form-unit form-horizontal">
		   <div class="control-group">
		     <label class="control-label"><?php echo smarty_function_loc(array('k'=>'index'),$_smarty_tpl);?>

		     	<a href="#" data-toggle="tooltip" title="" data-original-title="<?php echo smarty_function_loc(array('k'=>'index_desc'),$_smarty_tpl);?>
" class="help"><i class="icon-question-sign"></i></a>
	     	</label>
		     <div class="controls">
		       <input type="text" name="oMenu-index" value="<?php echo $_smarty_tpl->tpl_vars['oMenu']->value->getIndex();?>
" />
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label"><?php echo smarty_function_loc(array('k'=>'name'),$_smarty_tpl);?>
</label>
		     <div class="controls">
		       <input type="text" name="oMenu-name" value="<?php echo $_smarty_tpl->tpl_vars['oMenu']->value->getName();?>
" id="menuName"/>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label"><?php echo smarty_function_loc(array('k'=>'type'),$_smarty_tpl);?>
</label>
		     <div class="controls">
		       <select name="oMenu-type" onchange="showMenuType(); return false;" id="menuType">
		       	<option value="1" <?php if ($_smarty_tpl->tpl_vars['oMenu']->value->getType()==1){?>selected="selected"<?php }?>>Link to Url</option>
		       	<option value="2" <?php if ($_smarty_tpl->tpl_vars['oMenu']->value->getType()==2){?>selected="selected"<?php }?>>Link to Page</option>
		       	<option value="3" <?php if ($_smarty_tpl->tpl_vars['oMenu']->value->getType()==3){?>selected="selected"<?php }?>>Link to Module</option>
		       </select>
		     </div>
		   </div>
		   <div class="control-group" id="typeUrl">
		     <label class="control-label"><?php echo smarty_function_loc(array('k'=>'url'),$_smarty_tpl);?>
</label>
		     <div class="controls">
		       <input type="text" class="span12" name="oMenu-value" value="<?php echo $_smarty_tpl->tpl_vars['oMenu']->value->getValue();?>
" />
		     </div>
		   </div>
		   <div id="typePage">
			   <div class="control-group">
			     <label class="control-label"></label>
			     <div class="controls">
			       <select onchange="showPageType(); return false;" id="pageType" name="pageType">
			       	<option value="1" <?php if ($_POST['pageType']==1){?>selected="selected"<?php }?>>Existing Page</option>
			       	<option value="2" <?php if ($_POST['pageType']==2){?>selected="selected"<?php }?>>New Page</option>
			       </select>
			     </div>
			   </div>
			   <div class="control-group" id="existingPage">
			     <label class="control-label">Search Page</label>
			     <div class="controls">
			       <input type="text" class="span12" id="name" name="name" value="<?php echo $_smarty_tpl->tpl_vars['oMenu']->value->getPageName();?>
" />
			       <input type="hidden" id="productid" name="productid" value="<?php echo $_smarty_tpl->tpl_vars['oMenu']->value->getValue();?>
" />
			     </div>
			   </div>
			   <div id="newPage">
				<div class="control-group">
			     	<label class="control-label"><?php echo smarty_function_loc(array('k'=>'name'),$_smarty_tpl);?>
</label>
				     <div class="controls">
				       <input type="text" name="pageName" id="pageName" value="<?php echo $_POST['pageName'];?>
" class="span12"/>
				     </div>
				   </div>
				   <div class="control-group">
				     <label class="control-label"><?php echo smarty_function_loc(array('k'=>'description'),$_smarty_tpl);?>
</label>
				     <div class="controls">
				     	<input type="hidden" id="fixPageDescription" value="1"/>
				       <?php echo smarty_function_fckeditor(array('name'=>'pageDescription','value'=>$_POST['pageDescription']),$_smarty_tpl);?>

				     </div>
				   </div>
		   	   </div>
		   </div>
		   <div class="control-group" id="typeModule">
		     <label class="control-label">Module Name</label>
		     <div class="controls">
				<select name="moduleName">
			       	<option value="Default" <?php if ($_smarty_tpl->tpl_vars['oMenu']->value->getValue()=='Default'){?>selected="selected"<?php }?>>Home</option>
			       	<option value="ContactUs" <?php if ($_smarty_tpl->tpl_vars['oMenu']->value->getValue()=='ContactUs'){?>selected="selected"<?php }?>>Contact Us</option>
			       	<option value="Articles" <?php if ($_smarty_tpl->tpl_vars['oMenu']->value->getValue()=='Articles'){?>selected="selected"<?php }?>>Articles</option>
              <option value="News" <?php if ($_smarty_tpl->tpl_vars['oMenu']->value->getValue()=='News'){?>selected="selected"<?php }?>>News</option>
              <option value="Gallery" <?php if ($_smarty_tpl->tpl_vars['oMenu']->value->getValue()=='Gallery'){?>selected="selected"<?php }?>>Gallery</option>
              <option value="Testimonial" <?php if ($_smarty_tpl->tpl_vars['oMenu']->value->getValue()=='Testimonial'){?>selected="selected"<?php }?>>Testimonials</option>
              
              
			       	
		        </select>
		     </div>
		   </div>
		   <div class="control-group" id="typeCategory">
		     <label class="control-label">Category Name</label>
		     <div class="controls">
				<select name="categoryId">
					<option value="0" <?php if ($_smarty_tpl->tpl_vars['oMenu']->value->getValue()==0){?>selected="selected"<?php }?>>ALL</option>
			       	<?php  $_smarty_tpl->tpl_vars['oCategory'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['oCategory']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['aCategory']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['oCategory']->key => $_smarty_tpl->tpl_vars['oCategory']->value){
$_smarty_tpl->tpl_vars['oCategory']->_loop = true;
?>
			       	<option value="<?php echo $_smarty_tpl->tpl_vars['oCategory']->value->getId();?>
" <?php if ($_smarty_tpl->tpl_vars['oMenu']->value->getValue()==$_smarty_tpl->tpl_vars['oCategory']->value->getId()){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['oCategory']->value->getName();?>
</option>
			       	<?php } ?>
		        </select>
		     </div>
		   </div>
		   <div class="control-group" id="typePromo">
		     <label class="control-label">Promo Name</label>
		     <div class="controls">
				<select name="promoId">
					<option value="0" <?php if ($_smarty_tpl->tpl_vars['oMenu']->value->getValue()==0){?>selected="selected"<?php }?>>ALL</option>
			       	<?php  $_smarty_tpl->tpl_vars['oPromo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['oPromo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['aPromo']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['oPromo']->key => $_smarty_tpl->tpl_vars['oPromo']->value){
$_smarty_tpl->tpl_vars['oPromo']->_loop = true;
?>
			       	<option value="<?php echo $_smarty_tpl->tpl_vars['oPromo']->value->getId();?>
" <?php if ($_smarty_tpl->tpl_vars['oMenu']->value->getValue()==$_smarty_tpl->tpl_vars['oPromo']->value->getId()){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['oPromo']->value->getName();?>
</option>
			       	<?php } ?>
		        </select>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label"></label>
		     <div class="controls">
		       <label class="checkbox">
					<input type="checkbox" name="oMenu-new_tab" value="true" <?php if ($_smarty_tpl->tpl_vars['oMenu']->value->getNewTab()){?>checked="checked"<?php }?>> <?php echo smarty_function_loc(array('k'=>'open_in_new_tab'),$_smarty_tpl);?>

				</label>
		     </div>
		   </div>
		   <div class="clearfix"></div>
		</div>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="save" value="1"/>
		<input type="submit" value="<?php echo smarty_function_loc(array('k'=>'save'),$_smarty_tpl);?>
" class="btn btn-primary"/>
		<?php if (!$_smarty_tpl->tpl_vars['oMenu']->value->isNew()){?><input name="delete" type="button" value="<?php echo smarty_function_loc(array('k'=>'delete'),$_smarty_tpl);?>
" class="btn btn-danger" onclick="doDelete('<?php echo $_smarty_tpl->tpl_vars['oMenu']->value->getPrimaryKey();?>
','<?php echo smarty_function_val(array('v'=>$_smarty_tpl->tpl_vars['oMenu']->value->getName(),'parsequote'=>true),$_smarty_tpl);?>
')"/><?php }?>
		<a href="<?php echo $_smarty_tpl->tpl_vars['sUri']->value;?>
" class="btn">Close</a>
	</div>
	</form>
	<script type="text/javascript">showMenuType();showPageType();updateProduct('<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getCurrentPage();?>
');</script>
<?php }?><?php }} ?>