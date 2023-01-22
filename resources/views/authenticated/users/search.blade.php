@extends('layouts.sidebar')

@section('content')
<!-- <p>ユーザー検索</p> -->
<div class="search_content w-100 mt-3 d-flex">
  <div class="reserve_users_area">
    @foreach($users as $user)
    <div class="border m-2 one_person">
      <div class="user_top_area">
        <div class="user_icon">
          <span>ID : </span><span>{{ $user->id }}</span>
        </div>
        <div>
          <div>
            <!-- <span>ID : </span><span>{{ $user->id }}</span> -->
          </div>
          <div class="user_name ">
            <!-- <span>名前 : </span> -->
            <a href="{{ route('user.profile', ['id' => $user->id]) }}">
              <span>{{ $user->over_name }}</span>
              <span>{{ $user->under_name }}</span>
            </a>
          </div>
          <!-- <div>
            <span>カナ : </span>
            <span>({{ $user->over_name_kana }}</span>
            <span>{{ $user->under_name_kana }})</span>
          </div> -->
          <div>
            @if($user->sex == 1)
            <span class="text-muted">性別 : </span><span>男</span>
            @else
            <span class="text-muted">性別 : </span><span>女</span>
            @endif
          </div>
            <span class="text-muted">誕生日 : </span><span>{{ $user->birth_day }}</span>
        </div>
      </div>
      <div >
        <div>
          @if($user->role == 1)
          <span class="text-muted">権限 : </span><span>講師(国語)</span>
          @elseif($user->role == 2)
          <span class="text-muted">権限 : </span><span>講師(数学)</span>
          @elseif($user->role == 3)
          <span class="text-muted">権限 : </span><span>講師(英語)</span>
          @else
          <span class="text-muted">権限 : </span><span>生徒</span>
          @endif
        </div>
        <div>
          @if($user->role == 4)
          <span class="text-muted">選択科目 :</span>
          @endif
          @foreach($user->subjects as $subject)
          @if($subject->id == 1)
          <span> 国語 </span>
          @elseif($subject->id == 2)
          <span> 数学 </span>
          @elseif($subject->id == 3)
          <span> 英語 </span>
          @endif
          @endforeach
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="search_area w-25">
    <div class="search_container">
      <div class="search_box">
        <div class="search_count d-flex"><h5>検索</h5><span>{{ $users->count() }}名 / {{ $allUsers->count() }}名</span></div>
        <input type="text" class="free_word " name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
      </div>
      <div class="pt-3">
        <label>カテゴリー</label>
        <select class="" form="userSearchRequest" name="category">
          <option value="name">名前</option>
          <option value="id">社員ID</option>
        </select>
      </div>
      <div class="pt-3">
        <label>並び替え</label>
        <select class="" name="updown" form="userSearchRequest">
          <option value="ASC">昇順</option>
          <option value="DESC">降順</option>
        </select>
      </div>
      <div class="pt-3 mb-5">
        <p class="search_conditions"><span class="bg-secondary text-white">検索条件の追加</span></p>
        <div class="search_conditions_inner">
          <div>
            <label>性別</label>
            <span>男 </span><input type="radio" name="sex" value="1" form="userSearchRequest">
            <span>女 </span><input type="radio" name="sex" value="2" form="userSearchRequest">
          </div>
          <div>
            <label>権限</label>
            <select name="role" form="userSearchRequest" class="engineer ">
              <option selected disabled>----</option>
              <option value="1">教師(国語)</option>
              <option value="2">教師(数学)</option>
              <option value="3">教師(英語)</option>
              <option value="4" class="">生徒</option>
            </select>
          </div>
          <div class="selected_engineer">
            <label>選択科目</label>
            <li>国語 <input type="checkbox" name="subject" value="1" form="userSearchRequest"></li>
            <li>数学 <input type="checkbox" name="subject" value="2" form="userSearchRequest"></li>
            <li>英語 <input type="checkbox" name="subject" value="3" form="userSearchRequest"></li>
          </div>
        </div>
      </div>
    </div>
      <div class="search_area_bottom ">
        <div>
          <input class="pl-5 pr-5 btn btn-info" type="submit" name="search_btn" value="検索" form="userSearchRequest">
        </div>
        <div class="mt-3">
          <input class="btn-reset" type="reset" value="リセット" form="userSearchRequest">
        </div>
      </div>
    <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
  </div>
</div>
@endsection
