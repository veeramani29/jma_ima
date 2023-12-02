@extends('templates.default')
@section('content')
<?php ?>
<style>
.content_leftside{display: none;}
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
<div class="col-xs-12">
  <div class="main-title">
    <h1>JMA Topix Model</h1>
    <div class="mttl-line"></div>
  </div>
  <p>Objective of the model is to estimate the expected Topix by using only the fundamental economic variables</p>
  <div class="row">
    <div class="col-md-5">
      <div class="sub-title">
        <h5>Topix Calculator</h5>
        <div class="sttl-line"></div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">Calculator</div>
        <div class="panel-body">
          <form role="form" id="myform" method="post" action="topic_calculate">
            <div class="form-group">
              <label for="text" id="text" value="<?php if(isset($_POST)&&!empty($_POST))echo htmlspecialchars($_POST['a']); ?>">US Nominal GDP growth rate:</label>
              <div class="input-group">
                <input type="text" name="a" id="a" class="form-control" placeholder="0">
                <div class="input-group-addon">%</div>
              </div>
            </div>
            <div class="form-group">
              <label for="text" id="text" value="<?php if(isset($_POST)&&!empty($_POST))echo htmlspecialchars($_POST['b']); ?>">Japan Nominal GDP growth rate:</label>
              <div class="input-group">
                <input type="text" name="b" id="b" class="form-control" placeholder="0">
                <div class="input-group-addon">%</div>
              </div>
            </div>
            <div class="form-group">
              <label for="text" id="text" value="<?php if(isset($_POST)&&!empty($_POST))echo htmlspecialchars($_POST['c']); ?>">JGB 10 year rate:</label>
              <div class="input-group">
                <input type="text" name="c" id="c" class="form-control" placeholder="0">
                <div class="input-group-addon">%</div>
              </div>
            </div>
            <div class="form-group">
              <label for="text" id="text" value="<?php if(isset($_POST)&&!empty($_POST))echo htmlspecialchars($_POST['d']); ?>">USD/JPY Exchange rate:</label>
              <div class="input-group">
                <input type="text" name="d" id="d" class="form-control" placeholder="0">
                <div class="input-group-addon">&yen;</div>
              </div>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Compute</button>
            </div>
            <div class="spacer10"></div>
            <div id="third">
              <div id="result">
                <ul class="list-inline">
                  <li><h5>Total Topix :</h5></li>
                  <li>
                    <div id="resulting">
                      <label for="inputPassword3"></label>
                    </div>
                  </li>
                </ul>
              </div> 
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-7">
      <div class="sub-title">
        <h5>Historical Data</h5>
        <div class="sttl-line"></div>
      </div>
      <table class="table table-striped table-bordered">
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
  </div>
</div>
<div class="col-xs-12">
  <p>For the methodology and estimation details of our Topix model, <a href="<?php echo images_path('tools/topix-model-explanation.pdf'); ?>" target="_blank">click here</a></p>
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
@stop