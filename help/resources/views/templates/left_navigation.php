<div class="col-xs-12 col-md-2 content_leftside">
  <div class="smacol_leftmenu" role="tablist" aria-multiselectable="true">
    <ul class="menu top notranslate list-unstyled" id="accordion" >
      <?php $chartBook = isset($menu_items['chartBookList'])?$menu_items['chartBookList']:array();
      if(!empty($chartBook)) { ?>
      <li class="menu_group_title list-group-item">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#chart_book" aria-expanded="true" aria-controls="chart_book">
          <i class="fa fa-book" aria-hidden="true"></i> Chart Books
        </a>
        <div id="showViewMoreCBlist">
          <?php if(count($chartBook)>3){ ?>
          <a href="<?php echo url('mycharts/list_chartbook'); ?>" class="cbt_more"><img src="<?php echo images_path('more-list.png');?>"></a>
          <?php } ?>
        </div>
      </li>
      <li id="chart_book" class="chartbook_con collapse in" role="tabpanel" aria-labelledby="chart_book">
        <ul class="list-group list-chartbook" id="list-bookforchart">
          <?php
          if(count($chartBook)>2)
          {
            $chartBook = array_slice($chartBook, 0, 3);
          }
          $out="";
          foreach($chartBook as $keys=>$values)
          {
            $satus = 'ACTIVE';
            $newStatus = 'ACTIVATE';
            $originalStatus = 'ACTIVE';
            if($values['status'] == 'ACTIVE')
            {
              $originalStatus = 'INACTIVE';
              $satus = 'DEACTIVE';
              $newStatus = 'DEACTIVATE';
            }
            $out.= '<li class="submenu_leftside list-group-item newclassforcb"><i id = "change_status_icon_'.$values['folder_id'].'" class="fa fa-book '.strtolower($values['status']).'" aria-hidden="true"  data-toggle="modal" data-target="#status_chartbook_'.$values['folder_id'].'"></i><a data-id="'.$values['folder_id'].'"  href="'.url("mycharts/listChartBook/#".$values['folder_id']).'" class=" content_leftside_parent"><span data-id = "'.$values['folder_id'].'" contenteditable="false">'.$values['folder_name'].'</span></a><i class="fa fa-trash" aria-hidden="true" data-toggle="modal" data-target="#del_chartbook_'.$values['folder_id'].'"></i> </li>';
            $out.= ' <div class="modal fade" id="del_chartbook_'.$values['folder_id'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
            $out.= ' <div class="modal fade" id="status_chartbook_'.$values['folder_id'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
          <li class="cbcadd_book list-group-item" data-toggle="modal" data-target="#modaladd_chaboo">
            <i class="fa fa-plus-square"></i> Add Book
          </li>
        </ul>
      </li>
      <?php } else { if(Session::has('user.isAuthor') && Session::get('user.isAuthor') == "Y") { ?>
      <li class="menu_group_title list-group-item">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#chart_book" aria-expanded="true" aria-controls="chart_book">
          <i class="fa fa-book" aria-hidden="true"></i> Chart Books
        </a>
        <div id="showViewMoreCBlist">
        </div>
      </li>
      <li id="chart_book" class="chartbook_con collapse in" role="tabpanel" aria-labelledby="chart_book">
        <ul class="list-group list-chartbook" id="list-bookforchart">
          <li class="cbcadd_book list-group-item" data-toggle="modal" data-target="#modaladd_chaboo">
            <i class="fa fa-plus-square"></i> Add Book
          </li>
        </ul>
      </li>
      <?php } } ?>
      
      <?php if(isset($menu_items['Normal_left_menu'])) { echo $menu_items['Normal_left_menu']; } ?>
      <?php $showtBookList = isset($menu_items['showtBookList'])?$menu_items['showtBookList']:array();
      if(!empty($showtBookList)) { ?>
      <li class="menu_group_title list-group-item">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#chart_book" aria-expanded="true" aria-controls="chart_book">
          <i class="fa fa-book" aria-hidden="true"></i> Chart Books
        </a>
        <div id="showViewMoreCBlist">
          <?php if(count($showtBookList)>3){ ?>
          <a href="mycharts/list_chartbook" class="cbt_more"><img src="<?php echo images_path('more-list.png');?>"></a>
          <?php } ?>
        </div>
      </li>
      <li id="chart_book" class="chartbook_con collapse in" role="tabpanel" aria-labelledby="chart_book">
        <ul class="list-group">
          <?php
          $out="";
          if(count($showtBookList)>2)
          {
            $showtBookList = array_slice($showtBookList, 0, 3);
          }
          foreach($showtBookList as $keys=>$values)
          {
            $out.= '<li class="submenu_leftside list-group-item"><i class="fa fa-book" aria-hidden="true"></i><a data-id="'.$values['folder_id'].'"  href="'.url("mycharts/listChartBook/#".$values['folder_id']).'" class=" content_leftside_parent">'.$values['folder_name'].'</a></li>';
          }
          echo $out;
          ?>
        </ul>
      </li>
      <?php } ?>
    </ul>
  </div>
</div>
<div class="modal fade" id="del_chartbook" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
        <button type="button" class="btn btn-primary del-chartbook-name">Delete</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="save_chartbook_to_mychart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Chart book added Sucessfully</h4>
      </div>      
      <div class="modal-body">
        You can now view the Chartbook in My Chart.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" language="javascript">
$(document).ready(function()
{
  $('#modaladd_chaboo').on('hidden.bs.modal', function () {
    $(".form-control").val("");
  })
});
</script>
