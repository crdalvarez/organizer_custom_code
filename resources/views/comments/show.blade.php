@if (!empty($data->comments))
    @foreach ($data->comments as $comment)
        <div class="mt-2 bg-white border-top border-gray-50">
            <div class="w-full overflow-hidden">
                <section>
                    <div class="container mx-auto p-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pb-3">
                                    <div class="text-left">Posted by: <span class="text-primary"><a
                                                href="{{ route('profile.show', $comment->user->id) }}">{{ $comment->user->name }}
                                                {{ $comment->user->lastname }}</a></span></div>
                                    <div class="text-left text-sm">Created at {{ $comment->created_at }}</div>
                                </div>
                                <div class="card p-3">
                                    <div>
                                        <p>{!! $comment->comment !!}</p>
                                    </div>
                                    <div class="mt-1">
                                        @if (!empty($comment->file))
                                            {!! $comment->file !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    @endforeach
@endif
