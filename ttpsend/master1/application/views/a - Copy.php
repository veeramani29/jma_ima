 <div class="sb2-1">
                <!--== USER INFO ==-->
                <div class="sb2-12">
                    <ul>
                        <li><img src="<?php echo IMAGES;?>placeholder.jpg" alt="">
                        </li>
                        <li>
                            <h5>Ammin <span> Master</span></h5>
                        </li>
                        <li></li>
                    </ul>
                </div>
                <!--== LEFT MENU ==-->
                <div class="sb2-13">
                    <ul class="collapsible" data-collapsible="accordion">
                        <li><a href="<?php echo base_url('dashboard');?>" class="<?php echo ($this->router->fetch_class()=='dashboard')?'menu-active':'';?>"><i class="fa fa-bar-chart" aria-hidden="true"></i> Dashboard</a>
                        </li>
                       <!--  <li><a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-list-ul" aria-hidden="true"></i> Listing</a>
                            <div class="collapsible-body left-sub-menu">
                                <ul>
                                    <li><a href="listing-all.html">All listing</a>
                                    </li>
                                    <li><a href="listing-add.html">Add New listing</a>
                                    </li>
                                    <li><a href="listing-cat-all.html">All listing Categories</a>
                                    </li>
                                    <li><a href="listing-cat-add.html">Add listing Categories</a>
                                    </li>
                                </ul>
                            </div>
                        </li> -->
                        <li class="<?php echo ($this->router->fetch_class()=='admin')?'active':'';?>"><a href="javascript:void(0)" class="collapsible-header <?php echo ($this->router->fetch_class()=='admin')?'active':'';?>"><i class="fa fa-user" aria-hidden="true"></i> Users</a>
                            <div class="collapsible-body left-sub-menu">
                                <ul>
                                    <li><a href="<?php echo base_url('admin');?>" class="<?php echo ($this->router->fetch_class()=='admin'  && $this->router->fetch_method()=='index')?'menu-active':'';?>">All Users</a>
                                    </li>
                                    <li><a href="<?php echo base_url('admin/add');?>" class="<?php echo ($this->router->fetch_class()=='admin' && ($this->router->fetch_method()=='add' || $this->router->fetch_method()=='edit'  || $this->router->fetch_method()=='changepassword'))?'menu-active':'';?>">Add New user</a>
                                    </li>
                                </ul>
                            </div>
                        </li class="<?php echo ($this->router->fetch_class()=='tourpack')?'active':'';?>">
                        <li><a href="javascript:void(0)" class="collapsible-header <?php echo ($this->router->fetch_class()=='tourpack')?'active':'';?>"><i class="fa fa-umbrella" aria-hidden="true"></i> Tour Packages</a>
                            <div class="collapsible-body left-sub-menu">
                                <ul>
                                    <li><a class="<?php echo ($this->router->fetch_class()=='tourpack'  && $this->router->fetch_method()=='index')?'menu-active':'';?>" href="<?php echo base_url('tourpack');?>">All Packages</a>
                                    </li>
                                    <li><a class="<?php echo ($this->router->fetch_class()=='tourpack'  && $this->router->fetch_method()=='add_new_pack')?'menu-active':'';?>"  href="<?php echo base_url('tourpack/add_new_pack');?>">Add New Package</a>
                                    </li>
                                    <li><a class="<?php echo ($this->router->fetch_class()=='tourpack'  && $this->router->fetch_method()=='categories')?'menu-active':'';?>" href="<?php echo base_url('tourpack/categories');?>">All Package Categories</a>
                                    </li>
                                    <li><a class="<?php echo ($this->router->fetch_class()=='tourpack'  && $this->router->fetch_method()=='add_category')?'menu-active':'';?>" href="<?php echo base_url('tourpack/add_category');?>">Add Package Category</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                      <!--   <li><a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-h-square" aria-hidden="true"></i> Hotels</a>
                            <div class="collapsible-body left-sub-menu">
                                <ul>
                                    <li><a href="hotel-all.html">All Hotels</a>
                                    </li>
                                    <li><a href="hotel-add.html">Add New Hotel</a>
                                    </li>
                                    <li><a href="hotel-room-type-all.html">Room Type</a>
                                    </li>
                                    <li><a href="hotel-room-type-add.html">Add Room Type</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-picture-o" aria-hidden="true"></i> Sight Seeings</a>
                            <div class="collapsible-body left-sub-menu">
                                <ul>
                                    <li><a href="sight-see-all.html">All Sight Seeings</a>
                                    </li>
                                    <li><a href="sight-see-add.html">Add New Sight Seeing</a>
                                    </li>
                                </ul>
                            </div>
                        </li> -->
                        
                       
                        <li><a href="<?php echo base_url('login/signout');?>" target="_blank"><i class="fa fa-sign-in" aria-hidden="true"></i> Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
