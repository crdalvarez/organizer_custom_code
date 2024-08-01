@if ($posts->isNotEmpty())
    @foreach ($posts as $post)
        <div class="post">
            <div class="">
                <p class="text-right">Created: <span class="pl-3 text-primary">{{ $post->created_at }}</span></p>
            </div>
            <div>
                <p>{!! $post->post !!}</p>
            </div>

            @if (!empty($post->file))
                @php
                    $extension = pathinfo($post->file, PATHINFO_EXTENSION);
                @endphp
                @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'], true))
                test
                    <img src="{{ Storage::url($post->file) }}" class="image-fluid" style="width: 100%; height: auto;" />
                @else
                    <a href="{{ Storage::url($post->file) }}">{{ $post->file }}</a>
                @endif
            @endif
        </div>
    @endforeach
@else
    <div class="callout callout-info mt-2">
        <h4>There are no post yet.</h4>
    </div>
@endif
