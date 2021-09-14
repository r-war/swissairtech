<?php /* Smarty version Smarty-3.1.8, created on 2021-09-14 17:27:36
         compiled from "templates/www/default\PageModule.tpl" */ ?>
<?php /*%%SmartyHeaderCode:879261407918915893-65570585%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7f289fb8fb10344531ebef33f8b6d19a1e680bbc' => 
    array (
      0 => 'templates/www/default\\PageModule.tpl',
      1 => 1535074404,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '879261407918915893-65570585',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'aConfig' => 0,
    'page' => 0,
    'page_tabs' => 0,
    'tab' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_61407918c2c758_69168620',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61407918c2c758_69168620')) {function content_61407918c2c758_69168620($_smarty_tpl) {?>
<div class="heading-page heading-page-1 bg-cover" style="background: url('/contents/images/<?php echo $_smarty_tpl->tpl_vars['aConfig']->value['page'];?>
') center center no-repeat;">
  <div class="container">
    <h3 class="title"><?php echo $_smarty_tpl->tpl_vars['page']->value->getName();?>
</h3>
  </div>
</div>
<div class="page-content p-b-50">
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <?php if ($_smarty_tpl->tpl_vars['page']->value->haveSub()){?>
        <section class="section post-section-1 m-b-30 p-r-15">
          <p>&nbsp;</p>
          <?php  $_smarty_tpl->tpl_vars['tab'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tab']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['page_tabs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['tab']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['tab']->key => $_smarty_tpl->tpl_vars['tab']->value){
$_smarty_tpl->tpl_vars['tab']->_loop = true;
 $_smarty_tpl->tpl_vars['tab']->index++;
?>
          <div class="accordion-description <?php if ($_smarty_tpl->tpl_vars['tab']->index==0){?>active<?php }else{ ?>hide<?php }?>"  id="<?php echo $_smarty_tpl->tpl_vars['tab']->value->getId();?>
">
            <?php echo $_smarty_tpl->tpl_vars['tab']->value->getDescription();?>

          </div>
          <?php } ?>
        </section>
      </div>
      <div class="col-md-3">
        <p>&nbsp;</p>
        <h4 class="text-bold text-bold text-black text-med m-t-0 m-b-30">Who We Are</h4>
        <ul class="post-tabs post-tabs-1 m-b-40">
          <?php  $_smarty_tpl->tpl_vars['tab'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tab']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['page_tabs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['tab']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['tab']->key => $_smarty_tpl->tpl_vars['tab']->value){
$_smarty_tpl->tpl_vars['tab']->_loop = true;
 $_smarty_tpl->tpl_vars['tab']->index++;
?>
            <li >
                <a href="#<?php echo $_smarty_tpl->tpl_vars['tab']->value->getId();?>
"><?php echo $_smarty_tpl->tpl_vars['tab']->value->getName();?>
</a>
            </li>
            <?php } ?>
        </ul>
      </div>
      <?php }else{ ?>
      <div class="col-md-9">
        <section class="section post-section-1 m-b-30 p-r-15">
          <p>&nbsp;</p>
          <div class="accordion-description" >
            <?php echo $_smarty_tpl->tpl_vars['page']->value->getDescription();?>

          </div>
        </section>
      </div>
      <div class="col-md-3">
        
      </div>
      <?php }?>
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
<?php }} ?>