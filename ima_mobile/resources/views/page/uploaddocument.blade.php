@extends('templates.default')
@section('content')
<div class="col-md-10 col-xs-12 carpag_con">
  <?php if(isset($_SESSION['user']) && ($_SESSION['user']['id'] >0) && ($result['check_register_status'] == true)) { ?>
  <div class="well">
    <p>To upload your PowerPoint Presentation (PPT) please click the choose file button below and click submit. Please ensure that your PPT file name contains the group and college name. Further, your PPT should have 10 slides (including exhibits).</p>
    <p>IMA Idea Pitch Competition Case Study PDF <a href="<?php echo url('Docs/IMA_Case_Study.pdf');?>" traget="_blank"> click here</a></p>
    <div class="sec-title">
      <h1>
        Please Upload your PPT for IMA Idea Pitch Competition
      </h1>
      <div class="sttl-line"></div>
    </div>
    <p>We will get back to you if we find your submission suitable.</p>
    <form class="form-inline" name="career_resume_frm" id="career_resume_frm" action="" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
      <input type="hidden" name ="check_form_validation" id="check_form_validation" value="0" />
      <div class="form-group">
        <div class="input-group">
          <input type="file" class="form-control" value="{{ csrf_token() }}" name="careers_resume" id="careers_resume" onchange="CheckPPTXDocumentfiles()" placeholder="Amount">
          <div class="input-group-addon btn btn-primary">
            <button type="button" class="btn-normal" onclick="return onsubmitCompetition();">Submit</button>
          </div>
        </div>
      </div>
	  <div>Please upload your PPT by 1st March 2018.</div>
      <div id="err_careers_resume" style="color:red;"></div>		
      <?php  if($result['rightside']['param']=="success") { ?>
      <div class="cpc_success">Your documentation has been uploaded successfully. Thank you for your interest in our firm.</div>
      <?php  }?>
	  
    </form>
    <div class="text-right">Back to competition <a href="<?php echo url('page/ideapitchcompetition');?>">page</a></div>
  </div>
  <?php } else if(isset($_SESSION['user']) && ($_SESSION['user']['id'] >0) && ($result['check_register_status'] == false)){ ?>
  <div class="well text-center">
    <!-- <p>You need to first register to the IMA idea pitch competition to be able to upload the PPT.</p>
    <a class="btn btn-primary btn-sm" href="<?php echo url('user/login');?>">
      Login
    </a> -->
	<p>As you have not registered for the competition, you can not upload your ppt. As registration are closed. </p>
    <div class="text-right">Back to competition <a href="<?php echo url('page/ideapitchcompetition');?>">page</a></div>
  </div>
  <?php } else  { ?> 
  <div class="well text-center">
    <p>You are not logged in. Please login to upload your PowerPoint Presentations (PPT)for IMA Idea Pitch Competition.</p>
    <a class="btn btn-primary btn-sm" href="<?php echo url('user/login');?>">
      Login
    </a>
    <div class="text-right">Back to competition <a href="<?php echo url('page/ideapitchcompetition');?>">page</a></div>
  </div>
  <?php } ?>
</div>
@stop