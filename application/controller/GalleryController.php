<?php

class GalleryController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Auth::checkAuthentication();
    }

        public function index()
    {
        $this->View->render('gallery/index', [
            'pictures' => GalleryModel::getPictures(
                Session::get('user_id')
            )
        ]);
    }
    
    public function upload()
    {
        $user_id = Session::get('user_id');

        $targetFolder = "../userpictures/" . $user_id . "/";

        if (!is_dir($targetFolder)) {
            mkdir($targetFolder, 0777, true);
        }

        $filename = basename($_FILES["picture"]["name"]);
        $targetFile = $targetFolder . $filename;

        move_uploaded_file($_FILES["picture"]["tmp_name"], $targetFile);
        GalleryModel::addPicture($user_id, $filename);
        Redirect::to("gallery/index");
    }
    
    public function get($picture_id)
    {
        $picture = GalleryModel::getPictureById(
            $picture_id,
            Session::get('user_id')
        );

        if (!$picture) {
            Redirect::to("gallery/index");
        }

        $file = "../userpictures/" . Session::get('user_id') . "/" . $picture->filename;

        if (!file_exists($file)) {
            Redirect::to("gallery/index");
        }

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($picture->filename) . '"');
        header('Content-Length: ' . filesize($file));

        readfile($file);
        exit;
    }
    public function share($picture_id)
    {
        GalleryModel::sharePicture(
            $picture_id,
            Session::get('user_id')
        );

        Redirect::to("gallery/index");
    }
    
    public function delete($picture_id)
    {
        $picture = GalleryModel::getPictureById(
            $picture_id,
            Session::get('user_id')
        );

        if ($picture) {
            $file = "../userpictures/" . Session::get('user_id') . "/" . $picture->filename;

            if (file_exists($file)) {
                unlink($file);
            }

            GalleryModel::deletePicture($picture_id, Session::get('user_id'));
        }

        Redirect::to("gallery/index");
    }
    
    public function show($picture_id)
    {
        $picture = GalleryModel::getPictureById(
            $picture_id,
            Session::get('user_id')
        );

        if (!$picture) {
            Redirect::to("gallery/index");
        }

        $file = "../userpictures/" . Session::get('user_id') . "/" . $picture->filename;

        if (!file_exists($file)) {
            Redirect::to("gallery/index");
        }

        header("Content-Type: image/jpeg");
        readfile($file);
        exit;
    }
}
