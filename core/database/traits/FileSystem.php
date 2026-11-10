<?php

namespace core\database\traits;

trait FileSystem
{
    private function normalizeFiles($files)
    {
        if (!is_array($files['tmp_name'])) {
            foreach ($files as $key => $value) {
                $files[$key] = [$value];
            }
        }

        return $files;
    }

    public function saveFile($files, $path)
    {
        $files = $this->normalizeFiles($files);

        $root = dirname(__DIR__, 3);
        $savePath = $root . "/storage/upload/" . $path;

        if (!is_dir($savePath)) {
            mkdir($savePath, recursive: true);
        }

        $savedFiles = [];

        foreach ($files['tmp_name'] as $index => $tmpName) {
            $name = $files['name'][$index];

            if (move_uploaded_file($tmpName, $savePath . '/' . $name)) {
                $savedFiles[] = $path . '/' . $name;
            }
        }

        return $savedFiles;
    }

public function removeFile($path)
{
    $root = dirname(__DIR__, 3);
    $localPath = $root . "/storage/upload/" . $path;

    if (file_exists($localPath)) {
        unlink($localPath);
    }
}

    public function replaceFile($files, $path)
    {
        $files = $this->normalizeFiles($files);

        $root = dirname(__DIR__, 3);
        $savePath = $root . "/storage/upload/" . $path;

        if (!is_dir($savePath)) {
            mkdir($savePath, recursive: true);
        }

        foreach ($files['tmp_name'] as $index => $tmpName) {
            $name = $files['name'][$index];
            $destination = $savePath . '/' . $name;

            if (is_file($destination)) {
                unlink($destination);
            }

            move_uploaded_file($tmpName, $destination);
        }
    }

    public function getFilePath($path, $name)
    {
        $root = dirname(__DIR__, 3);

        return $root . "/storage/upload/" . $path . "/" . $name;
    }
}
