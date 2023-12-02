       <!--header-->
   <?php //$this->load->view('header');?>
   <!--header-->
     <!--leftmenu-->
   <?php $this->load->view('leftmenu');?>
   <!--leftmenu-->
 <!-- content -->
    <div id="content" class="app-content box-shadow-z0" role="main">
      
          <!--app footer-->
   <?php $this->load->view('a');?>
   <!--app footer-->
      <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="p-a white lt box-shadow">
          <div class="row">
            <div class="col-sm-6">
              <h4 class="m-b-0 _300">Welcome to BluStars</h4>
              <small class="text-muted">Bootstrap <strong>4</strong> Web App Kit with AngularJS</small>
            </div>
            <div class="col-sm-6 text-sm-right">
              <div class="m-y-sm">
                <span class="m-r-sm">Start Overview:</span>
                <div class="btn-group dropdown">
                  <button class="btn white btn-sm "><?php echo PROJECT_NAME;?></button>
                  <button class="btn white btn-sm dropdown-toggle" data-toggle="dropdown"></button>
                  <div class="dropdown-menu dropdown-menu-scale pull-right">
                    <a class="dropdown-item" href>Members</a>
                    <a class="dropdown-item" href>Tasks</a>
                    <a class="dropdown-item" href>Inbox</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item">Profile</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="padding">
          <div class="row">
            <div class="col-xs-12 col-sm-4">
              <div class="box p-a">
                <div class="pull-left m-r">
                  <span class="w-48 rounded  accent">
                    <i class="material-icons">directions_car</i>
                  </span>
                </div>
                <div class="clear">
                  <h4 class="m-a-0 text-lg _300"><a href>125 <span class="text-sm">Drivers</span></a></h4>
                  <small class="text-muted">6 new drivers.</small>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-4">
              <div class="box p-a">
                <div class="pull-left m-r">
                  <span class="w-48 rounded primary">
                    <i class="material-icons">directions_car</i>
                  </span>
                </div>
                <div class="clear">
                  <h4 class="m-a-0 text-lg _300"><a href>40 <span class="text-sm">Drivers Available</span></a></h4>
                  <small class="text-muted">38 open.</small>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-4">
              <div class="box p-a">
                <div class="pull-left m-r">
                  <span class="w-48 rounded warn">
                    <i class="material-icons">insert_drive_file</i>
                  </span>
                </div>
                <div class="clear">
                  <h4 class="m-a-0 text-lg _300"><a href>70 <span class="text-sm">Invoices Today</span></a></h4>
                  <small class="text-muted">75 trips.</small>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6 col-md-4">
              <div class="box">
                <div class="box-header">
                  <h3>Trip Status</h3>
                  <small>Calculated in last 30 days</small>
                </div>
                <div class="box-tool">
                  <ul class="nav">
                    <li class="nav-item inline">
                      <a class="nav-link">
                        <i class="material-icons md-18">&#xe863;</i>
                      </a>
                    </li>
                    <li class="nav-item inline dropdown">
                      <a class="nav-link" data-toggle="dropdown">
                        <i class="material-icons md-18">&#xe5d4;</i>
                      </a>
                      <div class="dropdown-menu dropdown-menu-scale pull-right">
                        <a class="dropdown-item" href>This week</a>
                        <a class="dropdown-item" href>This month</a>
                        <a class="dropdown-item" href>This week</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item">Today</a>
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="box-body">
                  <div class="text-center m-b">
                    <div class="btn-group" data-toggle="buttons">
                      <label class="btn btn-sm white">
                        <input type="radio" name="options" autocomplete="off"> Month
                      </label>
                      <label class="btn btn-sm white">
                        <input type="radio" name="options" autocomplete="off"> Day
                      </label>
                    </div>
                  </div>
                  <div ui-jp="plot" ui-refresh="app.setting.color" ui-options="[{ data: [[1, 3.6], [2, 3.5], [3, 6], [4, 4], [5, 4.3], [6, 3.5], [7, 3.6]], points: { show: true, radius: 0}, splines: { show: true, tension: 0.45, lineWidth: 2, fill: 1 } }, { data: [[1, 3], [2, 2.6], [3, 3.2], [4, 3], [5, 3.5], [6, 3], [7, 3.5]], points: { show: true, radius: 0}, splines: { show: true, tension: 0.45, lineWidth: 2, fill: 1 } }, { data: [[1, 2], [2, 1.6], [3, 2.4], [4, 2.1], [5, 1.7], [6, 1.5], [7, 1.7]], points: { show: true, radius: 0}, splines: { show: true, tension: 0.45, lineWidth: 2, fill: 1 } } ], {colors: ['#a88add','#0cc2aa','#fcc100'], series: { shadowSize: 3 }, xaxis: { show: true, font: { color: '#ccc' }, position: 'bottom' }, yaxis:{ show: true, font: { color: '#ccc' }}, grid: { hoverable: true, clickable: true, borderWidth: 0, color: 'rgba(120,120,120,0.5)' }, tooltip: true, tooltipOpts: { content: '%x.0 is %y.4',  defaultTheme: false, shifts: { x: 0, y: -40 } } } " style="height:188px" >
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-md-4">
              <div class="box">
                <div class="box-header">
                  <h3>Invoices / Vouchers</h3>
                  <small>Calculated in last 7 days</small>
                </div>
                <div class="box-tool">
                  <ul class="nav">
                    <li class="nav-item inline">
                      <a class="nav-link">
                        <i class="material-icons md-18">&#xe863;</i>
                      </a>
                    </li>
                    <li class="nav-item inline dropdown">
                      <a class="nav-link" data-toggle="dropdown">
                        <i class="material-icons md-18">&#xe5d4;</i>
                      </a>
                      <div class="dropdown-menu dropdown-menu-scale pull-right">
                        <a class="dropdown-item" href>This week</a>
                        <a class="dropdown-item" href>This month</a>
                        <a class="dropdown-item" href>This week</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item">Today</a>
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="box-body">
                  <div class="text-center m-b">
                    <div class="btn-group" data-toggle="buttons">
                      <label class="btn btn-sm rounded white">
                        <input type="radio" name="options" autocomplete="off"> This Month
                      </label>
                      <label class="btn btn-sm rounded white">
                        <input type="radio" name="options" autocomplete="off"> This Week
                      </label>
                    </div>
                  </div>
                  <div ui-jp="plot" ui-refresh="app.setting.color" ui-options="[{ data: [[1, 2], [2, 4], [3, 5], [4, 7], [5, 6], [6, 4], [7, 5], [8, 4]] } ], {bars: { show: true, fill: true,  barWidth: 0.25, lineWidth: 1, fillColor: { colors: [{ opacity: 0.8 }, { opacity: 1}] }, align: 'center' }, colors: ['#a88add'], series: { shadowSize: 3 }, xaxis: { show: true, font: { color: '#ccc' }, position: 'bottom' }, yaxis:{ show: true, font: { color: '#ccc' }}, grid: { hoverable: true, clickable: true, borderWidth: 0, color: 'rgba(120,120,120,0.5)' }, tooltip: true, tooltipOpts: { content: '%x.0 is %y.4',  defaultTheme: false, shifts: { x: 0, y: -40 } } } " style="height:188px" >
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12 col-md-4">
              <div class="box">
                <div class="box-header">
                  <h3>Revenue</h3>
                  <small>Calculated in last 7 days</small>
                </div>
                <div class="box-tool">
                  <ul class="nav">
                    <li class="nav-item inline">
                      <a class="nav-link">
                        <i class="material-icons md-18">&#xe863;</i>
                      </a>
                    </li>
                    <li class="nav-item inline dropdown">
                      <a class="nav-link" data-toggle="dropdown">
                        <i class="material-icons md-18">&#xe5d4;</i>
                      </a>
                      <div class="dropdown-menu dropdown-menu-scale pull-right">
                        <a class="dropdown-item" href>This week</a>
                        <a class="dropdown-item" href>This month</a>
                        <a class="dropdown-item" href>This week</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item">Today</a>
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="box-body">
                  <div class="text-center m-b">
                    <div class="btn-group" data-toggle="buttons">
                      <label class="btn btn-sm rounded white">
                        <input type="radio" name="options" autocomplete="off"> This Month
                      </label>
                      <label class="btn btn-sm rounded white">
                        <input type="radio" name="options" autocomplete="off"> This Week
                      </label>
                    </div>
                  </div>
                  <div ui-jp="plot" ui-refresh="app.setting.color" ui-options="[{ data: [[3, 1], [2, 2], [6, 3], [5, 4], [7, 5]] } ], {bars: { horizontal: true, show: true, fill: true,  barWidth: 0.3, lineWidth: 1, fillColor: { colors: [{ opacity: 0.8 }, { opacity: 1}] }, align: 'center' }, colors: ['#0cc2aa'], series: { shadowSize: 3 }, xaxis: { show: true, font: { color: '#ccc' }, position: 'bottom' }, yaxis:{ show: true, font: { color: '#ccc' }}, grid: { hoverable: true, clickable: true, borderWidth: 0, color: 'rgba(120,120,120,0.5)' }, tooltip: true, tooltipOpts: { content: '%x.0 is %y.4',  defaultTheme: false, shifts: { x: 0, y: -40 } } } " style="height:188px" >
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <div class="box">
                <div class="box-header">
                  <h3>Completed Trips <span class="label warning">9</span></h3>
                  <small>Your data status</small>
                </div>
                <div class="box-tool">
                  <ul class="nav">
                    <li class="nav-item inline">
                      <a class="nav-link">
                        <i class="material-icons md-18">&#xe863;</i>
                      </a>
                    </li>
                    <li class="nav-item inline dropdown">
                      <a class="nav-link" data-toggle="dropdown">
                        <i class="material-icons md-18">&#xe5d4;</i>
                      </a>
                      <div class="dropdown-menu dropdown-menu-scale pull-right">
                        <a class="dropdown-item" href>This week</a>
                        <a class="dropdown-item" href>This month</a>
                        <a class="dropdown-item" href>This week</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item">Today</a>
                      </div>
                    </li>
                  </ul>
                </div>
                <ul class="list inset">
                  <li class="list-item">
                    <a herf class="list-left">
                      <span class="w-40 avatar">
                        <img src="<?php echo IMAGES;?>a4.jpg" alt="...">
                      </span>
                    </a>
                    <div class="list-body">
                      <div><a href>Driver Name, Vehicle Number</a></div>
                      <div class="text-sm">
                        <span class="text-muted"><strong>10</strong> tasks, <strong>7</strong> Trips</span>
                        <span class="label"></span>
                      </div>
                    </div>
                  </li>
                  <li class="list-item">
                    <a herf class="list-left">
                      <span class="w-40 avatar">
                        <img src="<?php echo IMAGES;?>a2.jpg" alt="...">
                      </span>
                    </a>
                    <div class="list-body">
                      <div><a href>Driver Name, Vehicle Number</a></div>
                      <div class="text-sm">
                        <span class="text-muted"><strong>15</strong> tasks, <strong>10</strong> Trips</span>
                        <span class="label"></span>
                      </div>
                    </div>
                  </li>
                  <li class="list-item">
                    <a herf class="list-left">
                      <span class="w-40 avatar">
                        <img src="<?php echo IMAGES;?>a5.jpg" alt="...">
                      </span>
                    </a>
                    <div class="list-body">
                      <div><a href>Driver Name, Vehicle Number</a></div>
                      <div class="text-sm">
                        <span class="text-muted"><strong>9</strong> tasks, <strong>3</strong> Trips</span>
                        <span class="label"></span>
                      </div>
                    </div>
                  </li>
                  <li class="list-item">
                    <a herf class="list-left">
                      <span class="w-40 avatar">
                        <img src="<?php echo IMAGES;?>a6.jpg" alt="...">
                      </span>
                    </a>
                    <div class="list-body">
                      <div><a href>Driver Name, Vehicle Number</a></div>
                      <div class="text-sm">
                        <span class="text-muted"><strong>25</strong> tasks, <strong>25</strong> Trips</span>
                        <span class="label"></span>
                      </div>
                    </div>
                  </li>
                </ul>
                <div class="box-footer">
                  <a href class="btn btn-sm white text-u-c">More</a>
                </div>
              </div>
            </div>
            <div class="col-sm-12 col-md-6">
              <div class="box">
                <div class="box-header">
                  <h3>Company Trips</h3>
                  <small>Your data status</small>
                </div>
                <div class="box-tool">
                  <ul class="nav">
                    <li class="nav-item inline">
                      <a class="nav-link">
                        <i class="material-icons md-18">&#xe863;</i>
                      </a>
                    </li>
                    <li class="nav-item inline dropdown">
                      <a class="nav-link" data-toggle="dropdown">
                        <i class="material-icons md-18">&#xe5d4;</i>
                      </a>
                      <div class="dropdown-menu dropdown-menu-scale pull-right">
                        <a class="dropdown-item" href>This week</a>
                        <a class="dropdown-item" href>This month</a>
                        <a class="dropdown-item" href>This week</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item">Today</a>
                      </div>
                    </li>
                  </ul>
                </div>
                <ul class="list inset">
                  <li class="list-item">
                    <a herf class="list-left">
                      <span class="w-40 avatar">
                        <img src="<?php echo IMAGES;?>a4.jpg" alt="...">
                      </span>
                    </a>
                    <div class="list-body">
                      <div><a href>Company Name</a></div>
                      <div class="text-sm">
                        <span class="text-muted"><strong>10</strong> Trips provided, <strong>7</strong> Trips Completed</span>
                        <span class="label"></span>
                      </div>
                    </div>
                  </li>
                  <li class="list-item">
                    <a herf class="list-left">
                      <span class="w-40 avatar">
                        <img src="<?php echo IMAGES;?>a2.jpg" alt="...">
                      </span>
                    </a>
                    <div class="list-body">
                      <div><a href>Company Name</a></div>
                      <div class="text-sm">
                        <span class="text-muted"><strong>15</strong> Trips provided, <strong>13</strong> Trips Completed</span>
                        <span class="label"></span>
                      </div>
                    </div>
                  </li>
                  <li class="list-item">
                    <a herf class="list-left">
                      <span class="w-40 avatar">
                        <img src="<?php echo IMAGES;?>a5.jpg" alt="...">
                      </span>
                    </a>
                    <div class="list-body">
                      <div><a href>Company Name</a></div>
                      <div class="text-sm">
                        <span class="text-muted"><strong>7</strong> Trips provided, <strong>7</strong> Trips Completed</span>
                        <span class="label"></span>
                      </div>
                    </div>
                  </li>
                  <li class="list-item">
                    <a herf class="list-left">
                      <span class="w-40 avatar">
                        <img src="<?php echo IMAGES;?>a6.jpg" alt="...">
                      </span>
                    </a>
                    <div class="list-body">
                      <div><a href>Company Name</a></div>
                      <div class="text-sm">
                        <span class="text-muted"><strong>13</strong> Trips provided, <strong>7</strong> Trips Completed</span>
                        <span class="label"></span>
                      </div>
                    </div>
                  </li>
                </ul>
                <div class="box-footer">
                  <a href class="btn btn-sm white text-u-c">More</a>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6 col-md-4">
              <div class="box">
                <div class="box-header">
                  <h3>Staff</h3>
                </div>
                <ul class="list no-border p-b">
                  <li class="list-item">
                    <a herf class="list-left">
                      <span class="w-40 avatar">
                        <img src="<?php echo IMAGES;?>a4.jpg" alt="...">
                        <i class="on b-white bottom"></i>
                      </span>
                    </a>
                    <div class="list-body">
                      <div><a href>Chris Fox</a></div>
                      <small class="text-muted text-ellipsis">Designer, Blogger</small>
                    </div>
                  </li>
                  <li class="list-item">
                    <a herf class="list-left">
                      <span class="w-40 avatar">
                        <img src="<?php echo IMAGES;?>a5.jpg" alt="...">
                        <i class="on b-white bottom"></i>
                      </span>
                    </a>
                    <div class="list-body">
                      <div><a href>Mogen Polish</a></div>
                      <small class="text-muted text-ellipsis">Writter, Mag Editor</small>
                    </div>
                  </li>
                  <li class="list-item">
                    <a herf class="list-left">
                      <span class="w-40 avatar">
                        <img src="<?php echo IMAGES;?>a6.jpg" alt="...">
                        <i class="away b-white bottom"></i>
                      </span>
                    </a>
                    <div class="list-body">
                      <div><a href>Joge Lucky</a></div>
                      <small class="text-muted text-ellipsis">Art director, Movie Cut</small>
                    </div>
                  </li>
                  <li class="list-item">
                    <a herf class="list-left">
                      <span class="w-40 avatar">
                        <img src="<?php echo IMAGES;?>a7.jpg" alt="...">
                        <i class="busy b-white bottom"></i>
                      </span>
                    </a>
                    <div class="list-body">
                      <div><a href>Folisise Chosielie</a></div>
                      <small class="text-muted text-ellipsis">Musician, Player</small>
                    </div>
                  </li>
                  <li class="list-item">
                    <a herf class="list-left">
                      <span class="w-40 avatar success">
                        <span>P</span>
                        <i class="away b-white bottom"></i>
                      </span>
                    </a>
                    <div class="list-body">
                      <div><a href>Peter</a></div>
                      <small class="text-muted text-ellipsis">Musician, Player</small>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-sm-6 col-md-4">
              <div class="box">
                <div class="box-header">
                  <h3>Drivers on Board</h3>
                  <small>20 divers on task</small>
                </div>
                <div class="box-tool">
                  <ul class="nav">
                    <li class="nav-item inline">
                      <a class="nav-link">
                        <i class="material-icons md-18">&#xe863;</i>
                      </a>
                    </li>
                  </ul>
                </div>
                <div class="box-body">
                  <div class="streamline b-l m-b m-l">
                    <div class="sl-item">
                      <div class="sl-left">
                        <img src="<?php echo IMAGES;?>a2.jpg" class="img-circle">
                      </div>
                      <div class="sl-content">
                        <a href class="text-info">Diver Name</a><span class="m-l-sm sl-date">5 min ago</span>
                        <div>Company Name and Drop Location.</div>
                      </div>
                    </div>
                    <div class="sl-item">
                      <div class="sl-left">
                        <img src="<?php echo IMAGES;?>a5.jpg" class="img-circle">
                      </div>
                      <div class="sl-content">
                        <a href class="text-info">Diver Name</a><span class="m-l-sm sl-date">10 min ago</span>
                        <div>Company Name and Drop Location.</div>
                      </div>
                    </div>
                    <div class="sl-item">
                      <div class="sl-left">
                        <img src="<?php echo IMAGES;?>a8.jpg" class="img-circle">
                      </div>
                      <div class="sl-content">
                        <a href class="text-info">Diver Name</a><span class="m-l-sm sl-date">5 hour ago</span>
                        <div>Company Name and Drop Location.</div>
                      </div>
                    </div>
                  </div>
                  <a href class="btn btn-sm white text-u-c m-y-xs">Load More</a>
                </div>
              </div>
            </div>
            <div class="col-sm-12 col-md-4">
              <div class="box">
                <div class="box-header">
                  <span class="label success pull-right">5</span>
                  <h3>Booking Requests</h3>
                  <small>10 members bookings are pending.</small>
                </div>
                <div class="box-body">
                  <div class="streamline b-l m-b m-l">
                    <div class="sl-item">
                      <div class="sl-left">
                        <img src="<?php echo IMAGES;?>a1.jpg" class="img-circle">
                      </div>
                      <div class="sl-content">
                        <a href class="text-info">Company Name</a><span class="m-l-sm sl-date">5 min ago</span>
                        <div>Location to drop and members</div>
                      </div>
                    </div>
                    <div class="sl-item">
                      <div class="sl-left">
                        <img src="<?php echo IMAGES;?>a3.jpg" class="img-circle">
                      </div>
                      <div class="sl-content">
                        <a href class="text-info">Company Name</a><span class="m-l-sm sl-date">10 min ago</span>
                        <div>Location to drop and members</div>
                      </div>
                    </div>
                    <div class="sl-item">
                      <div class="sl-left">
                        <img src="<?php echo IMAGES;?>a7.jpg" class="img-circle">
                      </div>
                      <div class="sl-content">
                        <a href class="text-info">Company Name</a><span class="m-l-sm sl-date">1 hour ago</span>
                        <div>Location to drop and members</div>
                      </div>
                    </div>
                  </div>
                  <a href class="btn btn-sm white text-u-c m-y-xs">Load More</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- ############ PAGE END-->
      </div>
    </div>
    <!-- / -->

      <!--footer-->
   <?php //$this->load->view('footer');?>
   <!--footer-->