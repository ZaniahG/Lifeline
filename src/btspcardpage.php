@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card">

                @php
                    $i = '00';
                @endphp
                <img id="preview_{{ $i }}" class="img-fluid card-img-top"
                    style="width: 100%; height: 200px; cursor: pointer;object-fit:cover;"
                    onclick="triggerFileInput(`{{ $i }}`)" src="{{ asset($idolImage->getIdolProfileImage()) }}">
                <form id="uploadForm_{{ $i }}" enctype="multipart/form-data" data-url="{{ route('idol.upload') }}">
                    @csrf
                    <input type="file" name="photocard" class="form-control-file" id="fileInput_{{ $i }}"
                        style="display: none;" onchange="previewImage(`{{ $i }}`)">
                    <input type="hidden" name="photocard_id" value="{{ $i }}">
                </form>
                <div class="card-body">
                    <a href="javascript:void(0)" class="card-title text-decoration-none text-dark" data-size="md"
                        data-url="{{ route('edit.idol.name') }}" data-ajax-popup="true"
                        data-title="{{ __('Update Idol Name') }}">
                        <h5>{{ $idolImage->idol_name }} <i class="fa-solid fa-pen-to-square"></i></h5>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <h3 class="mx-auto mx-lg-0 text-center text-lg-left mt-3">Your Current Photocards</h3>
            <div class="row">
                @php
                    $gallery = $idolImage->gallery_images;
                @endphp
                @for ($i = 0; $i < 6; $i++)
                    @php
                        if (isset($gallery[$i])) {
                            $path = asset('storage/app/public/' . $gallery[$i]);
                        } else {
                            $path = asset('storage/app/public/avatar.png');
                        }
                    @endphp
                    <div class="col-md-4">
                        <div class="card text-center mb-3">
                            <div class="card-body">
                                <!-- Image preview -->
                                <img id="preview_{{ $i }}" src="{{ $path }}" alt="Photocard"
                                    class="img-fluid mb-3"
                                    style="width: 100%; height: 200px; cursor: pointer;object-fit:cover;"
                                    onclick="triggerFileInput(`{{ $i }}`)">

                                <div class="d-flex justify-content-between">
                                    <!-- Image Upload Form -->
                                    <div class="flex-grow-1">
                                        <form id="uploadForm_{{ $i }}" enctype="multipart/form-data"
                                            data-url="{{ route('photocard.upload') }}">
                                            @csrf
                                            <input type="file" name="photocard" class="form-control-file"
                                                id="fileInput_{{ $i }}" style="display: none;"
                                                onchange="previewImage(`{{ $i }}`)">
                                            <input type="hidden" name="photocard_id" value="{{ $i }}">
                                            <button type="button"
                                                class="btn btn-primary btn-sm w-100 upload-btn-{{ $i }}"
                                                onclick="triggerFileInput(`{{ $i }}`)">Upload Image</button>
                                        </form>
                                    </div>

                                    @if (isset($gallery[$i]))
                                        <div class="ml-1">
                                            <!-- Delete Button -->
                                            <form method="GET" action="{{ route('photocard.delete', $i) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>


                            </div>
                        </div>
                    </div>
                @endfor
            </div>


        </div>
    </div>
@endsection
@push('custom-scripts')
    <script>
        // Trigger hidden file input when the image is clicked
        function triggerFileInput(id) {
            document.getElementById(`fileInput_${id}`).click();
        }

        // Preview selected image before upload
        function previewImage(id) {
            console.log(id);
            var fileInput = document.querySelector(`#uploadForm_${id} input[type="file"]`);
            var preview = document.getElementById(`preview_${id}`);
            var file = fileInput.files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file); // Reads the file and triggers onloadend
                uploadImage(id);
            }
            // else {
            //     preview.src = "{{ asset('path-to-placeholder-image.jpg') }}"; // Placeholder
            // }
        }

        // Upload image via AJAX
        function uploadImage(id) {
            var formData = new FormData(document.getElementById(`uploadForm_${id}`));
            $(".upload-btn-" + id).prop('disabled', true);
            showToast("Uploading....", 'success', 'bottom-center');

            $.ajax({
                url: $(`#uploadForm_${id}`).data("url"),
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $(".upload-btn-" + id).prop('disabled', false);
                    showToast(response.success, 'success', 'bottom-center');
                },
                error: function(response) {
                    $(".upload-btn-" + id).prop('disabled', false);
                    showToast("Failed to upload image", 'error', 'bottom-center');
                }
            });
        }
    </script>
@endpush
