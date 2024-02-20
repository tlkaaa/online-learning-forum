<?php namespace App\Models;

use CodeIgniter\Model;
use Imagick;
use ImagickPixel;

class Image_model extends Model {

    protected $allowedFields = ['filename', 'path'];

    public function scale($path, $filename) {
    
        $imagick = new Imagick($path.$filename);
        $imagick->scaleImage(200, 200, true);
        $imagick->writeImage($path.'scale_'.$filename);
        $imagick->clear();
        $imagick->destroy();
        return 'scale_'.$filename;
    }

    public function scale_thumbnail($path, $filename) {
    
        $imagick = new Imagick($path.$filename);
        $imagick->scaleImage(30, 30, true);
        $imagick->writeImage($path.'tn_'.$filename);
        $imagick->clear();
        $imagick->destroy();
        return 'tn_'.$filename;
    }



    public function upload($path) {
        $db = \Config\Database::connect();
        $builder = $db->table('user');

        $session = session();
        $username = $_SESSION['username'];

        $builder->where('username', $username);

        $data = [
            'profile_picture' => $path
        ];

        $builder->update($data);

        return true;

    }

    public function get_profile_picture($username) {
        $db = \Config\Database::connect();
        $builder = $db->table('user');

        $query = $builder->where('username', $username);
        $query = $builder->get();

        if ($query->getRowArray()) {
            return $query->getRow();
        }

        return null;

    }


}
