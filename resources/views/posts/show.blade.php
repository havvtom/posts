@extends('layouts.app')

@section('content')
<div class="flex justify-center">
	<div class="w-6/12 bg-white p-6 rounded-lg">
		<div class="flex justify-between">
			<div class="text-gray-700 text-2xl font-bold mb-4">
				Posts
			</div>
			@guest
				<p>Please <a class="text-blue-500" href="{{ route('login') }}">login</a> to create a post</p>
			@endguest
			@auth
				<div class="mb-4 flex justify-end">
					<a href="{{ route('posts.create') }}" type="submit" class="bg-blue-500 text-white px-4 py-2 rounded font-medium">
						Create Post
					</a>
				</div>
			@endauth
		</div>	
		
		<div>
			<div class="mt-4">						
				<a href="" class="font-bold mb-3">
					{{ $post->user->name }}
				</a><span class="text-gray-600 text-sm">{{ $post->created_at->diffForHumans() }}</span>
				<div class="mt-4">
					<a href="{{ route('posts.show', $post) }}" class="font-semibold my-4 ">
						{{ $post->title }}
					</a href="#">
				</div>
				<p class="my-2">
					{{ $post->body }}
				</p>
				@can('update-post', $post)
					<div class="flex justify-between">
						<div class="flex">
							<form method="post" action="{{ route('posts.destroy', [ $post ]) }}">
								@method("DELETE") 
								@csrf
								<button type="submit" class="bg-red-500 text-white mr-2 px-4 py-1 rounded font-medium">
									Delete
								</button>
							</form>
							<a href="{{ route('posts.edit', $post) }}" class="bg-blue-500 text-white px-4 py-1 rounded font-medium">
								Edit
							</a>
						</div>
						<div>
							<a href="{{ route('posts.index') }}" class="bg-gray-500 text-white px-4 py-1 rounded font-medium">
								Back
							</a>
						</div>
					</div>
				@endcan
			</div>				
		</div>
	</div>
	
</div>
@endsection