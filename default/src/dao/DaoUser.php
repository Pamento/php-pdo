<?php

namespace pdoblog\dao;
use pdoblog\entities\User;
use pdoblog\dao\Connect;
class DaoUser {
    public function getAll():array {
        $tab = [];
        try {
            $query = Connect::getInstance()->prepare('SELECT * FROM User');
            $query->execute();
            while($row = $query->fetch()) {
                $user = new User($row['name'],
                            $row['surname'],
                            $row['username'],
														$row['email'],
														'',
                            $row['id']);
                $tab[] = $user;
            }
        }catch(\PDOException $e) {
            echo $e;
        }
        return $tab;
    }
    public function getById(int $id) {
        try {
            $query = Connect::getInstance()->prepare('SELECT * FROM User WHERE id=:id');
            $query->bindValue(':id', $id, \PDO::PARAM_INT);
            $query->execute();
            if($row = $query->fetch()) {
                $user = new User($row['name'],
                            $row['surname'],
                            $row['username'],
														$row['email'],
														$row['password'],
                            $row['id']);
                return $user;
            }
        }catch(\PDOException $e) {
            echo $e;
        }
        return null;
		}
		public function getByLogin(string $email,string $password){
			try {
				$query = Connect::getInstance()->prepare('SELECT * FROM User WHERE email = :email AND password = :password');
				$query->bindValue(':email',$email,\PDO::PARAM_STR);
				$query->bindValue(':password',$password,\PDO::PARAM_STR);
				$query->execute();
				if($row = $query->fetch()) {
					$user = new User($row['name'],
											$row['surname'],
											$row['username'],
											$row['email'],
											$row['password'],
											$row['id']);
					return $user;
				}
			}catch(\PDOException $e) {
				echo $e;
			}
			return null;
		}
    public function add(User $user) {
        try {
            $query = Connect::getInstance()->prepare('INSERT INTO User (name,surname,username,email,password) VALUES (:name, :surname, :username, :email, :password)');
            $query->bindValue(':name',$user->getName(),\PDO::PARAM_STR);
            $query->bindValue(':surname',$user->getSurname(),\PDO::PARAM_STR);
            $query->bindValue(':username',$user->getUsername(),\PDO::PARAM_STR);
            $query->bindValue(':email',$user->getEmail(),\PDO::PARAM_STR);
            $query->bindValue(':password',$user->getPassword(),\PDO::PARAM_STR);

            $query->execute();
            $user->setId(Connect::getInstance()->lastInsertId());
        }catch(\PDOException $e) {
            echo $e;
        }
    }
    public function update(User $user) {
        try {
            $query = Connect::getInstance()->prepare('UPDATE User SET name = :name, surname = :surname, username = :username WHERE id = :id');
            $query->bindValue(':name',$user->getName(),\PDO::PARAM_STR);
            $query->bindValue(':surname',$user->getSurname(),\PDO::PARAM_STR);
            $query->bindValue(':username',$user->getUsername(),\PDO::PARAM_STR);
            $query->bindValue(':email',$user->getEmail(),\PDO::PARAM_STR);
            $query->bindValue(':id',$user->getId(),\PDO::PARAM_INT);

            $query->execute();
        }catch(\PDOException $e) {
            echo $e;
        }
    }
    public function delete(int $id) {
        try {
            $query = Connect::getInstance()->prepare('DELETE FROM User WHERE id = :id');
            $query->bindValue(':id',$id,\PDO::PARAM_INT);

            $query->execute();
        }catch(\PDOException $e) {
            echo $e;
        }
    }
}