@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Submateri</h1>
        <form action="{{ route('submateri.update', $submateri->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="materi_id" class="form-label">Materi</label>
                <select name="materi_id" id="materi_id" class="form-control" required>
                    @foreach($materis as $materi)
                        <option value="{{ $materi->id }}" {{ $materi->id == $submateri->materi_id ? 'selected' : '' }}>{{ $materi->judulMateri }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="judulSubMateri" class="form-label">Judul Submateri</label>
                <input type="text" class="form-control" id="judulSubMateri" name="judulSubMateri" value="{{ $submateri->judulSubMateri }}" required>
            </div>

            <div class="mb-3">
                <label for="tujuanPembelajaran" class="form-label">Tujuan Pembelajaran</label>
                <textarea class="form-control" id="tujuanPembelajaran" name="tujuanPembelajaran" required>{{ $submateri->tujuanPembelajaran }}</textarea>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" required>{{ $submateri->content }}</textarea>
            </div>

            <div class="mb-3">
                <label for="file" class="form-label">File</label>
                <input type="file" class="form-control" id="file" name="file">
                <p>Current file: {{ $submateri->file }}</p>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
