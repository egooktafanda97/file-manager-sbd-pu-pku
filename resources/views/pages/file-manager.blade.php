@extends('app')
@section('content')
    <div class="w-full h-[80vh] overflow-auto">
        <div class="row">
            <div class="col-sm-12">
                <ul class="flex items-center mb-2">
                    <li class="inline-flex items-center mr-2">
                        <a class="text-gray-600 hover:text-blue-500" href="#">
                            <i class="fa fa-folder text-sky-600 fa-1x"></i>
                        </a>
                    </li>

                    @foreach ($paths as $item)
                        <li class="inline-flex items-center">
                            <a class="text-gray-600 hover:text-blue-500" href="{{ $item['uuid'] }}">
                                {{ $item['name'] }}
                            </a>

                            @if (!$loop->last)
                                <span class="mx-1 h-auto text-gray-400 font-medium">/</span>
                            @endif
                        </li>
                    @endforeach

                </ul>
                <div class="card">
                    <div class="card-header !py-3 !px-3 card-buttons flex justify-between">
                        <div class="flex space-x-6 text-gray-600 text-lg">
                            {{-- back --}}
                            <a class="text-sm flex items-center space-x-2 hover:text-blue-500"
                                href="{{ route('file-manager.index', ['uuid' => $parent_uuid]) }}">
                                <i class="fas fa-arrow-left"></i>
                            </a>


                            <!-- Upload Button -->
                            <button class="text-sm flex items-center space-x-2 hover:text-blue-500"
                                data-bs-target="#staticBackdrop" data-bs-toggle="modal">
                                <i class="fas fa-upload"></i>
                                <span>Upload</span>
                            </button>

                            <!-- New Folder Button -->
                            <button class="text-sm flex items-center space-x-2 hover:text-blue-500"
                                data-bs-target="#staticBackdropFolder" data-bs-toggle="modal">
                                <i class="fas fa-folder"></i>
                                <span>New Folder</span>
                            </button>

                            <!-- Delete Button -->
                            <button class="text-sm flex items-center space-x-2 hover:text-red-500 d-none" id="delete-bulk">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
                            </button>

                        </div>

                    </div>
                    <div class="card-body !pt-1">
                        <div class="table-responsive">
                            <table class="x-datatable table table-stripped">
                                <thead>
                                    <tr>
                                        <th class="min-w-[200px]">
                                            <label class="custom_check">
                                                <input id="select-all" type="checkbox">
                                                <span class="checkmark"></span>
                                            </label>
                                            Name
                                        </th>
                                        <th>Code</th>
                                        <th>Last Modified</th>
                                        <th>Created Date</th>
                                        <th>User</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($manager as $item)
                                        <tr>
                                            <td>
                                                <div class="flex flex-row">
                                                    <label class="custom_check">
                                                        <input class="item-checkbox" name="invoice[]" type="checkbox"
                                                            value="{{ $item->uuid }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    @if ($item->type == 'folder')
                                                        <a
                                                            href="{{ route('file-manager.index', ['uuid' => $item->uuid]) }}">
                                                            <i class="fa fa-folder text-sky-600"></i>
                                                            <span class="ml-3">{{ $item->name }}</span>
                                                        </a>
                                                    @else
                                                        <a class="text-gray-600 hover:text-blue-500 file-preview"
                                                            data-bs-target="#bs-example-modal-xl" data-bs-toggle="modal"
                                                            data-id="{{ $item->uuid }}" data-types="{{ $item->type }}">
                                                            <i class="fa fa-file text-gray-600"></i>
                                                            <span class="ml-3">{{ $item->name }}</span>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                {{ $item->code_clasification }}
                                            </td>
                                            <td>{{ $item->updated_at }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->user_id }}</td>
                                            <td class="!flex !justify-end !items-center">

                                                @if ($item->type == 'file')
                                                    <button class="btn-action-icon btn btn-share"
                                                        data-bs-target="#standard-modal-share" data-bs-toggle="modal"
                                                        data-id="{{ $item->id }}" data-uuid="{{ $item->uuid }}">
                                                        <i class="fe fe-share"></i>
                                                    </button>

                                                    <a class="btn-action btn-favorit me-2"
                                                        href="{{ route('file-manager.toggle-favorite', ['uuid' => $item->uuid]) }}">
                                                        <i
                                                            class="fe fe-star
                                                            @if ($item->favorit) text-yellow-500
                                                            @else
                                                                text-gray-500 @endif
                                                            "></i>
                                                    </a>

                                                    <a class="btn-action-icon me-2"
                                                        href="{{ route('file-manager.file-download', ['uuid' => $item->uuid]) }}"
                                                        title="download">
                                                        <i class="fe fe-download"></i>
                                                    </a>
                                                    <button aria-controls="offcanvasRight"
                                                        class="btn-action-icon me-2 info-canvas"
                                                        data-bs-target="#offcanvasRight" data-bs-toggle="offcanvas"
                                                        data-id="{{ $item->uuid }}" data-types="{{ $item->type }}">
                                                        <i class="fe fe-info"></i>
                                                    </button>
                                                @endif

                                                <button class="btn-action-icon me-2 edit_modal"
                                                    data-bs-target="#staticBackdropLabelUpdate" data-bs-toggle="modal"
                                                    data-id="{{ $item->uuid }}" data-types="{{ $item->type }}">
                                                    <i class="fe fe-edit"></i>
                                                </button>
                                                <form action="{{ route('file-manager.destroy', $item->uuid) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <input name="this_uuid" type="hidden"
                                                        value="{{ $this_uuid ?? null }}">
                                                    <button class="btn-action-icon me-2 show_confirm" data-toggle="tooltip"
                                                        title='Delete' type="submit">
                                                        <i class="fe fe-trash-2"></i>
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

    <div aria-hidden="true" aria-labelledby="staticBackdropLabel" class="modal fade" data-bs-backdrop="static"
        data-bs-keyboard="false" id="staticBackdrop" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('file-manager.upload') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <input name="this_uuid" type="hidden" value="{{ $this_uuid ?? null }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Upload File</h5>
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="file">File</label>
                            <input class="form-control" id="file" name="file" type="file">
                        </div>
                        <div class="form-group mb-3">
                            <label for="file">Code Clasification <strong class="text-red-500">*</strong></label>
                            <input class="form-control" id="code_clasification" name="code_clasification"
                                type="text">
                        </div>

                        <div class="form-group mb-3" id="dynamic-inputs">

                        </div>

                        <button class="btn btn-success mb-3" id="add-input" type="button">+ Add Info</button>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary ml-3 mr-3" data-bs-dismiss="modal" type="button">Close</button>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div aria-hidden="true" aria-labelledby="staticBackdropLabelFolder" class="modal fade" data-bs-backdrop="static"
        data-bs-keyboard="false" id="staticBackdropFolder" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('file-manager.new-folder') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <input name="this_uuid" type="hidden" value="{{ $this_uuid ?? null }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabelFolder">New Folder</h5>
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group mb-3">
                            <label for="folder">Folder Name</label>
                            <input class="form-control" id="folder_name" name="folder_name" type="text">
                        </div>
                        <div class="form-group mb-3">
                            <label for="file">Code Clasification <strong class="text-red-500">*</strong></label>
                            <input class="form-control" id="folder_code" name="folder_code" type="text">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary ml-3 mr-3" data-bs-dismiss="modal" type="button">Close</button>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div aria-hidden="true" aria-labelledby="staticBackdropLabelUpdate" class="modal fade" data-bs-backdrop="static"
        data-bs-keyboard="false" id="staticBackdropLabelUpdate" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('file-manager.updated') }}" method="POST">
                    @csrf
                    <input name="this_uuid" type="hidden" value="{{ $this_uuid ?? null }}">
                    <input id="_uuid-update" name="uuid" type="hidden">

                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabelUpdateLabels"></h5>
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group mb-3">
                            <label for="update_name" id="_update_name">Folder Name</label>
                            <input class="form-control" id="update_name" name="update_name" type="text">
                        </div>
                        <div class="form-group mb-3">
                            <label for="update_code" id="_update_code">Code Clasification <strong
                                    class="text-red-500">*</strong></label>
                            <input class="form-control" id="update_code" name="update_code" type="text">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary ml-3 mr-3" data-bs-dismiss="modal" type="button">Close</button>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div aria-labelledby="offcanvasRightLabel" class="offcanvas offcanvas-end" id="offcanvasRight" tabindex="-1">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">
                Info
            </h5>
            <button aria-label="Close" class="btn-close text-reset" data-bs-dismiss="offcanvas" type="button"></button>
        </div>
        <div class="offcanvas-body">
            <div>
                <table class="table-auto w-full border-collapse">
                    <tbody id="file-info-table">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal untuk Preview File -->
    <div aria-hidden="true" aria-labelledby="filePreviewModalLabel" class="modal fade" id="filePreviewModal"
        role="dialog" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body !p-0 text-center">
                    <!-- Preview Image -->
                    <img alt="file preview" class="img-fluid d-none" id="fileImagePreview">

                    <!-- Preview PDF -->
                    <iframe class="w-100 d-none" id="filePdfPreview" style="height: 90vh;"></iframe>

                    <!-- Google Docs Viewer for Word & Excel -->
                    <iframe class="w-100 d-none" id="fileGoogleDocsPreview" style="height: 500px;"></iframe>

                    <!-- Plain Text Preview -->
                    <pre class="d-none" id="fileTextPreview"></pre>

                    <!-- Fallback Icon -->
                    <img alt="file icon" class="img-fluid" id="fileIconPreview">
                </div>
            </div>
        </div>
    </div>

    {{-- modal share --}}

    <!-- Standard modal content -->
    <div aria-hidden="true" aria-labelledby="standard-modalLabel" class="modal fade" id="standard-modal-share"
        role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">User Access</h4>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <input id="file_idx" name="file_idx" type="hidden" value="x">
                                <input id="uuidx" name="uuidx" type="hidden" value="">
                                <label for="userx">Select User</label>
                                <select class="js-example js-example-basic-single" id="userx" name="userx">
                                    @foreach ($users as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                {{-- button --}}
                                <div class="w-full flex justify-end mt-2">
                                    <button class="btn btn-primary" id="shared-file" type="button">
                                        <i class="fas fa-share"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <table class="table mt-2 table-center table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Username</th>
                                        <th Class="no-sort">#</th>
                                    </tr>
                                </thead>
                                <tbody id="table-share">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.9/dist/axios.min.js"></script>
    <script defer>
        $(document).ready(function() {
            $('.x-datatable').DataTable({
                "bFilter": false,
                // "scrollX": true,
                "autoWidth": false,
                "sDom": 'fBtlpi',
                "ordering": false,
                paging: false,
                // top fixed
                fixedHeader: {
                    header: true,
                    footer: true
                },
                "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false,
                }],
            });
        });

        $(document).ready(function() {
            let inputIndex = 0;

            $("#add-input").click(function() {
                inputIndex++;
                $("#dynamic-inputs").append(`
                <div class="flex flex-col bg-gray-100 p-3 rounded shadow" id="input-group-${inputIndex}">
                    <div class="flex space-x-2">
                        <input class="border border-gray-300 rounded px-4 py-2 flex-1" type="text" name="extra_info[${inputIndex}][name]" placeholder="Name" required>
                        <input class="border border-gray-300 rounded px-4 py-2 flex-1" type="text" name="extra_info[${inputIndex}][description]" placeholder="Description" required>
                        <button type="button" class="remove-input text-red-500 hover:text-red-700" data-index="${inputIndex}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `);
            });

            $(document).on("click", ".remove-input", function() {
                let index = $(this).data("index");
                $("#input-group-" + index).remove();
            });
        });

        $('.show_confirm').click(function(event) {
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

        $(".edit_modal").click(function() {
            $("#update_name").val("");
            $("#update_code").val("");
            const uuid = $(this).data("id");
            const types = $(this).data("types");
            $("#staticBackdropLabelUpdateLabels").html(types == "folder" ? "Update Folder" : "Update File");
            $("#_update_name").html(types == "folder" ? "Folder Name" : "File Name");
            $("#_update_code").html(types == "folder" ? "Code Clasification" : "Code Clasification");
            $("#_uuid-update").val(uuid);
            axios.get(`/file-manager/${uuid}/first`)
                .then((response) => {
                    $("#update_name").val(response.data.name);
                    $("#update_code").val(response.data.code_clasification);
                })
                .catch((error) => {
                    console.error(error);
                });
        });
        $(".info-canvas").click(function() {
            const uuid = $(this).data("id");
            const types = $(this).data("types");
            axios.get(`/file-manager/${uuid}/file-info`)
                .then((response) => {
                    let html = "";
                    for (const [key, value] of Object.entries(response.data)) {
                        html += `
                        <tr>
                            <td class="border border-gray-300 p-2">${key}</td>
                            <td class="border border-gray-300 p-2">${value}</td>
                        </tr>
                    `;
                    }
                    $("#file-info-table").html(html);
                })
                .catch((error) => {
                    console.error(error);
                });
        });

        //table-file-name
        $(".file-preview").click(function() {
            const uuid = $(this).data("id");

            axios.get(`/file-manager/${uuid}/preview`, {
                    headers: {
                        'user_id': '{{ auth()?->user()?->id ?? null }}'
                    }
                })
                .then((response) => {
                    const result = response.data;
                    const filePath = `/storage/${result.path}`;
                    const fileExt = result?.ext?.toLowerCase() ?? 'pdf';

                    // Reset semua preview
                    $("#fileImagePreview, #filePdfPreview, #fileGoogleDocsPreview, #fileTextPreview, #fileIconPreview")
                        .addClass("d-none");

                    // Jika file adalah gambar (PNG, JPG, JPEG, GIF, SVG)
                    if (['png', 'jpg', 'jpeg', 'gif', 'svg'].includes(fileExt)) {
                        $("#fileImagePreview").attr("src", filePath).removeClass("d-none");
                    }
                    // Jika file adalah PDF
                    else if (fileExt === 'pdf') {
                        $("#filePdfPreview").attr("src", filePath).removeClass("d-none");
                    }
                    // Jika file adalah Word atau Excel (Gunakan Google Docs Viewer)
                    else if (['doc', 'docx', 'xls', 'xlsx'].includes(fileExt)) {
                        $("#fileGoogleDocsPreview").attr("src",
                            `https://docs.google.com/gview?url=${window.location.origin}${filePath}&embedded=true`
                        ).removeClass("d-none");
                    }
                    // Jika file adalah TXT (Tampilkan sebagai teks)
                    else if (fileExt === 'txt') {
                        axios.get(filePath)
                            .then(textResponse => {
                                $("#fileTextPreview").text(textResponse.data).removeClass("d-none");
                            })
                            .catch(() => {
                                $("#fileIconPreview").attr("src", `/storage/txt.png`).removeClass("d-none");
                            });
                    }
                    // Jika file tidak didukung, tampilkan ikon default
                    else {
                        $("#fileIconPreview").attr("src", `/storage/file-icon.png`).removeClass("d-none");
                    }

                    // Tampilkan modal
                    $("#filePreviewModal").modal("show");
                })
                .catch((error) => {
                    console.error(error);
                });
        });


        // Select All Checkbox Functionality
        $('#select-all').click(function() {
            $('.item-checkbox').prop('checked', $(this).prop('checked'));
            $('#delete-bulk').toggleClass('d-none', !$(this).prop('checked'));
        });

        $('.item-checkbox').click(function() {
            $('#delete-bulk').toggleClass('d-none', $('.item-checkbox:checked').length === 0);
        });

        // Multi-Delete Functionality
        $('#delete-bulk').click(function() {
            let selected = $('.item-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (selected.length === 0) {
                alert('No items selected');
                return;
            }

            if (!confirm('Are you sure you want to delete selected items?')) {
                return;
            }

            axios
                .post('/file-manager/delete-bulk', {
                    data: selected
                })
                .then(response => {
                    location.reload();
                })
                .catch(error => {
                    swal("Error", error?.response?.data?.message ?? "An error occurred", "error");
                });
        });

        $('.js-example-basic-single').select2({
            dropdownParent: $('#standard-modal-share .modal-content')
        });

        $(".btn-share")
            .click(function() {
                const id = $(this).data("id");
                const uuid = $(this).data("uuid");
                $("#file_idx").val(id);
                $("#uuidx").val(uuid);

                axios.get(`/file-manager/${uuid}/shared`)
                    .then(function(response) {
                        console.log(response.data);
                        let html = "";
                        response.data.forEach((item) => {
                            html += `
                            <tr>
                                <td>#${item.username} > ${item.name} </td>
                                <td>
                                    <button class="btn btn-danger share-delete" data-id="${item.id}">
                                        <i class="fas fa-trash"></i>
                                        </button>
                                </td>
                            </tr>
                        `;
                        });
                        $("#table-share").html(html);
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            });

        $("#shared-file")
            .click(function() {
                const user_id = $("#userx").val();
                const file_id = $("#file_idx").val();
                const uuidx = $("#uuidx").val();
                axios.post(`/file-share/share`, {
                        user_id: user_id,
                        file_id: file_id
                    })
                    .then(function(response) {
                        console.log(response.data);
                        Toastify({
                            text: "file shared successfully",
                            duration: 3000
                        }).showToast();
                        axios.get(`/file-manager/${uuidx}/shared`)
                            .then(function(response) {

                                let html = "";
                                response.data.forEach((item) => {
                                    html += `
                            <tr>
                                <td>#${item.username} > ${item.name} </td>
                                <td>
                                    <button class="btn btn-danger share-delete" data-id="${item.id}">
                                        <i class="fas fa-trash"></i>
                                        </button>
                                </td>
                            </tr>
                        `;
                                });
                                $("#table-share").html(html);
                            })
                            .catch(function(error) {
                                console.log(error);
                            });
                    })
                    .catch(function(error) {
                        console.log(error);
                        Toastify({
                            text: error?.response?.data?.message ?? "An error occurred",
                            duration: 3000,
                            backgroundColor: "linear-gradient(to right, #ff416c, #ff4b2b)"
                        }).showToast();
                    });
            });

        $(document).on("click", ".share-delete", function() {
            const id = $(this).data("id");
            const file_id = $("#file_idx").val();
            const uuidx = $("#uuidx").val()
            axios.get(`/file-share/remove-share/${id}/${file_id}`)
                .then(function(response) {
                    axios.get(`/file-manager/${uuidx}/shared`)
                        .then(function(response) {
                            console.log("x", response.data);
                            Toastify({
                                text: "This is a toast",
                                duration: 3000
                            }).showToast();
                            let html = "";
                            response.data.forEach((item) => {
                                html += `
                            <tr>
                                <td>#${item.username} > ${item.name} </td>
                                <td>
                                    <button class="btn btn-danger share-delete" data-id="${item.id}">
                                        <i class="fas fa-trash"></i>
                                        </button>
                                </td>
                            </tr>
                        `;
                            });
                            $("#table-share").html(html);
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                })
                .catch(function(error) {
                    console.log(error);
                });
        });
    </script>
@endpush
