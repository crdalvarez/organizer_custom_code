    <div class="container mx-auto p-4">
        <form method="POST" action="{{ route('comment.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="comment" class="form-label">New Comment</label>
                <input id="comment" class="form-control" type="text" name="comment" value="{{ old('comment') }}" required autofocus autocomplete="comment">
                @error('comment')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">File</label>
                <input id="file" class="form-control" type="file" name="file" value="{{ old('file') }}" autocomplete="file">
                <input id="commentable_type" type="hidden" name="commentable_type" value="{{$data->commentableType}}">
                
                <input id="commentable_id" type="hidden" name="commentable_id" value="{{$data->module->id}}">
                @error('file')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary ms-4">New Comment</button>
            </div>
        </form>
    </div>
