@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('admin.News') }}</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>{{ __('admin.Create News') }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="language">{{ __('admin.Language') }}</label>
                    <select name="language" id="language-select" class="form-control select2">
                        <option value="">--{{ __('admin.Select') }}--</option>
                        @foreach ($languages as $lang)
                        <option value="{{ $lang->lang }}">{{ $lang->name }}</option>
                        @endforeach
                    </select>
                    @error('language')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category">{{ __('admin.Category') }}</label>
                    <select name="category" id="category" class="form-control select2">
                        <option value="">--{{ __('admin.Select') }}--</option>
                    </select>
                    @error('category')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image">{{ __('admin.Image') }}</label>
                    <div id="image-preview" class="image-preview">
                        <label for="image-upload" id="image-label">{{ __('admin.Choose File') }}</label>
                        <input type="file" name="image" id="image-upload">
                    </div>
                    @error('image')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="title">{{ __('admin.Title') }}</label>
                    <input name="title" type="text" class="form-control" id="title">
                    @error('title')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content">{{ __('admin.Content') }}</label>
                    <div id="editor-container"></div>
                    <textarea name="content" id="content" class="d-none"></textarea>
                    @error('content')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tags">{{ __('admin.Tags') }}</label>
                    <input name="tags" type="text" class="form-control inputtags" id="tags">
                    @error('tags')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="meta_title">{{ __('admin.Meta Title') }}</label>
                    <input name="meta_title" type="text" class="form-control" id="meta_title">
                    @error('meta_title')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="meta_description">{{ __('admin.Meta Description') }}</label>
                    <textarea name="meta_description" class="form-control" id="meta_description"></textarea>
                    @error('meta_description')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="control-label">{{ __('admin.Status') }}</div>
                            <label class="custom-switch mt-2">
                                <input value="1" type="checkbox" name="status" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                    </div>

                    @if (canAccess(['news status', 'news all-access']))
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="control-label">{{ __('admin.Is Breaking News') }}</div>
                            <label class="custom-switch mt-2">
                                <input value="1" type="checkbox" name="is_breaking_news" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="control-label">{{ __('admin.Show At Slider') }}</div>
                            <label class="custom-switch mt-2">
                                <input value="1" type="checkbox" name="show_at_slider" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="control-label">{{ __('admin.Show At Popular') }}</div>
                            <label class="custom-switch mt-2">
                                <input value="1" type="checkbox" name="show_at_popular" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                    </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">{{ __('admin.Create') }}</button>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'font': [] }, { 'size': [] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'script': 'sub'}, { 'script': 'super' }],
                [{ 'header': '1' }, { 'header': '2' }, 'blockquote', 'code-block'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'direction': 'rtl' }, { 'align': [] }],
                ['link', 'image', 'video', 'formula'],
                ['clean']
            ]
        }
    });

    const form = document.querySelector('form');
    form.onsubmit = function() {
        const content = document.querySelector('textarea[name=content]');
        content.value = quill.root.innerHTML;
    };

    // Using MutationObserver to handle DOM changes
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' && mutation.target === quill.root) {
                const content = document.querySelector('textarea[name=content]');
                content.value = quill.root.innerHTML;
            }
        });
    });

    observer.observe(quill.root, { childList: true });
});
</script>

 <script>
        $(document).ready(function() {

            $('#language-select').on('change', function() {
                let lang = $(this).val();
                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.fetch-news-category') }}",
                    data: {
                        lang: lang
                    },
                    success: function(data) {
                        $('#category').html(
                            `<option value="">---{{ __('admin.Select') }}---</option>`);
                        $.each(data, function(index, data) {
                            $('#category').append(
                                `<option value="${data.id}">${data.name}</option>`);
                        });
                    },
                    error: function(error) {
                        console.log('Error fetching categories:', error);
                    }
                });
            });
        });
    </script>
@endpush
