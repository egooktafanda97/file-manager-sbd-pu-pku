@extends('app')
@section('content')
    <div class="w-full h-[80vh] overflow-auto">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header !py-3 !px-3 card-buttons flex justify-between">
                            <div class="flex space-x-6 text-gray-600 text-lg">
                                <a class="text-sm flex items-center space-x-2 hover:text-blue-500" href="/users/">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                                <h6 class="text-lg font-semibold">User Role</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table mt-2 table-center table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Role Name</th>
                                            <th Class="no-sort">
                                                <i class="fe fe-check-square !text-lg"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>
                                                    {{ $role->name }}
                                                </td>
                                                <td>
                                                    <label class="custom_check">
                                                        <input @if ($role->checked) checked @endif
                                                            class="role_checked" name="role_checked[]" type="checkbox"
                                                            value="{{ $role->id }}">
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
@endsection

@push('scripts')
    <script>
        $('.role_checked').on('change', function() {
            var role_id = $(this).val();
            var checked = $(this).prop('checked');
            axios.post(`{{ route('user.user-role') }}`, {
                user_id: '{{ request()->id }}',
                role_id: role_id,
                checked: checked
            }).then(function(response) {
                console.log(response.data);
            }).catch(function(error) {
                console.log(error);
            });
        });
    </script>
@endpush
