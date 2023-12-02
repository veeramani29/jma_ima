

<!--footer section-->
<div class="row">
<div class="col-sm-4">
<a
				href="https://stripe.com/ca/features#perfectly-scaled"
				title="How Stripe Works"
				onclick="javascript:window.open('https://stripe.com/ca/features#perfectly-scaled','Stripe','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;"><img
					src="images/stripe_icon1.png"
					height="70px" border="0" alt="Stripe Acceptance Mark"></a> <br><br>
					<img src="<?php echo $this->images;?>ssl/comodo_secure_113x59_white.png" width="60px">
</div>
<div class="col-sm-8">
<p>
Japan Macro Advisors Inc. ("We") are not an investment advisory and we do not make any offer or solicitation to buy/sell financial securities or other type of assets. The information contained
herein has been obtained from, or is based upon, sources believed
by us to be reliable, but we do not make any representation or
warranty for their accuracy or completeness. The text, numerical
data, charts and other graphical contents we provide ("JMA
contents") are copyrighted properties of Japan Macro Advisors
("Us"). While we permit personal non-commerical usage of JMA
contents, it should be accompanied by an explicit mention that the
contents belong to us. We do not allow any reproduction of JMA
contents for other purposes unless specifically authorised by us.
Please contact <a href="mailto:info@indiamacroadvisors.com"
style="color: #0F759F; text-decoration: underline;">info@indiamacroadvisors.com</a>
to seek our authorization.
				</p>
</div>
</div>
<div class="row">
<div class="col-sm-4">
		
			<p>Copyright &copy; 2012-<?php echo date('Y');?>; <a href="">JAPAN MACRO ADVISORS</a></p>
	
</div>
<div class="col-sm-8">

					<ul class="list-inline pull-right">
			<li><a href="<?php echo $this->url('/');?>">Home</a> |</li>
			<li><a href="<?php echo $this->url('user/newsletters');?>">Newsletter</a> |</li>
			<li><a href="<?php echo $this->url('aboutus/termsofuse');?>">Terms Of
					Use </a> |</li>
			<li><a href="<?php echo $this->url('aboutus/privacypolicy');?>">Our
					Privacy Policy </a> |</li>
			<li><a href="<?php echo $this->url('aboutus/commercial_policy');?>">Commercial Policy </a> |</li>

			<li><a href="<?php echo $this->url('contact');?>">Contact</a></li>
			
		</ul>
	
</div>
	
</div>
<!--footer section-->

<script type="text/javascript">

$('iframe').load(function(){
var ht=$(this).contents().height(); //alert($('iframe').contents().height() + 'is the height');
//document.getElementById('frame').height= (ht) + "px";
this.style.height = (ht) + "px";
//if(ht>495)
//{
//$(this).css("height",ht);
//}

});
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36471452-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>