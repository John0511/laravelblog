@extends('layouts.app')
@section('content')
    <!-- Page Content -->
  <div class="container">
{{-- 顯示驗證錯誤 --}}
@if (count($errors) > 0)
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif
    <div class="row">
      <!-- Post Content Column -->
      <div class="col-lg-8">
        <!-- Title -->
        <h1 class="mt-4">{{$show->title}}</h1>

        <!-- Author -->
        <p class="lead">
          by
          <a href="/name/{{$show->name}}">{{$show->name}}</a>
        </p>

        <hr>

        <!-- Date/Time -->
        <p>{{$show->post_time}}</p>

        <hr>

        <!-- Preview Image -->
        @if(isset($show->image))
        <img class="img-fluid rounded" src="{{$show->image_url}}" alt="{{$show->title}}">
        @endif
        <hr>
        <p class="card-text" style="font-size:large; ">{!!$show->article!!}</p>
        <hr>
       
        <!-- Comments Form -->
        <div class="card my-4">
          <h5 class="card-header">留言:</h5>
          <div class="card-body">
          <form action="{{route('post.comment')}}" method="post">
                @csrf
              <div class="form-group">
                <textarea class="form-control" rows="3" name="comment"></textarea>
                <input type="hidden" name="post_id" value="{{$show->id}}">
              </div>
              <button type="submit" class="btn btn-primary">送出留言</button>
            </form>
          </div>
        </div>
        
        @foreach (DB::table('comments')->where('post_id', $show->id)->orderBy('id','desc')->get() as $comment)
        <div class="media mb-4">
            <div class="media-body">
              <h5 class="mt-0">{{$comment->name}}<h6>&ensp;&ensp;{{$comment->ip}}&ensp;&ensp;{{$comment->c_time}}</h6></h5>
              <h5>{{$comment->comment}}</h5>
              <hr>
            </div>
          </div> 
        @endforeach
        
        <!-- Single Comment -->
       

       

      </div>

      <!-- Sidebar Widgets Column -->
      <div class="col-md-4">

        <!-- Search Widget -->
        <div class="card my-4">
          <h5 class="card-header">搜尋文章</h5>
          <div class="card-body">
            <div class="input-group">
              <input type="text" class="form-control">
              <span class="input-group-append">
                <button class="btn btn-secondary" type="button">搜尋</button>
              </span>
            </div>
          </div>
        </div>

    

      </div>

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; 隨意寫部落格 2020</p>
    </div>
    <!-- /.container -->
  </footer>


@endsection