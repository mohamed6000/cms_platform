<?php

require_once("utils.php");

class Account {
    public function __construct($database) {
        $this->conn = $database->get_connection();
    }

    public function create($first_name, $last_name, $user_name, $email, $password, $phone, $address, $gender, $birth_date, $role, $state, $email_sender) {
        if (isset($this->conn)) {
            $first_name = htmlspecialchars(strip_tags($first_name));
            $last_name = htmlspecialchars(strip_tags($last_name));
            $user_name = htmlspecialchars(strip_tags($user_name));
            $email = htmlspecialchars(strip_tags($email));
            $password = htmlspecialchars(strip_tags($password));
            $phone = htmlspecialchars(strip_tags($phone));
            $address = htmlspecialchars(strip_tags($address));
            $gender = htmlspecialchars(strip_tags($gender));
            if ($birth_date) $birth_date = htmlspecialchars(strip_tags($birth_date));
            $state = htmlspecialchars(strip_tags($state));
            $role = htmlspecialchars(strip_tags($role));

            $hashed_password = password_hash($password, PASSWORD_DEFAULT); // paired with password_verify

            try {
                $sql = "select `user_name` from account where `user_name` = :param1 limit 1";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["param1" => $user_name]);
                if ($result) {
                    $existing_account = $stmt->fetch();
                    if ($existing_account) {
                        return "Ce compte déja existe";
                    } else {
                        if ($state == "activated") {
                            Utils::send_mail($email_sender, $email, "Votre compte a été créé et approuvé", "Un administrateur a créé et approuvé votre compte technicien en utilisant cette adresse email, contactez-le pour obtenir vos informations de connexion.");
                        }

                        $sql = "insert into account (first_name, last_name,
                                                     user_name, email, 
                                                     password, phone,
                                                     address, gender,
                                                     birth_date, state, 
                                                     role) values 
                                                    ('$first_name', '$last_name', 
                                                     '$user_name', '$email', 
                                                     '$hashed_password', '$phone',
                                                     '$address', '$gender',
                                                     '$birth_date', '$state', 
                                                     '$role')";
                        $this->conn->exec($sql);
                        
                        return true;
                    }
                }
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return "Problème interne, réessayez plus tard ou contactez l'assistance.";
    }

    private function auth_account($account_details) {
        // Utils::begin_session();
        session_start();

        $_SESSION["account_id"]    = $account_details["id"];
        $_SESSION["account_email"] = $account_details["email"];
        $_SESSION["account_role"]  = $account_details["role"];
    }

    private function auth_admin($account_details) {
        // Utils::begin_session();
        session_start();

        $_SESSION["admin_id"] = $account_details["id"];
    }

    private function auth_user($account_details) {
        // Utils::begin_session();
        session_start();
        
        $_SESSION["account_id"] = $account_details["id"];
        $_SESSION["account_role"] = $account_details["role"];
    }

    // login returns true if succeeds or error message else
    public function login_as_admin($user_name, $password) {
        if (isset($this->conn)) {
            $user_name = htmlspecialchars(strip_tags($user_name));
            $password = htmlspecialchars(strip_tags($password));

            $sql = "select * from account where user_name = :username";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["username" => $user_name]);
            
            $account = $stmt->fetch();
            if ($account) {
                if (password_verify($password, $account["password"])) {
                    if ($account["role"] === "admin") {
                        $this->auth_admin($account);
                        return true;
                    } else {
                        return "Vous n'êtes pas autorisé à accéder à ce panneau";
                    }
                } else {
                    return "Mauvaises informations d'identification";
                }
            } else {
                return "Le compte n'existe pas.";
            }
        }

        return "Problème interne, réessayez plus tard ou contactez l'assistance.";
    }

    public function login_user($user_name, $password) {
        if (isset($this->conn)) {
            $user_name = htmlspecialchars(strip_tags($user_name));
            $password = htmlspecialchars(strip_tags($password));

            $sql = "select id, user_name, password, role, state from account where user_name = :username";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["username" => $user_name]);
            
            $account = $stmt->fetch();
            if ($account) {
                if (password_verify($password, $account["password"])) {
                    if ($account["state"] == "pending") {
                        return "Vous ne pouvez pas vous connecter, attendez l'approbation de votre compte";
                    } else if ($account["state"] == "restricted") {
                        return "Erreur : ce compte a été restreint";
                    } else {
                        $this->auth_user($account);
                        return true;
                    }
                } else {
                    return "Mauvaises informations d'identification";
                }
            } else {
                return "Le compte n'existe pas.";
            }
        }

        return "Problème interne, réessayez plus tard ou contactez l'assistance.";
    }

    public function admin_logout() {
        unset($_SESSION['admin_id']);
        //session_unset();
        //session_destroy();
    }

    public function user_logout() {
        unset($_SESSION['account_id']);
        unset($_SESSION['account_role']);
        // session_unset();
        // session_destroy();
    }

    public function get_single($id) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "select * from `account` where id = :id limit 1";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["id" => $id]);
                if ($result) {
                    $account = $stmt->fetch();                    
                    return $account;
                } else {
                    return false;
                }
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function update_by_id($first_name, $last_name, $email, $user_name, $phone, $address, $gender, $birth_date, $id) {
        if (isset($this->conn)) {
            $first_name = htmlspecialchars(strip_tags($first_name));
            $last_name = htmlspecialchars(strip_tags($last_name));
            $email = htmlspecialchars(strip_tags($email));
            $user_name = htmlspecialchars(strip_tags($user_name));
            $phone = htmlspecialchars(strip_tags($phone));
            $address = htmlspecialchars(strip_tags($address));
            $gender = htmlspecialchars(strip_tags($gender));
            $birth_date = htmlspecialchars(strip_tags($birth_date));
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "update `account` set `first_name` = :first_name, `last_name` = :last_name, `email` = :email, 
                                             `user_name` = :user_name, `phone` = :phone, `address` = :address, 
                                             `gender` = :gender, `birth_date` = :birth_date where `id` = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "email" => $email,
                    "user_name" => $user_name,
                    "phone" => $phone,
                    "address" => $address,
                    "gender" => $gender,
                    "birth_date" => $birth_date,
                    "id" => $id,
                ]);
                return true;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function update_with_state_new_password_by_id($first_name, $last_name, $email, $user_name, $phone, $address, $gender, $birth_date, $password, $state, $id) {
        if (isset($this->conn)) {
            $first_name = htmlspecialchars(strip_tags($first_name));
            $last_name = htmlspecialchars(strip_tags($last_name));
            $email = htmlspecialchars(strip_tags($email));
            $user_name = htmlspecialchars(strip_tags($user_name));
            $phone = htmlspecialchars(strip_tags($phone));
            $address = htmlspecialchars(strip_tags($address));
            $gender = htmlspecialchars(strip_tags($gender));
            $birth_date = htmlspecialchars(strip_tags($birth_date));
            $state = htmlspecialchars(strip_tags($state));
            $password = htmlspecialchars(strip_tags($password));
            $id = htmlspecialchars(strip_tags($id));

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            try {
                $sql = "update `account` set `first_name` = :first_name, `last_name` = :last_name, `email` = :email, 
                                             `user_name` = :user_name, `phone` = :phone, `address` = :address, 
                                             `gender` = :gender, `birth_date` = :birth_date,
                                             `password` = :password, `state` = :state where `id` = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "email" => $email,
                    "user_name" => $user_name,
                    "phone" => $phone,
                    "address" => $address,
                    "gender" => $gender,
                    "birth_date" => $birth_date,
                    "state" => $state,
                    "password" => $hashed_password,
                    "id" => $id,
                ]);
                return true;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function deactivate($id) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "update `account` set `state` = 'deactivated' where `id` = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute(["id" => $id]);
                return true;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function activate($id) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "update `account` set `state` = 'activated' where `id` = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute(["id" => $id]);
                return true;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function update_password_by_id($old_password, $new_password, $id) {
        if (isset($this->conn)) {
            $old_password = htmlspecialchars(strip_tags($old_password));
            $new_password = htmlspecialchars(strip_tags($new_password));
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "select `password` from `account` where id = :id limit 1";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["id" => $id]);
                if ($result) {
                    $account = $stmt->fetch();
                    if (password_verify($old_password, $account["password"])) {
                        if ($old_password == $new_password) {
                            return "You are using the same password";
                        } else {
                            // let's update
                            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                            $sql = "update `account` set `password` = :password where `id` = :id";
                            $stmt = $this->conn->prepare($sql);
                            $stmt->execute(["password" => $hashed_password, "id" => $id]);
                            return true;
                        }
                    } else {
                        return "Mot de passe incorrecte";
                    }
                }
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return "Problème interne, réessayez plus tard ou contactez l'assistance.";
    }

    public function get_technicians($page = 1, $per_page = 10) {
        $page = htmlspecialchars(strip_tags($page));
        $per_page = htmlspecialchars(strip_tags($per_page));

        $page = $page - 1;

        if (isset($this->conn)) {
            try {
                $sql = "select `id`, `first_name`, `last_name`, `user_name`, `email`, `role`, `state` from `account` where `role` = 'technician' limit $page, $per_page";
                $stmt = $this->conn->query($sql);
                $technicians = $stmt->fetchAll();

                return $technicians;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_all_technicians() {
        if (isset($this->conn)) {
            try {
                $sql = "select `id`, `first_name`, `last_name`, `user_name`, `email`, `role`, `state` from `account` where `role` = 'technician'";
                $stmt = $this->conn->query($sql);
                $technicians = $stmt->fetchAll();

                return $technicians;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_clients($page = 1, $per_page = 10) {
        $page = htmlspecialchars(strip_tags($page));
        $per_page = htmlspecialchars(strip_tags($per_page));

        $page = $page - 1;

        if (isset($this->conn)) {
            try {
                $sql = "select `id`, `first_name`, `last_name`, `user_name`, `email`, `role`, `state` from `account` where `role` = 'client' limit $page, $per_page";
                $stmt = $this->conn->query($sql);
                $clients = $stmt->fetchAll();

                return $clients;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function restrict($id) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "update `account` set `state` = 'restricted' where `id` = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute(["id" => $id]);
                return true;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function update_state($state, $id) {
        if (isset($this->conn)) {
            $state = htmlspecialchars(strip_tags($state));
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "update `account` set `state` = :state where `id` = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute(["state" => $state, "id" => $id]);
                return true;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function update_role($role, $id) {
        if (isset($this->conn)) {
            $role = htmlspecialchars(strip_tags($role));
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "update `account` set `role` = :role where `id` = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute(["role" => $role, "id" => $id]);
                return true;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_last_inserted_id() {
        if (isset($this->conn)) {
            
            return $this->conn->lastInsertId();
        }

        return 0;
    }

    public function get_pending_clients_count() {
        if (isset($this->conn)) {
            try {
                $sql = "select count(id) as total from `account` where `role` = 'client' and `state` = 'pending'";
                $stmt = $this->conn->query($sql);
                $result = $stmt->fetch();

                return $result["total"];
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return 0;
    }

    public function search_users_by_name_criteria($name) {
        if (isset($this->conn)) {
            $name = htmlspecialchars(strip_tags($name));

            try {
                $sql = "select * from `account` where first_name like '%". $name ."%' or last_name like '%". $name ."%' or user_name like '%". $name ."%'";
                $stmt = $this->conn->query($sql);
                $result = $stmt->fetchAll();

                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return 0;
    }

    public function permanently_delete($id) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "delete from `account` where `id` = :id";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["id" => $id]);
                return $result;
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }

    public function get_username_by_id($id) {
        if (isset($this->conn)) {
            $id = htmlspecialchars(strip_tags($id));

            try {
                $sql = "select `user_name` from `account` where id = :id limit 1";
                $stmt = $this->conn->prepare($sql);
                $result = $stmt->execute(["id" => $id]);
                if ($result) {
                    $account = $stmt->fetch();
                    if ($account) {
                        return $account["user_name"];
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }  catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return false;
    }
}

?>