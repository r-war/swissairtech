<section class="section bg-white p-t-70 p-b-40">
    <div class="container">
        <h3 class="text-block text-black text-bold text-med m-b-40">Send Us a Message</h3>
        {include file='core/feedback.tpl'}
        <div class="messages" id="status"></div>
        <form method="post" action="" name="contact" id="contact-form" role="form" data-toggle="validator">
            <div class="au-form-group">
                <div class="au-form-col-4 form-group">
                    <div class="help-block with-errors"></div>
                    <input class="au-input au-input-2" type="text" placeholder="Name" name="fullname" value="{$smarty.post.fullname}" required data-error="Name is required.">
                </div>
                <div class="au-form-col-4 form-group">
                    <div class="help-block with-errors"></div>
                    <input class="au-input au-input-2" type="email" placeholder="Email Address" name="email" value="{$smarty.post.email}" required data-error="Valid email is required.">
                </div>
                <div class="au-form-col-4 form-group">
                    <div class="help-block with-errors"></div>
                    <input class="au-input au-input-2" type="tel" placeholder="Phone Number" id="phone" name="phone" required data-error="Valid Phone is required.">
                </div>
            </div>
            <div class="form-group m-b-0">
              <div class="help-block with-errors"></div>
              <select class="form-control" name="type">
                <option value="" disabled>Select Type</option>
                <option>General Enquiries</option>
                <option>Event related information</option>
                <option>Feedback</option>
              </select>
            </div>
            <div class="form-group m-b-0">
              <div class="help-block with-errors"></div>
              <textarea class="au-textarea" placeholder="Your Messages" rows="6" name="message">{$smarty.post.message}</textarea>
            </div>
            <div class="form-group m-b-0">
              <div class="g-recaptcha" data-sitekey="6LfdvbYZAAAAAEtJRowxkGqRAp6XIcKp9xz5VPMz"></div>
            </div>
            <button class="au-btn au-btn-primary" name="send" value="1">SEND</button>
            {*<input class="au-btn au-btn-primary" placeholder="Send" type="submit" name="send" value="1">*}
        </form>
    </div>
</section>
<section id="contact-map">
  <!--# responsive google maps #-->
  <div class="google">
    {$aConfig.contact_map}
  </div>
  <!--# responsive google maps #-->                
</section>
          
          <!-- # contact -->

          
        <!--# content #-->