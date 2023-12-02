 <!-- theme switcher -->
    <div id="switcher">
      <div class="switcher box-color dark-white text-color" id="sw-theme">
        <a  ui-toggle-class="active" target="#sw-theme" class="box-color dark-white text-color sw-btn">
          <i class="fa fa-gear"></i>
        </a>
       
        <div class="box-header">
          <h2>Theme Switcher</h2>
        </div>
        <div class="box-divider"></div>
        <div class="box-body">
          <p class="hidden-md-down">
            <label class="md-check m-y-xs"  data-target="folded">
              <input type="checkbox">
              <i class="green"></i>
              <span class="hidden-folded">Folded Aside</span>
            </label>
            <label class="md-check m-y-xs" data-target="boxed">
              <input type="checkbox">
              <i class="green"></i>
              <span class="hidden-folded">Boxed Layout</span>
            </label>
          </p>
          <p>Colors:</p>
          <p data-target="themeID">
            <label class="radio radio-inline m-a-0 ui-check ui-check-color ui-check-md" data-value="{primary:'primary', accent:'accent', warn:'warn'}">
              <input type="radio" name="color" value="1">
              <i class="primary"></i>
            </label>
            <label class="radio radio-inline m-a-0 ui-check ui-check-color ui-check-md" data-value="{primary:'accent', accent:'cyan', warn:'warn'}">
              <input type="radio" name="color" value="2">
              <i class="accent"></i>
            </label>
            <label class="radio radio-inline m-a-0 ui-check ui-check-color ui-check-md" data-value="{primary:'warn', accent:'light-blue', warn:'warning'}">
              <input type="radio" name="color" value="3">
              <i class="warn"></i>
            </label>
            <label class="radio radio-inline m-a-0 ui-check ui-check-color ui-check-md" data-value="{primary:'success', accent:'teal', warn:'lime'}">
              <input type="radio" name="color" value="4">
              <i class="success"></i>
            </label>
            <label class="radio radio-inline m-a-0 ui-check ui-check-color ui-check-md" data-value="{primary:'info', accent:'light-blue', warn:'success'}">
              <input type="radio" name="color" value="5">
              <i class="info"></i>
            </label>
            <label class="radio radio-inline m-a-0 ui-check ui-check-color ui-check-md" data-value="{primary:'blue', accent:'indigo', warn:'primary'}">
              <input type="radio" name="color" value="6">
              <i class="blue"></i>
            </label>
            <label class="radio radio-inline m-a-0 ui-check ui-check-color ui-check-md" data-value="{primary:'warning', accent:'grey-100', warn:'success'}">
              <input type="radio" name="color" value="7">
              <i class="warning"></i>
            </label>
            <label class="radio radio-inline m-a-0 ui-check ui-check-color ui-check-md" data-value="{primary:'danger', accent:'grey-100', warn:'grey-300'}">
              <input type="radio" name="color" value="8">
              <i class="danger"></i>
            </label>
          </p>
          <p>Themes:</p>
          <div data-target="bg" class="text-u-c text-center _600 clearfix">
            <label class="p-a col-xs-6 light pointer m-a-0">
              <input type="radio" name="theme" value="" hidden>
              Light
            </label>
            <label class="p-a col-xs-6 grey pointer m-a-0">
              <input type="radio" name="theme" value="grey" hidden>
              Grey
            </label>
            <label class="p-a col-xs-6 dark pointer m-a-0">
              <input type="radio" name="theme" value="dark" hidden>
              Dark
            </label>
            <label class="p-a col-xs-6 black pointer m-a-0">
              <input type="radio" name="theme" value="black" hidden>
              Black
            </label>
          </div>
        </div>
      </div>
      <div class="switcher box-color black lt" id="sw-demo">
        <a  ui-toggle-class="active" target="#sw-demo" class="box-color black lt text-color sw-btn">
          <i class="fa fa-list text-white"></i>
        </a>
        <div class="box-header">
          <h2>Demos</h2>
        </div>
        <div class="box-divider"></div>
        <div class="box-body">
          <div class="text-u-c text-center _600 clearfix">
            <a href="dashboard.html" class="p-a col-xs-6 primary">
              <span class="text-white">Default</span>
            </a>
            <a href="dashboard.0.html" class="p-a col-xs-6 success">
              <span class="text-white">Zero</span>
            </a>
            <a href="dashboard.1.html" class="p-a col-xs-6 blue">
              <span class="text-white">One</span>
            </a>
            <a href="dashboard.2.html" class="p-a col-xs-6 warn">
              <span class="text-white">Two</span>
            </a>
            <a href="dashboard.3.html" class="p-a col-xs-6 danger">
              <span class="text-white">Three</span>
            </a>
            <a href="dashboard.4.html" class="p-a col-xs-6 green">
              <span class="text-white">Four</span>
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- / -->
    <!-- ############ LAYOUT END-->
  </div>



  <!-- build:js <?php echo SCRIPTS;?>app.html.js -->
  <!-- jQuery -->
  <script src="<?php echo JS;?>jquery/jquery/dist/jquery.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <!-- Bootstrap -->
  <script src="<?php echo JS;?>jquery/tether/dist/js/tether.min.js"></script>
  <script src="<?php echo JS;?>jquery/bootstrap/dist/js/bootstrap.js"></script>
  <!-- core -->
  <script src="<?php echo JS;?>jquery/underscore/underscore-min.js"></script>
  <script src="<?php echo JS;?>jquery/jQuery-Storage-API/jquery.storageapi.min.js"></script>
  <script src="<?php echo JS;?>jquery/PACE/pace.min.js"></script>
  <script src="<?php echo SCRIPTS;?>config.lazyload.js"></script>
  <script src="<?php echo SCRIPTS;?>palette.js"></script>
  <script src="<?php echo SCRIPTS;?>ui-load.js"></script>
  <script src="<?php echo SCRIPTS;?>ui-jp.js"></script>
  <script src="<?php echo SCRIPTS;?>ui-include.js"></script>
  <script src="<?php echo SCRIPTS;?>ui-device.js"></script>
  <script src="<?php echo SCRIPTS;?>ui-form.js"></script>
  <script src="<?php echo SCRIPTS;?>ui-nav.js"></script>
  <script src="<?php echo SCRIPTS;?>ui-screenfull.js"></script>
  <script src="<?php echo SCRIPTS;?>ui-scroll-to.js"></script>
  <script src="<?php echo SCRIPTS;?>ui-toggle-class.js"></script>
  <script src="<?php echo SCRIPTS;?>app.js"></script>
  <!-- ajax -->
  <script src="<?php echo JS;?>jquery/jquery-pjax/jquery.pjax.js"></script>
  <script src="<?php echo SCRIPTS;?>ajax.js"></script>
  <!-- endbuild -->


  <script>

 $('table td').on('click',"a.label-success",function(){
   event.preventDefault();
      var currel=$(this);
     var inactiveurl=$(this).attr("href");
    var curTr=$(this).parents("tr");
  
 
 if(confirm('Are you sure want to inactive this?')){
  curTr.fadeIn(function(){ 

      $.ajax({
            type: 'POST',
            url: inactiveurl,
            //async: true,
            //dataType: 'json',
           // data: data,
            success: function() {
               
              currel.removeClass('label-success');
             currel.addClass('label-danger');
              currel.text('Inactive');
      var newurl=inactiveurl.replace("inactive", "active");

      currel.attr('href',newurl);
        $('#alertMsg').parent('div').removeClass('hide');
      $('#alertMsg').parent('div').show();
$('#alertMsg').html('Selected items are activated');
            }
          });
        


       });
        }
  
    
    return false;
  });

 $('table td').on('click',"a.label-danger",function(){
   event.preventDefault();
  var currel=$(this);
     var activeurl=$(this).attr("href");
      var curTr=$(this).parents("tr");
      if(confirm('Are you sure you want to active this?')) {
       
       
  curTr.fadeIn(function(){ 
      $.ajax({
            type: 'POST',
            url: activeurl,
            //async: true,
            //dataType: 'json',
           // data: data,
            success: function() {
             
              currel.removeClass('label-danger');
             currel.addClass('label-success');
              currel.text('Active');
      var newurl=activeurl.replace("active", "inactive");
     
      currel.attr('href',newurl);
        $('#alertMsg').parent('div').removeClass('hide');
       $('#alertMsg').parent('div').show();
    $('#alertMsg').html('Selected items are inactivated');
            }
          });
     
        
 });

       }
    
    return false;
  });

 $('table td').on('click',"a.view-model",function(){
    $('#m-a-a div.modal-body').html('');
    $('#m-a-a div.modal-body').empty();
    var Href=$(this).parents("tr").find('a.edit').attr('href');
  

$.ajax({
      type: "POST",
      url: WEB_URL+'tariffs/view',
      data: { ID : $(this).data('vid')  },
      dataType: "json",
      success: function(data){
        if(data!=''){
        
        $('#m-a-a a.p-x-md').attr('href',Href);
        $('#m-a-a div.modal-body').html(data);
        $('#m-a-a').modal('show');
     
        }else{
       
        }
      }
    });
 });
</script>
</body>
</html>