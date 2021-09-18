	<!-- Google Map -->
	<div id="google-map">
		<div class="map-container">
			<div id="googleMaps" class="google-map-container">
				{$aConfig.contact_map}
			</div>
		</div><!-- /.map-container -->
	</div><!-- /#google-map-->
	<!-- Google Map end -->

	<!-- Main Contact Area -->
	<section id="contact-us" class="contact-us section-padding">
		<div class="container">
			<div class="section-head padding-bottom55 text-center">
				<h2>Our <span>Office</span></h2>
			</div>

			<div class="main-contact-form wow fadeInUp animated" data-wow-duration="1.1s" data-wow-delay=".5s">
				<div class="row">
					<div class="col-md-6">
						<div id="respond" class="comment-respond">
							<h4 id="reply-title" class="comment-reply-title color-212121 bold">
								Stay In Touch
							</h4><!-- /#reply-title -->
							<p>Our friendly customer support staff can offer expert advice and help save your money. Be sure to ask about available promotions</p>
							{include file='core/feedback.tpl'}
							<form action="" name="contactus" method="post">
								<div class="input-box">
									<div class="row">
										<div class="col-md-6">
											<input class="form-control user-name" type="text" name="name" placeholder="Your Name*" required>
										</div>

										<div class="col-md-6">
											<input class="form-control user-mail" type="email" name="email" placeholder="Your Email*" required>
										</div>
									</div>
								</div><!-- /.input-box -->

								<div class="message-box">
									<textarea name="message" class="form-control" placeholder="Message*" required></textarea>
								</div><!-- /.message-box -->
								<p class="submit-box"><input type="submit" name="send" class="base-bg" value="Send Message"></p>
							</form>
						</div><!-- /#respond -->
					</div>
					<div class="col-md-3">
						<div class="comtact-info-area">
							{$aConfig.contact_detail}
						</div><!-- /.comtact-info-area -->
					</div>
					<div class="col-md-3">
						<div class="opening-hour">
							{$aConfig.contact_hour}
						</div>
					</div>
				</div>
			</div><!-- /.contact-wrapper -->
		</div><!-- /.container -->
	</section><!-- /#our-main-office -->
	<!-- End Of Main Contact Area -->