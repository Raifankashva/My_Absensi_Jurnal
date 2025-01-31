<?php

return [
    'required' => 'Kolom :attribute wajib diisi.',
    'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
    'min' => [
        'string' => 'Kolom :attribute harus memiliki minimal :min karakter.',
    ],
    'max' => [
        'string' => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
    ],
    'unique' => 'Data :attribute sudah digunakan.',
    'numeric' => 'Kolom :attribute harus berupa angka.',
    'date' => 'Kolom :attribute harus berupa tanggal yang valid.',
    'exists' => 'Data :attribute tidak ditemukan.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'before' => 'Kolom :attribute harus sebelum :date.',
    'after' => 'Kolom :attribute harus setelah :date.',
    'digits' => 'Kolom :attribute harus memiliki :digits digit.',
    'same' => 'Kolom :attribute dan :other harus sama.',
    'mimes' => 'Kolom :attribute harus berupa file dengan format: :values.',
    'integer' => 'Kolom :attribute harus berupa bilangan bulat.',
    
    'attributes' => [
        'name' => 'Nama',
        'email' => 'Email',
        'password' => 'Kata Sandi',
        'tanggal_lahir' => 'Tanggal Lahir',
        'no_hp' => 'Nomor HP',
        'alamat' => 'Alamat',
        'token' => 'Token',
    ],
];
