<div class="sidebar">
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li @if ($pageSlug=='dashboard' ) class="active " @endif>
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-bar-32"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li>
                <a data-toggle="collapse" href="#transactions" {{ $section == 'transactions' ? 'aria-expanded=true' : '' }}>
                    <i class="tim-icons icon-bank"></i>
                    <span class="nav-link-text">Operaciones</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse {{ $section == 'transactions' ? 'show' : '' }}" id="transactions">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='tstats' ) class="active " @endif>
                            <a href="{{ route('transactions.stats')  }}">
                                <i class="tim-icons icon-chart-pie-36"></i>
                                <p>Estatísticas</p>
                            </a>
                        </li>
                        <!-- <li @if ($pageSlug=='transactions' ) class="active " @endif>
                            <a href="{{ route('transactions.index')  }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>Todas</p>
                            </a>
                        </li>-->
                        <li @if ($pageSlug=='receipts' ) class="active " @endif>
                            <a href="{{ route('receipts.index') }}">
                                <i class="tim-icons icon-paper"></i>
                                <p>Compras</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='sales' ) class="active " @endif>
                            <a href="{{ route('sales.index')  }}">
                                <i class="tim-icons icon-bag-16"></i>
                                <p>Ventas</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='expenses' ) class="active " @endif>
                            <a href="{{ route('transactions.type', ['type' => 'expense'])  }}">
                                <i class="tim-icons icon-coins"></i>
                                <p>Gastos</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='incomes' ) class="active " @endif>
                            <a href="{{ route('transactions.type', ['type' => 'income'])  }}">
                                <i class="tim-icons icon-credit-card"></i>
                                <p>Ingresos</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='transfers' ) class="active " @endif>
                            <a href="{{ route('transfer.index')  }}">
                                <i class="tim-icons icon-send"></i>
                                <p>Transferencias</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='payments' ) class="active " @endif>
                            <a href="{{ route('transactions.type', ['type' => 'payment'])  }}">
                                <i class="tim-icons icon-money-coins"></i>
                                <p>Pagos</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li>
                <a data-toggle="collapse" href="#inventory" {{ $section == 'inventory' ? 'aria-expanded=true' : '' }}>
                    <i class="tim-icons icon-app"></i>
                    <span class="nav-link-text">Inventario</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse {{ $section == 'inventory' ? 'show' : '' }}" id="inventory">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='istats' ) class="active " @endif>
                            <a href="{{ route('inventory.stats') }}">
                                <i class="tim-icons icon-chart-pie-36"></i>
                                <p>Estatísticas</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='inventories' ) class="active " @endif>
                            <a href="{{ route('inventory.inventory.index') }}">
                                <i class="tim-icons icon-notes"></i>
                                <p>Inventarios</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='products' ) class="active " @endif>
                            <a href="{{ route('products.index') }}">
                                <i class="tim-icons icon-notes"></i>
                                <p>Productos</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='materials' ) class="active " @endif>
                            <a href="{{ route('materials.index') }}">
                                <i class="tim-icons icon-notes"></i>
                                <p>Materias Primas</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='production' ) class="active " @endif>
                            <a href="{{ route('production.index') }}">
                                <i class="tim-icons icon-notes"></i>
                                <p>Producción</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='categories' ) class="active " @endif>
                            <a href="{{ route('categories.index') }}">
                                <i class="tim-icons icon-tag"></i>
                                <p>Categorías</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='spendingProfiles' ) class="active " @endif>
                            <a href="{{ route('spendingProfiles.index') }}">
                                <i class="tim-icons icon-tag"></i>
                                <p>Perfiles de Gastos</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#rrhh" {{ $section == 'rrhh' ? 'aria-expanded=true' : '' }}>
                    <i class="tim-icons icon-badge"></i>
                    <span class="nav-link-text">RRHH</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse {{ $section == 'rrhh' ? 'show' : '' }}" id="rrhh">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='employees' ) class="active " @endif>
                            <a href="{{ route('employees.index') }}">
                                <i class="tim-icons icon-chart-pie-36"></i>
                                <p>Funcionarios</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='salary' ) class="active " @endif>
                            <a href="{{ route('salary.index') }}">
                                <i class="tim-icons icon-chart-pie-36"></i>
                                <p>Pago de Salarios</p>
                            </a>
                        </li>
                    </ul>
                </div>


            </li>

            <li @if ($pageSlug=='clients' ) class="active " @endif>
                <a href="{{ route('clients.index') }}">
                    <i class="tim-icons icon-single-02"></i>
                    <p>Clientes</p>
                </a>
            </li>

            <li @if ($pageSlug=='providers' ) class="active " @endif>
                <a href="{{ route('providers.index') }}">
                    <i class="tim-icons icon-delivery-fast"></i>
                    <p>Proveedores</p>
                </a>
            </li>

            <li @if ($pageSlug=='methods' ) class="active " @endif>
                <a href="{{ route('methods.index') }}">
                    <i class="tim-icons icon-wallet-43"></i>
                    <p>Métodos y Ctas.</p>
                </a>
            </li>

            <li @if ($pageSlug=='branches') class="active" @endif>
                <a href="{{ route('branches.index') }}">
                    <i class="tim-icons icon-wallet-43"></i>
                    <p>Sucursales</p>
                </a>
            </li>

            @can('users.list')
            <li>
                <a data-toggle="collapse" href="#users" {{ $section == 'users' ? 'aria-expanded=true' : '' }}>
                    <i class="tim-icons icon-badge"></i>
                    <span class="nav-link-text">Admin</span>
                    <b class="caret mt-1"></b>
                </a>
                <div class="collapse {{ $section == 'users' ? 'show' : '' }}" id="users">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='profile') class="active" @endif>
                            <a href="{{ route('profile.edit')  }}">
                                <i class="tim-icons icon-badge"></i>
                                <p>Mi Perfil</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='users') class="active" @endif>
                            <a href="{{ route('users.index')  }}">
                                <i class="tim-icons icon-notes"></i>
                                <p>Admin. Usuarios</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='users-create') class="active" @endif>
                            <a href="{{ route('users.create')  }}">
                                <i class="tim-icons icon-simple-add"></i>
                                <p>Nuevo Usuario</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endcan
        </ul>
    </div>
</div>
