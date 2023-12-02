<?php 

?>
   <div class="col-xs-12 col-md-10">
<div class="row">
    <div class="col-md-12">
       
       <div class="main-title">
      <h1>Payment Successful</h1>
      <div class="mttl-line"></div>
    </div>

                <h4>Dear <?php echo ucfirst($_SESSION['user']['fname']).' '.ucfirst($_SESSION['user']['lname']);?></h4>

<?php if($this->getFlashMessage()=='Upgarde'){?>

<p>Our records show that you had signed up for our 1-month Premium trial before.Your subscription has been upgraded to Premium. You can continue to access your saved charts and other premium content. Your account subscription will renew automatically every month.</p>

<p>If you face any difficulties, please contact <a href="mailto:support@japanmacroadvisors.com">support@japanmacroadvisors.com</a></p>


<?php }else {?>

                <p>Thank you for choosing Japan Macro Advisors. Your Premium subscription has been successful and your Premium account is now active. 
<?php if(isset($_SESSION['user_type_upgrade']) && $_SESSION['user_type_upgrade']!=1){ ?>
                 Check your mail inbox for your login credentials sent to <?php echo (isset($_SESSION['user']['email']))?$_SESSION['user']['email']:'N/A';?>.
                 <?php } ?>
                 </p>

<p>Please mail <a href="mailto:support@japanmacroadvisors.com">support@japanmacroadvisors.com</a> with any problems.</p>
<?php } ?>
<p>Thank you, <br>Japan Macro Advisors</p>

				
	         
    </div>
</div>
</div>