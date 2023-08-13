@extends('layouts.app')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Extra Pages</a></li>
                        <li class="breadcrumb-item active">Starter</li>
                    </ol>
                </div>
                <h4 class="page-title">Starter</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Import Excel</h4>
                    <p class="sub-header">
                        Most common form control, text-based input fields. Includes support for all HTML5
                        types: <code>text</code>, <code>password</code>, <code>datetime</code>,
                        <code>datetime-local</code>, <code>date</code>, <code>month</code>,
                        <code>time</code>, <code>week</code>, <code>number</code>, <code>email</code>,
                        <code>url</code>, <code>search</code>, <code>tel</code>, and <code>color</code>.
                    </p>
                    <form action="{{ route('import_run') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="example-fileinput" class="form-label">Upload file Excel (.xls/.xlsx/.csv)</label>
                            <input type="file" id="example-fileinput" class="form-control" name="file_excel">
                        </div>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection