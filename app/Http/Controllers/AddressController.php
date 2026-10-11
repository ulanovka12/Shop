<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'city'        => ['required', 'string', 'max:255'],
            'street'      => ['required', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'phone'       => ['nullable', 'string', 'max:30'],
            'is_default'  => ['nullable', 'boolean'],
        ]);

        $data['user_id']    = $request->user()->id;
        $data['is_default'] = $request->boolean('is_default');

        DB::transaction(function () use ($request, $data) {
            // если новый адрес «по умолчанию» — снимаем флаг со старых
            if ($data['is_default']) {
                $request->user()->addresses()->update(['is_default' => false]);
            }

            $request->user()->addresses()->create($data);
        });

        return back()->with('status', 'address-created');
    }

    public function setDefault(Request $request, Address $address): RedirectResponse
    {
        abort_unless($address->user_id === $request->user()->id, 403);

        DB::transaction(function () use ($request, $address) {
            $request->user()->addresses()->update(['is_default' => false]);
            $address->update(['is_default' => true]);
        });

        return back();
    }

    public function destroy(Request $request, Address $address): RedirectResponse
    {
        abort_unless($address->user_id === $request->user()->id, 403);

        $address->delete();

        return back();
    }
}
