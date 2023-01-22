@extends('layouts.sidebar')

@section('content')
<div class="board_area w-100 border m-auto d-flex">
  <div class="post_view w-75 mt-5">
    <p class="w-75 ml-5">投稿一覧</p>
    <div class="post_all">
      @foreach($posts as $post)
      <div class="post_area border w-90 p-3">
        <div class="d-flex post_top_area">
          <p class="post_un text-muted"><span>{{ $post->user->over_name }}</span><span class="ml-1">{{ $post->user->under_name }}</span>さん<span class="ml-2">{{ $post->created_at }}</span></p>
          <div class="">
            <span><?php
            //乱数表示でviewカウントしてる風
            $min = 10;
            $max = 500;
            echo mt_rand($min, $max);
            ?></span><span class="text-muted"> views</span>
          </div>
        </div>
        <p><a href="{{ route('post.detail', ['id' => $post->id]) }}" class="visible-link">{{ $post->post_title }}</a></p>
        <p><a href="{{ route('post.detail', ['id' => $post->id]) }}" class="hidden-link"></a></p>
        <div class="d-flex ctg_fa">
          @foreach($post->subCategories as $sub_category)
          <p class="post_ctg">{{ $sub_category->sub_category }}</p>
          @endforeach
          <div class="post_bottom_area d-flex">
            <div class="d-flex post_status">
              <div class="mr-5">
                <p><i class="fa fa-comment"></i><span class="">{{ DB::table('post_comments')->where('post_id', $post->id)->count() }}</span></p>
              </div>
              <div>
                @if(Auth::user()->is_Like($post->id))
                <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span></p>
                @else
                <p class="m-0"><i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span></p>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  <div class="other_area pt-30 w-25">
    <div class=" m-4">
      <div class="post_button"><a href="{{ route('post.input') }}" class="post_link text-white ">投稿</a></div>
      <div class="serch_area">
        <input type="text" class="form-control keyword_area" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input type="submit" class="btn btn-outline-info" value="検索" form="postSearchRequest">
      </div>
      <div class="like_mine">
        <input type="submit" name="like_posts" class="category_btn ctg_like" value="いいねした投稿" form="postSearchRequest">
        <input type="submit" name="my_posts" class="category_btn ctg_mine" value="自分の投稿" form="postSearchRequest">
      </div>

      <div id="accordion" class="accordion-container">
        <h6>カテゴリー</h6>
        @foreach($categories as $category)
        <p class="main_categories accordion-title js-accordion-title">{{ $category->main_category }}</p>
        <div class="accordion-content">
          @foreach($category->subCategories as $sub_category)
          <input type="submit" class="btn btn-link" name="category_word" value="{{ $sub_category->sub_category }}" form="postSearchRequest">
          <input type="hidden" name="category_id" value="{{ $sub_category->id }}" form="postSearchRequest">
          @endforeach
        </div><!--/.accordion-content-->
        @endforeach
      </div><!--/#accordion-->

    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>
@endsection
