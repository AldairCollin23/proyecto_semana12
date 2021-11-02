
<li class="nav-item">
    <a href="{{ route('usuarios.index') }}"
       class="nav-link {{ Request::is('usuarios*') ? 'active' : '' }}">
        <p>Usuario</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('pacientes.index') }}"
       class="nav-link {{ Request::is('pacientes*') ? 'active' : '' }}">
        <p>Paciente</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('citas.index') }}"
       class="nav-link {{ Request::is('citas*') ? 'active' : '' }}">
        <p>Cita</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('detalles.index') }}"
       class="nav-link {{ Request::is('detalles*') ? 'active' : '' }}">
        <p>Cita Detalle</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('doctors.index') }}"
       class="nav-link {{ Request::is('doctors*') ? 'active' : '' }}">
        <p>Doctor</p>
    </a>
</li>

