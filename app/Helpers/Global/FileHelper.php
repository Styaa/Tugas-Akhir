<?php

// app/Helpers/FileHelper.php

function getFileIconClass($extension)
{
    $extension = strtolower($extension);

    switch ($extension) {
        case 'pdf':
            return 'pdf';
        case 'doc':
        case 'docx':
            return 'word';
        case 'xls':
        case 'xlsx':
            return 'excel';
        case 'ppt':
        case 'pptx':
            return 'powerpoint';
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
            return 'image';
        case 'zip':
        case 'rar':
            return 'zip';
        default:
            return 'text';
    }
}

if (!function_exists('getFileType')) {
    /**
     * Mendapatkan tipe file berdasarkan ekstensi
     *
     * @param string $extension
     * @return string
     */
    function getFileType($extension)
    {
        $extension = strtolower($extension);

        switch ($extension) {
            case 'pdf':
                return 'PDF Document';
            case 'doc':
            case 'docx':
                return 'Word Document';
            case 'xls':
            case 'xlsx':
                return 'Excel Spreadsheet';
            case 'ppt':
            case 'pptx':
                return 'PowerPoint Presentation';
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                return 'Image';
            case 'zip':
            case 'rar':
                return 'Archive';
            default:
                return 'Document';
        }
    }
}

if (!function_exists('formatFileSize')) {
    /**
     * Format ukuran file dalam bytes menjadi representasi yang mudah dibaca
     *
     * @param int $bytes
     * @return string
     */
    function formatFileSize($bytes)
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}
