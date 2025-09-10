<a href="{{ route('roles.edit', $role->id) }}">
    <button type="button" class="text-white bg-blue-600 hover:bg-blue-700 px-3 py-1.5 rounded-lg text-xs">
        Edit
    </button>
</a>

<form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline"
    onsubmit="return confirm('Apakah Anda yakin ingin menghapus role ini?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-lg text-xs">
        Delete
    </button>
</form>
