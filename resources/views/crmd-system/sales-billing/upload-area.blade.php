<!-- [ Extend Layouts ] -->
@extends('crmd-system.layouts.main')

<!-- [ Main Content ] start -->
@section('content')
    <style>
        .uploaded-preview {
            margin-top: 8px;
        }

        .uploaded-file {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: .25rem;
            padding: .5rem .75rem;
        }

        .file-name {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: inline-block;
            vertical-align: middle;
            max-width: 300px;
        }

        .file-actions {
            display: flex;
            gap: 10px;
        }

        .file-actions button {
            border: none;
            background: none;
            cursor: pointer;
            padding: 4px 6px;
        }

        .file-actions i {
            font-size: 18px;
        }

        @media (max-width: 576px) {
            .file-name {
                max-width: 120px;
            }

            .file-actions i {
                font-size: 16px;
            }
        }
    </style>
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Sales Biling</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Upload Sales Billing Document</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Upload Document ({{ $im->implant_pt_name }})
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('upload-sales-billing-document-page') }}"
                                        class="btn me-2 d-flex align-items-center">
                                        <span class="f-18">
                                            <i class="ti ti-arrow-left"></i>
                                        </span>
                                    </a>
                                    <h2 class="mb-0">Upload Document</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Alert ] start -->
            <div>
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="alert-heading">
                                <i class="fas fa-check-circle"></i>
                                Success
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="alert-heading">
                                <i class="fas fa-info-circle"></i>
                                Error
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <p class="mb-0">{{ session('error') }}</p>
                    </div>
                @endif
            </div>
            <!-- [ Alert ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">

                <!-- [ Upload Document ] start -->
                <div class="col-12">
                    <div class="card shadow-sm rounded-3 border-0">
                        <div class="card-body">
                            <div class="row g-4">
                                @php
                                    $inputs = [
                                        'sb_approval' => 'Upload Approval',
                                        'sb_borangG' => 'Upload Borang G',
                                        'sb_do' => 'Upload Direct Order (DO)',
                                        'sb_borangF' => 'Upload Borang F',
                                        'sb_receipt' => 'Upload Receipt',
                                        'sb_other_one' => 'Upload Others 1',
                                        'sb_other_two' => 'Upload Others 2',
                                        'sb_other_three' => 'Upload Others 3',
                                        'sb_other_four' => 'Upload Others 4',
                                    ];
                                @endphp

                                @foreach ($inputs as $name => $label)
                                    <div class="col-md-6">
                                        <div class="mb-3 file-uploader">
                                            <label for="upload-{{ $name }}"
                                                class="form-label fw-semibold">{{ $label }}</label>
                                            <input type="file" name="{{ $name }}"
                                                class="form-control @error($name) is-invalid @enderror instant-upload"
                                                id="upload-{{ $name }}"
                                                data-preview-id="preview-{{ $name }}"
                                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                            <small class="form-text text-muted">Allowed: PDF, DOC, JPG, JPEG, PNG | Max:
                                                10MB</small>

                                            @if (!empty($docs->$name))
                                                <div class="mt-2">
                                                    @php
                                                        $filePath = $docs->$name;
                                                        $fileName = basename($filePath);
                                                    @endphp

                                                    <div
                                                        class="border rounded p-2 bg-light d-flex justify-content-between align-items-center">
                                                        <div class="text-truncate" style="max-width: 70%;">
                                                            <i class="ti ti-file-text me-2 text-primary"></i>
                                                            <span class="file-name"
                                                                title="{{ $fileName }}">{{ $fileName }}</span>
                                                        </div>
                                                        <div class="btn-group">
                                                            <a href="{{ route('view-uploaded-document-get', ['path' => Crypt::encrypt($filePath)]) }}"
                                                                target="_blank" class="btn btn-sm btn-outline-primary"
                                                                title="Preview">
                                                                <i class="ti ti-eye"></i>
                                                            </a>
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-danger btn-remove"
                                                                title="Delete">
                                                                <i class="ti ti-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="uploaded-preview mt-2" id="preview-{{ $name }}"></div>

                                            @error($name)
                                                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ Upload Document ] end -->

            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>

    <script>
        $(document).ready(function() {

            /****************************************************/
            /********** UPLOAD: PREVIEW FUNCTION ****************/
            /****************************************************/

            $('input[type="file"]').on('change', function() {
                const input = $(this);
                const file = this.files[0];
                const previewId = input.data('preview-id');
                const preview = $('#' + previewId);

                preview.empty();

                if (file) {
                    const fileName = file.name;
                    const fileURL = URL.createObjectURL(file);
                    const truncatedName = fileName.length > 30 ? fileName.slice(0, 30) + '...' : fileName;

                    const previewHTML = `
                        <div class="uploaded-file">
                            <span class="file-name" title="${fileName}">${truncatedName}</span>
                             <div class="btn-group">
                                 <button type="button" class="btn-preview btn btn-sm btn-outline-primary" data-url="${fileURL}" title="Preview">
                                    <i class="ti ti-eye text-primary"></i>
                                </button>
                                <button type="button" class="btn-remove btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="ti ti-trash text-danger"></i>
                                </button>                     
                            </div>
                        </div>
                    `;
                    preview.html(previewHTML);
                }
            });

            $(document).on('click', '.btn-preview', function() {
                const fileUrl = $(this).data('url');
                window.open(fileUrl, '_blank');
            });

            $(document).on('click', '.btn-remove', function() {
                const container = $(this).closest('.uploaded-preview');
                const input = container.siblings('input[type="file"]');
                input.val(''); // clear file input
                container.empty();
            });

            /****************************************************/
            /************* UPLOAD: CRUD FUNCTION ****************/
            /****************************************************/

            $('.instant-upload').on('change', function() {
                const fileInput = this;
                const $input = $(fileInput);
                const fieldName = $input.attr('name');
                const formData = new FormData();
                const file = fileInput.files[0];
                const url = "{{ route('upload-document-post', Crypt::encrypt($im->id)) }}";

                $input.removeClass('is-invalid');
                $input.next('.invalid-feedback').remove();

                if (!file) return;

                formData.append(fieldName, file);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422 && xhr.responseJSON.errors) {
                            const errorMsg = xhr.responseJSON.errors[fieldName][0];
                            $input.addClass('is-invalid');
                            $input.after(
                                `<div class="invalid-feedback d-block mt-1">${errorMsg}</div>`
                            );
                        } else {
                            alert('An error occurred while uploading the file.');
                        }
                    }
                });
            });

            $(document).on('click', '.btn-remove', function() {
                const $formGroup = $(this).closest('.file-uploader'); // new parent container
                const field = $formGroup.find('input[type="file"]').attr('name');
                const docId = "{{ Crypt::encrypt($docs->id ?? '') }}"; // ensure Blade receives this safely

                if (confirm('Are you sure you want to delete this file?')) {
                    $.ajax({
                        url: '{{ route('delete-upload-document-post') }}',
                        type: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify({
                            field: field,
                            doc_id: docId
                        }),
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            if (data.success) {
                                location.reload();
                            } else {
                                alert(data.message);
                            }
                        },
                        error: function() {
                            alert('An error occurred while deleting the file.');
                        }
                    });
                }
            });

        });
    </script>
@endsection
<!-- [ Main Content ] end -->
