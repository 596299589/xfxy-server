<?php
function upFile(){
    if(empty($_FILES)){
        $status = 1;
        $info = '没有文件上传';
    }
    if($_FILES['file']['error'] === 0 || $_FILES['file']['error'] === '0' ){
        //文件上传成功
        $tmp = pathinfo($_FILES['file']['name']);
        $new_fname = $tmp['filename'].'.'.$tmp['extension'];
        if(!move_uploaded_file($_FILES['file']['tmp_name'], './'.$new_fname)){
            $status = 1;
            $info = '上传（移动）失败';
        }else{
            $status = 0;
            $info = '上传成功';
        }
    } else {
        //文件上传失败
        $info = '文件上传失败';
        switch($_FILES['file']['error']){
            case 1:
                $info = '上传文件超过php.ini中upload_max_filesize配置参数';
                break;
            case 2:
                $info = '上传文件超过表单MAX_FILE_SIZE选项指定的值';
                break;
            case 3:
                $info = '文件只有部份被上传';
                break;
            case 4:
                $info = '没有文件被上传';
                break;
            case 5:
                $info = '上传文件大小为0';
                break;
        }
        $status = 1;
    }
    return array('status'=>$status, 'info'=>$info);
}

print_r(upFile());