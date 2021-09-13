<?php /* Smarty version Smarty-3.1.8, created on 2021-09-13 16:01:22
         compiled from "templates/www/default\core\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21516613efd5ba1e7b9-09931020%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a5ad9ac569d79c86ddb86accb9719faac273801b' => 
    array (
      0 => 'templates/www/default\\core\\header.tpl',
      1 => 1631523680,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21516613efd5ba1e7b9-09931020',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_613efd5c647fc2_41588445',
  'variables' => 
  array (
    'oSeo' => 0,
    'oMod' => 0,
    'aConfig' => 0,
    'interceptor' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_613efd5c647fc2_41588445')) {function content_613efd5c647fc2_41588445($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title><?php if ($_smarty_tpl->tpl_vars['oSeo']->value instanceof Seo){?><?php echo $_smarty_tpl->tpl_vars['oSeo']->value->getMetaTitle();?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['oMod']->value->getName();?>
 | <?php echo $_smarty_tpl->tpl_vars['aConfig']->value['web_title'];?>
<?php }?></title>
    <?php if ($_smarty_tpl->tpl_vars['oSeo']->value instanceof Seo){?>
    <meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['oSeo']->value->getMetaKeywords();?>
" />
    <meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['oSeo']->value->getMetaDescription();?>
" />
    <?php }else{ ?>
    <meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['aConfig']->value['meta_name_keywords'];?>
" />
    <meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['aConfig']->value['meta_name_description'];?>
" />
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['aConfig']->value['web_ico']!=''){?>
      <link rel="icon"  href="/contents/images/<?php echo $_smarty_tpl->tpl_vars['aConfig']->value['web_ico'];?>
">
    <?php }?>
     <link href='https://fonts.googleapis.com/css?family=Oswald:400,700,300|Open+Sans:400,800,700,300,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getConfigVariable('CSS_PATH');?>
font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getConfigVariable('CSS_PATH');?>
ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getConfigVariable('CSS_PATH');?>
bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getConfigVariable('CSS_PATH');?>
animate.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getConfigVariable('CSS_PATH');?>
owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getConfigVariable('CSS_PATH');?>
menu/menuzord.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getConfigVariable('CSS_PATH');?>
menu/menuzord-min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getConfigVariable('CSS_PATH');?>
style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getConfigVariable('CSS_PATH');?>
responsive.css">


    <script type="text/javascript" src="<?php echo $_smarty_tpl->getConfigVariable('JS_PATH');?>
vendor/modernizr-2.8.3.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getConfigVariable('CSS_PATH');?>
/revolution/navstylechange.css" media="screen" >
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getConfigVariable('CSS_PATH');?>
/revolution/settings.css" media="screen" >
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getConfigVariable('CSS_PATH');?>
/revolution/rev-style.css" media="screen" >

    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getConfigVariable('CSS_PATH');?>
/custom.css" media="screen" >
    
  </head>

  

<body class="home about common-style">
  <div id="main-menu" class="main-menu responsive-device-menu scrol_fixed_nav">
    <nav id="menuzord" class="menuzord red">
      <a href="/" class="menuzord-brand"><img src="<?php echo $_smarty_tpl->getConfigVariable('CONTENT_PATH');?>
<?php echo $_smarty_tpl->tpl_vars['aConfig']->value['web_logo'];?>
" width="100" alt=""
          srcset=""></a>

      <div class="menu-right-part">
        <div class="social-btn">
          <ul>
            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
            <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
            <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
            <li><a href="#"><i class="fa fa-rss" aria-hidden="true"></i></a></li>
          </ul>
        </div>
      </div><!-- /.menu-right-part -->
      <?php echo $_smarty_tpl->tpl_vars['interceptor']->value->menu($_smarty_tpl->tpl_vars['oMod']->value);?>

    </nav>
  </div>
<?php }} ?>