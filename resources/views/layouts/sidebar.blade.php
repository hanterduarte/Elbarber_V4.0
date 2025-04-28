<!-- Configurações -->
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-cog"></i>
        <p>
            Configurações
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('permissions.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Permissões</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('roles.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Papéis</p>
            </a>
        </li>
    </ul>
</li> 