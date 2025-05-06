@extends('layouts.app')

@section('js_head')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </link>
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.2.1/ckeditor5.css" crossorigin>
@endsection

@section('content')
    <div class="container">
        <div class="main-container">
            <h3 class="text-center fw-bold">Form Proposal Kegiatan</h3>
            <p class="text-center">Program Kerja: <strong>{{ $programKerja->nama }}</strong> - Periode: {{ $periode }}
            </p>
            <div class="presence" id="editor-presence"></div>

            @if(isset($dokumen))
                <input type="hidden" id="existing_proposal_id" value="{{ $dokumen->id }}">
            @endif

            <script>
                // Make the database content available to JavaScript
                const proposalContent = @json($dokumen->isi_dokumen ?? '');
            </script>

            <div class="editor-container editor-container_document-editor editor-container_include-outline editor-container_include-annotations editor-container_include-pagination"
                id="editor-container">
                <div class="editor-container__menu-bar" id="editor-menu-bar"></div>
                <div class="editor-container__toolbar" id="editor-toolbar"></div>
                <div class="editor-container__editor-wrapper">
                    <div class="editor-container__sidebar">
                        <div id="editor-outline"></div>
                    </div>
                    <div class="editor-container__editor">
                        <div id="editor"></div>
                    </div>
                    <div class="editor-container__sidebar">
                        <div id="editor-annotations"></div>
                    </div>
                </div>
            </div>
            <div class="revision-history" id="editor-revision-history">
                <div class="revision-history__wrapper">
                    <div class="revision-history__editor" id="editor-revision-history-editor"></div>
                    <div class="revision-history__sidebar" id="editor-revision-history-sidebar"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('assets/custom/dokumen/proposal.js') }}"></script>

    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.umd.js" crossorigin></script> --}}
    {{-- <script src="{{asset('assets/plugins/ckeditor/ckeditor.js')}}" crossorigin></script> --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/44.2.1/ckeditor5.umd.js" crossorigin></script>
    <script src="{{ asset('js/ckeditorProposal.js') }}"></script>
@endsection
