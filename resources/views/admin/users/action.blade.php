<td>
    <div class="dropdown text-center">
        <a class="dropdown-button btn btn-default btn-lg" id="dropdown-menu-{{ $data->id }}" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-ellipsis-v"></i>
        </a>
        <ul class="dropdown-menu" aria-labelledby="dropdown-menu-{{ $data->id }}">

            @can('user.view')
            <li>
                <a class="dropdown-item success" href="{{ route('admin.users.show', $data->id) }}">
                    <i class="fa fa-user fa-lg"></i>
                    view
                </a>
            </li>

            @endcan

            @can('user.edit')
            <li>
                <a class="dropdown-item info" href="{{ route('admin.users.edit', $data->id) }}">
                    <i class="fa fa-edit"></i>
                    edit
                </a>

            </li>

            @endcan

            @can('user.delete')
            <li>
                <a class="dropdown-item danger" href="#" onclick="if(confirm('{{ trans('global.areYouSure') }}')) document.getElementById('delete-{{ $data->id }}').submit()">
                    <i class="fa fa-trash"></i>
                    Delete
                </a>
            </li>
            <form id="delete-{{ $data->id }}" action="{{ route('admin.users.destroy', $data->id) }}" method="POST">
                @method('DELETE')
                @csrf
            </form>

            @endcan
        </ul>
    </div>
</td>
