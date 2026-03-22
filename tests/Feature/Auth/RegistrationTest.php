<?php

test('registration route does not exist when registration is disabled', function () {
    $this->get('/register')->assertNotFound();
});

test('registration submission returns not found when registration is disabled', function () {
    $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertNotFound();
});
