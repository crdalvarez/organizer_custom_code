<div class="row">
    <div class="col-12 col-md-12 col-lg-12 p-3 pt-5">
        <h3 class="text-primary">Add Client</h3>
    </div>
    <div class="row p-3 w-100">
        <form method="POST"action="{{ route('project.client.add') }}" class="w-100">
            @csrf
            <div class="row w-100">
                <div class="col-8">
                    <select name="client" class="form-control w-100">
                        @foreach ($data->clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4">
                    <input type="hidden" name="project" value="{{ $data->module->id }}" />
                    <button class="btn btn-primary" type="submit">Add Client</button>
                </div>
            </div>
        </form>
    </div>
</div>
