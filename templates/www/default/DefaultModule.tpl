{*
        <!--# content #-->

          {if count($banners) > 0}
          <!--# slider #-->
          <section>
          <div class="swiper-container" id="home-slider">
            <div class="swiper-wrapper">
              {foreach $banners as $slider }
              <div class="swiper-slide">
                 <img src="{$slider->getPictureUrl()}">
                {*<a href="{$slider->getUrl()}" {if $slider->getNewTab()}target="_blank"{/if} " >
                  
                </a>
                <div class="title animated delay300ms fatten" data-animation="bounceInUp">{$slider->getName()}</div>
                <p class="animated delay300ms fatten" data-animation="zoomIn">{$slider->getDescription()}</p>
              </div>
              {/foreach}
            </div>
            <!--# slider pagination #-->
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev swiper-button-white"></div>
            <div class="swiper-button-next swiper-button-white"></div>
          </div>
          </section>
          <!--# slider #-->
          {/if}
          <section class="section bg-primary p-t-70 p-b-40 bg-cover js-waypoint">
            <div class="container">
                <div class="relative">
                    <div class="heading-section heading-section-1 light">
                        <h3>Our Group</h3>
                    </div>
                    <div class="owl-carousel nav-style-1" data-carousel-margin="45" data-carousel-nav="true" data-carousel-autoplay="true">
                        {foreach $services as $service}
                        <div class="image-card image-card-1 light">
                          {if $service->getPicture()!=''}
                            <div class="image">
                                <a href="{$oMod->getBasePage('News',$service->getUrl())}">
                                    <img src="{$service->getPictureUrl()}" alt="{$service->getName()}" />
                                </a>
                            </div>
                            {/if}
                            <h3 class="title">
                                <a href="{$oMod->getBasePage('News',$service->getUrl())}">{$service->getName()}</a>
                            </h3>
                            <div class="content">
                                {$service->getDescription()|truncate:300}
                            </div>
                            <div class="link">
                                <a href="{$oMod->getBasePage('News',$service->getUrl())}">
                                    <i class="fa fa-caret-right"></i>
                                    <span>Learn More</span>
                                </a>
                            </div>
                        </div>
                        {/foreach}
                    </div>
                </div>
            </div>
        </section>
          <!--# home-content #-->
          <div class="home-content">
            <div class="container">
              <div class="entry-content">
              {$aConfig.content_home}
              </div>
            </div>
          </div>
          <!--# home-content #-->
        <section class="section bg-grey-light p-t-70 p-b-50">
        <div class="container">
            <div class="relative section-testimonials-wrapper-1">
                <div class="heading-section heading-section-1 dark">
                    <h3>Testimonials</h3>
                </div>
                <div class="owl-carousel dark nav-style-1" data-carousel-margin="30" data-carousel-nav="true" data-carousel-loop="false" data-carousel-autoplay="true">
                    {foreach $testimonials as $testimonial}
                    {if $testimonial->getActive()}
                    <div class="image-card image-card-2">
                        <div class="card-top">
                            <div class="avatar">
                                <a href="#">
                                    <img src="{$testimonial->getPictureUrl()}" alt="{$testimonial->getName()}" />
                                </a>
                            </div>
                            <div class="info">
                                <span class="name">{$testimonial->getName()}</span>
                            </div>
                        </div>
                        <div class="card-body">
                                {$testimonial->getDescription()}
                            <div class="content">
                            </div>
                        </div>
                    </div>
                    {/if}
                    {/foreach}
                </div>
            </div>
        </div>
    </section>
    <section class="section p-t-70 p-b-30 bg-white">
        <div class="container">
            <div class="relative">
                <div class="heading-section heading-section-1 dark">
                    <h3>Latest News</h3>
                </div>
                <div class="owl-carousel dark nav-style-1" data-carousel-margin="45" data-carousel-nav="true" data-carousel-loop="false">
                    {foreach $latest_news as $news}
                    <div class="image-card image-card-4">
                        <div class="image">
                            <a href="{$oMod->getBasePage('News',$news->getUrl())}">
                                <img src="{$news->getPictureUrl()}" alt="{$news->getName()}" />
                            </a>
                        </div>
                        <div class="date">
                            <span>{$news->getDate()}</span>
                        </div>
                        <h3 class="title">
                            <a href="{$oMod->getBasePage('News',$news->getUrl())}">{$news->getName()}</a>
                        </h3>
                        <div class="content">
                            {$news->getDescription|truncate:100}
                        </div>
                        <div class="link">
                            <a href="{$oMod->getBasePage('News',$news->getUrl())}">Continue reading</a>
                        </div>
                    </div>
                    {/foreach}
                </div>
            </div>
        </div>
    </section>
           <section class="section bg-grey-light p-t-70 p-b-70">
        <div class="container">
            <div class="relative">
                <div class="p-b-15">
                    <div class="heading-section heading-section-2 dark">
                        <h3>OUR PARTNER</h3>
                    </div>
                </div>
                <div class="owl-carousel dark nav-style-2" data-carousel-margin="30" data-carousel-nav="true" data-carousel-loop="true" data-carousel-items="5" data-carousel-autoplay="true">
                    <div class="icon-box icon-box-3">
                        <div class="icon">
                            <a href="#">
                                <img src="{#IMAGE_PATH#}partner-1.jpg" alt="our partner" />
                            </a>
                        </div>
                    </div>
                    <div class="icon-box icon-box-3">
                        <div class="icon">
                            <a href="#">
                                <img src="{#IMAGE_PATH#}partner-2.jpg" alt="our partner" />
                            </a>
                        </div>
                    </div>
                    <div class="icon-box icon-box-3">
                        <div class="icon">
                            <a href="#">
                                <img src="{#IMAGE_PATH#}partner-3.jpg" alt="our partner" />
                            </a>
                        </div>
                    </div>
                    <div class="icon-box icon-box-3">
                        <div class="icon">
                            <a href="#">
                                <img src="{#IMAGE_PATH#}partner-4.jpg" alt="our partner" />
                            </a>
                        </div>
                    </div>
                    <div class="icon-box icon-box-3">
                        <div class="icon">
                            <a href="#">
                                <img src="{#IMAGE_PATH#}partner-5.jpg" alt="our partner" />
                            </a>
                        </div>
                    </div>
                    <div class="icon-box icon-box-3">
                        <div class="icon">
                            <a href="#">
                                <img src="{#IMAGE_PATH#}partner-6.jpg" alt="our partner" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
*}
	<div id="banner" class="banner-section">
        <img src="{#CONTENT_PATH#}{$aConfig.home1}" />
		<div class="overlay">
			<div class="banner-text text-right">
				<div id="main-slider" class="carousel slide" data-ride="carousel">
					<div class="container">

						<!-- Wrapper for slides -->
						<div class="carousel-inner text-right" role="listbox">
							<div class="item active">
								<div class="slider-txt">
									<h3 class="title wow fadeInUp" data-wow-duration=".5s" data-wow-delay=".6s">SwissAir
									</h3>
									<h2 class="description wow fadeInUp" data-wow-duration=".5s" data-wow-delay=".8s">
										Air Purifier</h2>
									<p class="wow fadeInUp" data-wow-duration=".5s" data-wow-delay=".9s">We Protect The
										Air You Breathe</p>
								</div><!-- /.slider-txt -->
							</div>

							<div class="item">
								<div class="slider-txt">
									<h3 class="title wow fadeInUp" data-wow-duration=".5s" data-wow-delay=".6s">SwissAir
									</h3>
									<h2 class="description wow fadeInUp" data-wow-duration=".5s" data-wow-delay=".8s">
										Air Purifier</h2>
									<p class="wow fadeInUp" data-wow-duration=".5s" data-wow-delay=".9s">We Protect The
										Air You Breathe</p>
								</div><!-- /.slider-txt -->
							</div>

							<div class="item">
								<div class="slider-txt">
									<h3 class="title wow fadeInUp" data-wow-duration=".5s" data-wow-delay=".6s">SwissAir
									</h3>
									<h2 class="description wow fadeInUp" data-wow-duration=".5s" data-wow-delay=".8s">
										Air Purifier</h2>
									<p class="wow fadeInUp" data-wow-duration=".5s" data-wow-delay=".9s">We Protect The
										Air You Breathe</p>
								</div><!-- /.slider-txt -->
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
							<!-- SLIDE 1 -->
							<li data-transition="zoomin" data-slotamount="7" data-masterspeed="1500">
								<!-- MAIN IMAGE -->
								<img src="/default/images/images-1.jpg" alt="slidebg1" data-bgfit="cover"
									data-bgposition="left top" data-bgrepeat="no-repeat">
								<!-- LAYERS -->

								<!-- LAYER 1 -->
								<div id="z2" class="tp-caption hlimo-h2 customin" data-x="50" data-y="280"
									data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
									data-speed="500" data-start="600" data-easing="Power3.easeInOut"
									data-endspeed="300">
									<h2>CLEAN AIR</h2>
								</div>

								<!-- LAYER 2 -->
								<div id="z3" class="tp-caption hlimob-h2 customin" data-x="50" data-y="380"
									data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
									data-speed="500" data-start="900" data-easing="Power3.easeInOut"
									data-endspeed="300">
									<h2><span>FOR LIFE</span></h2>
								</div>


								<!-- LAYER 3 -->
								<div id="z7" class="tp-caption home-p skewfromright customout" data-x="50" data-y="500"
									data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
									data-speed="800" data-start="1500" data-easing="Power4.easeOut" data-endspeed="300"
									data-endeasing="Power1.easeIn" data-captionhidden="on">
									<p>The UNECE – Switzerland</p>
									<p>Air pollution harms human health, affect food security, hinders economic
										development, contributes to climate change and degrades the environment upon
										which our very livelihoods depend.</p>
									<p>With no political boundaries: pollution from sources in one country can be
										transported and deposited in neighbouring countries, sometimes even thousands of
										kilometres away.</p>
								</div>
							</li>
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
							<div class="col-sm-4">
								<div class="colmd4">
									<div class="product-tab-img">
										<img src="images/produk-1.jpg" class="img-responsive" alt="Tab Product Image">
									</div>
								</div>
							</div><!-- /.col-sm-4 -->
							<div class="col-sm-4">
								<div class="colmd4">
									<div class="product-tab-img">
										<img src="images/produk-2.jpg" class="img-responsive" alt="Tab Product Image">
									</div>
								</div>
							</div><!-- /.col-sm-4 -->\
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
				<div class="col-md-5 wow fadeInUp" data-wow-duration=".8s" data-wow-delay=".6s">
					<div class="section-head text-center">
						<h2>SwissAir Technology AG </h2>
						<p>was founded on the firm belief that the freedom to breathe Clear and Healthy Air is The
							Greatest Gift. Using the micron mesh filter to effectively block 2.5mm fibrous particulate
							matter, the air can be cleaned easily by ten of thousands times. Preventing large particles
							such as pet fur, dander, and coarse dust, etc. In technical ways, it can increase the life
							of the following filters.</p>
					</div>
				</div><!-- /.col-md-4 -->
				<div class="col-md-7 wow fadeInUp" data-wow-duration=".8s" data-wow-delay=".8s">
					<div class="big-sale-img">
						<img src="images/technology.jpg" class="img-responsive" alt="">
					</div>
				</div><!-- /.col-md-8 -->
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
							<span>Limo Corp</span>
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
			<div class="section-head padding-bottom55 text-center wow fadeInUp" data-wow-duration=".8s"
				data-wow-delay=".3s">
				<h2>7 SHIELD PROTECTION</h2>
			</div>
			<div class="section-content">
				<div class="col-md-4">
					<div class="colmd4 wow fadeInUp" data-wow-duration=".8s" data-wow-delay=".6s">
						<img src="images/produk-3.jpg" class="img-responsive" alt="">
					</div>
				</div><!-- /.col-md-4 -->
				<div class="col-md-8 d-grid grid-column-2 grid-column-xs">
					<div class="wow fadeInUp" data-wow-duration=".8s" data-wow-delay=".9s">
						<div class="single-item">
							<div class="icon"><img src="images/home-light/service/1.png" alt=""></div>
							<div class="mm-small-box">
								<h4>1st: Pre-filter</h4>
								<p>Made of white nylon to be washed repeatedly</p>
							</div>
						</div><!-- /.single-service -->
					</div>
					<div class="wow fadeInUp" data-wow-duration=".8s" data-wow-delay="1s">
						<div class="single-item">
							<div class="icon"><img src="images/home-light/service/2.png" alt=""></div>
							<div class="mm-small-box">
								<h4>2nd: HEPA filter</h4>
								<p>HEPA filter widely used for medical use, to strongly absord particles PM 2.5</p>
							</div>
						</div><!-- /.single-service -->
					</div>
					<div class="wow fadeInUp" data-wow-duration=".8s" data-wow-delay="1.1s">
						<div class="single-item">
							<div class="icon"><img src="images/home-light/service/3.png" alt=""></div>
							<div class="mm-small-box">
								<h4>3rd: Antibacterial Filter</h4>
								<p>5-10 Times powerful than traditional carbon filter</p>
							</div>
						</div><!-- /.single-service -->
					</div>
					<div class="wow fadeInUp" data-wow-duration=".8s" data-wow-delay="1.2s">
						<div class="single-item">
							<div class="icon"><img src="images/home-light/service/4.png" alt=""></div>
							<div class="mm-small-box">
								<h4>4th: Activated Carbon</h4>
								<p>5-10 Times powerful than traditional carbon filter</p>
							</div>
						</div><!-- /.single-service -->
					</div>
					<div class="wow fadeInUp" data-wow-duration=".8s" data-wow-delay="1.3s">
						<div class="single-item">
							<div class="icon"><img src="images/home-light/service/5.png" alt=""></div>
							<div class="mm-small-box">
								<h4>5th: Photocatalyst filter</h4>
								<p>Nano TIO2 as representative materials</p>
							</div>
						</div><!-- /.single-service -->
					</div>
					<div class="wow fadeInUp" data-wow-duration=".8s" data-wow-delay="1.4s">
						<div class="single-item">
							<div class="icon"><img src="images/home-light/service/6.png" alt=""></div>
							<div class="mm-small-box">
								<h4>6th: Ion Generator</h4>
								<p>Produce Large Amount of Negative ION</p>
							</div>
						</div><!-- /.single-service -->
					</div>
					<div class="wow fadeInUp" data-wow-duration=".8s" data-wow-delay="1.4s">

						<div class="single-item">
							<div class="icon"><img src="images/home-light/service/6.png" alt=""></div>
							<div class="mm-small-box">
								<h4>7th: UV Light</h4>
								<p>Cold cathode ultraviolet lamp with a wavelength of 235.7nm can effectively kill a
									variety of common bacteria and viruses</p>
							</div>
						</div><!-- /.single-service -->
					</div>
				</div><!-- /.col-md-8 -->
			</div><!-- /.section-content -->
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
				<div class="col-md-6 wow fadeInUp animated" data-wow-duration=".8s" data-wow-delay="0.4s">
					<div class="post-item">
						<div class="col-sm-6"><img src="images/articles.jpg" class="img-responsive" alt=""></div>
						<div class="col-sm-6">
							<div class="mm-small-box">
								<h4><a href="#" class="black">SwissAir Air Purifier</a></h4>
								<span>07 Jan 2016</span>
								<p>With UV Light, the use of a cold cathode ultraviolet lamp with a wavelength of
									235.7nm</p>
								<a href="#" class="more-btn">Read More</a>
							</div>
						</div>
					</div>
				</div>
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
							<input class="form-control user-web" type="url" name="website" placeholder="Subject*">
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
	<!-- /#contact -->