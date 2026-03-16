<?php

namespace App\Enums;

enum NavigationGroupEnum: string
{
    case Areas = 'Gestión Áreas';
    case Inventario = 'Gestión Inventario';
    case Usuarios = 'Gestión Usuarios';
    case Transacciones = 'Transacciones';
}