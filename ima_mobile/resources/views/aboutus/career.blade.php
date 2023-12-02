@extends('templates.default')
@section('content')
<div class="col-xs-12 carpag_con">
  <div class="well">
    <p>Are you passionate about economics? Like the idea of being part of a dynamic startup culture?  If you are an aspiring young economist looking to combine analytical skills and entrepreneurial spirit, then join us. </p>
    <p>Job Description PDF <a href="<?php echo url('Docs/Job_Description_for_Junior_Economist-IMA.pdf');?>"> click here</a></p>
    <div class="sec-title">
      <h1>
        Send us your resume
      </h1>
      <div class="sttl-line"></div>
    </div>
    <p>We will get back to you if we find your profile suitable</p>
    <form class="form-inline" name="career_resume_frm" id="career_resume_frm" action="" method="post" enctype="multipart/form-data">
	 {{ csrf_field() }}
      <div class="form-group">
        <div class="input-group">
          <input type="file" class="form-control" value="{{ csrf_token() }}" name="careers_resume" id="careers_resume" onchange="CheckResumefiles()" placeholder="Amount">
          <div class="input-group-addon btn btn-primary">
            <button type="submit" class="btn-normal" onclick="return onsubmitResume();">Submit</button>
          </div>
        </div>
      </div>
		<div id="err_careers_resume" style="color:red;"></div>		
		<?php  if($result['rightside']['param']=="success") { ?>
		  <div class="cpc_success">Your resume has been uploaded successfully. Thank you for your interest in our firm.</div>
		 <?php  }?>
    </form>
  </div>
</div>
@stop