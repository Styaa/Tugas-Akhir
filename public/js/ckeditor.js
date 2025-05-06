const {
    DecoupledEditor,
    Alignment,
    Autoformat,
    AutoImage,
    AutoLink,
    Autosave,
    BalloonToolbar,
    BlockToolbar,
    Bold,
    Bookmark,
    CloudServices,
    Code,
    Essentials,
    FindAndReplace,
    FontBackgroundColor,
    FontColor,
    FontFamily,
    FontSize,
    Heading,
    HorizontalLine,
    ImageBlock,
    ImageCaption,
    ImageInline,
    ImageInsertViaUrl,
    ImageResize,
    ImageStyle,
    ImageTextAlternative,
    ImageToolbar,
    ImageUpload,
    Indent,
    IndentBlock,
    Italic,
    Link,
    LinkImage,
    List,
    ListProperties,
    Mention,
    PageBreak,
    Paragraph,
    PasteFromOffice,
    RemoveFormat,
    SpecialCharacters,
    SpecialCharactersArrows,
    SpecialCharactersCurrency,
    SpecialCharactersEssentials,
    SpecialCharactersLatin,
    SpecialCharactersMathematical,
    SpecialCharactersText,
    Strikethrough,
    Subscript,
    Superscript,
    Table,
    TableCaption,
    TableCellProperties,
    TableColumnResize,
    TableProperties,
    TableToolbar,
    TextTransformation,
    TodoList,
    Underline,
    Plugin,
    ButtonView
} = window.CKEDITOR;

const LICENSE_KEY =
    'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3Njk5MDM5OTksImp0aSI6ImYyNGU2NGQxLWNiMjktNGE4My1hNjMyLTcwN2JiNjdkNmY3OSIsImxpY2Vuc2VkSG9zdHMiOlsiMTI3LjAuMC4xIiwibG9jYWxob3N0IiwiMTkyLjE2OC4qLioiLCIxMC4qLiouKiIsIjE3Mi4qLiouKiIsIioudGVzdCIsIioubG9jYWxob3N0IiwiKi5sb2NhbCJdLCJ1c2FnZUVuZHBvaW50IjoiaHR0cHM6Ly9wcm94eS1ldmVudC5ja2VkaXRvci5jb20iLCJkaXN0cmlidXRpb25DaGFubmVsIjpbImNsb3VkIiwiZHJ1cGFsIl0sImxpY2Vuc2VUeXBlIjoiZGV2ZWxvcG1lbnQiLCJmZWF0dXJlcyI6WyJEUlVQIl0sInZjIjoiNDAwNWRhOTgifQ.XJMNhLTBDTwB6SOio3GDtdPFrJCsqIyGLTuuTdv6AnufNdxQXjOYFQUanxnmoHVGjq4F2Ap7LSjWWTsB7eKkpw';

// Buat plugin HeaderFooter kustom
class HeaderFooter extends Plugin {
    init() {
        this._defineSchema();
        this._defineConverters();

        // Mendaftarkan perintah untuk menambahkan header dan footer
        this.editor.commands.add('insertHeaderFooter', {
            execute: () => {
                this._insertHeaderFooter();
            }
        });

        // Tambahkan tombol ke toolbar
        this.editor.ui.componentFactory.add('headerFooter', locale => {
            const view = new ButtonView(locale);

            view.set({
                label: 'Tambah Header/Footer',
                withText: true,
                tooltip: true
            });

            // Menghubungkan klik tombol dengan eksekusi perintah
            view.on('execute', () => {
                this.editor.execute('insertHeaderFooter');
            });

            return view;
        });
    }

    _defineSchema() {
        const schema = this.editor.model.schema;

        // Daftarkan elemen 'headerFooter'
        schema.register('documentHeader', {
            isObject: true,
            allowWhere: '$block',
            allowContentOf: '$root'
        });

        schema.register('documentFooter', {
            isObject: true,
            allowWhere: '$block',
            allowContentOf: '$root'
        });
    }

    _defineConverters() {
        const conversion = this.editor.conversion;

        // Upcast converter (HTML → Model)
        conversion.for('upcast').elementToElement({
            view: {
                name: 'div',
                classes: 'document-header'
            },
            model: 'documentHeader'
        });

        conversion.for('upcast').elementToElement({
            view: {
                name: 'div',
                classes: 'document-footer'
            },
            model: 'documentFooter'
        });

        // Downcast converters (Model → HTML)
        conversion.for('dataDowncast').elementToElement({
            model: 'documentHeader',
            view: {
                name: 'div',
                classes: 'document-header'
            }
        });

        conversion.for('dataDowncast').elementToElement({
            model: 'documentFooter',
            view: {
                name: 'div',
                classes: 'document-footer'
            }
        });

        conversion.for('editingDowncast').elementToElement({
            model: 'documentHeader',
            view: (modelElement, {
                writer
            }) => {
                const div = writer.createContainerElement('div', {
                    class: 'document-header'
                });
                return div;
            }
        });

        conversion.for('editingDowncast').elementToElement({
            model: 'documentFooter',
            view: (modelElement, {
                writer
            }) => {
                const div = writer.createContainerElement('div', {
                    class: 'document-footer'
                });
                return div;
            }
        });
    }

    _insertHeaderFooter() {
        const editor = this.editor;

        // Header default dengan kop surat (sesuai dengan gambar)
        const headerHtml = `<div class="document-header">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td style="width: 120px; vertical-align: top; text-align: center;">
                                            <img src="/assets/images/logo-ubaya.png" alt="Logo UBAYA" style="max-width: 70px; height: auto;">
                                            <p style="margin: 0; font-family: 'Cambria', serif; font-size: 12pt; text-align: center; font-weight: bold;">UBAYA</p>
                                            <p style="margin: 0; font-family: 'Cambria', serif; font-size: 10pt; text-align: center;">UNIVERSITAS<br>SURABAYA</p>
                                        </td>
                                        <td style="vertical-align: middle; text-align: center;">
                                            <p style="margin: 0; font-family: 'Cambria', serif; font-size: 12pt; font-weight: bold; text-align: center;">KELOMPOK STUDI MAHASISWA INFORMATIKA</p>
                                            <p style="margin: 0; font-family: 'Cambria', serif; font-size: 12pt; font-weight: bold; text-align: center;">FAKULTAS TEKNIK</p>
                                            <p style="margin: 0; font-family: 'Cambria', serif; font-size: 12pt; font-weight: bold; text-align: center;">UNIVERSITAS SURABAYA</p>
                                            <p style="margin: 5px 0; font-family: 'Cambria', serif; font-size: 12pt; text-align: center;">Jl. Raya Kalirungkut-Tenggilis</p>
                                            <p style="margin: 0; font-family: 'Cambria', serif; font-size: 12pt; text-align: center;">Surabaya 60292</p>
                                        </td>
                                        <td style="width: 120px; vertical-align: top; text-align: center;">
                                            <img src="/assets/images/logo-ksmif.png" alt="Logo KSM-IF" style="max-width: 70px; height: auto;">
                                        </td>
                                    </tr>
                                </table>
                                <hr style="border-top: 2px solid #000; margin: 5px 0;">
                                <hr style="border-top: 1px solid #000; margin: 2px 0 5px 0;">
                            </div>`;

        // Footer dengan nomor halaman (sesuai dengan gambar)
        const footerHtml = `<div class="document-footer">
                                <hr style="border-top: 1px solid #000; margin: 10px 0 5px 0;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td style="text-align: left; font-size: 10pt; font-family: 'Cambria', serif;">
                                            Notulen Rapat - [Tanggal Rapat]
                                        </td>
                                        <td style="text-align: right; font-size: 10pt; font-family: 'Cambria', serif;">
                                            Halaman <span class="page-number"></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>`;

        // Tambahkan header dan footer ke konten
        const viewFragment = editor.data.processor.toView(headerHtml + footerHtml);
        const modelFragment = editor.data.toModel(viewFragment);

        editor.model.change(writer => {
            // Tambahkan header dan footer ke awal dokumen
            editor.model.insertContent(modelFragment, editor.model.document.selection);
        });
    }
}

// Konfigurasi editor
const editorConfig = {
    toolbar: {
        items: [
            'heading',
            '|',
            'fontSize',
            'fontFamily',
            'fontColor',
            'fontBackgroundColor',
            '|',
            'bold',
            'italic',
            'underline',
            '|',
            'link',
            'insertTable',
            '|',
            'alignment',
            '|',
            'bulletedList',
            'numberedList',
            'todoList',
            'outdent',
            'indent',
            '|',
            'pageBreak',
            'headerFooter'
        ],
        shouldNotGroupWhenFull: false
    },
    plugins: [
        Alignment,
        Autoformat,
        AutoImage,
        AutoLink,
        Autosave,
        BalloonToolbar,
        BlockToolbar,
        Bold,
        Bookmark,
        CloudServices,
        Code,
        Essentials,
        FindAndReplace,
        FontBackgroundColor,
        FontColor,
        FontFamily,
        FontSize,
        Heading,
        HorizontalLine,
        ImageBlock,
        ImageCaption,
        ImageInline,
        ImageInsertViaUrl,
        ImageResize,
        ImageStyle,
        ImageTextAlternative,
        ImageToolbar,
        ImageUpload,
        Indent,
        IndentBlock,
        Italic,
        Link,
        LinkImage,
        List,
        ListProperties,
        Mention,
        PageBreak,
        Paragraph,
        PasteFromOffice,
        RemoveFormat,
        SpecialCharacters,
        SpecialCharactersArrows,
        SpecialCharactersCurrency,
        SpecialCharactersEssentials,
        SpecialCharactersLatin,
        SpecialCharactersMathematical,
        SpecialCharactersText,
        Strikethrough,
        Subscript,
        Superscript,
        Table,
        TableCaption,
        TableCellProperties,
        TableColumnResize,
        TableProperties,
        TableToolbar,
        TextTransformation,
        TodoList,
        Underline,
        HeaderFooter
    ],
    balloonToolbar: ['bold', 'italic', '|', 'link', '|', 'bulletedList', 'numberedList'],
    blockToolbar: [
        'fontSize',
        'fontColor',
        'fontBackgroundColor',
        '|',
        'bold',
        'italic',
        '|',
        'link',
        'insertTable',
        '|',
        'bulletedList',
        'numberedList',
        'outdent',
        'indent'
    ],
    fontFamily: {
        options: [
            'default',
            'Arial, Helvetica, sans-serif',
            'Cambria, serif',
            'Courier New, Courier, monospace',
            'Georgia, serif',
            'Lucida Sans Unicode, Lucida Grande, sans-serif',
            'Times New Roman, Times, serif',
            'Trebuchet MS, Helvetica, sans-serif',
            'Verdana, Geneva, sans-serif'
        ],
        supportAllValues: true
    },
    fontSize: {
        options: [8, 9, 10, 11, 12, 14, 16, 18, 20, 22, 24, 26, 28, 36, 48],
        supportAllValues: true
    },
    heading: {
        options: [{
                model: 'paragraph',
                title: 'Paragraph',
                class: 'ck-heading_paragraph'
            },
            {
                model: 'heading1',
                view: 'h1',
                title: 'Heading 1',
                class: 'ck-heading_heading1'
            },
            {
                model: 'heading2',
                view: 'h2',
                title: 'Heading 2',
                class: 'ck-heading_heading2'
            },
            {
                model: 'heading3',
                view: 'h3',
                title: 'Heading 3',
                class: 'ck-heading_heading3'
            },
            {
                model: 'heading4',
                view: 'h4',
                title: 'Heading 4',
                class: 'ck-heading_heading4'
            },
            {
                model: 'heading5',
                view: 'h5',
                title: 'Heading 5',
                class: 'ck-heading_heading5'
            },
            {
                model: 'heading6',
                view: 'h6',
                title: 'Heading 6',
                class: 'ck-heading_heading6'
            }
        ]
    },
    image: {
        toolbar: [
            'toggleImageCaption',
            'imageTextAlternative',
            '|',
            'imageStyle:inline',
            'imageStyle:wrapText',
            'imageStyle:breakText',
            '|',
            'resizeImage'
        ]
    },
    initialData: `
    <h2 style="text-align:center; font-family: 'Cambria', serif; font-size: 14pt;">NOTULEN RAPAT</h2>
    <h3 style="font-family: 'Cambria', serif; font-size: 12pt;">Informasi Rapat</h3>
    <table border="0" style="width: 100%; font-family: 'Cambria', serif; font-size: 12pt;">
        <tr>
            <td style="width: 150px">Hari/Tanggal</td>
            <td style="width: 10px">:</td>
            <td></td>
        </tr>
        <tr>
            <td>Waktu</td>
            <td>:</td>
            <td></td>
        </tr>
        <tr>
            <td>Tempat</td>
            <td>:</td>
            <td></td>
        </tr>
        <tr>
            <td>Agenda</td>
            <td>:</td>
            <td></td>
        </tr>
        <tr>
            <td>Peserta</td>
            <td>:</td>
            <td></td>
        </tr>
    </table>
    <h3 style="font-family: 'Cambria', serif; font-size: 12pt;">Pembahasan</h3>
    <ol style="font-family: 'Cambria', serif; font-size: 12pt;">
        <li>
            <p>Agenda 1</p>
            <p>Hasil pembahasan...</p>
        </li>
        <li>
            <p>Agenda 2</p>
            <p>Hasil pembahasan...</p>
        </li>
    </ol>
    <h3 style="font-family: 'Cambria', serif; font-size: 12pt;">Keputusan & Tindak Lanjut</h3>
    <ol style="font-family: 'Cambria', serif; font-size: 12pt;">
        <li>
            <p>Keputusan 1</p>
            <p>Tindak lanjut...</p>
        </li>
        <li>
            <p>Keputusan 2</p>
            <p>Tindak lanjut...</p>
        </li>
    </ol>
    <p>&nbsp;</p>
    <table border="0" style="width: 100%; font-family: 'Cambria', serif; font-size: 12pt;">
        <tr>
            <td style="width: 50%; text-align: center;">
                <p>Mengetahui,</p>
                <p>Ketua</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>(............................)</p>
            </td>
            <td style="width: 50%; text-align: center;">
                <p>Surabaya, ................ 2025</p>
                <p>Notulis</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>(............................)</p>
            </td>
        </tr>
    </table>`,
    licenseKey: LICENSE_KEY,
    link: {
        addTargetToExternalLinks: true,
        defaultProtocol: 'https://',
        decorators: {
            toggleDownloadable: {
                mode: 'manual',
                label: 'Downloadable',
                attributes: {
                    download: 'file'
                }
            }
        }
    },
    list: {
        properties: {
            styles: true,
            startIndex: true,
            reversed: true
        }
    },
    mention: {
        feeds: [{
            marker: '@',
            feed: []
        }]
    },
    menuBar: {
        isVisible: true
    },
    placeholder: 'Ketik atau tempel konten Anda di sini!',
    table: {
        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
    }
};

// Tambahkan CSS kustom untuk header, footer, dan layouting A4
const style = document.createElement('style');
style.innerHTML = `
    /* Styling untuk editor di tampilan web */
    .editor-container__editor {
        background-color: #f5f5f5;
        padding: 20px;
        display: flex;
        justify-content: center;
    }

    #editor {
        background-color: white;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        min-height: 1123px;
        width: 794px;
        padding: 20px;
        box-sizing: border-box;
        margin: 0 auto;
    }

    .document-header {
        position: relative;
        border: 1px dashed #ccc;
        padding: 10px;
        margin-bottom: 20px;
        background-color: #f9f9f9;
    }

    .document-footer {
        position: relative;
        border: 1px dashed #ccc;
        padding: 10px;
        margin-top: 20px;
        background-color: #f9f9f9;
    }

    /* Styling untuk dokumen cetak */
    @media print {
        @page {
            size: A4 portrait;
            margin: 15mm;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Cambria, serif;
            counter-reset: page;
        }

        /* Hide UI elements */
        .editor-container__toolbar,
        .editor-container__menu-bar,
        .print-button,
        .export-buttons {
            display: none !important;
        }

        /* Styling untuk header/footer dengan position: relative */
        .document-header, .document-footer {
            position: relative;
            border: none;
            padding: 5mm 0;
            background-color: white;
            width: 100%;
        }

        /* Add header/footer to each page */
        @page {
            @top-center {
                content: element(header);
            }
            @bottom-center {
                content: element(footer);
            }
        }

        .header-print {
            position: running(header);
        }

        .footer-print {
            position: running(footer);
        }

        /* Page number */
        .page-number:after {
            content: counter(page);
        }

        /* Page break */
        .page-break {
            page-break-before: always;
            display: none;
        }

        /* Prevent element breaking across pages */
        p, h1, h2, h3, h4, h5, h6, table, ol, ul, figure {
            page-break-inside: avoid;
        }
    }

    /* Tambahan styling untuk tombol cetak */
    .print-button {
        background-color: #1a73e8 !important;
        color: white !important;
    }

    .print-button:hover {
        background-color: #0d64d8 !important;
    }

    .export-buttons {
        margin: 10px 0;
        text-align: right;
    }

    .export-buttons button {
        margin-left: 10px !important;
    }
`;
document.head.appendChild(style);

// Modifikasi kode untuk memindahkan tombol ke header
DecoupledEditor.create(document.querySelector('#editor'), editorConfig)
    .then(editor => {
        // Lampirkan toolbar dan menu bar ke elemen yang ditentukan
        document.querySelector('#editor-toolbar').appendChild(editor.ui.view.toolbar.element);

        // Pastikan bahwa menu bar view tersedia sebelum mencoba memasangnya
        if (editor.ui.view.menuBarView && document.querySelector('#editor-menu-bar')) {
            document.querySelector('#editor-menu-bar').appendChild(editor.ui.view.menuBarView.element);
        }

        // Buat tombol save dan print
        // Tombol Save to Database
        const buttonSave = document.createElement('button');
        buttonSave.textContent = 'Save to Database';
        buttonSave.className = 'ck ck-button save-button';
        buttonSave.style.marginLeft = '10px';
        buttonSave.addEventListener('click', async () => {
            // Kode event listener yang sama seperti sebelumnya
            const content = editor.getData();
            const title = document.querySelector('h2') ? document.querySelector('h2').textContent.trim() : 'Notulen Rapat';

            try {
                // Show loading indicator
                buttonSave.textContent = 'Saving...';
                buttonSave.disabled = true;

                // Get information from URL parameters
                const urlParams = new URLSearchParams(window.location.search);
                alert(urlParams);
                const rapatId = urlParams.get('id_rapat');

                // Periksa dan ambil parameter yang ada (selain ormawa_id yang selalu ada)
                const programKerjaId = urlParams.get('program_kerjas_id');
                const divisiOrmawaId = urlParams.get('divisi_ormawas_id');
                const divisiProgramKerjaId = urlParams.get('divisi_program_kerjas_id');

                // Log for debugging
                console.log('Rapat ID:', rapatId);
                console.log('Params:', {
                    program_kerjas_id: programKerjaId,
                    divisi_ormawas_id: divisiOrmawaId,
                    divisi_program_kerjas_id: divisiProgramKerjaId
                });

                // Buat object data dasar
                const postData = {
                    title: title,
                    content: content,
                    rapat_id: rapatId
                };

                // Tambahkan parameter lain jika ada
                if (programKerjaId) {
                    postData.program_kerjas_id = programKerjaId;
                } else if (divisiOrmawaId) {
                    postData.divisi_ormawas_id = divisiOrmawaId;
                } else if (divisiProgramKerjaId) {
                    postData.divisi_program_kerjas_id = divisiProgramKerjaId;
                } else {
                    const pathSegments = window.location.pathname.split('/');
                    const ormawaCode = pathSegments[1];

                    postData.ormawa_id = ormawaCode;

                }

                // Dapatkan kode ormawa dari URL
                const pathSegments = window.location.pathname.split('/');
                const ormawaCode = pathSegments[1]; // Asumsikan format URL adalah /{KODE_ORMAWA}/rapat/...

                // Send the content to the server
                const response = await fetch('/api/notulens/save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(postData)
                });

                if (response.ok) {
                    const result = await response.json();
                    alert('Notulen berhasil disimpan!');

                    // Redirect ke halaman yang sesuai
                    window.location.href = `/${ormawaCode}/rapat/notulen/${result.id}`;
                } else {
                    const error = await response.json();
                    alert(`Error menyimpan notulen: ${error.message || 'Unknown error'}`);
                }
            } catch (error) {
                console.error('Error saving document:', error);
                alert('Gagal menyimpan notulen. Silakan coba lagi.');
            } finally {
                // Reset button state
                buttonSave.textContent = 'Save to Database';
                buttonSave.disabled = false;
            }
        });

        // Tombol Cetak
        const buttonPrint = document.createElement('button');
        buttonPrint.textContent = 'Cetak Dokumen';
        buttonPrint.className = 'ck ck-button print-button';
        buttonPrint.style.marginLeft = '10px';
        buttonPrint.addEventListener('click', () => {
            const content = editor.getData();
            const printWindow = window.open('', '_blank');

            // Buat dokumen cetak dengan konten editor dan styling untuk header/footer yang tepat
            printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Cetak Notulen Rapat</title>
            <style>
                /* Base styling */
                @media print {
                    @page {
                        size: A4;
                        margin: 0;
                    }
                }

                body {
                    font-family: "Cambria", serif;
                    font-size: 12pt;
                    line-height: 1.2;
                    margin: 0;
                    padding: 0;
                    counter-reset: page;
                }

                p {
                    margin: 4px 0; /* Reduced paragraph spacing */
                }

                h1, h2, h3, h4, h5, h6 {
                    margin-top: 8px;
                    margin-bottom: 8px;
                }

                /* Hide borders from editor view */
                .document-header, .document-footer {
                    position: relative;
                    border: none !important;
                    background-color: transparent !important;
                }

                /* Page structure */
                .page {
                    position: relative;
                    width: 210mm;
                    min-height: 297mm;
                    height: 297mm;
                    page-break-after: always;
                    margin: 0 auto;
                    background: white;
                    box-sizing: border-box;
                    overflow: hidden;
                }

                /* Header/footer containers */
                .header-container {
                    position: relative;
                    top: 0;
                    left: 0;
                    right: 0;
                    height: 48px;
                    padding: 8mm 15mm 0;
                }

                .footer-container {
                    position: relative;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    height: 48px;
                    padding: 0 15mm 8mm;
                }

                /* Content container */
                .content-container {
                    padding: 125px 15mm 50px;
                    box-sizing: border-box;
                    max-height: calc(297mm - 125px - 50px);
                    overflow: hidden;
                }

                /* Fixed spacing for document header elements */
                .document-header table {
                    margin: 0;
                }

                .document-header {
                    margin-bottom: 20px !important; /* Add space after header in editor view */
                }

                .document-header p {
                    margin: 1px 0; /* Even smaller margins in header */
                    line-height: 1.1; /* Tighter line height in header */
                }

                .document-header hr {
                    margin: 3px 0;
                }

                /* Fixed spacing for document footer elements */
                .document-footer hr {
                    margin: 3px 0;
                }

                .document-footer p {
                    margin: 1px 0;
                }

                /* Page number handling */
                .page {
                    counter-increment: page;
                }

                .page-number:after {
                    content: counter(page);
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    table-layout: fixed;
                }

                table td, table th {
                    padding: 2px 4px; /* Reduced cell padding */
                }

                /* List spacing adjustments */
                ol, ul {
                    margin-top: 4px;
                    margin-bottom: 4px;
                    padding-left: 20px;
                }

                li {
                    margin-bottom: 2px;
                }

                /* Additional print styles */
                @media print {
                    body {
                        background: white;
                    }
                    .page {
                        box-shadow: none;
                        margin: 0;
                    }
                    .page-break {
                        display: none;
                    }
                }
            </style>
        </head>
        <body>
            <script>
                window.onload = function() {
                    // Parse the content
                    const contentStr = \`${content}\`;
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(contentStr, 'text/html');

                    // Extract header and footer
                    const headerEl = doc.querySelector('.document-header');
                    const footerEl = doc.querySelector('.document-footer');

                    let headerHtml = '';
                    let footerHtml = '';

                    if (headerEl) {
                        headerHtml = headerEl.outerHTML;
                        headerEl.remove();
                    }

                    if (footerEl) {
                        footerHtml = footerEl.outerHTML;
                        footerEl.remove();
                    }

                    // Get the remaining content
                    const mainContent = doc.body.innerHTML;

                    // Process any existing manual page breaks
                    let contentParts = [];
                    if (mainContent.includes('<div class="page-break"></div>')) {
                        contentParts = mainContent.split('<div class="page-break"></div>');
                    } else {
                        contentParts = [mainContent];
                    }

                    // Function to create a page with content
                    const createPage = (content, isFirstPage = false) => {
                        // For first page, include title after header
                        const firstPageContent = isFirstPage ? titleHtml + content : content;

                        return \`
                            <div class="page">
                                <div class="header-container">\${headerHtml}</div>
                                <div class="content-container">\${firstPageContent}</div>
                                <div class="footer-container">\${footerHtml}</div>
                            </div>
                        \`;
                    };

                    // First, append all parts with manual page breaks
                    let allPagesHtml = '';
                    contentParts.forEach(content => {
                        // Now we'll handle automatic pagination for each content part
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = content;

                        // Get all top-level elements
                        const elements = Array.from(tempDiv.children);

                        // Initialize variables for automatic pagination
                        let currentPageContent = '';
                        let currentPageHeight = 0;
                        const maxPageContentHeight = 730; // Approximate content height for A4 in pixels

                        // Process each element for automatic pagination
                        elements.forEach(element => {
                            // Get element's approximate height
                            const elementClone = element.cloneNode(true);
                            const measureDiv = document.createElement('div');
                            measureDiv.style.visibility = 'hidden';
                            measureDiv.style.position = 'absolute';
                            measureDiv.style.width = '170mm'; // Approximate content width of A4
                            measureDiv.appendChild(elementClone);
                            document.body.appendChild(measureDiv);

                            const elementHeight = measureDiv.offsetHeight;
                            document.body.removeChild(measureDiv);

                            // Check if adding this element would exceed the page height
                            if (currentPageHeight + elementHeight > maxPageContentHeight && currentPageContent !== '') {
                                // Create a new page with the current content
                                allPagesHtml += createPage(currentPageContent);

                                // Reset for new page
                                currentPageContent = '';
                                currentPageHeight = 0;
                            }

                            // Add element to current page
                            currentPageContent += element.outerHTML;
                            currentPageHeight += elementHeight;
                        });

                        // Add the final page for this content part
                        if (currentPageContent !== '') {
                            allPagesHtml += createPage(currentPageContent);
                        }
                    });

                    // Insert into the document
                    document.body.innerHTML = allPagesHtml;

                    // Wait a bit to ensure all content is rendered properly
                    setTimeout(() => {
                        // Apply final fixes for page numbers
                        document.querySelectorAll('.page').forEach((page, index) => {
                            const pageNumElements = page.querySelectorAll('.page-number');
                            pageNumElements.forEach(el => {
                                el.textContent = (index + 1).toString();
                            });
                        });

                        // Finally, print
                        window.print();
                    }, 500);
                };
            </script>
        </body>
        </html>
    `);
            printWindow.document.close();
        });

        // Tambahkan CSS untuk tombol-tombol
        const buttonStyle = document.createElement('style');
        buttonStyle.innerHTML = `
            .save-button {
                background-color: #4CAF50 !important;
                color: white !important;
            }

            .save-button:hover {
                background-color: #45a049 !important;
            }

            .save-button:disabled {
                background-color: #cccccc !important;
                cursor: not-allowed !important;
            }

            .print-button {
                background-color: #1a73e8 !important;
                color: white !important;
            }

            .print-button:hover {
                background-color: #0d64d8 !important;
            }
        `;
        document.head.appendChild(buttonStyle);

        // PENTING: Tambahkan tombol-tombol ke toolbar CKEditor
        // Ini adalah bagian kunci untuk memasukkan tombol ke dalam header
        const toolbar = document.querySelector('#editor-toolbar .ck-toolbar__items');

        // Buat pembatas untuk memisahkan tombol-tombol
        const separator = document.createElement('span');
        separator.className = 'ck ck-toolbar__separator';
        toolbar.appendChild(separator);

        // Tambahkan tombol-tombol ke toolbar
        toolbar.appendChild(buttonSave);
        toolbar.appendChild(buttonPrint);

        return editor;
    })
    .catch(error => {
        console.error('Error initializing editor:', error);
    });
