<html>

<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="AZF7ZNHSMU3JJ">
<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>


  <body  >
<!--  <a href="https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=SQT5R2RYGVFFJ&switch_classic=true">
<img src="https://www.paypalobjects.com/en_US/i/btn/btn_unsubscribe_LG.gif">
</a>  -->
      <div style="width: 100%">
        <div style="text-align: center; margin-top: 200px">
        	<img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/pp-acceptance-medium.png" alt="Buy now with PayPal" />

          <img style="display: block; margin: 0 auto" src="http://beta.ticketfinder.nl/assets/images/Preloader.gif" alt="Preloader">
          <span style="font-size: 20px">Please wait, do not refresh or close this window. </span>
        </div>
      </div>


      <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">

    <!-- Identify your business so that you can collect the payments. -->
    <input type="hidden" name="business" value="ajtravellabs@gmail.com">

    <!-- Specify a Subscribe button. -->
    <input type="hidden" name="cmd" value="_xclick-subscriptions">
    <!-- Identify the subscription. -->
<input type="hidden" name="image_url" width="150px" height="50px" value="<?php echo images_path("logo.png");?>">
<input type="hidden" name="cpp_cart_border_color"  value="d14836">
<input type="hidden" name="cpp_headerborder_color"  value="d14836">
<!--  <input type="hidden" name="cpp_headerback_color"  value="d14836"> -->
<input type="hidden" name="cpp_header_image" width="250px" height="200px" value="<?php echo images_path("logo.png");?>">
<input type="hidden" name="cpp_logo_image" width="150px" height="50px" value="<?php echo images_path("logo.png");?>">
	<input type="hidden" name="item_name" value="JMA Standard Monthly Subscription">
    
    <input type="hidden" name="notify_url" value="<?php echo url("/");?>">
	<input type='hidden' name='cancel_return' value="<?php echo url("user/payment_done/");?>">
	<input type='hidden' name='return' value='<?php echo url("user/payment_done/");?>'>
	<input type="hidden" size="60" name="item_number" value="<?php echo time();?>">
	<input type="hidden" size="60" name="invoice" value="JMASTD<?php echo time();?>">
	<input type='hidden' name='rm' value='2'>
    <!-- Set the terms of the regular subscription. -->
    <input type="hidden" name="currency_code" value="USD">
     <!-- Set the terms of the 1st trial period. -->
    
    <input type="hidden" name="a1" value="0">
    <input type="hidden" name="p1" value="1">
    <input type="hidden" name="t1" value="D">

    <!-- Set the terms of the 2nd trial period. -->
    <input type="hidden" name="a2" value="100.00">
    <input type="hidden" name="p2" value="1">
    <input type="hidden" name="t2" value="D">

    <!-- Set the terms of the regular subscription. -->
    <input type="hidden" name="a3" value="100.00">
    <input type="hidden" name="p3" value="1">
    <input type="hidden" name="t3" value="D">

    <!-- Set recurring payments until canceled. -->
    <input type="hidden" name="src" value="1">

    <!-- Display the payment button. -->
    <input type="image" name="submit"
    src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribe_LG.gif"
    alt="Subscribe">
    <img alt="" width="1" height="1"
    src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
</form>


			  </body>
</html>