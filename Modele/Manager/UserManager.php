<?php

namespace MiniChat\Manager;

require_once $_SERVER["DOCUMENT_ROOT"] . '/Classes/DB.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/Modele/Entity/User.php';
use MinichatProjet\Classes\DB;
use MinichatProjet\Entity\user;

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/checkIsset.php';

class userManager
{
    /**
     * Return a user based on id.
     * @param int $id
     * @return user
     */
    public function getUser(int $id): user
    {
        $request = DB::connectDB()->prepare("SELECT * FROM user INNER JOIN role ON user.role_fk = role.id WHERE user.id=:id");
        $request->bindValue(':id', $id);
        $request->execute();
        $user_data = $request->fetch();

        return new user($user_data['name'], $user_data['firstname'],
             $user_data['pseudo'], $user_data['email'], $user_data['password'], $user_data['role'], $user_data['activate']);
    }

    /**
     * Return a users list.
     * @return array
     */
    public function getUsers(): array
    {
        $users = [];
        $request = DB::connectDB()->prepare("SELECT * FROM user");
        $request->execute();
        $users_response = $request->fetchAll();

        if ($users_response) {
            foreach ($users_response as $data) {
                $users[] = new user($data['id'], $data['name'], $data['firstname'], $data['pseudo'], $data['email'],
                    $data['password'], $data['role_fk']);
            }
        }
        return $users;
    }

    /**
     *  add a new user.
     * @param $name
     * @param $firstname
     * @param $pseudo
     * @param $email
     * @param $password
     */

    public function addUser($name, $firstname, $pseudo, $email, $password) {
        $lenghtToken = 15;
        $token = "";
        for($i = 1; $i < $lenghtToken; $i++){
            $token .= mt_rand(0, 9);
        }

        $request = DB::connectDB()->prepare("INSERT INTO user (name, firstname, pseudo, email, password, role_fk, token, activate)
                                                         VALUES ( ?, ?, ?, ?, ?, 2, ?, 0)");
        $request->execute([$name, $firstname, $pseudo, $email, password_hash($password, PASSWORD_DEFAULT), $token]);
        $this->mail($email, $token);
        header('location: ../index.php');
    }

    function mail($email, $token) {
        $to = $_POST['email'];
        $sujet = 'Creepy Blog';
        $message = 'bienvenue sur le Creepy Blog !
                    <br>
                    Le lien d\'activation est : <a href="sam.up-to.fr/utils/validateRegistration.php?email='.$email.'&token='.$token.'">Lien</a>';
        $headers = "MIME-Version: 1.0"."\r\n";
        $message = wordwrap($message, 70,"\r\n");
        mail($to, $sujet, $message, $headers);
    }

}
