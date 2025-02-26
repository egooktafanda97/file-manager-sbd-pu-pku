@extends('app')
@section('content')
    <div class="w-full h-[80vh] overflow-auto">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row w-full">
                            <div class="row">
                                <div class="col-md-4">
                                    <form action="{{ route('user.role-store') }}" method="post">
                                        @csrf
                                        <div class="relative">
                                            <input
                                                class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                id="role" name="role" placeholder="role" required type="search" />
                                            <button class="absolute end-2.5 bottom-2.5 btn btn-primary btn-sm"
                                                type="submit">
                                                <i class="fe fe-save text-md"></i>
                                            </button>
                                        </div>
                                    </form>

                                    <table class="table mt-2 table-center table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Role Name</th>
                                                <th Class="no-sort">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($roles as $role)
                                                <tr
                                                    class="{{ request()->get('role') == $role->id ? '!text-sky-500 !bg-red-100' : '!text-gray-500' }}">
                                                    <td>
                                                        <a class="{{ request()->get('role') == $role->id ? '!text-sky-500' : '!text-gray-500' }}"
                                                            href="?role={{ $role->id }}">
                                                            {{ $role->name }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('user.role-destroy', $role->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button class=" btn btn-danger btn-sm role-delete"
                                                                type="submit">
                                                                <i class="fe fe-save text-md"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-8">
                                    <table class="table mt-2 table-center table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Permission Name</th>
                                                <th Class="no-sort">
                                                    <i class="fe fe-check-square !text-lg"></i>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($permissions as $permission)
                                                <tr>
                                                    <td>
                                                        {{ $permission->name }}
                                                    </td>
                                                    <td>
                                                        <label class="custom_check">
                                                            <input {{ $permission->checked ? 'checked' : '' }}
                                                                class="permissions_checked" name="permissions_checked[]"
                                                                type="checkbox" value="{{ $permission->id }}">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div aria-hidden="true" aria-labelledby="" class="modal fade" id="roleCreated" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body !p-0 text-center">

                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(".role-delete").click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: "Are you sure?",
                    text: "This action cannot be undone. The selected file or folder will be permanently deleted.",
                    icon: "warning",
                    buttons: ["Cancel", "Yes, delete it!"],
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });

        $(".permissions_checked").click(function() {
            var role = "{{ request()->get('role') }}";
            var permission = $(this).val();
            var checked = $(this).prop('checked');
            axios.post(`/users/set-permission`, {
                role: role,
                permission: permission,
                checked: checked
            }).then(function(response) {
                console.log(response.data);
            });
        });
    </script>
@endpush
