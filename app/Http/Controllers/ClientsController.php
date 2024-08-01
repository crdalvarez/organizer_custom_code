<?php

namespace App\Http\Controllers;
use \stdClass;
use App\Models\User;
use App\Models\Client;

class ClientsController extends Controller
{
    
    public function index(Client $client, User $user)
    {
        $clients = Client::all();
        return view('clients/index', compact('clients'));
    }

    public function new()
    {
        return view('clients/new');
    }

    public function create()
    {
        $data = request()->validate([
            'name' => ['required'],
            'description' => ['required'],
            'details' => ['required'],
        ]);

        $data['user_id'] = auth()->user()->id;
        $client = auth()->user()->clients()->create($data);

        return redirect('client/' . $client->id);
    }

    public function show(Client $client)
    {
        $data = new stdClass();
        $data->module = $client;
        $data->commentableType = Client::class;
        $comments = new CommentsController();
        $comments = $comments->show($data->module);

        $data->comments = $comments;

        return view('clients/show', compact('client', 'data'));
    }

    public function edit(Client $client)
    {
        return view('clients/edit', compact('client'));
    }

    public function update(Client $client, User $user)
    {
        $clientData = request()->validate([
            'name' => ['required'],
            'description' => ['required'],
            'details' => ['required'],
        ]);

        $clientProfileData = request()->validate([
            'title' => [],
            'industry' => [],
            'descriptors' => [],
            'address' => [],
            'url' => [],
            'email' => [],
            'phone' => [],
        ]);

        if (request('image')) {
            $imagePath = request('image')->store('profile', 'public');
            $imageArray = ['image' => $imagePath];
        }

        $client = Client::find($client->id);
        $client->update(array_merge($clientData, $imageArray ?? []));
        $client->clientProfile->update($clientProfileData);

        return redirect("client/{$client->id}");
    }
}
