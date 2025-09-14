<form action="{{ route($route, $id) }}" method="POST" class="delete-form">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-default">
        <span class="fa fa-trash"></span>
    </button>
</form>
