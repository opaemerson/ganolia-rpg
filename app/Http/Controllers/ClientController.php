<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController
{
    public function index(Request $request)
    {
        $search = $request->get('q');

        $clients = Client::with(['phones', 'emails', 'addresses'])
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('document', 'like', "%{$search}%")
                    ->orWhereHas('phones', function ($qPhones) use ($search) {
                        $qPhones->where('phone', 'like', "%{$search}%");
                    })
                    ->orWhereHas('emails', function ($qEmails) use ($search) {
                        $qEmails->where('email', 'like', "%{$search}%");
                    });
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('register.list-client', compact('clients'));
    }

    public function create()
    {
        return view('register.create-client');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'document' => 'nullable|string|max:20',
            'type'     => 'required|in:fisica,juridica',
            'active'   => 'boolean',

            'phone'    => 'nullable|string|max:20',
            'email'    => 'nullable|email|max:255',

            'street'   => 'nullable|string|max:255',
            'number'   => 'nullable|string|max:20',
            'city'     => 'nullable|string|max:100',
            'state'    => 'nullable|string|max:2',
            'cep' => 'nullable|string|max:8',
        ]);

        DB::transaction(function () use ($data) {

            $client = Client::create($data);

            if (!empty($data['phone'])) {
                $client->phones()->create([
                    'phone'   => $data['phone'],
                ]);
            }

            if (!empty($data['email'])) {
                $client->emails()->create([
                    'email'   => $data['email'],
                ]);
            }

            if (!empty($data['street'])) {
                $client->addresses()->create([
                    'street'   => $data['street'],
                    'number'   => $data['number'] ?? null,
                    'city'     => $data['city'],
                    'state'    => $data['state'],
                    'cep' => $data['cep'],
                ]);
            }
        });

        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function edit(Client $client)
    {
        $client->load(['phones', 'emails', 'addresses']);
        $client->phone   = $client->phones->first()->phone ?? null;
        $client->email   = $client->emails->first()->email ?? null;
        $address         = $client->addresses->first();

        $client->street  = $address->street ?? null;
        $client->number  = $address->number ?? null;
        $client->city    = $address->city ?? null;
        $client->state   = $address->state ?? null;
        $client->cep = $address->cep ?? null;

        return view('register.edit-client', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'document' => 'nullable|string|max:20',
            'type'     => 'required|in:fisica,juridica',
            'active'   => 'boolean',

            'phone'    => 'nullable|string|max:20',
            'email'    => 'nullable|email|max:255',

            'street'   => 'nullable|string|max:255',
            'number'   => 'nullable|string|max:20',
            'city'     => 'nullable|string|max:100',
            'state'    => 'nullable|string|max:2',
            'cep' => 'nullable|string|max:10',
        ]);

        DB::transaction(function () use ($client, $data) {

            $client->update($data);

            if (!empty($data['phone'])) {
                $client->phones()->updateOrCreate(
                    ['phone' => $data['phone']]
                );
            }

            if (!empty($data['email'])) {
                $client->emails()->updateOrCreate(
                    ['email' => $data['email']]
                );
            }

            if (!empty($data['street'])) {
                $client->addresses()->updateOrCreate(
                    [
                        'street'   => $data['street'],
                        'number'   => $data['number'] ?? null,
                        'city'     => $data['city'],
                        'state'    => $data['state'],
                        'cep' => $data['cep'],
                    ]
                );
            }
        });

        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente atualizado com sucesso!');
    }


    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente removido com sucesso!');
    }
}
