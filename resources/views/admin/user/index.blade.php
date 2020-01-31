@extends('layouts.base')

@section('content')
<section class="users">
    <h1>
        Users list
    </h1>
    <table class="users__list">
        <thead>
            <th>
                Fullname
            </th>
            <th>
                Address
            </th>
            <th>
                Email
            </th>
            <th>
                Action
            </th>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>
                    {{ $user->name }}
                </td>
                <td>
                    {{ $user->address }}
                </td>
                <td>
                    {{ $user->email }}
                </td>
                <td class="cell-action">
                    <a href="{{ route('users.setvip', ['user' => $user, 'vip' => $user->vip ? 0 : 1]) }}">
                        {{ $user->vip ? 'Unset Vip' : 'Set Vip' }}
                    </a>
                    <a href="{{ route('users.edit', ['user' => $user]) }}">
                        <i title="Edit" alt="Edit button" class="far fa-edit edit-btn"></i>
                    </a>
                    <a href="{{ route('orders.index', ['user' => $user]) }}">
                        <i title="Orders" alt="Orders button" class="far fa-list-alt edit-btn"></i>
                    </a>
                    <span title="Delete" alt="Delete button" onclick="deleteUser({{ $user->id }})"
                        class="delete-button edit-btn">✖</span>
                    <form style="display:none;" method="POST" id="delete-form-{{ $user->id }}"
                        action="{{ route('users.destroy', ['user' => $user]) }}">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection

@push('scripts')
<script>
    const deleteUser = (id) => {
        Swal.fire({
            title: 'Delete user?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if(result.value) {
                    document.getElementById('delete-form-' + id).submit();
                }
        })
    }
</script>
@endpush
