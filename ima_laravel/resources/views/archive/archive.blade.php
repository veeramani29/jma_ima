@extends('templates.default')
@section('content')
<div class="col-md-10 col-xs-12">
  <div class="content">
    <table class="table border">
      <thead>
        <tr>
          <th>No</th>
          <th>Title</th>
          <!-- <th>Updated Time</th> -->
          <th>Published on</th>
        <!--   <th>Past Comments</th> -->
          <!-- <th><a href="{{url('/add')}}">Add</a></th> -->
        </tr>
      </thead>
      
      <?php
      $no=1;
      ?>
      <tbody>
        @if(!empty($result))
        @foreach($result as $row)
        
        <tr>
          <td><?php echo $no; ?></td>
           <?php $str_slug=$row['slug'];?>
          <td><a href="{{url('/archive/'.$str_slug)}}">{{$row['post_title']}} / <?php echo $row['updated_date'] ?></a></td>
          
          <td>{{$row['post_released']}}</td>
           

         <!--  <td class="text-center"><a href="{{url('/archive/'.str_slug($str_slug).'/'.$row['id'])}}"><i class="fa fa-eye" aria-hidden="true"></i></a></td> -->
        </tr>
        <?php
        $no++;
        ?>
        @endforeach
        @endif
      </tbody>
    </table>
    <?php
    if(empty($result)){
    ?>
    <p class="text-center">No data found</p>
    <?php
    } ?>
  </div>
</div>
@stop