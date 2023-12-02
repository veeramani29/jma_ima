@extends('templates.default')
@section('content')
<?php  //dd($result['check_register_status']);?>
<div class="col-xs-12 col-sm-10 ipc_main">
  <div class="main-title">
    <h1>IMA Idea Pitch Competition</h1>
    <div class="mttl-line"></div>
  </div>
  <img alt="Ideas Pitch" src="<?php echo images_path('ima.jpg');?>" alt="Competition">
 
  <p >The competition wishes to explore bright minds by challenging them to solve problems specific to our portal India Macro Advisors (IMA).</p>
 
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <table class="table table-bordered">
        <tbody>
         <!-- <tr>
            <th>When:</th>
            <td>15th December 2017</td>
          </tr> -->
          <tr>
            <th>Where:</th>
            <td>India</td>
          </tr>
          <tr>
            <th>Eligibility:</th>
            <td>MBA students </td>
          </tr>
          <tr>
            <th>Updated on:</th>
            <td>30th November 2017</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <!--<div class="text-center">
    <?php if(isset($_SESSION['user']) && ($_SESSION['user']['id'] >0) && ($result['check_register_status'] == false)){ ?>
    <a class="btn btn-primary btn-sm" href="<?php echo url('user/registercompetition/login');?>">
      Registration Page 
    </a>
    <?php } else if(isset($_SESSION['user']) && ($_SESSION['user']['id'] >0) && ($result['check_register_status'] == true)) { ?>
      <span></span>
    <?php } else { ?>
    <a class="btn btn-primary btn-sm" href="<?php echo url('user/registercompetition/withoutlogin');?>">
      Registration Page 
    </a>
    <?php } ?>
  </div> -->
  <div class="spacer10f"></div>
  <p><b>Note:</b> (Applicants need to make a free account with India Macro Advisors (IMA) to be eligible for registration for the business competition)</p>
  <div class="spacer10"></div>
  <div class="sub-title">
    <h5>About India Macro Advisors (IMA)</h5>
    <div class="sttl-line"></div>
  </div>
  <p>India Macro Advisors (IMA) is a macro-economic data portal offering concise and unbiased analysis on the Indian economy.  India Macro Advisors (IMA) is a start-up which is a privately-owned affiliate of the "Japan Macro Advisors Inc" (JMA). We (IMA) aim to keep improving on our service of providing concise analysis and easy access to well-structured macro-economic data since the data on the Indian economy is spread over many government websites in an unstructured format. Further, the Indian economy has always faced a problem of inadequacy of structured and "easy to use" accessible data. We feel that an economy should have an open data policy where the data should be public and easily available. We believe that the access to data should not be available just to corporates, researchers or policy makers, but for everyone in order to facilitate research across various sectors of the Indian economy.</p>
  <p>To know more about IMA and it's services please watch our video <a class="yt_videos" data-toggle="modal" data-target=".jma_modvid">Introduction to IMA</a></p>
  <div class="spacer10"></div>
  <div class="sub-title">
    <h5>About IMA Idea Pitch Competition</h5>
    <div class="sttl-line"></div>
  </div>
  <p>IMA Idea Pitch Competition welcomes ideas and solutions towards specific challenges faced by our organisation This competition is being conducted in collaboration with <a href="http://www.iimidr.ac.in/">Indian Institute of Management (IIM) Indore Mumbai Campus</a>.</p>
  <div class="row">
    <div class="col-sm-9">
      <p>Following are the challenges to which we wish to seek unique and effective ideas:</p>
      <ul class="list-fontawesome im_list">
        <li><i class="fa fa-hand-o-right"></i> Achieving our aforementioned business aim requires some influx of capital, so what is the business model IMA should follow so as to increase its user base as well as generate enough revenues so as to keep providing quality services and continuously upgrading our features for the users? This is to clarify that we want to carry out this work as a business and provide this service as a private entity free from the government control.</li>
        <li><i class="fa fa-hand-o-right"></i> Secondly, another important challenge is to figure out what should be IMA’s strategy moving forward and making people aware about the existence of such a platform?</li>
      </ul>
    </div>
    <div class="col-sm-3">
      <div class="spacer10"></div>
      <img alt="Ideas Pitch" src="<?php echo images_path('IIM_IMA.jpg');?>" alt="team image">
    </div>
  </div>  
  <div class="panel panel-default im_panel">
    <div class="panel-body">
      <p>To understand more about the case study related to the competition please access the document attached below.</p>
      <a class="btn btn-primary" href="<?php echo url('Docs/IMA_Case_Study.pdf');?>" download><i class="fa fa-file-pdf-o"></i> Download IMA Case Study</a> <br>
      <!--<small><b>Note:</b> If we receive registrations/entries fewer than 500 we may revoke the competition.</small>-->
    </div>
  </div>
  <h5>Competition Process:</h5>
  <p>The first round of the competition consists of various teams (max. 3 people per team)/individuals representing various colleges sending out their respective PowerPoint presentations (Max 10 slides including exhibits) and uploading it on our platform using the link given <a class="bg-primary" href="<?php echo url('page/upload_document/');?>">Upload your PPT</a>.</p>
  <p>Please upload your PPT by 1st March 2018.</p>
  <p>All the PPTs will be thoroughly studied and analysed by our economic research team and our founder and CEO Mr. Takuji Okubo. A maximum of 5 ideas will be shortlisted and their names will be put out on our page along with the intimation to the respective groups/individuals via email.</p>
  <p>In the second and final round of the competition the shortlisted applicants will directly have a Skype call with our founder and CEO Mr. Takuji Okubo for a personal Q&A session based on the ideas submitted by them in the previous round.</p>
  <p>Finally, the winner and the first runner up would be announced.</p>
  <div class="spacer10"></div>
  <blockquote class="b-primary">
    <h4>Top 2 teams/individuals will get the following prize money</h4>
    <p><b>Winner:</b>  The winner would receive a sum worth of <span>Rs. 50,000/-</span> and <b> </b> the second best idea will be given a sum worth <span>Rs. 30,000/-</span>. Acknowledgment letters will be provided to the winner and the first runner up.<br></p>
  </blockquote>
  <h5>Important Dates:</h5>
  <ul class="list-unstyled">
    <!--<li><b>Commencement of the event:</b></li>
    <li>Registrations open: 30th November 2017</li>
    <li>Registration closes: 31st January 2018</li>
    <li>Winners to be announced on: To be announced</li>-->
	<li>Registrations are closed.</li>
  </ul>
  <div class="spacer10"></div>
  <?php if(isset($_SESSION['user']) && ($_SESSION['user']['id'] >0) && ($result['check_register_status'] == true)){ ?>
    <p>You can <a class="bg-primary" href="<?php echo url('page/upload_document/');?>">Upload your PPT</a>.</p>
	<p>For additional queries, you can send us an email to <a href="mailto:erteam@indiamacroadvisors.com">erteam@indiamacroadvisors.com</a></p>
  <?php } ?>
  
  <div class="folussoc_con">
    <h5>Share and spread the word about this competition</h5>
		<ul class="list_socail">
			<li class="fs_facebook" data-toggle="tooltip" title="Share&nbsp;on&nbsp;facebook">
				<a href="javascript:void(0)" class="commonShare" link_input_id="common_share_url" stype="facebook">
					<i class="fa fa-facebook" aria-hidden="true"></i>
				</a>
			</li>
			<li class="fs_twitter" data-toggle="tooltip" title="Share&nbsp;on&nbsp;twitter">
				<a href="javascript:void(0)" class="commonShare" link_input_id="common_share_url" stype="twitter">
					<i class="fa fa-twitter" aria-hidden="true"></i>
				</a>
			</li>
			<li class="fs_linkedin" data-toggle="tooltip" title="Share&nbsp;on&nbsp;linkedin">
				<a href="javascript:void(0)" class="commonShare" link_input_id="common_share_url" stype="linkedin">
					<i class="fa fa-linkedin" aria-hidden="true"></i>
				</a>
			</li>
			<input type="hidden" class="graph_share_input form-control" name="common_share_url" id="common_share_url" value="<?php echo 'http://'.$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI'];?>">
		</ul>
  </div>
</div>
@stop