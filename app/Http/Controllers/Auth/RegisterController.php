<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    // Обработка данных регистрации
    public function store(Request $request)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'email.unique' => 'Этот email уже зарегистрирован.',
            'password.confirmed' => 'Пароли не совпадают.',
        ]);

        // Создание нового пользователя
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Аутентификация пользователя
        Auth::guard('web')->login($user);

        // Перенаправление с сообщением
        return redirect('/');
    }
}
// ->with('auth', ['user' => null])