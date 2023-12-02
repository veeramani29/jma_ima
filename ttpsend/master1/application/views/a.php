   <div class="app-header white box-shadow">
        <div class="navbar">
          <!-- Open side - Naviation on mobile -->
          <a data-toggle="modal" data-target="#aside" class="navbar-item pull-left hidden-lg-up">
            <i class="material-icons">&#xe5d2;</i>
          </a>
          <!-- / -->
          <!-- Page title - Bind to $state's title -->
          <div class="navbar-item pull-left h5" ng-bind="$state.current.data.title" id="pageTitle"></div>
          <!-- navbar right -->
          <ul class="nav navbar-nav pull-right">
            <li class="nav-item dropdown pos-stc-xs">
              <a class="nav-link" href data-toggle="dropdown">
                <i class="material-icons">&#xe7f5;</i>
                <span class="label label-sm up warn">3</span>
              </a>
              <div ui-include="'<?php echo HOST_ADMIN;?>views/blocks/dropdown.notification.html'"></div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link clear" href data-toggle="dropdown">
                <span class="avatar w-32">
                  <img src="<?php echo IMAGES;?>a0.jpg" alt="...">
                  <i class="on b-white bottom"></i>
                </span>
              </a>
      
                <?php include 'views/blocks/dropdown.user.php'; ?>

        
            </li>
            <li class="nav-item hidden-md-up">
              <a class="nav-link" data-toggle="collapse" data-target="#collapse">
                <i class="material-icons">&#xe5d4;</i>
              </a>
            </li>
          </ul>
          <!-- / navbar right -->
          <!-- navbar collapse -->
          <div class="collapse navbar-toggleable-sm" id="collapse">
            <div ui-include="'<?php echo HOST_ADMIN;?>views/blocks/navbar.form.right.html'"></div>
            <!-- link and dropdown -->
          <!--   <ul class="nav navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link" href data-toggle="dropdown">
                  <i class="fa fa-fw fa-plus text-muted"></i>
                  <span>New</span>
                </a>
                <div ui-include="'<?php echo HOST_ADMIN;?>views/blocks/dropdown.new.html'"></div>
              </li>
            </ul> -->
            <!-- / -->
          </div>
          <!-- / navbar collapse -->
        </div>
      </div>


 <div class="app-footer">
        <div class="p-a text-xs">
          <div class="pull-right text-muted">
            &copy; Copyright <strong>BluStars</strong> <span class="hidden-xs-down">- Built with Best</span>
            <a ui-scroll-to="content"><i class="fa fa-long-arrow-up p-x-sm"></i></a>
          </div>
          <div class="nav">
            <a class="nav-link" href="../">About</a>
            <span class="text-muted">-</span>
            <a class="nav-link label accent" href="javascript:;">Blue Star</a>
          </div>
        </div>
      </div>