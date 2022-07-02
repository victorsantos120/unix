<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfileFormRequest;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function profile()
    {
        return view('site.profile.profile');
    }

    public function profileUpdate(UpdateProfileFormRequest $request)
    {
        $user = auth()->user();
        $data = $request->all();

        if ($data['password'] != null)
            $data['password'] = bcrypt($data['password']);
        else
            unset($data['password']);

        $data['image'] = $user->image; // caso já axista a imagem cadastrada, ficara com mesmo nome
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($user->image)
                $name = $user->image;
            else
                $name = $user->id . kebab_case($user->name);

            $extension = $request->image->extension();
            $nameFinal = $name . "." . $extension;

            $data['image'] = $nameFinal;
            $upload = $request->image->storeAs('users', $nameFinal);

            if (!$upload)
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer upload da imagem');
        }
        
        $update = $user->update($data);

        if ($update)
            return redirect()
                    ->route('profile')
                    ->with('success', 'Sucesso ao atualizar!');

        return redirect()
            ->back()
            ->with('error', 'Falha ao atualizar o perfil...');
    }
}
