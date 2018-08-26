<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadRepository
{
    public function upload(Request $request, $filetype = 'designer')
    {
        $filename = $request->input('img', '');
        
        if ($request->isMethod('post') || $request->isMethod('put'))
        {
            $file = $request->file('upload_file');
            if (!empty($file))
            {
                // 文件是否上传成功
                if ($file->isValid()) {
                    // 获取文件相关信息
                    $originalName   = $file->getClientOriginalName(); // 文件原名
                    $ext            = $file->getClientOriginalExtension(); // 扩展名
                    $realPath       = $file->getRealPath(); //临时文件的绝对路径
                    //$type           = $file->getClientMimeType(); // image/jpeg
                    
                    // 上传文件
                    $filename = md5_file($file->getPathName());
                    $dirPrefix = substr($filename, 0, 2) . '/' . substr($filename, 2, 2) . '/';
                    $filename = $dirPrefix . $filename . '.' . $ext;
                    
                    $bool = Storage::disk('uploads')->put($filetype . '/' . $filename, file_get_contents($realPath));
                    if ($bool) {
                        $filename = '/exhibition/public/uploads/' . $filetype . '/' . $filename;
                    }
                }
            }
        }
        
        return $filename;
    }
}