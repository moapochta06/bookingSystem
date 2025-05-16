<?php

return [
    'required' => 'Поле :attribute обязательно для заполнения.',
    'email' => 'Поле :attribute должно быть действительным email-адресом.',
    'unique' => 'Такое значение поля :attribute уже существует.',
    'confirmed' => 'Поле :attribute не совпадает с подтверждением.',
    'max' => [
        'string' => 'Поле :attribute не должно превышать :max символов.',
    ],
    'min' => [
        'string' => 'Поле :attribute должно содержать минимум :min символов.',
    ],
    'attributes' => [
        'name' => 'Имя',
        'email' => 'Email',
        'password' => 'Пароль',
    ],
];