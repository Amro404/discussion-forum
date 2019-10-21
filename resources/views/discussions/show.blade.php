@extends('layouts.app')

@section('content')


		<div class="card mb-5">
			@include("partials.discussion-header")

			<div class="card-body">
				

				{{ $discussion->title }}
				
				<hr>

				{!! $discussion->content !!}

				@if($discussion->bestReply)
					<div class="card bg-success my-5" style="color: #fff;">
						<div class="card-header">
							<div class="d-flex justify-content-between">
								<div>
									<img height="40px" width="40px" style="border-radius: 50%" src="{{ Gravatar::src('$discussion->bestReply->user->email') }}">
								<span>{{ $discussion->bestReply->user->name }}</span>
								</div>

								<div>
									<strong>Best Reply</strong>
								</div>
								
							</div>
						</div>

						<div class="card-body">
							{!! $discussion->bestReply->content !!}
						</div>
					</div>
				@endif
				
				
			</div>
		</div>

		@foreach($discussion->replies()->paginate(3) as $reply)
			<div class="card-md-5">
				<div class="card-header">
					<div class="d-flex justify-content-between">
						<div>
							<img height="40px" width="40px" style="border-radius: 50%" src="{{ Gravatar::src('$reply->user->email') }}">
							<span>{{ $reply->user->name }}</span>
						</div>

						<div>

						@if(Auth::user() && auth()->user()->id == $discussion->user_id)	
							<form action="{{ route('discussions.best-reply',['discussion' => $discussion->slug, 'reply' => $reply->id]) }}" method="POST">
								@csrf
								<button type="submit" class="btn btn-sm btn-info">Mark as best reply</button>
							</form>
						@endif
					</div>
					</div>
				</div>

				<div class="card-body">
					{!! $reply->content !!}
		
				</div>

				
			</div>


		@endforeach
		{{ $discussion->replies()->paginate(3)->links() }}
		
		<div class="card my-5">
			<div class="card-header">
				Add a reply
			</div>

			<div class="card-body">
				@auth
					<form action="{{ route('replies.store', $discussion->slug) }}" method="POST">
						@csrf

						<div class="form-group">
	                    <label for="content">Content</label>
	    

	                    <input id="content" type="hidden" name="content" value="{{ old('content') }}">
	                    <trix-editor input="content"></trix-editor>

	                </div>
	                <div class="form-group">
	                    
	                    <button  class="btn btn-sm btn-success"> 
	                    	Add reply
	                    </button>

	                </div>
					</form>


				@else

					<a href="{{ route('login') }}" class="btn btn-info">Sign in to add a reply</a>

				@endauth
			</div>
		</div>

 
@endsection

@section("scripts")
     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.js"></script>
@endsection

@section("css")
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.css">
@endsection
