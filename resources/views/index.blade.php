@extends('layouts.app')
@section('content')
<div class="container">

    <div class="row">

      <!-- Blog Entries Column -->
      <div class="col-md-8">

        <h1 class="my-4" >隨意寫部落格
        </h1>

        <!-- Blog Post -->
        @forelse ($posts as $post)
        <div class="card mb-4">
        @if (isset($post->image))
        <img class="card-img-top rounded" src={{$post->image_url}} alt={{$post->title}}>
        @endif
          <div class="card-body">
            @guest
            <h2 class="card-title" style="font-size:xx-large;">{{$post->title}}</h2>
            <p class="card-text" style="font-size:large; ">{!!$post->article!!}</p>
            <a href="/show/{{$post->id}}" class="btn btn-primary">繼續閱讀 &rarr;</a>留言({{DB::table('comments')->where('post_id',$post->id)->count()}})
            <div class="card-footer text-muted">
              Posted on {{$post->post_time}} by
            <a href="/name/{{$post->name}}">{{$post->name}}</a>
            </div>    
            @endguest  
            @auth
              @if (Auth::user()->id == $post->user_id)
              <h2 class="card-title" style="font-size:xx-large;">{{$post->title}}</h2>
              <p class="card-text" style="font-size:large; ">{!!$post->article!!}</p>
              <a href="/show/{{$post->id}}" class="btn btn-primary">繼續閱讀 &rarr;</a>
              <a href="/edit/{{$post->id}}"class="btn btn-primary">編輯文章</a>
              <a href="#" class="btn btn-primary btn-del-post" id="delete-button" data-id="{{$post->id}}">刪除文章</a> 留言({{DB::table('comments')->where('post_id',$post->id)->count()}})
              <div class="card-footer text-muted">
                Posted on {{$post->post_time}} by
              <a href="/name/{{$post->name}}">{{$post->name}}</a>
              </div>   
              @else
              <h2 class="card-title" style="font-size:xx-large;">{{$post->title}}</h2>
              <p class="card-text" style="font-size:large; ">{!!$post->article!!}</p>
              <a href="/show/{{$post->id}}" class="btn btn-primary">繼續閱讀 &rarr;</a>留言({{DB::table('comments')->where('post_id',$post->id)->count()}})
              <div class="card-footer text-muted">
                Posted on {{$post->post_time}} by
              <a href="/name/{{$post->name}}">{{$post->name}}</a>
              </div>   
              @endif
          @endauth
          
           
            
    
          
          </div>
          
        </div>
        
        @empty
        <h1 class="my-4" >目前沒有文章
        </h1>

        @endforelse
        
       
      
        <!-- Pagination -->
        
        <ul class="pagination justify-content-center mb-4">
          {!! $posts->links() !!}
        </ul>

      </div>
      
      <!-- Sidebar Widgets Column -->
      <div class="col-md-4">

        <!-- Search Widget -->
      <form action="{{route('post.search')}}" method="get">
        @csrf
        <div class="card my-4">
          <h5 class="card-header">搜尋文章</h5>
          <div class="card-body">
            <div class="input-group">
              <input type="text" class="form-control" name="keyword">
              <span class="input-group-append">
                <button class="btn btn-secondary" type="submit">搜尋</button>
              </span>
            </div>
          </div>
        </div>
      </form>

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



  
</body>

@endsection


@section('script')
<script>
jQuery(document).ready(function(){
  $('.btn-del-post').click(function () {
     var post_id=$(this).data('id');
    var yes = confirm('確定刪除文章?');
    if (yes) {
     axios.delete('/post/' + post_id)
      .then(function(){
        alert('文章已刪除');
        location.reload()
                      }); 
      } else {
        
        return;
     }  
  });
});
</script>  
@endsection
