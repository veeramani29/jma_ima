<?php?>
<html>
  <body>

      <div style="width: 100%">
        <div style="text-align: center; margin-top: 200px">
          <!--   <img src="https://dashboard.razorpay.com/img/logo_full.png" alt="Buy now with PayPal" /> -->
            <span style="font-size: 20px">Welcome to IMA -Premium Subscription. </span>
          <img style="display: block; margin: 0 auto" src="http://beta.ticketfinder.nl/assets/images/Preloader.gif" alt="Preloader">
          <span style="font-size: 20px">Please wait, do not refresh or close this window. </span>
        </div>
      </div>
      </body>
      </html>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    "key": "rzp_test_0G426euDFns9qo",
    "subscription_id": "<?php echo $subscription->id;?>",
    "name": "India Macro Advisors",
    "description": "PREMIUM SUBSCRIPTION",
    "image": "https://www.indiamacroadvisors.com/assets/images/logo.png",
    "handler": function (response){
        alert(response.razorpay_payment_id);
    },
    "prefill": {
        "name": "Customer Name",
        "email": "test@email.com"
    },
    "notes": {
        "address": "PREMIUM SUBSCRIPTION Monthly fee of INR 799"
    },
    "theme": {
        "color": "#316AB4"
    }
};
var rzp1 = new Razorpay(options);

document.body.onload = function(e){
    rzp1.open();
    e.preventDefault();
}
</script>