@foreach ($meetings as $meeting)
    <div class="col-md-12 mb-4">
        <div class="card border-0 shadow-sm p-3 d-flex flex-row align-items-center">
            <div class="me-3">
                <img src="{{ $meeting['image'] }}" class="rounded" width="150" height="100" alt="Meeting Image">
            </div>
            <div class="flex-grow-1">
                <h5 class="fw-bold mb-1"><a
                        href="{{ route('rapat.show', ['kode_ormawa' => $kode_ormawa, 'id_rapat' => $meeting->id]) }}">{{ $meeting->nama }}</a>
                </h5>
                <p class="text-muted small mb-1">
                    <strong>{{ $meeting->hari }}, {{ $meeting->tanggal }} ({{ $meeting->waktu }})</strong>
                </p>
                <p class="text-muted small mb-2">Diselenggarakan oleh:
                    <strong>{{ $meeting->tipe_penyelenggara }}</strong>
                </p>
                @if ($meeting->tipe == 'online')
                    <a href="{{ $meeting->tempat }}" class="btn btn-primary btn-sm">Join</a>
                @endif
            </div>
        </div>
    </div>
@endforeach
