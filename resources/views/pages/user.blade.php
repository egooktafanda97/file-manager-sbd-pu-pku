@extends('app')
@section('content')
    <div class="w-full h-[80vh] overflow-auto">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header !py-3 !px-3 card-buttons flex justify-between">
                        <div class="w-full flex justify-between items-center">
                            <h4 class="text-xl font-bold card-title">Form User</h4>
                            <div>
                                <button class="btn btn-primary btn-sm" data-bs-target="#addUser" data-bs-toggle="modal">
                                    Add User
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table table-stripped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->created_at }}</td>
                                            <td>{{ $user->updated_at }}</td>
                                            <td>
                                                {{-- permission --}}
                                                <a class="btn btn-warning me-2"
                                                    href="{{ route('user.set-user-role', $user->id) }}">
                                                    <i class="fa fa-shield me-1 !text-lg"></i>
                                                </a>

                                                <button class="btn btn-primary btn-sm" data-bs-target="#updateUser"
                                                    data-bs-toggle="modal" data-email="{{ $user->email }}"
                                                    data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                                    data-username="{{ $user->username }}">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <form action="{{ route('user.destroy', $user->id) }}" class="d-inline"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm btn-delete" type="submit">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
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

    <div aria-hidden="true" aria-labelledby="addUserBackdropLabel" class="modal fade" data-bs-backdrop="static"
        data-bs-keyboard="false" id="addUser" tabindex="-1">
        <div class="modal-dialog modal-md">
            <form action="{{ route('user.store') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title !text-sm" id="addUserBackdropLabel">
                            Form Add User
                        </h5>
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label for="name">Name</label>
                            <input class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                type="text" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- username --}}
                        <div class="form-group mb-2">
                            <label for="username">Username</label>
                            <input class="form-control @error('username') is-invalid @enderror" id="username"
                                name="username" type="text" value="{{ old('username') }}">
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="email">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                type="email" value="{{ old('email') }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="password">Password</label>
                            <input class="form-control pass-input @error('password') is-invalid @enderror" id="password"
                                name="password" type="password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="password_confirmation">Password Confirmation</label>
                            <input class="form-control pass-input" id="password_confirmation" name="password_confirmation"
                                type="password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary mr-2" data-bs-dismiss="modal" type="button">Close</button>
                        <button class="btn btn-primary ml-2" type="submit">
                            <i class="fa fa-save"></i>
                            Save
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>


    <div aria-hidden="true" aria-labelledby="updateUserBackdropLabel" class="modal fade" data-bs-backdrop="static"
        data-bs-keyboard="false" id="updateUser" tabindex="-1">
        <div class="modal-dialog modal-md">
            <form action="#" method="post">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateUserBackdropLabel">
                            Form Update User
                        </h5>
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label for="name">Name</label>
                            <input class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                type="text">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="username">Username</label>
                            <input class="form-control @error('username') is-invalid @enderror" id="username"
                                name="username" type="text">
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="email">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" type="email">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="password">Password</label>
                            <input class="form-control pass-input @error('password') is-invalid @enderror" id="password"
                                name="password" type="password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary mr-2" data-bs-dismiss="modal" type="button">Close</button>
                        <button class="btn btn-primary ml-2" type="submit">
                            <i class="fa fa-save"></i>
                            Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- sweet alert error store --}}
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session(' error ') }}',
            })
        </script>
    @endif
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session(' success ') }}',
            })
        </script>
    @endif


    <script>
        $(document).ready(function() {
            $('.datatable').DataTable();
        });

        $('#addUser').on('show.bs.modal', function(event) {
            var modal = $(this);
            modal.find('form').trigger('reset');
        });

        $('#updateUser').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('form').attr('action', '{{ route('user.update', '') }}' + '/' + button.data('id'));
            modal.find('.modal-body #name').val(button.data('name'));
            modal.find('.modal-body #username').val(button.data('username'));
            modal.find('.modal-body #email').val(button.data('email'));
            // password null
            modal.find('.modal-body #password').val('');
        });

        $(".btn-delete").click(function(event) {
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
    </script>
@endpush
