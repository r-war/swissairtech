<?php /* Smarty version Smarty-3.1.8, created on 2021-09-16 17:22:27
         compiled from "templates/www/default\NewsModule.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1227861431ae399c5d5-81655606%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a3c91be6c2aea1314c4e4d861fe619633ae6560f' => 
    array (
      0 => 'templates/www/default\\NewsModule.tpl',
      1 => 1535073568,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1227861431ae399c5d5-81655606',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'news' => 0,
    'aConfig' => 0,
    'latest_news' => 0,
    'data' => 0,
    'news_list' => 0,
    'oMod' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_61431ae41e69b1_29282473',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61431ae41e69b1_29282473')) {function content_61431ae41e69b1_29282473($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include 'D:\\laragon\\www\\swissairtech\\classes\\smarty\\plugins\\modifier.truncate.php';
?>        <!--# content #-->

          <?php if ($_smarty_tpl->tpl_vars['news']->value){?>
          <div class="heading-page heading-page-1 bg-cover" style="background: url('/contents/images/<?php echo $_smarty_tpl->tpl_vars['aConfig']->value['news'];?>
') center center no-repeat;">
            <div class="container">
              
            </div>
          </div>
          <div class="page-content p-b-70">
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <section class="section post-section-2 p-r-40">
                            <div class="post-header">
                                <h3 class="text-block text-black text-bold text-med-large m-b-25"><?php echo $_smarty_tpl->tpl_vars['news']->value->getName();?>
</h3>
                                <div class="post-info m-b-30">
                                    <p class="text-block"><?php echo $_smarty_tpl->tpl_vars['news']->value->getDate('F d, Y');?>

                                    </p>
                                </div>
                            </div>
                            <div class="post-content">
                              <img src="<?php echo $_smarty_tpl->tpl_vars['news']->value->getPictureUrl();?>
" class="img-responsive">
                              <br>
                              <?php echo $_smarty_tpl->tpl_vars['news']->value->getDescription();?>

                            </div>
                        </section>
                    </div>
                    <br>
                    <div class="col-md-3">
                        <h4 class="text-block text-bold text-med m-b-40">Latest News</h4>
                        <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['latest_news']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value){
$_smarty_tpl->tpl_vars['data']->_loop = true;
?>
                        <div class="image-card image-card-9">
                          <div class="image">
                            <a href="blog-single.html">
                                <img src="<?php echo $_smarty_tpl->tpl_vars['data']->value->getThumbnailURL(50,30);?>
" alt="<?php echo $_smarty_tpl->tpl_vars['data']->value->getName();?>
" />
                            </a>
                          </div>
                          <div class="content">
                            <h3 class="title">
                                <a href="blog-single.html"><?php echo $_smarty_tpl->tpl_vars['data']->value->getName();?>
</a>
                            </h3>
                            <span class="subtitle"><?php echo $_smarty_tpl->tpl_vars['data']->value->getDate('F d, Y');?>
</span>
                          </div>
                        </div>
                        <?php } ?>
                  </div>
                </div>
            </div>
          </div>
          <?php }else{ ?>
          <br>
          <div class="section p-t-0 p-b-70 bg-white">
            <div class="container">
              <div class="row">
              <?php if (count($_smarty_tpl->tpl_vars['news_list']->value)>0){?>
              <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['news_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value){
$_smarty_tpl->tpl_vars['data']->_loop = true;
?>
                <div class="col-md-4">
                    <div class="image-card image-card-4">
                        <div class="image">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getBasePage('News',$_smarty_tpl->tpl_vars['data']->value->getUrl());?>
">
                                <img src="<?php echo $_smarty_tpl->tpl_vars['data']->value->getThumbnailURL(500,300);?>
" alt="<?php echo $_smarty_tpl->tpl_vars['data']->value->getName();?>
" />
                            </a>
                        </div>
                        <div class="date">
                            <span><?php echo $_smarty_tpl->tpl_vars['data']->value->getDate('F d, Y');?>
</span>
                        </div>
                        <h3 class="title">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getBasePage('News',$_smarty_tpl->tpl_vars['data']->value->getUrl());?>
"><?php echo $_smarty_tpl->tpl_vars['data']->value->getName();?>
</a>
                        </h3>
                        <div class="content">
                          <?php if ($_smarty_tpl->tpl_vars['data']->value->getShortDescription()!=''){?>
                            <?php echo $_smarty_tpl->tpl_vars['data']->value->getShortDescription();?>

                          <?php }else{ ?>
                            <?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['data']->value->getDescription(),300);?>

                          <?php }?>
                        </div>
                        <div class="link">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['oMod']->value->getBasePage('News',$_smarty_tpl->tpl_vars['data']->value->getUrl());?>
">Continue reading</a>
                        </div>
                    </div>
                </div>
              <?php } ?>
              </div>
              <?php }else{ ?>
                <div class="text-center">
                  No News Found
                </div>
                <?php }?>
            </div>
          </div>

          <?php }?>
        <!--# content #--><?php }} ?>