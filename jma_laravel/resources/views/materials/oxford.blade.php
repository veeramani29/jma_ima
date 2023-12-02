@extends('templates.default')
@section('content')
<?php
$resn = $result['materials'];
?>
<div class="col-xs-12 col-md-10">
	<div class="row">
		<div class="col-md-12">
			<?php
			$count = count($resn);
			?>
			<div class="main-title"> <h4> グローバル経済レポート </h4> <div class="mttl-line"></div> </div>
			<!--<p><strong>（オックスフォード・エコノミクス社レポート）</strong></p>-->
			<div class="row">
				<!--<div class="col-md-6">
					<img style="width: 100%;" alt="Oxford Economics" src="<?php //echo images_path('oe_logo.png');?>"  />
				</div>-->
				<div class="col-md-6">
					<img style="width: 100%;" alt="Japan Macro Advisors" src="<?php echo images_path('logo.png');?>"  />
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<br>
					<!--<p>
						ジャパンマクロアドバイザーズは、2015年4月よりオックスフォード・エコノミクス社と提携関係を結びました。オックスフォード・エコノミクスは1981年に創業し、民間では最大規模のマクロリサーチ会社です。弊社ではオックスフォードエコノミクス社が発信する数多くのレポートから厳選した価値あるレポートを日本語訳し、日本国内で発信しています。
					</p>
					<p>
						オックスフォード社グレーバル経済レポート（日本語版）シリーズは、月次3回発行予定です。継続してお受け取りになりたい方、また同社が提供するマクロ経済レポート、計量モデルツールにご関心をお持ちの方は<a
						href="<?php //echo url('materials/category/oxford-economics/');?>#request_info">こちら</a>、もしくは、弊社（Japan
						Macro Advisors 電話０３．５７８６．３２７５ 担当＜今関＞）までご連絡ください。
					</p>-->
					<p>
						This page no longer exist.
					</p>
				</div>
			</div>
			<?php //if($count>0){?>
			<!--<p><strong>新着レポート</strong></p>
			<hr>-->
			<?php
			/*$i=0;
			foreach ($resn as $materials) {
				$i++;
				$title = $materials['material_title'];
				$material_description = $materials['material_description'];
				$title_image = $materials['material_title_img'];
				$material_path = $materials['material_path'];
				$date =  $materials['material_date'];
				$id = $materials['material_id'];*/
				?>
				<!--<div class="row">
					<div class="col-md-12">
						<table class="table">
							<tr>
								<td>
									<p><span id="<?php //echo date('d F, Y',strtotime($date));?>" ><strong><?php //echo $title;?></strong></span></p>
									<p class="released"><?php //echo date('d F, Y',strtotime($date));?></p>
									<?php //echo $material_description;?>
								</td>
							</tr>
							<tr>
								<td class="text-center">
									<?php //if($materials['is_premium'] == 'N'){?>
									<a href="<?php //echo url('materials/download/'.$id.'/'.$material_path);?>" target="_blank">
										<img src="<?php //echo url('/').$title_image;?>" height="220px" alt="title image"></a>
										<?php /*}else{
											if($result['login_status']==true) {
												if($result['access_permission']==true){*/ ?>
												<a href="<?php //echo url('materials/download/'.$id.'/'.$material_path);?>" target="_blank">
													<img src="<?php //echo url('/').$title_image;?>" height="220px" alt="title image"></a>
													<?php //}else{?>
													<a href="javascript:void(0)" onclick="JMA.User.showUpgradeBox()">
														<img src="<?php //echo url('/').$title_image;?>" height="220px" alt="title image"></a>
														<?php //}?>
														<?php //}else{?>
														<a href="javascript:void(0)" onclick="JMA.User.showUpgradeBox()">
															<img src="<?php //echo url('/').$title_image;?>" height="220px" alt="title image"></a>
															<?php //}?>
															<?php //}?>
														</td>
													</tr>
												</table>
											</div>
										</div>
										<?php //echo $count == $i ? '<hr>' : '<hr>'; ?>
										<?php
									//}
								//}
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<form action="" class="form-horizantal" method="post">
							       <input type="hidden" name="_token" value="{{ csrf_token() }}">
									<a name="request_info"></a>
									<?php /*if(($flashMsg = Session::get('message')) != null) {
										echo "<p>".$flashMsg."<p>";
									}*/?>
									<p><i style="color: #ef6f07;" class="fa fa-question-circle"></i> Request Info</p>
									<div class="form-group">
										<label class="col-md-4">Name</label>
										<div class="col-md-8">
											<input type="text" style="margin-top: 5px" value="<?php //echo isset($result['postvars']['name']) ? $result['postvars']['name'] : ((Session::has('user.fname')) ? Session::get('user.fname').' '.Session::get('user.lname') : '');?>" id="req_name"
											name="name" class="form-control">
										</div>
									</div>

									

									<div class="form-group">
										<label class="col-md-4">Phone Number</label>
										<div class="col-md-8">
											<input type="text" style="margin-top: 5px" value="<?php //echo isset($result['postvars']['phone']) ? $result['postvars']['phone'] : ((Session::has('user.phone')) ? Session::get('user.phone') : '');?>" id="req_phone"
											name="phone" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4">Email</label>
										<div class="col-md-8">
											<input type="text" style="margin-top: 5px" value="<?php //echo isset($result['postvars']['email']) ? $result['postvars']['email'] : ((Session::has('user.email')) ? Session::get('user.phone') : '');?>" id="req_email"
											name="email" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12 ">
											<p>&nbsp;</p>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12 text-center">
											<button type="submit"  value="Submit" name="req_btn" class="btn btn-primary"><i class="fa fa-angle-double-right" ></i>Submit</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>-->
					<?php
  //include('view/templates/rightside.php');
					?>
					@stop