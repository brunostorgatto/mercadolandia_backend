<?php

return [
    'invite' => [
        'required' => 'Por favor, insira o código do convite.',
        'not_found' => 'Este código de convite não existe.',
        'used'     => 'Este convite já foi utilizado.',
        'expired'  => 'Este convite já expirou.',
        'invalid_format' => 'O código deve ter 2 letras seguidas de 4 números (Ex: AB1234).', // ADICIONE ESTA LINHA
    ],
    'user' => [
        'name_required'  => 'O nome é obrigatório.',
        'name_min'       => 'O nome deve ter no mínimo 3 caracteres.',
        'email_required' => 'O e-mail é obrigatório.',
        'email_invalid'  => 'Informe um endereço de e-mail válido.',
        'email_unique'   => 'Este e-mail já está em uso.',
    ],
    'password' => [
        'required'  => 'A senha é obrigatória.',
        'min'       => 'A senha deve ter no mínimo 8 caracteres.',
        'confirmed' => 'As senhas não conferem.',
    ],
];