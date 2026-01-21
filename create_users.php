<?php
// Script para crear usuarios sin necesidad de BD
$users = [
    ['name' => 'Administrador', 'email' => 'admin@myshop.com', 'password' => 'password123', 'role' => 'admin'],
    ['name' => 'Trabajador invitado', 'email' => 'worker@myshop.com', 'password' => 'password123', 'role' => 'worker'],
    ['name' => 'Cliente', 'email' => 'customer@myshop.com', 'password' => 'password123', 'role' => 'guest'],
];

foreach ($users as $user) {
    echo "Usuario: {$user['email']} - Contraseña: {$user['password']} - Rol: {$user['role']}\n";
}
