@extends('templates.default')
@section('content')
<div class="col-xs-12 col-md-10 chabok_lisall" >
  <?php
  $viewAllChartBookSlist = $result['viewChartBookList'];
  $out = "";
  foreach($viewAllChartBookSlist as $key=>$value){
    $datetime = strtotime($value['timestamp']); ?>
    
<?php if(Session::get('user.isAuthor') == "Y"){ ?>
	<div class="sec-date main-title">
      <span class="released"><?php echo date('F d Y h:i',$datetime); ?></span>
      <h1><i class="fa fa-book <?php echo strtolower($value['status']) ?>" id="change_status_icon_<?php echo $value['folder_id']; ?>" aria-hidden="true" data-toggle="modal" data-target="#status_chartbook_forList_<?php echo $value['folder_id']; ?>"></i> <?php echo $value['folder_name']; ?>
	  <i class="fa fa-trash pull-right" aria-hidden="true" data-toggle="modal" data-target="#del_chartbook_forList_<?php echo $value['folder_id']; ?>" ></i></h1>
      <div class="mttl-line"></div>
    </div>
    <p><?php echo $value['folder_desc']; ?></p>
    <div class="text-right marb20">
      <a class="btn btn-primary" href="mycharts/listChartBook/#<?php echo $value['folder_id']; ?>"> View Chart book </a>
    </div>
	
 <?php } else { ?> 

	<?php if($value['status']=='ACTIVE') { ?> 
	
	<div class="sec-date main-title">
      <span class="released"><?php echo date('F d Y h:i',$datetime); ?></span>
      <h1><?php echo $value['folder_name']; ?></h1>
      <div class="mttl-line"></div>
    </div>
    <p><?php echo $value['folder_desc']; ?></p>
    <div class="text-right marb20">
      <a class="btn btn-primary" href="mycharts/listChartBook/#<?php echo $value['folder_id']; ?>"> View Chart book </a>
    </div>
	<?php } ?>
<?php }	?>
	
    <?php } ?>
  </div>
  
              <?php 
			      $out = "";
                  foreach($viewAllChartBookSlist as $key=>$values){
					  
                     $satus = 'ACTIVE';
					 $newStatus = 'ACTIVATE';
					$originalStatus = 'ACTIVE';
					
					if($values['status'] == 'ACTIVE')
					{
						$originalStatus = 'INACTIVE';
						$satus = 'DEACTIVE';
						$newStatus = 'DEACTIVATE';
					}
					
					$out.= ' <div class="modal fade" id="del_chartbook_forList_'.$values['folder_id'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					  <div class="modal-dialog modal-sm" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Delete Chart Book</h4>
						  </div>
						  <div class="modal-body">
							Click on the delete button to delete the chartbook.
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							<button type="button" data-id="'.$values['folder_id'].'" class="btn btn-primary del-chartbook-name">Delete</button>
						  </div>
						</div>
					  </div>
					</div>';
					
					
					
					$out.= ' <div class="modal fade" id="status_chartbook_forList_'.$values['folder_id'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					  <div class="modal-dialog modal-sm" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Status Chart Book</h4>
						  </div>
						  <div class="modal-body">
							Click on the '.$satus.' button to '.$newStatus.' the chartbook.
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							<button type="button" data-id="'.$originalStatus.'-'.$values['folder_id'].'" class="btn btn-primary status-chartbook-name">'.$newStatus.'</button>
						  </div>
						</div>
					  </div>
					</div>';
				  }
				  
				  echo $out;
	          ?>	
@stop			  