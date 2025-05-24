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
        supportAllValues: true,
        defaultValue: 'Cambria, serif'
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
    initialData: lpjContent || `
        <div class="proposal-template">
            <!-- Header Section -->
            <div class="proposal-header" style="text-align:center;">
                <h1 style="text-align:center; font-family: 'Cambria', serif; font-size: 16pt; font-weight: bold; margin-bottom: 5px;">LAPORAN PERTANGGUNGJAWABAN</h1>
                <h2 style="text-align:center; font-family: 'Cambria', serif; font-size: 14pt; font-style: italic; margin-top: 5px; margin-bottom: 15px;">[NAMA KEGIATAN]</h2>
                <h3 style="text-align:center; font-family: 'Cambria', serif; font-size: 14pt; font-weight: bold; margin-top: 15px; margin-bottom: 5px;">[NAMA ORGANISASI/UNIT]</h3>
                <h3 style="text-align:center; font-family: 'Cambria', serif; font-size: 14pt; font-weight: bold; margin-top: 5px;">[TAHUN]</h3>
                <h3 style="text-align:center; font-family: 'Cambria', serif; font-size: 12pt; font-weight: bold; margin-top: 20px;">FAKULTAS [NAMA FAKULTAS]</h3>
                <h3 style="text-align:center; font-family: 'Cambria', serif; font-size: 12pt; font-weight: bold; margin-top: 5px;">UNIVERSITAS SURABAYA</h3>
            </div>

            <!-- Table of Contents Section -->
            <div class="table-of-contents" style="margin-bottom: 30px; display: none;">
                <!-- This will be auto-generated if needed -->
            </div>

            <!-- Section 1: Latar Belakang -->
            <h2 style="font-family: 'Cambria', serif; font-size: 14pt; font-weight: bold; margin-top: 30px;">LATAR BELAKANG KEGIATAN</h2>
            <p style="font-family: 'Cambria', serif; font-size: 12pt; text-align: justify; text-indent: 30px;">
                [Isi latar belakang kegiatan - jelaskan mengapa kegiatan ini perlu diadakan, situasi/kondisi yang melatarbelakangi, serta manfaat yang diharapkan]
            </p>

            <!-- Section 2: Sasaran & Tujuan -->
            <h2 style="font-family: 'Cambria', serif; font-size: 14pt; font-weight: bold; margin-top: 30px;">SASARAN & TUJUAN</h2>
            <p style="font-family: 'Cambria', serif; font-size: 12pt;"><strong>Sasaran :</strong> [Target peserta/audience dari kegiatan ini]</p>
            <p style="font-family: 'Cambria', serif; font-size: 12pt;"><strong>Tujuan :</strong></p>
            <ol style="font-family: 'Cambria', serif; font-size: 12pt;">
                <li>[Tujuan pertama]</li>
                <li>[Tujuan kedua]</li>
                <li>[Tujuan ketiga]</li>
                <li>[Tujuan keempat, dst]</li>
            </ol>

            <!-- Section 3: Nama Kegiatan -->
            <h2 style="font-family: 'Cambria', serif; font-size: 14pt; font-weight: bold; margin-top: 30px;">NAMA KEGIATAN</h2>
            <p style="font-family: 'Cambria', serif; font-size: 12pt; text-align: justify;">[Nama kegiatan].</p>

            <!-- Section 4: Bentuk Kegiatan -->
            <h2 style="font-family: 'Cambria', serif; font-size: 14pt; font-weight: bold; margin-top: 30px;">BENTUK KEGIATAN</h2>
            <p style="font-family: 'Cambria', serif; font-size: 12pt; text-align: justify;">
                [Jelaskan format/bentuk kegiatan akan dilaksanakan, misalnya: seminar, workshop, kompetisi, dll. Beri detail tentang metode pelaksanaan kegiatan]
            </p>

            <!-- Section 5: Pelaksanaan Kegiatan -->
            <h2 style="font-family: 'Cambria', serif; font-size: 14pt; font-weight: bold; margin-top: 30px;">PELAKSANAAN KEGIATAN</h2>
            <p style="font-family: 'Cambria', serif; font-size: 12pt;"><strong>Hari, tanggal :</strong> [Hari, tanggal kegiatan]</p>
            <p style="font-family: 'Cambria', serif; font-size: 12pt;"><strong>Tempat :</strong> [Lokasi kegiatan]</p>
            <p style="font-family: 'Cambria', serif; font-size: 12pt;"><strong>Waktu :</strong></p>
            <p style="font-family: 'Cambria', serif; font-size: 12pt;"><strong>Rundown Acara</strong></p>
            <table border="1" style="width: 100%; border-collapse: collapse; font-family: 'Cambria', serif; font-size: 12pt;">
                <tr style="background-color: #f2f2f2;">
                    <th style="padding: 8px; text-align: center; width: 30%;">Waktu</th>
                    <th style="padding: 8px; text-align: center; width: 70%;">Kegiatan</th>
                </tr>
                <tr>
                    <td style="padding: 8px; text-align: center; font-weight: bold;" colspan="2">[HARI 1, TANGGAL]</td>
                </tr>
                <tr>
                    <td style="padding: 8px;">[Waktu]</td>
                    <td style="padding: 8px;">[Kegiatan]</td>
                </tr>
                <tr>
                    <td style="padding: 8px;">[Waktu]</td>
                    <td style="padding: 8px;">[Kegiatan]</td>
                </tr>
                <tr>
                    <td style="padding: 8px; text-align: center; font-weight: bold;" colspan="2">[HARI 2, TANGGAL] (jika ada)</td>
                </tr>
                <tr>
                    <td style="padding: 8px;">[Waktu]</td>
                    <td style="padding: 8px;">[Kegiatan]</td>
                </tr>
            </table>

            <!-- Section 6: Susunan Panitia -->
            <h2 style="font-family: 'Cambria', serif; font-size: 14pt; font-weight: bold; margin-top: 30px;">SUSUNAN PANITIA PELAKSANAAN</h2>
            <table border="1" style="width: 100%; border-collapse: collapse; font-family: 'Cambria', serif; font-size: 12pt;">
                <tr style="background-color: #f2f2f2;">
                    <th style="padding: 8px; text-align: center; width: 10%;">No</th>
                    <th style="padding: 8px; text-align: center; width: 40%;">Nama</th>
                    <th style="padding: 8px; text-align: center; width: 20%;">NRP/NPK</th>
                    <th style="padding: 8px; text-align: center; width: 30%;">Jabatan</th>
                </tr>
                <tr>
                    <td style="padding: 8px; text-align: center;">1.</td>
                    <td style="padding: 8px;">[Nama]</td>
                    <td style="padding: 8px;">[NRP/NPK]</td>
                    <td style="padding: 8px;">[Jabatan]</td>
                </tr>
                <tr>
                    <td style="padding: 8px; text-align: center;">2.</td>
                    <td style="padding: 8px;">[Nama]</td>
                    <td style="padding: 8px;">[NRP/NPK]</td>
                    <td style="padding: 8px;">[Jabatan]</td>
                </tr>
            </table>

            <!-- Section 7: Indikator Keberhasilan -->
            <h2 style="font-family: 'Cambria', serif; font-size: 14pt; font-weight: bold; margin-top: 30px;">INDIKATOR KEBERHASILAN</h2>
            <p style="font-family: 'Cambria', serif; font-size: 12pt; text-align: justify;">
                [Jelaskan bagaimana mengukur keberhasilan kegiatan ini, misalnya: jumlah peserta, hasil kuesioner, dsb]
            </p>

            <!-- Section 8: Sumber Dana & Anggaran -->
            <h2 style="font-family: 'Cambria', serif; font-size: 14pt; font-weight: bold; margin-top: 30px;">SUMBER DANA DAN ANGGARAN DANA</h2>

            <!-- Pemasukan Table -->
            <p style="font-family: 'Cambria', serif; font-size: 12pt; font-weight: bold;">BIAYA PEMASUKAN</p>
            <table border="1" style="width: 100%; border-collapse: collapse; font-family: 'Cambria', serif; font-size: 12pt; margin-bottom: 20px;">
                <tr style="background-color: #f2f2f2;">
                    <th style="padding: 8px; text-align: center; width: 10%;">No</th>
                    <th style="padding: 8px; text-align: center; width: 40%;">Komponen Biaya</th>
                    <th style="padding: 8px; text-align: center; width: 15%;">Biaya</th>
                    <th style="padding: 8px; text-align: center; width: 15%;">Jumlah</th>
                    <th style="padding: 8px; text-align: center; width: 20%;">Total</th>
                </tr>
                <tr>
                    <td style="padding: 8px; text-align: center;">1.</td>
                    <td style="padding: 8px;">[Sumber Dana]</td>
                    <td style="padding: 8px; text-align: right;">Rp[Nominal]</td>
                    <td style="padding: 8px; text-align: center;">[Jumlah]</td>
                    <td style="padding: 8px; text-align: right;">Rp[Total]</td>
                </tr>
                <tr>
                    <td style="padding: 8px; text-align: center;">2.</td>
                    <td style="padding: 8px;">[Sumber Dana]</td>
                    <td style="padding: 8px; text-align: right;">Rp[Nominal]</td>
                    <td style="padding: 8px; text-align: center;">[Jumlah]</td>
                    <td style="padding: 8px; text-align: right;">Rp[Total]</td>
                </tr>
                <tr style="font-weight: bold; background-color: #f2f2f2;">
                    <td style="padding: 8px; text-align: center;" colspan="4">TOTAL PEMASUKAN</td>
                    <td style="padding: 8px; text-align: right;">Rp[Grand Total]</td>
                </tr>
            </table>

            <!-- Pengeluaran Table -->
            <p style="font-family: 'Cambria', serif; font-size: 12pt; font-weight: bold;">BIAYA PENGELUARAN</p>

            <!-- Sie 1 Expenses -->
            <p style="font-family: 'Cambria', serif; font-size: 12pt; font-weight: bold;">SIE [NAMA SIE 1]</p>
            <table border="1" style="width: 100%; border-collapse: collapse; font-family: 'Cambria', serif; font-size: 12pt; margin-bottom: 20px;">
                <tr style="background-color: #f2f2f2;">
                    <th style="padding: 8px; text-align: center; width: 10%;">No</th>
                    <th style="padding: 8px; text-align: center; width: 30%;">Nama Barang</th>
                    <th style="padding: 8px; text-align: center; width: 15%;">Harga Barang</th>
                    <th style="padding: 8px; text-align: center; width: 15%;">Jumlah Barang</th>
                    <th style="padding: 8px; text-align: center; width: 10%;">Satuan</th>
                    <th style="padding: 8px; text-align: center; width: 20%;">Total</th>
                </tr>
                <tr>
                    <td style="padding: 8px; text-align: center;">1.</td>
                    <td style="padding: 8px;">[Nama Barang]</td>
                    <td style="padding: 8px; text-align: right;">Rp[Harga]</td>
                    <td style="padding: 8px; text-align: center;">[Jumlah]</td>
                    <td style="padding: 8px; text-align: center;">[Satuan]</td>
                    <td style="padding: 8px; text-align: right;">Rp[Total]</td>
                </tr>
                <tr style="font-weight: bold; background-color: #f2f2f2;">
                    <td style="padding: 8px; text-align: center;" colspan="5">Subtotal</td>
                    <td style="padding: 8px; text-align: right;">Rp[Subtotal]</td>
                </tr>
            </table>

            <!-- Total Expenses -->
            <table border="1" style="width: 100%; border-collapse: collapse; font-family: 'Cambria', serif; font-size: 12pt; margin-bottom: 20px;">
                <tr style="font-weight: bold; background-color: #f2f2f2;">
                    <td style="padding: 8px; text-align: center; width: 80%;">SUBTOTAL PENGELUARAN</td>
                    <td style="padding: 8px; text-align: right; width: 20%;">Rp[Grand Total]</td>
                </tr>
            </table>

            <!-- Section 9: Penutup -->
            <h2 style="font-family: 'Cambria', serif; font-size: 14pt; font-weight: bold; margin-top: 30px;">PENUTUP</h2>
            <p style="font-family: 'Cambria', serif; font-size: 12pt; text-align: justify; text-indent: 30px;">
                Demikian proposal ini kami buat, dengan harapan acara yang akan berjalan dapat memberikan manfaat kepada [target peserta/audience]. Sekian proposal ini, kami dan segenap anggota kepanitiaan mengucapkan terima kasih. Contact Person: <strong>[Nama]</strong> dengan nomor telepon <strong>[Nomor Telepon]</strong>.
            </p>

            <!-- Section 10: Lembar Pengesahan -->
            <h2 style="font-family: 'Cambria', serif; font-size: 14pt; font-weight: bold; margin-top: 30px;">LEMBAR PENGESAHAN</h2>
            <table border="0" style="width: 100%; border-collapse: collapse; font-family: 'Cambria', serif; font-size: 12pt;">
                <tr>
                    <td style="width: 50%;"></td>
                    <td style="width: 50%;">[Kota], [Tanggal]</td>
                </tr>
                <tr>
                    <td colspan="2">Dengan hormat,</td>
                </tr>
            </table>
            <table border="0" style="width: 100%; border-collapse: collapse; font-family: 'Cambria', serif; font-size: 12pt; margin-top: 20px;">
                <tr>
                    <td style="width: 50%; text-align: center;">Ketua Acara</td>
                    <td style="width: 50%; text-align: center;">Sekretaris dan Bendahara</td>
                </tr>
                <tr>
                    <td style="height: 80px;"></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: center; text-decoration: underline;">[Nama Ketua]</td>
                    <td style="text-align: center; text-decoration: underline;">[Nama Sekretaris]</td>
                </tr>
                <tr>
                    <td style="text-align: center;">([NRP Ketua])</td>
                    <td style="text-align: center;">([NRP Sekretaris])</td>
                </tr>
            </table>
            <table border="0" style="width: 100%; border-collapse: collapse; font-family: 'Cambria', serif; font-size: 12pt; margin-top: 20px;">
                <tr>
                    <td colspan="2">Menyetujui,</td>
                </tr>
                <tr>
                    <td style="width: 50%; text-align: center;">Gubernur BEM Fakultas</td>
                    <td style="width: 50%; text-align: center;">Ketua [Nama Organisasi]</td>
                </tr>
                <tr>
                    <td style="height: 80px;"></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: center; text-decoration: underline;">[Nama Gubernur BEM]</td>
                    <td style="text-align: center; text-decoration: underline;">[Nama Ketua Organisasi]</td>
                </tr>
                <tr>
                    <td style="text-align: center;">([NRP Gubernur BEM])</td>
                    <td style="text-align: center;">([NRP Ketua Organisasi])</td>
                </tr>
            </table>
            <table border="0" style="width: 100%; border-collapse: collapse; font-family: 'Cambria', serif; font-size: 12pt; margin-top: 20px;">
                <tr>
                    <td colspan="2">Mengetahui,</td>
                </tr>
                <tr>
                    <td style="width: 50%; text-align: center;">Ketua Jurusan [Nama Jurusan]</td>
                    <td style="width: 50%; text-align: center;">Dosen Pembimbing</td>
                </tr>
                <tr>
                    <td style="height: 80px;"></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: center; text-decoration: underline;">[Nama Ketua Jurusan]</td>
                    <td style="text-align: center; text-decoration: underline;">[Nama Dosen Pembimbing]</td>
                </tr>
                <tr>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                </tr>
            </table>
        </div>
        `,
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
    /* Original styles preserved */
    .editor-container__editor {
        background-color: #f5f5f5;
        padding: 10px;
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
        .editor-header-buttons,
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

    /* Header buttons container */
    .editor-header-buttons {
        display: flex;
        justify-content: flex-end;
        padding: 10px;
        background-color: #f0f0f0;
        border-bottom: 1px solid #ddd;
    }

    /* Button styling */
    .editor-button {
        margin-left: 10px;
        padding: 8px 16px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 14px;
        font-weight: 500;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .print-button {
        background-color: #1a73e8;
        color: white;
    }

    .print-button:hover {
        background-color: #0d64d8;
    }

    .save-button {
        background-color: #34a853;
        color: white;
    }

    .save-button:hover {
        background-color: #2d9249;
    }
`;
document.head.appendChild(style);

// Inisialisasi editor
DecoupledEditor.create(document.querySelector('#editor'), editorConfig)
    .then(editor => {
        // Lampirkan toolbar dan menu bar ke elemen yang ditentukan
        document.querySelector('#editor-toolbar').appendChild(editor.ui.view.toolbar.element);

        // Pastikan bahwa menu bar view tersedia sebelum mencoba memasangnya
        if (editor.ui.view.menuBarView && document.querySelector('#editor-menu-bar')) {
            document.querySelector('#editor-menu-bar').appendChild(editor.ui.view.menuBarView.element);
        }

        const buttonSave = document.createElement('button');
        buttonSave.textContent = 'Save to Database';
        buttonSave.className = 'ck ck-button save-button';
        buttonSave.style.marginLeft = '10px';
        buttonSave.addEventListener('click', async () => {
            const content = editor.getData();
            try {
                // Show loading indicator
                buttonSave.textContent = 'Saving...';
                buttonSave.disabled = true;

                // Get information from URL parameters
                const urlParams = window.location.pathname.split('/');
                const programKerjaIndex = urlParams.indexOf('program-kerja');

                // Extract parameters matching the database structure
                const programKerjaId = urlParams[programKerjaIndex+1];
                const ormawaKode = urlParams[1];
                const tipe = 'laporan_pertanggungjawaban';

                // Check if we're editing an existing document
                const urlParams2 = new URLSearchParams(window.location.search);
                const dokumenId = urlParams2.get('dokumenId');

                // Prepare data structure that matches database fields
                const postData = {
                    isi_dokumen: content,
                    program_kerja_id: programKerjaId,
                    ormawas_kode: ormawaKode,
                    tipe: tipe,
                    status: 'draft',
                    catatan: '',
                    revisi: 0,
                    step: 1,
                    peninjau_id: 0,
                    id: dokumenId // Include the ID if we're updating
                };

                // Send the content to the server - use PUT for updates
                const endpoint = dokumenId ?
                    `/api/lpj/update/${dokumenId}` :
                    `/api/lpj/save`;

                const method = dokumenId ? 'PUT' : 'POST';

                const response = await fetch(endpoint, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(postData)
                });

                if (response.ok) {
                    const result = await response.json();
                    alert('Dokumen berhasil disimpan!');

                    // Redirect to appropriate page
                    // const ormawaCode = postData.ormawas_kode;
                    window.location.href = `/${ormawaKode}/program-kerja/${programKerjaId}/lpj/create?dokumenId=${result.id}`;
                } else {
                    const error = await response.json();
                    alert(`Error menyimpan dokumen: ${error.message || 'Unknown error'}`);
                }
            } catch (error) {
                console.error('Error saving document:', error);
                alert('Gagal menyimpan dokumen. Silakan coba lagi.');
            } finally {
                // Reset button state
                buttonSave.textContent = 'Save to Database';
                buttonSave.disabled = false;
            }
        });

        // Tambahkan tombol cetak dan export dalam container terpisah
        const exportButtons = document.createElement('div');
        exportButtons.className = 'export-buttons';

        // Tombol Cetak
        const buttonPrint = document.createElement('button');
        buttonPrint.textContent = 'Cetak Dokumen';
        buttonPrint.className = 'ck ck-button print-button';
        // Modifikasi fungsi cetak untuk menambahkan page break otomatis
        // Tambahkan ini ke bagian tombol Print pada kode CKEditor Anda

        buttonPrint.addEventListener('click', () => {
            const content = editor.getData();
            const printWindow = window.open('', '_blank');

            // Buat dokumen cetak dengan konten editor dan styling untuk header/footer yang tepat
            printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Cetak Laporan Pertanggungjawaban Program Kerja</title>
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
                    margin: 0;
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
                    height: 32.7mm;
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
                    padding: 12px 15mm 50px;
                    box-sizing: border-box;
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
                        const maxPageContentHeight = 1069; // Approximate content height for A4 in pixels

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

        // Optionaly, tambahkan skrip untuk deteksi panjang konten dan penambahan page break otomatis saat edit
        // Fungsi ini bisa ditambahkan ke event editor.model.document.on('change:data')
        function detectContentOverflow() {
            // Ini contoh implementasi sederhana
            // Dalam prakteknya, fungsi ini perlu dibuat lebih robust untuk menangani kondisi kompleks
            const contentHeight = editor.editing.view.domRoots.get('main').getBoundingClientRect().height;
            const pageHeight = 1069; // Tinggi halaman A4 dalam piksel

            if (contentHeight > pageHeight) {
                // Tambahkan page break otomatis
                // Implementasi lebih lanjut dibutuhkan untuk menambahkan page break di posisi yang tepat
                console.log("Content overflow detected, automatic page break should be added");
            }
        }

        const toolbar = document.querySelector('#editor-toolbar .ck-toolbar__items');

        // Buat pembatas untuk memisahkan tombol-tombol
        const separator = document.createElement('span');
        separator.className = 'ck ck-toolbar__separator';
        toolbar.appendChild(separator);

        // Tambahkan tombol-tombol ke toolbar
        toolbar.appendChild(buttonSave);
        toolbar.appendChild(buttonPrint);

        // Sisipkan tombol export setelah toolbar
        document.querySelector('#editor-toolbar').parentNode.insertBefore(exportButtons, document.querySelector('#editor-toolbar').nextSibling);

        return editor;
    })
    .catch(error => {
        console.error('Error initializing editor:', error);
    });
