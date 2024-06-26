<x-layout :page="$post->title">


    <div class="container-fluid">
        
        <div class="row">

            <div class="col-3">
                <div class="sidebar px-2 py-3">

                    <div class="wedget border bg-light mb-3">
                        <h4 class="wedget-title bg-dark text-light px-4 py-3">Author info</h4>
                        <div class="wedget-content p-3 mb-3">
                            <ul class="text-muted m-0">
                                <li>Name: {{ $post->user->name }}</li>
                                <li>Email: {{ $post->user->email }}</li>
                                <li>Member since: {{ $post->user->created_at->DiffForHumans() }}</li>
                            </ul>
                        </div>
                    </div>

                    <div class="wedget border bg-light mb-3">
                        <h4 class="wedget-title bg-dark text-light px-4 py-3">Latest Posts</h4>
                        <div class="wedget-content p-3 mb-3">
                            @foreach ($latest_posts as $latest_post)
                                <div class="single-post mb-3">
                                    <a href="{{ route('post.show', $latest_post->id) }}">
                                        {{ $latest_post->title }}
                                    </a>
                                    By 
                                    <a href="{{ route('user.show', $latest_post->user->id) }}">
                                        {{ $latest_post->user->name }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="wedget border bg-light mb-3">
                        <h4 class="wedget-title bg-dark text-light px-4 py-3">Search for Posts</h4>
                        <div class="wedget-content p-3 mb-3">
                            <form 
                                action="{{ route('post.search') }}"
                                method="GET">

                                <div class="input-group">
                                    <input type="submit" value="Find" class="btn btn-primary">
                                    <input type="text" placeholder="Type something" class="form-control" name="query">
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>

            <div class="col-9">
                <div class="main-content">
                    <div class="post bg-light p-5 pt-0">
                        <div class="title pt-5 pb-4">
                            <h2>{{ $post->title }}</h2>
                            <span class="text-muted fs-5">
                                Published: {{$post->created_at->DiffForHumans()}},
                                By: <a href="{{ route('user.show', $post->user->id)}}">{{ $post->user->name }}</a>
                            </span>
                        </div>
                        <img 
                            src="{{ asset('storage/' . ($post->image ?? 'images/banner.jpg')) }}" 
                            alt="{{ $post->title }}"
                            class="d-block img-thumbnail rounded-4 w-100 mb-4">
            
            
                        <p class="lead">
                            {{ $post->content }}
                        </p>
            
                        {{-- awner buttons --}}
                        @if ($post->user_id == Auth::user()->id)
                            <div class="actions text-right">
                                <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-success">Edit post</a>
                                <form 
                                    action="{{ route('post.destroy', $post->id) }}"
                                    method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <input 
                                        onclick="return confirm('Are you sure that you want to delete this post?')" 
                                        class="btn btn-sm btn-danger" 
                                        type="submit" 
                                        name="submit"
                                        value="Delete post">
                                </form>
                            </div>
                        @endif
                        {{-- awner buttons --}}
            
            
                        {{-- comments section --}}
                        <div class="comments" id="post-comments">
                            <hr class="my-4">
                            <h3>Comments</h3>
            
                            @session('message')
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endsession
            
                            @foreach ($comments as $comment)
                                <div class="single-comment border p-4 mb-2 rounded">
                                    <h5>
                                        <a href="{{ route('user.show', $comment->user_id) }}">
                                            <img 
                                                src="{{ asset('storage/' . ($comment->user->image ?? 'images/default.jpg')) }}" 
                                                alt="{{ $comment->user->name }}"
                                                class="rounded-circle position-relative"
                                                style="width: 32px; top: -2px">
                                            {{ $comment->user->name }}
                                        </a>
                                    </h5>
                                    <p class="text-muted">
                                        {{ $comment->comment }}
                                    </p>
                                    <div class="date text-muted">
                                        {{ $comment->created_at->DiffForHumans() }}
                                    </div>
                                    @if ($comment->user_id == Auth::user()->id)
                                        <div class="owner mt-3">
                                            <a 
                                                href="{{ route('comment.edit', $comment->id) }}" 
                                                class="btn btn-sm btn-primary">Edit</a>
                                            <form 
                                                onsubmit="return confirm('Are you sure that you want to delete this comment?')"
                                                action="{{ route('comment.destroy', $comment->id)}}"
                                                class="d-inline"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" value="Delete" class="btn btn-sm btn-danger">
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
            
                            <div class="add-comment mt-4">
                                <h3 id="add-comment" class="py-3">Add a new comment</h3>
                                <form 
                                    action="{{ route('comment.store') }}"
                                    method="POST"
                                    class="form add-comment">
            
                                    @csrf
            
                                    <input type="hidden" value="{{ $post->id }}" name="post_id">
            
                                    <div class="form-group mb-3">
                                        <textarea 
                                            name="comment" 
                                            style="height: 280px"
                                            class="form-control">{{ old('comment') }}</textarea>
                                        
                                        @error('comment')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
            
                                    </div>
            
                                    <div class="form-group">
                                        <input type="submit" value="Publish" name="submit" class="btn btn-primary px-4">
                                    </div>
                                </form>
                            </div>
            
                        </div>
                        {{-- comments section --}}
                    </div>
                </div>
            </div>

        </div>

    </div>
    


</x-layout>