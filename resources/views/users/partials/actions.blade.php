<a href="{{ route('users.edit', $user->id) }}">
    <button type="button" class="text-white bg-blue-600 hover:bg-blue-700 px-3 py-1.5 rounded-lg text-xs">
        Edit
    </button>
</a>

<form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline"
    onsubmit="return confirm('Apakah Anda yakin ingin menghapus User ini?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-lg text-xs">
        Delete
    </button>
</form>
