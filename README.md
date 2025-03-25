# File Listing Utility

## Overview

This PHP project provides a dynamic file listing utility that scans a specified directory (default: `projects`) and displays a formatted list of directories and files. It includes features such as displaying file sizes, last modified times in a human-readable relative format, and file type descriptions based on file extensions.

## Features

- **Dynamic File Listing:**  
  Scans the defined directory and categorizes items as files or directories.

- **File Type Classification:**  
  Utilizes file extensions to assign specific CSS classes and descriptions to files (e.g., PHP, JavaScript, images).

- **Human-Readable Timestamps:**  
  Uses a custom function (`getRelativeTime()`) to display modification dates as relative time (e.g., "2 days ago").

- **File Size Formatting:**  
  Automatically calculates and formats file sizes in appropriate units (B, KB, MB, etc.).

- **Modular & Secure:**  
  Code is organized into clear, reusable functions with proper output sanitization to help prevent XSS vulnerabilities.

## Installation

1. **Requirements:**
   - PHP 7.0 or higher
   - A web server (e.g., Apache, Nginx)
   
2. **Setup:**
   - Place the main PHP file along with any additional header (`header.inc`) or footer (`footer.inc`) files in your project directory.
   - Create a directory named `projects` in the root folder. This directory will contain your files and experiments.

3. **Configuration:**
   - Modify the `PROJECTS_DIR` constant in the PHP file if you wish to change the directory being scanned.

## Usage

1. **Deploy the PHP Files:**  
   Upload the PHP files to your server.

2. **Access the Utility:**  
   Open the relevant URL in your browser to view the dynamically generated file list.

3. **Browse Files:**  
   The tool will display a list of directories and files with details such as:
   - File Name (with clickable links)
   - File Size
   - Last Modified (displayed as relative time)
   - Description (file type or content from a `description.txt` in directories)

## Customization

- **Styling:**  
  Customize the CSS classes (e.g., `file-php`, `file-image`) to modify the appearance of different file types.

- **Function Adjustments:**  
  Modify the `getRelativeTime()`, `getFileTypeClass()`, and `getFileTypeDescription()` functions to adapt the functionality or add support for additional file types.

## Contributing

Contributions to improve functionality or code quality are welcome. Please submit pull requests with detailed descriptions of your changes.

## License

This project is provided "as-is" without any warranties. Use and modify the code according to your requirements.
