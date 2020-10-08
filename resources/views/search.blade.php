@extends('layouts.app')
@section('content')
<div class="container">

    <div class="row">

      <!-- Blog Entries Column -->
      <div class="col-md-8">

        <h1 class="my-4" >隨意寫部落格
        </h1>

        <!-- Blog Post -->
        @forelse ($search as $posts)
        <div class="card mb-4">
          <div class="card-body">
            <a href="/show/{{$posts->id}}" ><h2 class="card-title" style="font-size:xx-large;">{{$posts->title}}</h2></a>
          </div>
        </div>
        
        @empty
        <h1 class="my-4" >找不到文章
        </h1>

        @endforelse

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

