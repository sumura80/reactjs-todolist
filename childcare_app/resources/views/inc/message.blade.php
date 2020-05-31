@if(session('success'))
  <div class="alert alert-success mt-2">
    {{session('success')}}
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger mt-2">
    {{session('error')}}
  </div>
@endif 

<!-- 検索文字を最低３語入れないとエラーになる -->
{{-- @if($errors-> has('keyword') )
<div class="alert alert-danger mt-2">
  {{$errors->first('keyword')}}
</div>
@endif  --}}