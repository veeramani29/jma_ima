
<!-- Upgrade Premium content Modal Start-->
<div class="modal fade" id="Dv_modal_upgrade_premium_content" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-warning">Sorry..! This feature restricted</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <p class="text-center">
              <i class="fa fa-warning" style="font-size: 6em;line-height:1.5em;color: #FFA500;"></i>
            </p>
          </div>
          <div class="col-xs-12 col-sm-9">
            <p>
             <b>Sorry..! You do not have a permission to view premium contents. Please upgrade your free account to <a  href="<?php echo url('user/myaccount/subscription');?>">Premium account </a> to view this page.</b>
              <br class="un-justify"><br>Thank you again for being an IMA user and we welcome any feedback you like to share with us at
              <a href="mailto:info@indiamacroadvisors.com">info@indiamacroadvisors.com</a>. 
            </p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Upgrade Premium content End-->

<!-- Createfolder Restricted Modal Start-->
<div class="modal fade" id="Dv_modal_createfolder_restricted" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-warning">Sorry..! Folder Creation - Reached limit</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <p class="text-center"><i class="fa fa-warning" style="font-size: 6em;color: #FFA500;"></i></p>
          </div>
          <div class="col-xs-12 col-sm-9 sm-txtcen">
            <br>
           <p><b>Sorry..! You have reached maximum allowed folders.<br>You not allowed to create more folders.</b>
            </p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Createfolder Restricted End-->

<!-- Content - Reached limit Modal Start-->
<div class="modal fade" id="Dv_modal_addchart_restricted" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-warning">Sorry..! Add Content - Reached limit</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <p class="text-center"><i class="fa fa-warning" style="font-size: 6em;color: #FFA500;"></i></p>
          </div>
          <div class="col-xs-12 col-sm-9 sm-txtcen">
            <br>
           <p><b>Sorry..! You have reached maximum allowed content for this folder.You not allowed to add more content.</b>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Content - Reached limit End-->

<!-- Common Error Start-->
<div class="modal fade" id="Dv_modal_error_common" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-danger">Error...!</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <p class="text-center"><i class="fa fa fa-times-circle" style="font-size: 6em;line-height:1.5em;color:red;"></i>
            </p>
          </div>
          <div class="col-xs-12 col-sm-9 sm-txtcen">
            <p>
              Sorry..! Something went wrong while displaying this webpage.<br>To continue, please click on "Refresh" or wait for the page to get refreshed.
              <br><br> <b>Page will refresh in <span id="error_page_refresh_countdown" style="font-weight: bold;"></span> seconds.</b>                
            </p>
            <button class="btn btn-primary btn-sm" id="common_btn_refresh" type="button" onclick="location.reload();"><i class="fa fa-refresh"></i> Refresh</button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Common Error End-->

<!-- Common Error with message Start-->
<div class="modal fade" id="Dv_modal_error_common_with_message" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-danger">Error...!</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <p class="text-center"><i class="fa fa fa-times-circle" style="font-size: 6em;color:#E60013;"></i></p>
          </div>
          <div class="col-xs-12 col-sm-9 sm-txtcen">
            <br>
            <p><b>Sorry..! Something went wrong and an error occured.
              <br><br><span id="error_page_error_message"></span></b>
            </p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Common Error with message End-->

<!-- Mycyhart Floating Menu--> 
<?php if(thisController()=='mycharts'){ ?>
<div class="myfol_toggle">
  <div class="mft_ttl"> <i class="fa fa-angle-right"></i></span></div>
  <div class="mtf_content">
    <ul class="menu top notranslate list-unstyled">
      <li class="sub-menu folders mychart-menu-set">
        <ul class="list-unstyled">
          <?php if(!isset($_SESSION['user'])){ ?>
          <li class="mycha_toglogin">
            Please login to access MyChart function
          </li>
          <?php }else{
            echo isset($menu_items['folders'])?$menu_items['folders']:'';
          } ?>

          <li class="add-folder">

            <?php if(!isset($_SESSION['user'])){ ?>
            <a class="btn btn-primary mtfc_btn">
              <i class="fa fa-sign-in"></i> Login
            </a>
            <?php }else{ ?>
            <a class="btn btn-primary mtfc_btn" data-toggle="modal" data-target="#modaladd_folder">
              <i class="fa fa-plus-square"></i> Add Folder
            </a>
            <?php } ?>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</div>
<?php } ?>
<!-- Mycyhart Floating Menu-->

<!-- add folder modal -->
<div class="modal fade" id="modaladd_folder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Folder</h4>
      </div>
      <form  name="frmEditFolder" id ="frmEditFolder" action="" method="post" >
        <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
        <div class="modal-body">
          <div class="full-width">
            <div class="form-group">
              <label for="exampleInputEmail1">Folder Name</label>
              <input type="text" class="form-control" id="editfolderName" name="editfolderName" placeholder="Write your folder name here">
              <div id="errFolderName" style="color:red;"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" id="saveFolderName" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Intrducing ima video -->
<div class="modal fade jma_modvid"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Introduction to IMA</h4>
      </div>
      <div class="modal-body">
        <div class="embed-responsive embed-responsive-16by9">
          <div id="ytplayer"></div>
          <script type="text/javascript">
          var tag = document.createElement('script');
          tag.src = "https://www.youtube.com/iframe_api";
          var firstScriptTag = document.getElementsByTagName('script')[0];
          firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
          $(".jma_modvid").on('shown.bs.modal', function() {
            if(typeof player.playVideo == 'function') {
              player.playVideo();
            } else {
              var fn = function(){
                player.playVideo();
              };
              setTimeout(fn, 200);
            }
          });
          $(".jma_modvid").on('hidden.bs.modal', function() {
            player.stopVideo();
          });
          var player;
          function onYouTubeIframeAPIReady() {
            player = new YT.Player('ytplayer', {
              videoId: '_4RA3oRRbho',
              playerVars: {
                vq: 'hd720',
                rel: 0
              },
              events: {
                'onReady': onPlayerReady
              }
            });
          }
          function onPlayerReady() {
            player.setVolume(10);
          }
          </script>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- registeration modal -->
<!-- Modal -->
<div class="modal fade tercon-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Terms and condition</h4>
      </div>
      <div class="modal-body">
        <div class="agrement-con">
          <div class="main-title">
            <h1>Agreement to terms of use</h1>
            <div class="mttl-line"></div>
          </div>
          <p>Please read the following terms and conditions ("Terms of Use") before using the India Macro Advisors ("IMA", "We", "US" or "Our") website (the "Site") and our products including, but not limited to, our research, text, charts, videos, recordings ("Products") that are offered via email or other format provide by US. Your access to and use of the Site and the Products are subject to these Terms of Use and all applicable laws and regulations. The Terms of Use constitute a legal agreement between you and IMA. The Site and the Products are available only to, and may only be used by, individuals who can form legally binding contracts under applicable law. Without limiting the foregoing, the Site and the Products are not available to persons under age 18. By accessing and using the Site and the Products, you accept, without qualification, these Terms of Use. If you do not approve and accept these Terms of Use without qualification, you should exit the Site, and terminate the use of our Products immediately.</p>
          <div class="sub-title">
            <h5>Personal and non-commercial use limitation</h5>
            <div class="sttl-line"></div>
          </div>
          <p>The Site and the Products are for your personal and non-commercial use. IMA grants you a non-exclusive, non-transferable and limited personal license to access and use the Site and the Products, conditioned on your continued compliance with these Terms of Use. You may not modify, copy (except as set forth below), distribute, transmit, display, perform, reproduce, publish, license, create derivative works from, transfer, or sell any information, products or services obtained from the Site and the Products. You may not link other websites to the Site without our prior written permission. You may print one hardcopy of the information and download one temporary copy of the information into one single computer's memory solely for your own personal, non-commercial use and not for distribution, provided that all copyright, trademark and other proprietary notices are kept intact. You may not allow others to use your user name or password to access or use any part of the Site or the Products. If your user name or password has been compromised for any reason, you should contact US immediately for a new user name and password. If you provide your user name or password to any third party, you will be solely responsible for any actions that such third party takes using that information. All information on the password-restricted areas of the Site and in the Products are confidential and private and may not be disclosed or distributed by you to any other person for any purpose and is made available solely for your personal use. You are prohibited from using the Site or the Products to advertise or perform any commercial solicitation. You also are prohibited from using any robot, spider, scraper or other automated means to access the Site for any purpose without the prior written permission of IMA. You may not take any action that imposes, or may impose, in our sole discretion, an unreasonable or disproportionately large load on Our infrastructure, interfere or attempt to interfere with the proper working of the Site or any activities conducted on the Site, or bypass any measures IMA may use to prevent or restrict access to the Site or the Products. IMA reserves any rights not expressly granted herein.</p>
          <div class="sub-title">
            <h5>Subscription Fees</h5>
            <div class="sttl-line"></div>
          </div>
          <p>IMA provides two types of subscription: Free and Premium. Free subscribers are entitled to no fee. Premium subscriber will pay the Monthly Fee for the monthly subscription on a monthly basis. All fees will be paid at the beginning of service. The initial service period of the monthly subscription is one (1) month and will auto renew for subsequent one (1) month periods until you cancel your subscription or send the 30 day notice to us before the subscription expires. </p>
          <p>IMA may offer, as indicated on the Website Payment page, a trial period for its subscription products. The Subscriber will be billed at the beginning of the initial service period for services and will be charged, which starts after the 1 month trial period has concluded. Following any trial period, the normal terms of this Agreement will remain in effect. Service of the subscription will not begin until all charges have been processed.</p>
          <p>Following the initial service period, IMA reserves the right to increase the Monthly Fee at any time upon 30 days notice to you, provided you shall have the right to terminate the Subscription by choosing Unsubscribe which turn back your subscription type to Free subscription from Premium subscription.  </p>
          <p>You (a) agree to pay the Monthly Fee according to any applicable credit card issuer agreement, (b) expressly authorize IMA to automatically charge the applicable card on a monthly basis during the term of this Agreement (unless otherwise agreed by the parties), (c) agrees that any fee increase made in accordance with this Section may also be charged to the same card in the same manner and (d) that you will use the subscription for your own individual usage and you will not share your login credentials with other users. <u>Each individual user must have their own individual subscription.</u></p>
          <div class="sub-title">
            <h5>Subscription term</h5>
            <div class="sttl-line"></div>
          </div>
          <p>Free subscription term/period is unlimited. Premium subscription will end after the expiration date until you cancel the subscription. Once you cancel your subscription you will be notified via email and your subscription type will turn back to Free subscription. If you encounter any problem, please feel free to contact us at <a href="mailto:support@indiamacroadvisors.com">support@indiamacroadvisors.com</a> or you can submit your query at our <a href="<?php echo url('helpdesk/post/');?>">Help Desk</a>.</p>
          <div class="sub-title">
            <h5>No Refund</h5>
            <div class="sttl-line"></div>
          </div>
          <p>The credit card which you provide will automatically and immediately be billed for the Services you subscribe to. While in trial period the card will be charged only after the trial period ends on the expiration date. Premium subscription will be charged in USD. If you cancel your Services you will no longer be billed but no money already paid will be refunded. If your credit card is invalid for any reason, IMA has the right to terminate the Services immediately.</p>
          <div class="sub-title">
            <h5>IMA is a financial publisher, not an investment adviser</h5>
            <div class="sttl-line"></div>
          </div>
          <p>IMA is strictly a financial publisher. We are not, and are not registered as, an investment adviser, broker-dealer or other financial adviser or planner. For example, IMA and its officers, members, managers, employees and affiliates are not registered as investment advisers or broker-dealers with India Financial Service Agency or with any other regulatory authority, either in India or in other jurisdiction. We recommend consulting with a registered investment advisor, broker-dealer, and/or financial advisor in connection with your use of the Site and the Products. Any consequences (including any losses) resulting from your investments are your sole responsibility (whether or not you choose to seek advice from any such advisor).</p>
          <p>IMA publishes information and our opinions regarding economic, financial, political and social issues in India and the rest of the world in which We believe our readers and subscribers may be interested and our reports reflect its sincere opinions. The Site and the Products do not and are not intended to provide any individualized investment advice. IMA will not and cannot offer personalized trading or investment advice and cannot request or consider your financial circumstances. Therefore, you agree not to provide IMA with any information about your financial situation, investment portfolio or other individual information, and further agree not to request any individualized investment advice.</p>
          <div class="sub-title">
            <h5>We are not liable to you</h5>
            <div class="sttl-line"></div>
          </div>
          <p>Neither IMA nor any officer, member, manager, employees and affiliates thereof, will be liable to any subscriber, guest or anyone else for, among other things:</p>
          <p>Any interruption, inaccuracy, error or omission, regardless of cause, in any information appearing on or furnished by IMA or for any damages whatsoever allegedly caused thereby;</p>
          <p>Any unavailability of use of the Site or the Products, nor undelivered e-mails due to Internet bandwidth problems, equipment failure, or natural causes;</p>
          <p>The information, software and services published on this Site and in the Products may include inaccuracies or typographical errors. Due to various factors, including the inherent possibility of human and mechanical error, the accuracy, completeness, timeliness and correct sequencing of such information, software and services. IMA does not guarantee the results obtained from their use or any persons creating or transmitting such information, software and services. The Site and the Products may be unavailable from time to time due to required maintenance, telecommunications interruptions or other reasons.</p>
          <p>IMA and/or its suppliers make no representations about the suitability of the information, software, products and services on this Site and in the Products for any purpose. All such information, software, products and services are provided "as is" without warranty of any kind. IMA and/or its respective suppliers disclaim all warranties and conditions regarding this information, software, products and services, including all implied warranties and conditions of merchantability, fitness for a particular purpose, title, non-infringement and availability. Because some states/jurisdictions do not allow the exclusion of implied warranties, the above exclusion may not apply to you.</p>
          <p>Your use of the Site and the Products is at your own risk. You are solely responsible for any damage to your computer system, loss of data or any other damage or loss that results from downloading any content from the Site or the Products.</p>
          <p>IMA and/or its suppliers shall not be liable for any direct, indirect, punitive, incidental, special or consequential damages arising out of or in any way connected with or relating to the use of or access to this Site or the Products or with the delay or inability to use this Site, the Products or any information, software, products or services obtained through this Site or the Products, whether based on contract, tort, strict liability or otherwise, even if IMA or any of its suppliers has been advised of the possibility of damages. Because some jurisdictions do not allow the exclusion or limitation of liability for consequential or incidental damages, the above limitation may not apply to you.</p>
          <p>IMA and any person creating or transmitting the information on the Site and in the Products shall not be liable for any infection by viruses of or damage to any computer that results from your use of, access to or downloading of such information. If you are dissatisfied with the information, products or services offered at the Site or in the Products or with these Terms of Use, your sole and exclusive remedy is to discontinue use of and access to the Site and the Products.</p>
          <div class="sub-title">
            <h5>Ownership of content</h5>
            <div class="sttl-line"></div>
          </div>
          <p>The Site, the Products and all of their content, including but not limited to all text, graphics, charts, audio, logos, images, data compilations, icons, code and software ("Content"), are the property of IMA and are protected by Japanese and international copyright laws, with all rights reserved unless otherwise noted. All trademarks, service marks, trade names and other product and service names and logos displayed on the Site and in the Products are proprietary to IMA, including all registered and unregistered trademarks and service marks of the IMA. If the Site or any Products includes any trademarks, service marks, trade names or logos of any third parties, such items are the proprietary marks and names of their respective owners, and are protected by applicable trademark and intellectual property laws. Your use of any Content, whether owned by IMA or any third party, without our express written permission, is strictly prohibited except as otherwise expressly permitted in these Terms of Use. Without limiting the foregoing, you are prohibited from using any of the Our copyrighted material or trademarks for any purpose, including, but not limited to, use as links or otherwise on any website, without the Our prior written permission.</p>
          <div class="sub-title">
            <h5>Truthful information</h5>
            <div class="sttl-line"></div>
          </div>
          <p>As a condition to your use of the Site and the Products, you represent and warrant to, and agree with US that, all of the information that you provide is truthful, accurate and complete. If We collect any information from users of the Site or the Products, the collection and use of such information is governed by our Privacy Policy which you should read before providing any information to US.</p>
          <div class="sub-title">
            <h5>No unlawful or prohibited use</h5>
            <div class="sttl-line"></div>
          </div>
          <p>As a condition to your use of the Site and the Products, you represent and warrant to, and agree with US that you will not use the Site or the Products for any purpose that is unlawful or prohibited by these Terms of Use.</p>
          <div class="sub-title">
            <h5>References to publications and other companies</h5>
            <div class="sttl-line"></div>
          </div>
          <p>References to any publication, companies or institutions in the Site or the Products are for reference and informational purposes only and are not intended to suggest that any of such entities endorse, recommend or approve of the services, analysis or recommendations of IMA or that We endorses, recommends or approves the services or products of such companies. News stories reflect only the author's opinion and not necessarily that of IMA.</p>
          <div class="sub-title">
            <h5>Links to third party websites</h5>
            <div class="sttl-line"></div>
          </div>
          <p>The Site or the Products may contain hyperlinks to websites operated by parties other than IMA, which may not have been screened or reviewed by IMA and which may contain inaccurate, inappropriate or offensive material, products or services. We do not control such websites, and We assume no responsibility or liability regarding the accuracy, reliability, legality or decency of such third-party websites, content, products or services. Such hyperlinks are provided for your convenience only. Our inclusion of hyperlinks to such websites does not imply any endorsement of the material on such websites or any association with their operators.</p>
          <div class="sub-title">
            <h5>Modification and monitoring of terms of use</h5>
            <div class="sttl-line"></div>
          </div>
          <p>We reserves the right, at its discretion, to change, modify, add or remove portions of these Terms of Use at any time without notice to you. We recommends that you check these Terms of Use periodically for changes. These Terms of Use can be accessed from the link at the bottom of each page of the Site. If you use the Site or the Products after We post changes to these Terms of Use, you accept the changed Terms of Use. IMA expressly reserves the right to monitor any and all use of the Site and the Products.</p>
          <div class="sub-title">
            <h5>Indemnity</h5>
            <div class="sttl-line"></div>
          </div>
          <p>You agree, at your own expense, to indemnify, defend and hold harmless IMA, its parents, subsidiaries and affiliates, and their officers, partners, managers, members, employees, agents, distributors and licensees, from and against any judgments, losses, deficiencies, damages, liabilities, costs, claims, demands, suits, and expenses (including, without limitation, reasonable attorney's fees and expenses) incurred in, arising out of or in any way related to your breach of these Terms of Use or the Privacy Policy, your use of the Site or any product or service related thereto, or any of your other acts or omissions.</p>
          <div class="sub-title">
            <h5>Jurisdictional issues and applicable law</h5>
            <div class="sttl-line"></div>
          </div>
          <p>These Terms of Use are governed by Japanese law, without regard to its choice of law provisions. You hereby consent to the exclusive and personal jurisdiction and venue of courts in the Tokyo Metropolitan Area, India, which shall have exclusive jurisdiction over any and all disputes arising out of or relating to these Terms of Use, the use of the Site or any product or service related thereto. Use of the Site is unauthorized in any jurisdiction that does not give effect to all provisions of these terms and conditions, including without limitation this paragraph.</p>
          <p>Software from the Site is further subject to Japanese export controls. Software from the Site may not be downloaded or otherwise exported or re-exported outside India. By downloading or using such software, you represent and warrant that you are not located in, under the control of, or a national or resident of any country or territory outside of the United States</p>
          <div class="sub-title">
            <h5>General</h5>
            <div class="sttl-line"></div>
          </div>
          <p>You agree that no joint venture, partnership, employment or agency relationship exists between you and IMA as a result of these Terms of Use or use of the Site or the Products.</p>
          <p>Our's performance of these Terms of Use is subject to existing laws and legal process, and nothing in these Terms of Use is in derogation of Our right to comply with law enforcement requests or requirements relating to your use of the Site, the Products or information provided to or gathered by IMA regarding such use.</p>
          <p>If any part of these Terms of Use is determined to be invalid or unenforceable pursuant to applicable law including, but not limited to, the warranty disclaimers and liability limitations set forth above, then the invalid or unenforceable provision shall be deemed superseded by a valid, enforceable provision that most closely matches the intent of the original provision and the remainder of these Terms of Use shall continue in effect.</p>
          <p>By reviewing or using the information on the Site or in the Products after accessing the Site, you represent and warrant that (a) you have the authority to enter into these Terms of Use and create a binding contractual obligation, (b) you understand and intend these Terms of Use to be the legal equivalent of a signed, written contract equally binding and (c) you will use the information on the Site and in the Products in a manner consistent with applicable laws and regulations in accordance with these Terms of Use, as the same may be amended by IMA online or otherwise from time to time. A printed version of these Terms of Use and any notice given in electronic form shall be admissible in judicial or administrative proceedings based on or relating to these Terms of Use to the same extent and subject to the same conditions as other business documents and records originally generated and maintained in printed form.</p>
          <p>These Terms of Use constitute the entire agreement between you and IMA with respect to the Site and the Products and they supersede all prior or contemporaneous communications and proposals, whether electronic, oral or written, between you and IMA regarding the Site and the Products.</p>
          <div class="sub-title">
            <h5>Special terms of use for the AIPL indices</h5>
            <div class="sttl-line"></div>
          </div>
          <p>(i) Neither Intermacro Associates, AIPL, their affiliates nor any third-party licensor shall have any liability for the accuracy or completeness of the information or software furnished through the Licensee Service, or for delays, interruptions or omissions therein nor for any lost profits, indirect, special or consequential damages.</p>
          <p>(ii) Either  Intermacro Associates, AIPL, their affiliates or third-party licensors have exclusive proprietary rights in any information and software received.</p>
          <p>(iii) Subscriber shall not use or permit anyone to use the information or software provided through the  Intermacro Associates Service for any unlawful or unauthorized purpose.</p>
          <p>(iv) Subscriber is not authorized or permitted to furnish such information or software to any person or firm for reuse or retransmission without prior written approval of the source of such information or software.</p>
          <p>(v) Access to the AIPL Service(s) is subject to termination in the event that any agreement between  Intermacro Associates and a provider of information or software distributed through the  Intermacro Associates Service is terminated in accordance with its terms and.</p>
          <p>(vi) The use of the AIPL Service(s) by End Users and  Intermacro Associates Customers shall be in compliance with Section (ii-iii) above.</p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="agreeButton" data-dismiss="modal">Agree</button>
        <button type="button" class="btn btn-default" id="disagreeButton" data-dismiss="modal">Disagree</button>
      </div>
    </div>
  </div>
</div>

<!-- BSC aggrement modal -->
<div class="modal fade bsc-aggmod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Sensex Aggrement</h4>
      </div>
      <div class="modal-body">
        <p>
          “Asia Index Private Limited 200*. A “The S&P BSE SENSEX, S&P BSE 500, S&P BSE 100, S&P BSE AllCap, S&P BSE LargeCap, S&P BSE MidCap, S&P BSE SmallCap is a product of AIPL, which is a joint venture of S&P Dow Jones Indices LLC or its affiliates (“SPDJI”) and BSE, and has been licensed for use by Intermacro Associates here by reffered to as IMA. Standard & Poor’s® and S&P® are registered trademarks of Standard & Poor’s Financial Services LLC (“S&P”); BSE® is a registered trademark of BSE Limited (“BSE”); Dow Jones® is a registered trademark of Dow Jones Trademark Holdings LLC (“Dow Jones”); and these trademarks have been licensed for use by AIPL and sublicensed for certain purposes by IMA. Redistribution, reproduction and/or photocopying in whole or in part are prohibited without written permission of AIPL. For more information on any of AIPL’s indices please visit http://www.asiaindex.com/. None of AIPL, BSE Dow Jones Trademark Holdings LLC, their affiliates nor their third party licensors make any representation or warranty, express or implied, as to the ability of any index to accurately represent the asset class or market sector that it purports to represent and none of AIPL, BSE, S&P Dow Jones Indices LLC, Dow Jones Trademark Holdings LLC or their affiliates nor their third party licensors shall have any liability for any errors, omissions, or interruptions of any index or the data included therein.”
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- BSC aggrement for un registered user -->
<div class="modal fade bsc_unuser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
        <h4 class="modal-title" id="myModalLabel">Terms Of Use</h4>
      </div>
      <div class="modal-body">
        <p>The information contained in this page belongs Asia India Pvt. Ltd(AIPL). Intermacro Associates hereby reffered to as the LICENSEE has obtained the liscense for using the Services of AIPL in the website India Macro Advisors(www.indiamacroadvisors.com). The Index included here is S&P BSE SENSEX, S&P BSE 500, S&P BSE 100, S&P BSE AllCap, S&P BSE LargeCap, S&P BSE MidCap, S&P BSE SmallCap. The data is available for veiwing only. To view the data please agree to the terms of use and login to our website with your username and password. If you are a new user then please Sign up here.</p>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" href="<?php echo url('user/signup');?>">Sign Up</a>
        <button type="button" class="btn btn-secondry" id="sensexAgree" data-dismiss="modal">Agree and proceed</button>
      </div>
    </div>
  </div>
</div>

<!-- secure payment -->
<div class="modal fade secpay_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Razorpay Information</h4>
      </div>
      <div class="modal-body">



<h4>How do recurring payments on Credit Cards work in India?</h4>
<p>Recurring payments are allowed on MasterCard and Visa network credit cards provided the customer authorizes the first transaction through a normal Two-Factor Authentication/3DSecure flow.</p>

<h4>How do recurring payments on Debit Cards work in India?</h4>
<p>Recurring payments are allowed on Mastercard and Visa network cards issued by ICICI Bank, Kotak Mahindra Bank, Citibank and Canara Bank, provided the customer authorizes the first transaction through a normal Two-Factor Authentication/3DSecure flow.</p>

<h4>How does the two-factor authentication (2FA) work with recurring payments? </h4>
<p>The first transaction needs to go through the 2FA process. Further charges can be made automatically, without 2FA.</p>

<h4>Which payment instruments support recurring payments?</h4>
<p>Credit cards on MasterCard and Visa network issued by any bank in India. Debit cards on Mastercard and Visa network issued by ICICI Bank, Kotak Mahindra Bank, Citibank and Canara Bank.</p>

<p>One of my customers received this SMS from bank.
Your trx is debited to xxxx Bank CREDIT Card for Rs. xx.xx. This is not an authenticated trx as per RBI Mandate effective 1 May 12.
Some customers may receive such messages from the bank for subscription transactions. However, no need to worry about it as this communication is for information only. We assure you that all transactions on Razorpay are authorised as per RBI compliance.</p>

       <!--  <p>No credit card information is ever stored on our servers.  We use Stripe.com, one of the most secure and reputable payment processors available. All card numbers are encrypted on disk with AES-256 and decryption keys are stored on separate machines. None of Stripe's internal servers and daemons are able to obtain plaintext card numbers; instead, they can just request that cards be sent to a service provider on a static whitelist. </p>
        <p> Stripe's infrastructure for storing, decrypting, and transmitting card numbers runs in separate hosting infrastructure and doesn't share any credentials with Stripe's primary services (API, website, etc.) For more information, you can visit Stripe's security policy right <a href="https://stripe.com/help/security" target="_blank">here</a>!</p> -->
        <p> In other words, your credit card details are safe!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- comodo payment -->
<div class="modal fade compay_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Comodo Information</h4>
      </div>
      <div class="modal-body">
        <p>SSL (Secure Sockets Layer) is a standard security protocol which establishes encrypted links between a web server and a browser, thereby ensuring that all communication that happens between a web server and browser(s) remains encrypted and hence private. SSL Certificate is today an industry standard that is used by millions of websites worldwide to protect all communication and data that's transmitted online through the websites. </p>
        <p> To Know more about comodo SSL please click here <a href="https://ssl.comodo.com/" target="_blank">here</a>!</p>
        <p> In other words, your credit card details are safe!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- modal for charts -->
<div class="modal fade lgh_charts"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id = "indicator_view_charts">
  <div class="modal-dialog modal-lg" role="document">
 		<div class="modal-content">
 			<div class="modal-header">
				<button type="button" class="close edit_chart_close"  aria-label="Close"><span aria-hidden="true">&times;</span></button>
 				<h4 class="modal-title" id="myModalLabel">Customize chart</h4>
 			</div>
 			<div class="modal-body">
 				 <div id='Chart_Dv_placeholder_0' class="Chart_Dv_placeholder_mobile"> </div>
 			</div>
 			<div class="modal-footer">
				<button type="button" class="btn btn-default edit_chart_close" >Close</button>
				<!--data-dismiss="modal" -->
 			</div>
 		</div>
 	</div>
</div>

<!-- mychart video -->
<div class="modal fade" id="mychart_video" tabindex="-1" role="dialog" aria-labelledby="mychart_video">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="embed-responsive embed-responsive-16by9">
          <!-- <iframe src="https://www.youtube.com/embed/_4RA3oRRbho?rel=0&showinfo=0" frameborder="0" allowfullscreen></iframe> -->
          <div id="mcplayer"></div>
          <script type="text/javascript">
        /*  var tag = document.createElement('script');
          tag.src = "https://www.youtube.com/iframe_api";
          var firstScriptTag = document.getElementsByTagName('script')[0];
          firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);*/
          $("#mychart_video").on('shown.bs.modal', function() {
            if(typeof player.playVideo == 'function') {
              player.playVideo();
            } else {
              var fn = function(){
                player.playVideo();
              };
              setTimeout(fn, 200);
            }
          });
          $("#mychart_video").on('hidden.bs.modal', function() {
            player.stopVideo();
          });
          var player;
          function onYouTubeIframeAPIReady() {
            player = new YT.Player('mcplayer', {
              videoId: '_4RA3oRRbho',
              playerVars: {
                vq: 'hd720',
                rel: 0
              },
              events: {
                'onReady': onPlayerReady
              }
            });
          }
          function onPlayerReady() {
            player.setVolume(10);
          }
          </script>
        </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Upgrade Premium Feature Modal Start-->
<div class="modal fade mod_restricted" id="Dv_modal_upgrade_premium_feature" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-warning">Sorry..! This feature restricted</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <p class="text-center"><i class="fa fa-warning"></i></p>
          </div>
          <div class="col-xs-12 col-sm-9">
            <p><b> Sorry..! With a free account, you can save & edit up to 1 folder with 4 charts & tables in your personal online folder. If you wish to save more than  1 folder or more than 4 charts, please upgrade to a PREMIUM account. Otherwise, you can also delete unnecessary charts & tables from your folder.For more details, please check your account details <a href="<?php echo url('user/myaccount/subscription');?>">here</a></b>. </p>
           <p class="un-justify"> Thank you again for being a IMA user and we welcome any feedback you like to share with us at <a href="mailto:info@indiamacroadvisors.com">info@indiamacroadvisors.com</a>. </p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Upgrade Premium Feature End-->

<!-- Login Modal Start -->
<div class="modal fade" id="Dv_modal_login" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="pull-left">
          <h4 class="modal-title">Login</h4>
        </div>
        <!-- <ul class="list-inline list_sigmod">
          <li>
            <div class="download-img" >
              <i class="fa fa-user fa-lg color-green"></i><b>FREE</b>
            </div>
          </li>
          <li>
            <div class="premium-img color-blue icon-sup">
              <i class="fa fa-user fa-lg"></i>
              <sup>
                <i class="fa fa-star fa-fw"></i>
              </sup>
              <b>PREMIUM</b>
            </div>
          </li>
          <li>
            <div class="premium-img">
              <i class="fa fa-building fa-lg"
              style="color: #22558F;"></i><b>CORPORATE</b>
            </div>
          </li>
        </ul>-->
      </div>
     <div class="modal-body">
				<form name="login_frm_ajx" id="login_frm_ajx" class="signup_frm" action="<?php echo url('/user/login');?>" method="post">
					<input type="hidden" name="_token" value="<?php echo csrf_token();?>">
					<div class="text-center form-group mychart">
						<p>This feature is available for registered users only. Please log-in to access our Save to <b>My Charts function</b>.<br>
						</p>
					</div>
					<div class="text-center form-group premium">
						<!--<p>This content is restricted <b>for paying users only.</b> <br> If you
							are a PREMIUM / CORPORATE account user, please log-in.<br>
						</p>-->
						<p>Sorry..! You do not have a permission to view premium contents. Only our Premium account holders have access to this page.</p>
						<p>Please click here to <a  href="<?php echo url('user/signup?pre_info=y');?>">sign up</a> as a premium user of IMA or log in to your existing premium account to view the page.</p>
					</div>
					<div class="text-center form-group download">
						<p>This feature is available for registered users only. Please log-in to access our <b>data download function.</b><br></p>
					</div>
					<div class="text-center form-group">
						<a href="<?php echo url('user/linkedinProcess');?>" class="linkedIn btn btn-lisu">
							<i class="fa fa-linkedin"></i> Sign up
							<!-- <img src="<?php echo  images_path('sign-in-with-linkedin.png');?>" /> -->
						</a>
						<a class="reg_fb btn btn-fbsu" onclick="window.open('<?php echo url('auth/login/facebook',isset($product)? $product : 'free');?>', '_blank', 'width=600,height=600,scrollbars=yes,status=yes,resizable=yes,screenx='+((parseInt(screen.width) - 600)/2)+',screeny='+((parseInt(screen.height) - 600)/2)+'');" href="javascript:void(0);"> 
							<i class="fa fa-facebook"></i> Sign up
						</a> 
					</div>
					<div class="sinup_orcon"><p>OR</p></div>
					<p class="login_frm_ajx_login_status text-center text-danger" style="font-size: 12px;display: none;"></p>
					<div class="form-group col-xs-12 col-sm-6 sm-pad padl0">
						<!-- <label for="login_email" class="control-label visible-xs">&nbsp;</label>  -->
						<input class="form-control" placeholder="Email" name="login_email" id="login_email">
					</div>
					<div class="form-group col-xs-12 col-sm-6 sm-pad padr0">
						<!-- <label for="login_password" class="control-label visible-xs">&nbsp;</label> -->
						<input type="password" class="form-control"  placeholder="Password" name="login_password" id="login_password"  />
						<input type="hidden" name="chart_login_perm_type" id="chart_login_perm_type" >
						<input type="hidden" name="chart_login_chart_index" id="chart_login_chart_index">
						<input type="hidden" name="chart_login_premium_url" id="chart_login_premium_url">
					</div>
					<div class="full-width text-center marb20">
						<button type="button"  class="btn btn-primary btn-sm" name="login_btn" id="pop_login_btn">
							Submit
						</button>
						<a class="btn" id="SubmitForgotPss" href="<?php echo url('user/forgotpassword');?>">
							Forgot Password?
						</a>
					</div>
					<!--<p class="premium-logininfo">
						<a href="<?php echo url('products');?>">Upgrade or Register for </a> PREMIUM or CORPORATE account.
					</p>-->
					<p class="download-logininfo">
						Not registered?<br/>
						<i class="fa fa-play-circle" style="color: #F39019; font-size: 20px;padding: 1px 5px 3px 2px;"></i>
						<a href="<?php echo url('products');?>">Setup a <b>Free Account</b></a> to access our services free of charge.
					</p>
				</form>
			</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Login Modal End-->


<!-- Paypal payment -->
<div class="modal fade paypal_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Paypal Information</h4>
      </div>
      <div class="modal-body">
        <p>When you subscribe with us, we are creating "Recurring Payments Profile" based on this method we would deduct amount directly from you PayPal account. First  month subscripption is "Free" from next each month subscription amount should be deducted .  </p>
        <p> To Know more about PayPal recurring payment please click  <a href="https://developer.paypal.com/docs/classic/express-checkout/ht_ec-recurringPaymentProfile-curl-etc/" target="_blank">here</a>!</p>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Paypal End -->