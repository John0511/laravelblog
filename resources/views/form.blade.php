@extends('layouts.app')
@section('content')

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

      <!-- Blog Entries Column -->
      <div class="col-md-8">

        <h1 class="my-4">新增文章
        </h1>

        <!-- Blog Post -->
        <form action="{{route('post.store')}}" method="post"  enctype="multipart/form-data">
          @csrf
        <div class="card mb-4">
          <table class="table-hover">
                 
            <tr>
               <td ><div class="badge badge-primary d-flex justify-content-around mb-3"><h2>標題</h2></div> </td>
                <td><input type="text" class="form-control" name="title" ></td>
            </tr>
             <tr>
               <td><div class="badge badge-primary d-flex justify-content-around mb-3"><h2>內容</h2></div>  </td>
               <td><textarea class="form-control" rows="8" name="article"></textarea></td>
             </tr>
             <tr>
               <td ><div class="badge badge-primary d-flex justify-content-around mb-3"><h2>圖片</h2></div>  </td>
               <td ><input type="file" class="form-control-file border" name="image"></td>
             </tr>
             <tr>
                 <td colspan="2"  >
                     <div class="d-flex justify-content-center"><input type="submit" class="btn btn-primary"  value="送出文章"></div></td>
             </tr>
            
           </table>
          </div>
          </form>
        </div>
    <!-- /.row -->
    </div>
  <!-- /.container -->
</div>
  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; 隨意寫部落格 2020</p>
    </div>
    <!-- /.container -->
  </footer>



@endsection