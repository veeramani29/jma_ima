@extends('templates.default')
@section('content')
<?php
$resn = $result['posts'];

$category_path = isset($result['category_path'])?$result['category_path']:'';

?>
<div class="col-xs-12 col-md-10">
		<?php
		$count = count($resn);
		if($count==0)
		{
			?>
			<h3>Sorry, No items found</h3>
			<?php
		} else {?>
		<div class="first-section">
					<div class="sec-title sec-date">
							<h1>{{ucfirst(str_replace(["-","/"],[" "," > "],$category_path))}}</h1>
						<div class="sttl-line"></div>
					</div>
		<ul class="list-inline fc_links"> <?php 
			for($i=0;$i<$count;$i++)
			{  
			$news_link_url="href=".url('/page/category/'.$category_path.$resn[$i]['category_url']).""; 	?>
			 <li> 
			 	<h5> 
			
			<a class="title-link" <?php echo $news_link_url;?>> <?php echo stripslashes($resn[$i]['post_category_name']);?> </a>|
			</h5>
			</li>
        
						
					
				
				<?php
				
			}
		}
		?>
	</ul>
	</div>
</div>


@stop