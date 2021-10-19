<?php 

namespace app\controller;

use app\models\Users;

class UserController {

    public function create($data = null) {
        $user = new Users;

        $user->action('insert')->values($data)->process();
    }

    public function read($data = null) {
        $user = new Users;

        return $user->action('select')->selector()->process();
    }

    public function update($data, $id) {
        $user = new Users;

        $user->action('update')->valuesWithColumn($data)->where('id', '=', $id)->process();

        redirect('app.php');
    }

    public function delete($id) {
        $user = new Users;
        
        $user->action('delete')->where('id', '=', $id)->process();
    }
}

?>