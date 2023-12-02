<?php 
//echo '<pre>';
//print_r($this->resultSet['result']['category']['nonpremium']);
//strtolower($str)
?>




<style>
/*
		.clearbutton {

	
				}
		.clearbutton:hover {
	
				}
		.clearbutton:active {
			position:relative;
			top:1px;
			}*/
		/*.myButton {
			width:90px;
			height:30px;
			background-color:#2884cc;
			color:#FFF;
			font-weight:bold;
	
	
	
			}*/
		.form_submit_btn {
    background: none repeat scroll 0 0 #2884CD;
    border: medium none;
    color: #FFFFFF;
    cursor: pointer;
    font-family: arimo;
    font-size: 12px;
    font-weight: bold;
    text-align: center;
	height:30px;
	width:90px;
	margin-right:100px;
}

	#first,#second,#id,.form-group3,.form-group1,.form-group2,.form-group4{

			display: inline-block;
			vertical-align: top;
			padding-left:10px;

			}
		#a, #b, #c, #d{
			width:75px;
			height:20px;
			box-shadow:inset 0 1px 1px #BFBFBF;
            background: #fff;
			
			}
		#second{
			line-height:35px;
			}

		.form-group{
			display: inline-flex;
		
			}
			
			
.tg  
{border-collapse:collapse;border-spacing:0;border-color:#ccc; width:360px; height:310px; margin-top:-5px;}

.tg td
{font-family:arimo;font-size:10px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff; padding:4px;}
.tg th
{font-family:Arimo;font-size:10px;font-weight:bold;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0;}
.tg .tg-jgzc
{background-color:#f7f7f7;color:#333333;text-align:center}

</style>
			
 	<script>

		$("#myform").live( "submit" , function(){

    	// Intercept the form submission

    	var formdata = $(this).serialize(); // Serialize all form data

    	// Post data to your PHP processing script

    	$.post( JMA.baseURL+"tools/topic_calculate", formdata, function( data ) {

        // Act upon the data returned, setting it to #success <div>

        $("#resulting").html ( data );

    	});

    	return false; // Prevent the form from actually submitting

		});

	</script>



		<div style="margin-left:180px; padding-top:1px;">
		<div class="col-md-9">
			<a style="font-family:PT Serif; font-size:35px;margin-left:10px;">JMA Topix Model</a>
		</div>

		<div style="font-family:droid serif" class="col-md-9">
			<p style="font-family:droid serif; font-size:14px;margin-left:10px;">Objective of the model is to estimate the expected Topix by using only the fundamental economic variables</p>
		</div>


		<div style="background-color:#ffffff; height:auto; padding-top:3px;">
       

		
         
        <!-- Calculator part begins -->
        <div>
        <h2 style="font-family:arimo; font-size:18px;background-color:#575757;width:158px;height:30px;color:#ffffff;text-align:center;margin-bottom:0px;padding-top:6px;  padding-left:4px;margin-left:10px;">Topix Calculator</h2>
		
        <div style="font-family:Arimo bold; font-size:18px;" id="first" align="left">
        
        
        
		<div style="width:350px; height:310px; background-color:#F9FBF6; text-align:right; box-shadow:4px 3px 0px #CECECE;border:1px solid #B0B5B9;" id="second">
    		<h4> <div style="font-family:arimo; font-size:14px; padding-right:140px;margin-bottom: -16px;" >INPUT</h4>


			<form class="form-horizontal" role="form" id="myform" method="post" action="topic_calculate">



		<div style="font-family:arimo; font-size:12px;padding-right:75px; line-height:15px;padding-bottom:10px;" class="">
        	<label for="text" id="text" class="form-group1 " value="<?php if(isset($_POST)&&!empty($_POST))echo htmlspecialchars($_POST['a']); ?>">US Nominal<br /> GDP growth rate:</label>
		<div class="form-group1">
             <input type="text" name="a" id="a" class="form-group1 form-control list-inline" placeholder="0" >
        </div>
            % &nbsp;&nbsp;
        </div>
        
        
        <div style="font-family:arimo; font-size:12px; padding-right:75px; line-height:15px;padding-bottom:10px;" class="">

        	<label for="text" id="text" class="form-group2 col-sm-6 control-label" value="<?php if(isset($_POST)&&!empty($_POST))echo htmlspecialchars($_POST['b']); ?>">Japan Nominal <br />GDP growth rate:</label>

         <div class="form-group2">

                <input type="text" name="b" id="b" class="form-group2 form-control" placeholder="0"  >

         </div>
            % &nbsp;&nbsp;

        </div>



        <div style="font-family:arimo; font-size:12px; padding-right:75px;line-height:20px;padding-bottom:10px;" class="">



        	<label for="text" id="text" class="form-group3 col-sm-6 control-label" value="<?php if(isset($_POST)&&!empty($_POST))echo htmlspecialchars($_POST['c']); ?>">JGB 10 year rate:</label>



          <div class="form-group3">

            <input type="text" name="c" id="c" class="form-group3 form-control" placeholder="0"  >

            </div> 
            % &nbsp;&nbsp;

        </div>

        <div style="font-family:arimo; font-size:12px; padding-right:89px;line-height:15px;padding-bottom:10px;" class="">

        <label for="text" id="text" class="form-group4 col-sm-6 control-label" value="<?php if(isset($_POST)&&!empty($_POST))echo htmlspecialchars($_POST['d']); ?>"> USD/JPY <br />Exchange rate:</label>

            <div class="form-group4 col-sm-4"> 
 
                <input type="text" name="d" id="d" class="form-group4 form-control" placeholder="0" >

            </div> 
            &yen; 
        </div>

        <div style="font-family:droid serif" class="form-group">
            <div >
            <button type="submit" class="form_submit_btn">Compute</button>
            </div></div>
            <!--<div align="right">

         <button class="clearbutton" id="clearing" type="reset">Reset</button>
        	</div>-->
            <div id="third" style="font-family:arimo; text-align:left; margin-left:35px; font-size:14px; margin-top:-15px;">
    <div id="result"><h3>RESULT</h3>
   

    <div style="font-family:arimo;  height:auto; text-align:left; margin-left:40px; font-size:14px; margin-top:-25px;" id="resulting">        	
        <label for="inputPassword3" class="col-sm-10 control-label">Topix :</label>
 </div>
    </div> </div>
        
        
        
    </form>
    </div>	
          <!-- Calculator part Ends -->  
            <!--
            <h2 style="font-family:arimo; font-size:18px; padding-top:30px; margin-bottom:-8px;">Topix Graph</h2>
    		<p><img border="0" src="<?php //echo $this->images; ?>tools/topixgraph.jpg" alt="Topix graph" width="360" height="220"></p> </p>-->
          	
    	</div>

<!-- Historical Data part begins -->
<div style="float: right; margin-top:-46px;padding-right:30px;">
	  <h2 style="font-family:arimo; font-size:18px;">Historical Data</h2>
     		<table class="tg">
  <tr>
    <th class="tg-jgzc"></th>
    <th class="tg-jgzc">US Nominal<br>GDP growth rate<br></th>
    <th class="tg-jgzc">Japan Nominal<br>GDP growth rate<br></th>
    <th class="tg-jgzc"><br>JGB 10yr rate<br></th>
    <th class="tg-jgzc">USD/JPY<br>Exchange rate<br></th>
  </tr>
  <tr style="height:1px">
    <td class="tg-jgzc" >2002</td>
    <td class="tg-jgzc">3.3</td>
    <td class="tg-jgzc">-1.3</td>
    <td class="tg-jgzc">1.3</td>
    <td class="tg-jgzc">125</td>
  </tr>
  <tr>
    <td class="tg-jgzc">2003</td>
    <td class="tg-jgzc">4.8</td>
    <td class="tg-jgzc">-0.1</td>
    <td class="tg-jgzc">1.0</td>
    <td class="tg-jgzc">116</td>
  </tr>
  <tr>
    <td class="tg-jgzc">2004</td>
    <td class="tg-jgzc">6.6</td>
    <td class="tg-jgzc">1.0</td>
    <td class="tg-jgzc">1.5</td>
    <td class="tg-jgzc">108</td>
  </tr>
  <tr>
    <td class="tg-jgzc">2005</td>
    <td class="tg-jgzc">6.7</td>
    <td class="tg-jgzc">0.0</td>
    <td class="tg-jgzc">1.4</td>
    <td class="tg-jgzc">110</td>
  </tr>
  <tr>
    <td class="tg-jgzc">2006</td>
    <td class="tg-jgzc">5.8</td>
    <td class="tg-jgzc">0.5</td>
    <td class="tg-jgzc">1.7</td>
    <td class="tg-jgzc">116</td>
  </tr>
  <tr>
    <td class="tg-jgzc">2007</td>
    <td class="tg-jgzc">4.5</td>
    <td class="tg-jgzc">1.3</td>
    <td class="tg-jgzc">1.7</td>
    <td class="tg-jgzc">118</td>
  </tr>
  <tr>
    <td class="tg-jgzc">2008</td>
    <td class="tg-jgzc">1.7</td>
    <td class="tg-jgzc">-2.3</td>
    <td class="tg-jgzc">1.5</td>
    <td class="tg-jgzc">103</td>
  </tr>
  <tr>
    <td class="tg-jgzc">2009</td>
    <td class="tg-jgzc">-2.1</td>
    <td class="tg-jgzc">-6.0</td>
    <td class="tg-jgzc">1.4</td>
    <td class="tg-jgzc">94</td>
  </tr>
  <tr>
    <td class="tg-jgzc">2010</td>
    <td class="tg-jgzc">3.7</td>
    <td class="tg-jgzc">2.4</td>
    <td class="tg-jgzc">1.2</td>
    <td class="tg-jgzc">88</td>
  </tr>
  <tr>
    <td class="tg-jgzc">2011</td>
    <td class="tg-jgzc">3.8</td>
    <td class="tg-jgzc">-2.3</td>
    <td class="tg-jgzc">1.1</td>
    <td class="tg-jgzc">80</td>
  </tr>
  <tr>
    <td class="tg-jgzc">2012</td>
    <td class="tg-jgzc">4.6</td>
    <td class="tg-jgzc">0.5</td>
    <td class="tg-jgzc">0.9</td>
    <td class="tg-jgzc">80</td>
  </tr>
  <tr>
    <td class="tg-jgzc">2013</td>
    <td class="tg-jgzc">3.4</td>
    <td class="tg-jgzc">1.0</td>
    <td class="tg-jgzc">0.7</td>
    <td class="tg-jgzc">98</td>
  </tr>
</table>

</div>
    <!-- Historical Data part Ends -->
   
</div>
</div>  
<div style="margin-left:10px; margin-top:30px;">            
<p style="font-family:arimo; font-size:12px; word-spacing:-1px;">For the methodology and estimation details of our Topix model,<a style="padding-left:10px; font-family:arimo; font-size:12px; color:#0F759F; font-weight:bold"  href="<?php echo $this->images; ?>tools/topix-model-explanation.pdf" target="_blank">click here</a>&nbsp; </p></div>
</div>

<div style="height:50px;">&nbsp;&nbsp;&nbsp;
</div>

<script type="text/javascript">

$('#clearing').click(function(){

			 $(':input','#myform')
			.not(':button, :submit, :reset, :hidden')
			.val('')
			.removeAttr('checked')
			.removeAttr('selected');
});
</script>