@extends('templates.default')
@section('content')
<?php 
$emailCategory = isset($result['emailAlert_category'])?$result['emailAlert_category']:'';


$defultAlertValue = implode(",",$result['defaultEmailAlert']);

$user_details = $result['userdetails'];
//print_r($user_details);

$userChoice = isset($result['emailAlert_choiceofUsers'][0]['want_to_email_alert'])?$result['emailAlert_choiceofUsers'][0]['want_to_email_alert']:'';
if(!empty($userChoice))
{
	$defaultemail = explode(",",$userChoice);
}
else
{
	$defaultemail = array();
}
?>
 <h6 class="text-center text-success" id="update_success">
		   <?php //echo $this->resultSet['result']['tabname'] == 'update' ? 'Updated successfully' : '';?>
</h6>  
<div class="col-xs-12 col-sm-10 unsub_con">
  <div class="usc_usedet">
    <p class="ussd_user">Hi <strong><?php echo $user_details[0]['fname'].' '.$user_details[0]['lname']; ?> ,</strong></p>
    <p>Please untick the indicators for which you don't wish to receive email alerts. You also have an option to unsubscribe from all email alerts, by clicking "Remove all" button.Thank you.</p>
  </div>
   <form name="frmEmailAlert" id="frmEmailAlert" method="post" action="<?php echo url('user/mailAlertUpdateWithoutLogin');?>">
           <input type="hidden" name="_token" value="{{ csrf_token() }}">
		   <input type="hidden" name="alert_type" id="alert_type" value="<?php echo $result['firstParam'] != '' ? $result['firstParam'] : '';?>" />
		   <input type="hidden" name="alert_value" id="alert_value" value="0" />
		   <input type="hidden" name="is_thematic" id="is_thematic" value="<?php echo $user_details[0]['breaking_News_Alert']; ?>" />
           <div id="email-custom" >
              <div class="well">
                <div class="main-title">
                  <h1>Please select indicators for which you like to receive our commentary</h1>
                  <div class="mttl-line"></div>
                </div>
				<?php 
					$defaultemail = (array_unique($defaultemail));
					$categoryId = array();
					foreach($emailCategory as $key=>$val)
					{
						foreach($val as $k => $v)
						{
							$categoryId[] = $k;
						}
						
					}
					$allemailCategory = implode(',',$categoryId);
				?>
                <ul class="list-inline email_cusalert">
                  <li>
                    <div class="full-widthf">
                      <label class="control control--checkbox">All
                        <input type="checkbox" value="All" name="checkAllemailAlert" id="checkAllemailAlert" onclick="return selectallEmail('reports and indicator');" <?php echo  (count($categoryId)===count($defaultemail)  && $user_details[0]['breaking_News_Alert'] == "Y")?'checked':'' ?>>
                        <span class="control__indicator"></span>
                      </label>
                    </div>
                  </li>
				   <li>
				   <?php //echo $user_details[0]['breaking_News_Alert']; ?>
				   <?php //echo $defultAlertValue; ?>
                    <div class="full-widthf">
                      <label class="control control--checkbox">Default selection
                        <input type="checkbox" value="All" name="checkAllemailAlert" id="checkDefaultemailAlert" onclick="return selectdefaultEmail('<?php echo $defultAlertValue; ?>','reports and indicator');" <?php echo ($user_details[0]['want_to_email_alert'] == $defultAlertValue && $user_details[0]['breaking_News_Alert'] != "Y") ? 'checked' : '';?>>
                        <span class="control__indicator"></span>  
                      </label>
                    </div>
                  </li>
				   <li>
					<div class="full-widthf">
					  <label class="control control--checkbox"> No email alerts
						<input type="checkbox" value="y" name="remove_box" id="remove_box" onclick="return removeallEmail();" <?php echo (($user_details[0]['want_to_email_alert'] == 0) && $user_details[0]['breaking_News_Alert'] == 'N')  ? 'checked' : '';?>>
						<span class="control__indicator"></span>
					  </label>
					</div>
				  </li>
                </ul>
				<div class="sub-title" style="display:none;">
				  <h5>Thematic Reports</h5>
				  <div class="sttl-line"></div>
				</div>
				<ul class="list-inline email_cusalert" style="display:none;">
				  <li>
					<div class="full-widthf">
					  <label class="control control--checkbox">Thematic reports
						<input type="checkbox" value="y" name="thematic_report" id="thematic_report" onclick="return issetThematicReports('<?php echo $defultAlertValue; ?>','<?php echo $allemailCategory; ?>');" <?php echo $user_details[0]['breaking_News_Alert'] == "Y" ? 'checked' : '';?>>
						<span class="control__indicator"></span>
					  </label>
					</div>
				  </li>
				</ul>
                <div class="sub-title" style="display:none;">
                  <h5>Topics</h5>
                  <div class="sttl-line"></div>
                </div>
                <ul class="list-inline email_cusalert" style="display:none;">
                  <li>
				 
                    <div class="full-widthf"> 
                      <label class="control control--checkbox"><?php echo $emailCategory[0][key($emailCategory[0])] ?>
                        <input type="checkbox" value="<?php echo key($emailCategory[0]); ?>" name="emailAlert[]" id="emailAlert_indicators1_<?php echo  key($emailCategory[0]); ?>" class="email_alert" <?php if(in_array(key($emailCategory[0]),$defaultemail)) { echo 'checked'; } ?> >
                        <span class="control__indicator"></span>
                      </label>
                    </div>
                  </li>
                </ul>
                <div class="sub-title">
                  <h5>Indicators</h5>
                  <div class="sttl-line"></div>
                </div>
                <ul class="list-inline email_cusalert">
				  
				  <?php 
				  
				  if(empty($defaultemail))
				  {
					 // $defaultemail = array(88,89,90,92,98,112,100,104);
				  }
				  
				  foreach($emailCategory as $key => $val)
				  {
					    
                        
							 foreach($val as $k => $v)
							 { ?>
									<li>
									<div class="full-widthf">
									  <label class="control control--checkbox"><?php echo $v; ?>
										<input type="checkbox" value="<?php echo $k; ?>" name="emailAlert[]" id="emailAlert_indicators_<?php echo  $k; ?>" <?php if(in_array($k,$defaultemail)) { echo "checked"; } ?> class="email_alert" onclick="return checkDefaultRemove('<?php echo $defultAlertValue; ?>','<?php echo $allemailCategory; ?>','reports and indicator');">
										<span class="control__indicator"></span>
									  </label>
									</div>
								  </li>
					   <?php }
						
				  }?>
                </ul>
				
              </div>
            </div>
  <div class="col-xs-12 text-center">
   <p class="text-danger" id="errEmailAlert"></p>
    <button class="btn btn-primary btn-long" onclick="return mailWithOutLoginAlertUpdate();"> Submit</button>
  </div>
  </form>
</div>
@stop