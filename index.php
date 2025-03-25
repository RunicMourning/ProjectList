<?php
define('PROJECTS_DIR', 'projects');

function getRelativeTime($datetime, $depth = 1) {
    $timeUnits = array(
        "year" => 31104000,
        "month" => 2592000,
        "week" => 604800,
        "day" => 86400,
        "hour" => 3600,
        "minute" => 60,
        "second" => 1
    );

    // Use these values directly where needed
    $plural = "s";
    $conjugator = " and ";
    $separator = ", ";

    $timediff = time() - strtotime($datetime);

    // Handle special cases
    if ($timediff == 0) {
        return "now";
    }

    if ($depth < 1) {
        return "";
    }

    $maxDepth = count($timeUnits);
    $remainder = abs($timediff);
    $output = "";
    $countDepth = 0;
    $fixDepth = true;

    foreach ($timeUnits as $unit => $value) {
        if ($remainder > $value && $depth-- > 0) {
            // Update variable names for better readability
            if ($fixDepth) {
                $maxDepth -= ++$countDepth;
                if ($depth >= $maxDepth) {
                    $depth = $maxDepth;
                }
                $fixDepth = false;
            }

            $u = (int)($remainder / $value);
            $remainder %= $value;
            $pluralise = $u > 1 ? $plural : "";
            $separate = $remainder == 0 || $depth == 0 ? "" : ($depth == 1 ? $conjugator : $separator);
            
            // Improved formatting for better readability
            $output .= "{$u} {$unit}{$pluralise}{$separate}";
        }
        $countDepth++;
    }

    return $output . ($timediff < 0 ? " left" : " ago");
}


function getFilesize($file, $digits = 2) {
    if (is_file($file)) {
        $filePath = $file;
        if (!realpath($filePath)) {
            $filePath = $_SERVER["DOCUMENT_ROOT"] . $filePath;
        }
        $fileSize = filesize($filePath);
        $sizes = array("TB", "GB", "MB", "KB", "B");
        $total = count($sizes);
        while ($total-- && $fileSize > 1024) {
            $fileSize /= 1024;
        }
        return round($fileSize, $digits) . " " . $sizes[$total];
    }
    return false;
}

function getFileTypeClass($filename) {
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $filetype = "file-file";
    switch ($extension) {
        case "php":
        case "inc":
            $filetype = "file-php";
            break;
        case "js":
            $filetype = "file-js";
            break;
        case "html":
        case "htm":
            $filetype = "file-web";
            break;
        case "css":
            $filetype = "file-css";
            break;
        case "jpg":
        case "jpeg":
        case "gif":
        case "png":
        case "svg":
        case "ico":
            $filetype = "file-image";
            break;
        case "txt":
        case "md":
        case "csv":
        case "json":
        case "xml":
            $filetype = "file-text";
            break;
        case "doc":
        case "docx":
        case "xls":
        case "xlsx":
        case "ppt":
        case "pptx":
            $filetype = "file-office";
            break;
        case "pdf":
            $filetype = "file-pdf";
            break;
        case "mp3":
        case "ogg":
        case "wav":
            $filetype = "file-audio";
            break;
        case "mp4":
        case "mkv":
        case "webm":
            $filetype = "file-video";
            break;
    }
    return $filetype;
}

function listFiles($directory) {
    $files = scandir($directory);
    $files = array_diff($files, [".", ".."]);

    $directories = [];
    $filesList = [];

    foreach ($files as $file) {
        $filePath = $directory . DIRECTORY_SEPARATOR . $file;
        if (is_dir($filePath)) {
            $directories[] = $file;
        } else {
            $filesList[] = $file;
        }
    }

    natcasesort($directories);
    natcasesort($filesList);

    $output = '<ul class="filelist">';
    $output .= '<li><ul class="flisthead">
                    <li class="col1 file-type">&nbsp;</li>
                    <li class="col">File Name</li>
                    <li class="col">File Size</li>
                    <li class="col">Last Modified</li>
                    <li class="col">Description</li>
                </ul></li>';

    foreach ($directories as $dir) {
        $dirPath = $directory . DIRECTORY_SEPARATOR . $dir;
        $lastmod = date("d-m-Y H:i:s", filemtime($dirPath));

        // Check for the presence of description.txt
        $description = is_file($dirPath . DIRECTORY_SEPARATOR . 'description.txt') ? file_get_contents($dirPath . DIRECTORY_SEPARATOR . 'description.txt') : '';

        $output .= '<li><ul>
                        <li class="col1 file-directory"></li>
                        <li class="col"><a href="' . DIRECTORY_SEPARATOR . $dirPath . '">' . $dir . '</a></li>
                        <li class="col">--</li>
                        <li class="col">' . getRelativeTime($lastmod, 2) . '</li>
                        <li class="col">' . htmlspecialchars($description) . '</li>
                    </ul></li>';
    }
function getFileTypeDescription($extension) {
    $typeDescriptions = array(
        "php" => "PHP file",
        "inc" => "Include file",
        "js" => "JavaScript file",
        "html" => "HTML file",
        "htm" => "HTML file",
        "css" => "CSS file",
        "jpg" => "JPEG image",
        "jpeg" => "JPEG image",
        "gif" => "GIF image",
        "png" => "PNG image",
        "svg" => "SVG image",
        "ico" => "Icon file",
        "txt" => "Text file",
        "md" => "Markdown file",
        "csv" => "CSV file",
        "json" => "JSON file",
        "xml" => "XML file",
        "doc" => "Microsoft Word document",
        "docx" => "Microsoft Word document",
        "xls" => "Microsoft Excel spreadsheet",
        "xlsx" => "Microsoft Excel spreadsheet",
        "ppt" => "Microsoft PowerPoint presentation",
        "pptx" => "Microsoft PowerPoint presentation",
        "pdf" => "Adobe Acrobat file",
        "mp3" => "MP3 audio file",
        "ogg" => "OGG audio file",
        "wav" => "WAV audio file",
        "mp4" => "MP4 video file",
        "mkv" => "MKV video file",
        "webm" => "WebM video file"
        // Add more mappings as needed
    );

    // Default to "File" if no mapping is found
    return $typeDescriptions[$extension] ?? "File";
}

    foreach ($filesList as $file) {
        $filePath = $directory . DIRECTORY_SEPARATOR . $file;
        $filetype = getFileTypeClass($file);
        $lastmod = date("d-m-Y H:i:s", filemtime($filePath));

        // For files, display the file type as description
        $description = getFileTypeDescription(pathinfo($file, PATHINFO_EXTENSION));

        $output .= '<li><ul>
                        <li class="col1 ' . $filetype . '"></li>
                        <li class="col"><a href="' . DIRECTORY_SEPARATOR . $filePath . '">' . $file . '</a></li>
                        <li class="col">' . getFilesize($filePath) . '</li>
                        <li class="col">' . getRelativeTime($lastmod, 2) . '</li>
                        <li class="col">' . htmlspecialchars($description) . '</li>
                    </ul></li>';
    }

    $output .= '</ul>';
    echo $output;
}

function includeHeaderAndFooter() {
    $headerFile = 'header.inc';
    $footerFile = 'footer.inc';

    if (file_exists($headerFile)) {
        include($headerFile);
    } else {
        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Your Page Title</title>
            <link rel="stylesheet" href="path/to/your/bootstrap.css">
            <!-- Include Bootstrap CSS here -->
        </head>
        <body>';
    }

    echo '<div id="content">';

    listFiles(PROJECTS_DIR);

    echo '</div>';

    if (file_exists($footerFile)) {
        include($footerFile);
    } else {
        echo '</body>
        </html>';
    }
}

includeHeaderAndFooter();
?>
