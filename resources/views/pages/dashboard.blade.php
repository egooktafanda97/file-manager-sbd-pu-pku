@extends('app')
@section('content')
    <div class="w-full h-[80vh] overflow-auto">
        <div class="row">
            <div class="col-xl-4 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header !m-0">
                            <span class="dash-widget-icon bg-1">
                                <i class="fas fa-folder"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">File Drive</div>
                                <div class="dash-counts">
                                    <p>{{ $widget['drive'] ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header !m-0">
                            <span class="dash-widget-icon bg-2">
                                <i class="fas fa-folder"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">File Favorit</div>
                                <div class="dash-counts">
                                    <p>{{ $widget['favorit'] ?? 0 }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header !m-0">
                            <span class="dash-widget-icon bg-3">
                                <i class="fas fa-folder"></i>
                            </span>
                            <div class="dash-count">
                                <div class="dash-title">File Shared</div>
                                <div class="dash-counts">
                                    <p>{{ $widget['share'] ?? 0 }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h2 class="m-0 text-2xl">File Opened</h2>
                        <div class="row w-full">
                            @foreach ($current_file as $item)
                                <a class="col-md-4 m-1 flex items-center justify-between p-4 border rounded-lg shadow-sm bg-white file-preview"
                                    data-bs-target="#bs-example-modal-xl" data-bs-toggle="modal"
                                    data-id="{{ $item->file->uuid }}" data-types="{{ $item->file->type }}">
                                    <div class="flex items-center space-x-4">
                                        <div class="p-3 bg-green-100 rounded-lg">
                                            <i class="fe fe-file !text-3xl text-green-500"></i>
                                        </div>
                                        <div>

                                            <h3 class="text-sm font-semibold text-gray-800" title="{{ $item->file->name }}">
                                                {{ \Str::limit($item->file->name ?? '', 20, '...') }}
                                            </h3>
                                            <p class="text-sm text-gray-500">
                                                {{ $item->file->code_clasification }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600">
                                            {{ $item->created_at->diffForHumans() }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            {{ number_format($item->file->size / (1024 * 1024), 2) }} MB
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div aria-hidden="true" aria-labelledby="filePreviewModalLabel" class="modal fade" id="filePreviewModal" role="dialog"
        tabindex="-1">
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
@endsection


@push('scripts')
    <script>
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
    </script>
@endpush
