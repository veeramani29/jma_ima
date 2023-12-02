  <!-- aside -->
    <div id="aside" class="app-aside modal fade nav-dropdown folded">
      <!-- fluid app aside -->
      <div class="left navside dark dk" layout="column">
        <div class="navbar no-radius">
          <!-- brand -->
          <a class="navbar-brand">
            <div ui-include="'<?php echo IMAGES;?>logo.svg'"></div>
            <img src="<?php echo IMAGES;?>logo.png" alt="." class="hide">
            <span class="hidden-folded inline">BluStars</span>
            <i class="material-icons menu-toggle"> keyboard_arrow_left </i>
          </a>
          <!-- / brand -->
        </div>
        <div flex class="hide-scroll">
          <nav class="scroll nav-light">
            <ul class="nav" ui-nav>
              <li>
                <a href="<?php echo HOST_ADMIN;?>dashboard" >
                  <span class="nav-icon">
                    <i class="material-icons">&#xe3fc;
                      <span ui-include="'<?php echo IMAGES;?>i_0.svg'"></span>
                    </i>
                  </span>
                  <span class="nav-text">Dashboard</span>
                </a>
              </li>
              <li>
                <span class="nav-caret">
                  <i class="fa fa-caret-down"></i>
                </span>
                <a>
                  <span class="nav-icon">
                    <i class="fa fa-building-o" aria-hidden="true"></i>
                  </span>
                  <span class="nav-text">Company</span>
                </a>
                <ul class="nav-sub">
                  <li>
                    <a href="<?php echo HOST_ADMIN;?>companies" >
                      <span class="nav-text">Companies</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li>
                <span class="nav-caret">
                  <i class="fa fa-caret-down"></i>
                </span>
                <a>
                  <span class="nav-icon">
                    <i class="material-icons">attach_money</i>
                  </span>
                  <span class="nav-text">Tariff</span>
                </a>
                <ul class="nav-sub">
                  <li>
                    <a href="<?php echo HOST_ADMIN;?>tariffs" >
                      <span class="nav-text">Tariffs</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li>
                <span class="nav-caret">
                  <i class="fa fa-caret-down"></i>
                </span>
                <a>
                  <span class="nav-icon">
                    <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                  </span>
                  <span class="nav-text">User</span>
                </a>
                <ul class="nav-sub">
                  <li>
                    <a href="<?php echo HOST_ADMIN;?>admin" >
                      <span class="nav-text">Users</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li>
                <span class="nav-caret">
                  <i class="fa fa-caret-down"></i>
                </span>
                <a href="<?php echo HOST_ADMIN;?>cabs">
                  <span class="nav-icon">
                    <i class="material-icons">directions_car</i>
                  </span>
                  <span class="nav-text">Cabs</span>
                </a>
                <ul class="nav-sub">
                  <li>
                    <a href="<?php echo HOST_ADMIN;?>cabs" >
                      <span class="nav-text">Cabs</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo HOST_ADMIN;?>vehicles" >
                      <span class="nav-text">Vehicles</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo HOST_ADMIN;?>drivers" >
                      <span class="nav-text">Drivers</span>
                    </a>
                  </li>

                   <li>
                    <a href="<?php echo HOST_ADMIN;?>vehicles/vehicle_category" >
                      <span class="nav-text">Vehicles Category</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li>
                <span class="nav-caret">
                  <i class="fa fa-caret-down"></i>
                </span>
                <a>
                  <span class="nav-icon">
                    <i class="fa fa-ticket" aria-hidden="true"></i>
                  </span>
                  <span class="nav-text">Booking</span>
                </a>
                <ul class="nav-sub">
                  <li>
                    <a href="<?php echo HOST_ADMIN;?>html/list_bookings.html" >
                      <span class="nav-text">Bookings</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo HOST_ADMIN;?>html/tracking.html" >
                      <span class="nav-text">Tracking</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li>
                <span class="nav-caret">
                  <i class="fa fa-caret-down"></i>
                </span>
                <a>
                  <span class="nav-icon">
                    <i class="fa fa-keyboard-o" aria-hidden="true"></i>
                  </span>
                  <span class="nav-text">Feeding</span>
                </a>
                <ul class="nav-sub">
                  <li>
                    <a href="<?php echo HOST_ADMIN;?>html/feeding.html">
                      <span class="nav-text">Feeding</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li>
                <span class="nav-caret">
                  <i class="fa fa-caret-down"></i>
                </span>
                <a>
                  <span class="nav-icon">
                    <i class="fa fa-map-signs" aria-hidden="true"></i>
                  </span>
                  <span class="nav-text">Trip</span>
                </a>
                <ul class="nav-sub">
                  <li>
                    <a href="<?php echo HOST_ADMIN;?>html/list_trips.html" >
                      <span class="nav-text">Trips</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li>
                <span class="nav-caret">
                  <i class="fa fa-caret-down"></i>
                </span>
                <a>
                  <span class="nav-icon">
                    <i class="fa fa-money" aria-hidden="true"></i>
                  </span>
                  <span class="nav-text">Payment</span>
                </a>
                <ul class="nav-sub">
                  <li>
                    <a href="<?php echo HOST_ADMIN;?>html/list_company.html" >
                      <span class="nav-text">Payments</span>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </nav>
        </div>
        <div flex-no-shrink class="b-t">
          <div class="nav-fold">
            <a href="<?php echo HOST_ADMIN;?>html/profile.html">
              <span class="pull-left">
                <img src="<?php echo IMAGES;?>a0.jpg" alt="..." class="w-40 img-circle">
              </span>
              <span class="clear hidden-folded p-x">
                <span class="block _500">Jean Reyes</span>
                <small class="block text-muted"><i class="fa fa-circle text-success m-r-sm"></i>online</small>
              </span>
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- / -->