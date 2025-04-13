<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light">Admin Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Emploi du temps -->
                <li class="nav-item">
                  
                <a href="{{ route('emploi_du_temps.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>Emploi du temps</p>
                    </a>
                </li>

                <!-- Emploi d examen -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>Emploi d examen</p>
                    </a>
                </li>

                <!-- Emploi de soutenance (Nouvel élément) -->
                <li class="nav-item">
                    <a href="{{ route('soutenance.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>Emploi de soutenance</p>
                    </a>
                </li>
                <!-- Gestion des thèmes (Nouvel élément) -->
                <li class="nav-item">
                    <a href="{{ route('gestiondesthemes.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>Gestion des thèmes</p>
                    </a>
                </li>

                <!-- Groupes -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Groupes</p>
                    </a>
                </li>

                <!-- Professeurs -->
<li class="nav-item">
    <a href="{{ route('professeurs.index') }}" class="nav-link">
        <i class="nav-icon fas fa-chalkboard-teacher"></i>
        <p>Professeurs</p>
    </a>
</li>

                

                

                <!-- Salles -->
                <li class="nav-item">
                    <a href="{{ route('locals.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-door-open"></i>
                        <p>Salles</p>
                    </a>
                </li>

                <li class="nav-item">
                <a href="{{ route('themes.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-door-open"></i>
                        <p>Themes</p>
                    </a>
                </li>

                 
                <li class="nav-item">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="nav-link bg-danger text-white">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
        </button>
    </form>
</li>


                
            </ul>
        </nav>
    </div>
</aside>