<a href="{{ route('positions.edit', $position->id) }}">
    <button type="button" class="text-white bg-blue-600 hover:bg-blue-700 px-3 py-1.5 rounded-lg text-xs">
        Edit
    </button>
</a>

<form action="{{ route('positions.destroy', $position->id) }}" method="POST" class="inline"
    onsubmit="return confirm('Apakah Anda yakin ingin menghapus Position ini?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-lg text-xs">
        Delete
    </button>
</form>
