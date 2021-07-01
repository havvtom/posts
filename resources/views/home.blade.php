@extends('layouts.app')

@section('content')
	<div class="flex justify-center">
		<div class="w-6/12 bg-white p-6 rounded-lg">
			@auth
				You are logged in !!! You can navigate to <a href="{{ route('posts.index') }}" class="text-blue-500">posts.</a>
			@endauth
			@guest
				You need to <a href="{{ route('login') }}" class="text-blue-500">login</a> to create posts
			@endguest
			
		</div>
	</div>
@endsection