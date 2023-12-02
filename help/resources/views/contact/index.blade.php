@extends('templates.default')
@section('content')
<div class="col-md-10 col-xs-12 conpage_container">
  <div class="main-title">
    <h1>Contact Us</h1>
    <div class="mttl-line"></div>
  </div>
  <h4>General inquiry</h4>
  <p>
    For general inquiry, please send e-mail to 
    <a href="mailto:<?=GENERAL_EMAIL;?>"><?=GENERAL_EMAIL;?></a>
  </p>
  <p>
    For technical assistance and subscription inquiry, please send e-mail to 
    <a href="mailto:<?=SUPPORT_EMAIL;?>"><?=SUPPORT_EMAIL;?></a>
  </p>
 
</div>
@stop