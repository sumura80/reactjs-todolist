@extends('layouts.app')

@section('content')

<h1>Posts</h1>
@if(count($posts)>0)
  @foreach($posts as $post)
  <h3><a href="/posts/{{$post->slug}}">{{ $post->title }}</a></h3>
<p>Written on {{ $post->created_at->format('m/d/Y')  }}</p>
  @endforeach 
  {{$posts->links()}}
@else
  <p>No Posts Found</p>
@endif
@endsection