<ul class="menu top notranslate list-unstyled">
  <li class="sub-menu folders mychart-menu-set">
    <ul class="list-group">
      <li class="menu_group_title list-group-item">
        <i class="fa fa-line-chart"></i> My Charts
      </li>
      <?php echo $this->resultSet['result']['category']['folders'];?>
      <li class="add-folder list-group-item">
        <i class="fa fa-plus-square"></i> Add Folder
      </li>
    </ul>
  </li>
  <?php echo $this->resultSet['result']['category']['menu'] ?>
</ul>