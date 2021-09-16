<?php /* Smarty version Smarty-3.1.8, created on 2021-09-16 17:23:02
         compiled from "templates/www/default\DefaultModule.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8533613efd5f8ec603-43484363%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b100b893d2f6903585ac7cf2164aea061b4f7ee1' => 
    array (
      0 => 'templates/www/default\\DefaultModule.tpl',
      1 => 1631787775,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8533613efd5f8ec603-43484363',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_613efd606d0811_27877592',
  'variables' => 
  array (
    'aConfig' => 0,
    'sliders' => 0,
    'slider' => 0,
    'banners' => 0,
    'banner' => 0,
    'products' => 0,
    'product' => 0,
    'news_list' => 0,
    'news' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_613efd606d0811_27877592')) {function content_613efd606d0811_27877592($_smarty_tpl) {?>	<div id="banner" class="banner-section">
        <img src="<?php echo $_smarty_tpl->getConfigVariable('CONTENT_PATH');?>
<?php echo $_smarty_tpl->tpl_vars['aConfig']->value['home1'];?>
" /> 
		<div class="overlay">
			<div class="banner-text text-right">
				<div id="main-slider" class="carousel slide" data-ride="carousel">
					<div class="container">

						<!-- Wrapper for slides -->
						<div class="carousel-inner text-right" role="listbox">
							<div class="item active">
								<?php  $_smarty_tpl->tpl_vars['slider'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['slider']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['sliders']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['slider']->key => $_smarty_tpl->tpl_vars['slider']->value){
$_smarty_tpl->tpl_vars['slider']->_loop = true;
?>
								<div class="slider-txt">
									<h3 class="title wow fadeInUp" data-wow-duration=".5s" data-wow-delay=".6s"><?php echo $_smarty_tpl->tpl_vars['slider']->value->getName();?>

									</h3>
									<h2 class="description wow fadeInUp" data-wow-duration=".5s" data-wow-delay=".8s">
										<?php echo $_smarty_tpl->tpl_vars['slider']->value->getShortDescription();?>
</h2>
									<p class="wow fadeInUp" data-wow-duration=".5s" data-wow-delay=".9s"><?php echo $_smarty_tpl->tpl_vars['slider']->value->getDescription();?>
</p>
								</div><!-- /.slider-txt -->
								<?php } ?>
							</div>
						</div><!-- /.carousel-inner -->
						<div class="next-section">
							<button id="go-to-next" class="btn"><i class="fa fa-angle-double-down"></i></button>
						</div>

					</div><!-- /.container -->
				</div><!-- /#main-slider -->
			</div><!-- /.banner-text -->
		</div>
		<!-- Main Slider -->
		<div id="slider" class="slider-section">
			<div class="menu-in-slider">
				<div class="tp-banner-container">
					<div class="tp-banner">
						<ul>
						<?php  $_smarty_tpl->tpl_vars['banner'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['banner']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['banners']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['banner']->key => $_smarty_tpl->tpl_vars['banner']->value){
$_smarty_tpl->tpl_vars['banner']->_loop = true;
?>
							<!-- SLIDE 1 -->
							<li data-transition="zoomin" data-slotamount="7" data-masterspeed="1500">
								<!-- MAIN IMAGE -->
								<img src="<?php echo $_smarty_tpl->tpl_vars['banner']->value->getPictureUrl();?>
" alt="slidebg1" data-bgfit="cover"
									data-bgposition="left top" data-bgrepeat="no-repeat">
								<!-- LAYERS -->

								<!-- LAYER 1 -->
								<div id="z2" class="tp-caption hlimo-h2 customin" data-x="50" data-y="280"
									data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
									data-speed="500" data-start="600" data-easing="Power3.easeInOut"
									data-endspeed="300">
									<h2><?php echo $_smarty_tpl->tpl_vars['banner']->value->getName();?>
</h2>
								</div>

								<!-- LAYER 2 -->
								<div id="z3" class="tp-caption hlimob-h2 customin" data-x="50" data-y="380"
									data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
									data-speed="500" data-start="900" data-easing="Power3.easeInOut"
									data-endspeed="300">
									<h2><span><?php echo $_smarty_tpl->tpl_vars['banner']->value->getUrl();?>
</span></h2>
								</div>


								<!-- LAYER 3 -->
								<div id="z7" class="tp-caption home-p skewfromright customout" data-x="50" data-y="500"
									data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
									data-speed="800" data-start="1500" data-easing="Power4.easeOut" data-endspeed="300"
									data-endeasing="Power1.easeIn" data-captionhidden="on">
									<?php echo $_smarty_tpl->tpl_vars['banner']->value->getDescription();?>

									
								</div>
							</li>
						<?php } ?>
						</ul>
						<!-- <div class="tp-bannertimer"></div> -->
					</div>
				</div>
			</div><!-- /.menu-in-slider -->
		</div><!-- /.slider-section -->
		<!-- End of Main Slider -->
    </div>
<!-- /#fleets -->
	<section id="fleets" class="fleets-section section-padding ">
		<div class="container">
			<div class="section-head text-center wow fadeInUp" data-wow-duration=".8s" data-wow-delay=".6s">
				<h2>OUR PRODUCT</h2>
			</div>
			<div class="tab-wrap wow fadeInUp" data-wow-duration=".8s" data-wow-delay=".8s">
				<!-- Tab panes -->
				<div id="product-tab" class="tab-content">
					<div role="tabpanel" class="tab-pane fade active in" id="all">
						<div class="row">
						<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
$_smarty_tpl->tpl_vars['product']->_loop = true;
?>
							<div class="col-sm-4">
								<div class="colmd4">
									<div class="product-tab-img">
										<img src="<?php echo $_smarty_tpl->tpl_vars['product']->value->getPictureUrl();?>
" class="img-responsive" alt="Tab Product Image">
									</div>
								</div>
							</div><!-- /.col-sm-4 -->
							<?php } ?>
						</div>
					</div><!-- /#all -->
				</div>
			</div>
		</div><!-- /.container -->
	</section>
	<!-- /#fleets -->

	<!-- /#big-sale -->
	<div id="big-sale" class="big-sale padding-bottom100">
		<div class="container">
			<div class="section-content">
				<?php echo $_smarty_tpl->tpl_vars['aConfig']->value['content_home'];?>

			</div>
		</div><!-- /.container -->
	</div>
	<!-- /#big-sale -->

	<!-- Quote Section -->
	<div id="quote" class="quote-section">
		<div class="overlay section-padding">
			<div class="container">
				<div id="quote-slider">
					<div class="quote-text-wrap text-center">
						<div class="quote-info">
							<p>“Clean Air For Next Generation”</p>
							<a href="#" class="font-Montserrat">We love our planet</a>
							
						</div><!-- /.quote-info -->
					</div>
				</div>
			</div>
		</div>
	</div><!-- /#quote -->
	<!-- End of Quote Section -->

	<!-- /#service -->
	<section id="service" class="service-section padding-top100">
		<div class="container">
				<?php echo $_smarty_tpl->tpl_vars['aConfig']->value['content_home_protect'];?>

		</div>
	</section>
	<!-- /#service -->

	<!-- /#news -->
	<section id="news" class="news-section section-padding">
		<div class="container">
			<div class="section-head padding-bottom55 text-center wow fadeInUp animated" data-wow-duration=".8s"
				data-wow-delay="0.3s">
				<h2>Latest <span>News</span></h2>
			</div>
			<div class="section-content">
				<?php  $_smarty_tpl->tpl_vars['news'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['news']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['news_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['news']->key => $_smarty_tpl->tpl_vars['news']->value){
$_smarty_tpl->tpl_vars['news']->_loop = true;
?>	
					<div class="col-md-6 wow fadeInUp animated" data-wow-duration=".8s" data-wow-delay="0.4s">
						<div class="post-item">
							<div class="col-sm-6"><img src="<?php echo $_smarty_tpl->tpl_vars['news']->value->getPictureUrl();?>
" class="img-responsive" alt=""></div>
							<div class="col-sm-6">
								<div class="mm-small-box">
									<h4><a href="#" class="black"><?php echo $_smarty_tpl->tpl_vars['news']->value->getName();?>
</a></h4>
									<span><?php echo $_smarty_tpl->tpl_vars['news']->value->getDate();?>
</span>
									<p><?php echo $_smarty_tpl->tpl_vars['news']->value->getShortDescription();?>
</p>
									<a href="/news/<?php echo $_smarty_tpl->tpl_vars['news']->value->getCode();?>
" class="more-btn">Read More</a>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div><!-- /.section-content -->
		</div>
	</section>
	<!-- /#news -->

	<!-- /#contact -->
	<section id="contact" class="contact-section section-padding">
		<div class="container">
			<div class="section-head padding-bottom100 text-center wow fadeInUp" data-wow-duration=".8s"
				data-wow-delay=".3s">
				<h2 class="color-white">Contact <span>us</span></h2>
			</div>
			<div class="section-content wow zoomIn" data-wow-duration="1s" data-wow-delay=".4s">
				<form action="#" method="post">
					<div class="input-box">
						<div class="col-md-4">
							<input class="form-control user-name" type="text" name="name" placeholder="Your Name*"
								required>
						</div>

						<div class="col-md-4">
							<input class="form-control user-mail" type="email" name="email" placeholder="Your Email*"
								required>
						</div>

						<div class="col-md-4">
							<input class="form-control user-web" type="url" name="subject" placeholder="Subject*">
						</div>
					</div><!-- /.input-box -->

					<div class="message-box">
						<div class="col-md-12">
							<textarea name="message" class="form-control" placeholder="Message*" required></textarea>
						</div>
					</div><!-- /.message-box -->

					<p class="submit-box text-center"><input type="submit" class="base-bg" value="Send Message"></p>
				</form>
			</div><!-- /.section-content -->
		</div>
	</section>
	<!-- /#contact --><?php }} ?>