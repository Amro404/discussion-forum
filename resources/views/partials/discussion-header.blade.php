	<div class="card-header">
				<div class="d-flex justify-content-between">

						<div>
							<img height="40px" width="40px" style="border-radius: 50%" src="{{Gravatar::src('$discussion->user->email') }}">
						<strong class="ml-2">{{ $discussion->user->name }}</strong>							
						</div>

					<div>
						<a href="{{ route('discussions.show', $discussion->slug) }}" class="btn btn-success btn-sm">View</a>
					</div>
				</div>
			</div>