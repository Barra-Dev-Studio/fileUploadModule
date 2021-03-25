<?php

namespace App\Services;

use App\Models\Upload;
use Illuminate\Http\Request;

class UploadService
{
    public function store(Request $request)
    {
        $foldername = uniqid() . '-' . now()->timestamp;
        $filename = $foldername . '.' . $request->file->extension();
        $request->file->move(public_path('product-images-temp/' . $foldername), $filename);

        $this->_insertToDatabase($foldername, $filename);

        return $foldername;
    }

    public function revert($id)
    {
        $this->_deleteFromDatabase($id);
        return $this->_deleteFolder($id);
    }

    private function _getFromDatabase($id)
    {
        return Upload::where('foldername', $id)->first();
    }

    private function _insertToDatabase($foldername, $filename)
    {
        return Upload::create(
            [
                'foldername' => $foldername,
                'filename' => $filename
            ]
        );
    }

    private function _deleteFromDatabase($id)
    {
        return Upload::where('foldername', $id)->delete();
    }

    private function _deleteFolder($foldername)
    {
        $foldername = public_path('product-images-temp/' . $foldername);

        foreach (scandir($foldername) as $file) {
            if ('.' === $file || '..' === $file) continue;
            if (is_dir("$foldername/$file")) $this->_deleteFolder("$foldername/$file");
            else unlink("$foldername/$file");
        }
        rmdir($foldername);
    }
}
