<?php /* Smarty version Smarty-3.1.8, created on 2021-09-14 17:25:06
         compiled from "templates/www/default\ProductModule.tpl" */ ?>
<?php /*%%SmartyHeaderCode:251106140778349d762-88984580%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '441a6795f5d2082ef830c962caf7e6f94b46e052' => 
    array (
      0 => 'templates/www/default\\ProductModule.tpl',
      1 => 1631615007,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '251106140778349d762-88984580',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_6140778388fb50_32905107',
  'variables' => 
  array (
    'aConfig' => 0,
    'products' => 0,
    'product' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6140778388fb50_32905107')) {function content_6140778388fb50_32905107($_smarty_tpl) {?><div class="background-img text-center text-uppercase">
    <img src="./contents/images/<?php echo $_smarty_tpl->tpl_vars['aConfig']->value['product'];?>
" class="img-responsive" alt="">
    <div class="overlay"></div>
    <h2 class="background-text">Products</h2>
</div>

<div class="limo-list dark-bg padding-top100">
    <div class="container">
        <?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
$_smarty_tpl->tpl_vars['product']->_loop = true;
?>
        <div class="col-md-4 wow fadeInUp animated" data-wow-duration=".8s" data-wow-delay="0.3s">
            <div class="colmd4">
                <div class="list-single-item">
                    <div class="list-img"><img src="<?php echo $_smarty_tpl->tpl_vars['product']->value->getPictureUrl();?>
" class="img-responsive" alt="List Image"></div>
                    <div class="car-info">
                        <div class="name-price">
                            <span class="name"><?php echo $_smarty_tpl->tpl_vars['product']->value->getName();?>
</span>
                            <!-- <span class="price">$1350 <sub>/Hour</sub> </span> -->
                        </div>
                        <div class="feature-lsit">
                            <?php echo $_smarty_tpl->tpl_vars['product']->value->getDescription();?>

                        </div>
                    </div><!-- /.car-info -->
                </div><!-- /.list-single-item -->
            </div>
        </div><!-- /.col-md-4 -->
        <?php } ?>
    </div>
</div><?php }} ?>