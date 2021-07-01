@extends('layouts.app')

@section('content')
<div class="flex justify-center">
	
	<div class="w-6/12 bg-white p-6 rounded-lg">
		<div class="text-gray-700 text-2xl font-bold mb-4">
			Create Post
		</div>
		<form action="{{ route('posts.store') }}" method="post" class="mb-6">
			@csrf
				<div class="mb-6">
					<label class="block mb-2 uppercase font-bold text-xs text-gray-700 @error('title') text-red-500 @enderror"
						for="title" 
					>
						Title
					</label>

					<input 
						class="border border-blue-400 rounded-lg p-2 w-full" 
						type="text"
						name="title"
						id="title"
					>
					@error('title')
						<div class="text-red-500 text-sm">
							{{ $message }}
						</div>
					@enderror
				</div>
				<div class="mb-6">
					<label class="block mb-2 uppercase font-bold text-xs text-gray-700  @error('body') text-red-500 @enderror"
						for="body" 
					>
						Description
					</label>
					<textarea
				            class="w-full outline-none border border-blue-400 rounded-lg py-4 px-8 "
				            name="body"
				            id="body"
				            cols="30"
				            rows="4"
				            placeholder="Post something!"
				    ></textarea>
					@error('body')
						<div class="text-red-500 text-sm">
							{{ $message }}
						</div>
					@enderror
				</div>
			<div>
				<button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded font-medium">
					Save Post
				</button>
			</div>
		</form>		
	</div>
	
</div>
@endsection