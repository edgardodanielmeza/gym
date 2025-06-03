<nav class="bg-blue-700 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-lg font-bold">Gimnasio LWPOS - Admin Panel</div>
        <div>
            @auth('admin')
                <span class="mr-4">Hola, {{ Auth::guard('admin')->user()->nombre_completo }}</span>
                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="hover:underline">Cerrar sesión</button>
                </form>
            @else
                <!-- Podría haber un enlace a admin.login si no está autenticado, o nada -->
            @endauth
        </div>
    </div>
</nav>