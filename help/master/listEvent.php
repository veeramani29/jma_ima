<?php include('header.php');
function editorfix($value)
{

$order   = array("\\r\\n", "\\n", "\\r", "rn","<p>&nbsp;</p>","\\","\'");
$replace = array(" ", " ", "", "","","","","'");
$value = str_replace($order, $replace, $value); 
return $value;
}
?>

<script>
    function deleteEvent(id){
   var agree=confirm("Are you sure you want to delete?");
  if(agree){
      var url = 'deleteEvent.php?id='+id;
      window.location = url;
  }
  else{
      return false;
  }
}
</script>
<!-- start content -->
<div id="content">

  <!--  start page-heading -->
  <div id="page-heading">
    <h1>Media</h1>
  </div>
  <!-- end page-heading -->

  <table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
  <tr>
    <th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowleft.jpg" width="20" height="300" alt="slider image" /></th>
    <th class="topleft"></th>
    <td id="tbl-border-top">&nbsp;</td>
    <th class="topright"></th>
    <th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowright.jpg" width="20" height="300" alt="slider image" /></th>
  </tr>
  <tr>
    <td id="tbl-border-left"></td>
    <td>
    <!--  start content-table-inner ...................................................................... START -->
    <div id="content-table-inner">
    
      <!--  start table-content  -->
      <div id="table-content">
      
        <!--  start product-table ..................................................................................... -->
        <form id="mainform" action="">
        <table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
        <tr>
          
          <th class="table-header-repeat line-left"><a href="">Id</a> </th>
         <!-- <th class="table-header-repeat line-left"><a href="">Notice</a> </th>
          <th class="table-header-repeat line-left"><a href="">Sort</a> </th> -->
          <th class="table-header-repeat line-left minwidth-1"><a href="">Event Date</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Logo Image</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Event Title</a></th>
                                        <th class="table-header-repeat line-left minwidth-1"><a href="">Event Text</a></th>
                              <th  class="table-header-repeat line-left minwidth-1"><a href="">Event Link</a></th>
                               
                               <th class="table-header-options line-left minwidth-1"><a href="">Is Premium ?</a></th>
                               <th class="table-header-options line-left minwidth-1"><a href="">Status</a></th>
                               <th class="table-header-options line-left minwidth-1"><a href="">Date</a></th>
                              
                    <th class="table-header-options line-left minwidth-1"><a href="">Options</a></th>
        </tr>
                                
                                <?php 
                                  $getEvent = $mediaObj->getEventList();
                                    if(count($getEvent)>0){
                                         for($i=0;$i<count($getEvent);$i++){
                                           $class = '';
                                           if($i%2 == 0){
                                               $class = 'alternate-row';
                                           }
                                           
                                ?>
           
                    
        <tr class="<?php echo $class?>">
          
          <td><?php echo $getEvent[$i]['event_id'];?></td>

          <td><?php echo $getEvent[$i]['event_date'];?></td>
           <td>
                                            <?php if($getEvent[$i]['event_value_img'] != ''){?>
                                            <img src="../public/uploads/media/<?php echo $getEvent[$i]['event_value_img'] ?>" style="height:65px;width:125px" alt="event image"/>
                                            <br/><a  style="color:#959595" href="deleteEventImage.php?id=<?php echo $getEvent[$i]['event_id'] ?>">Delete</a>
                                            <?php } ?>                                        </td>
                                             <td><?php echo $getEvent[$i]['event_title']?></td>
                                        <td><?php echo $getEvent[$i]['event_value_text']; //editorfix($getMedia[$i]['media_value_text'])?></td>
         
          <td ><?php echo $getEvent[$i]['event_link']?></td>
          
            <td><?php echo $getEvent[$i]['premium_user']; ?></td>
           <td><?php echo $getEvent[$i]['status']=='1'?'Active':'Inactive';?></td>
           <td><?php echo  $getEvent[$i]['date']; ?></td>
          
          
                                       
          
         
          <td class="options-width">
          <a href="editevent.php?id=<?php echo $getEvent[$i]['event_id'] ?>" title="Edit" class="icon-1 info-tooltip"></a>
          <a href="#" onclick="deleteEvent('<?php echo $getEvent[$i]['event_id']?>')" title="Delete" class="icon-2 info-tooltip"></a>         </td>
        </tr>
                                <?php
                                       }
                                   }
                                ?>
        </table>
        <!--  end product-table................................... --> 
        </form>
      </div>
      <!--  end content-table  -->
      
      <div class="clear"></div>
     
    </div>
    <!--  end content-table-inner ............................................END  -->
    </td>
    <td id="tbl-border-right"></td>
  </tr>
  <tr>
    <th class="sized bottomleft"></th>
    <td id="tbl-border-bottom">&nbsp;</td>
    <th class="sized bottomright"></th>
  </tr>
  </table>
  <div class="clear">&nbsp;</div>

</div>
<?php include('footer.php');?>
