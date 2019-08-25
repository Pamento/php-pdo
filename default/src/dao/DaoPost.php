<?php

namespace pdoblog\dao;
use pdoblog\entities\Post;
use pdoblog\dao\Connect;
class DaoPost {
	public function getAll($id):array {
		$tab = [];
		try {
			$query = Connect::getInstance()->prepare('SELECT articles.* FROM `articles` INNER JOIN `User` ON User.id = articles.id_user WHERE User.id = :id');
			$query->bindValue(':id',$id, \PDO::PARAM_INT);
			$query->execute();
			while($row = $query->fetch()) {
				$post = new Post($row['title'],
										$row['article'],
										$row['id_user'],
										$row['articles.id']);;
				$tab[] = $post;
			}
		}catch(\PDOException $e) {
			echo $e;
		}
		return $tab;
	}
	public function getByUser(string $email) {
		$tab = [];
		try {
			$query = Connect::getInstance()->prepare('SELECT articles.* FROM `articles` INNER JOIN `User` ON User.id = articles.id_user WHERE User.email = :email');
			$query->bindValue(':email', $email, \PDO::PARAM_STR);
			$query->execute();
			while($row = $query->fetch()) {
				
				$post = new Post($row['title'],
										$row['article'],
										$row['id_user'],
										$row['id']);
				$tab[] = $post;
			}
		}catch(\PDOException $e) {
			echo $e;
		}
		return $tab;
	}
	public function getById(int $id) {
		try {
			$query = Connect::getInstance()->prepare('SELECT * FROM articles WHERE id=:id');
			$query->bindValue(':id', $id, \PDO::PARAM_INT);
			$query->execute();
			if($row = $query->fetch()) {
				$post = new Post($row['title'],
										$row['article'],
										$row['id_user'],
										$row['id']);
				return $post;
			}
		}catch(\PDOException $e) {
			echo $e;
		}
		return null;
	}
	public function add(Post $post) {
		try {
			$query = Connect::getInstance()->prepare('INSERT INTO articles (title,article) VALUES (:title, :article)');
			$query->bindValue(':title',$post->getTitle(),\PDO::PARAM_STR);
			$query->bindValue(':article',$post->getArticle(),\PDO::PARAM_STR);

			$query->execute();
			$post->setId(Connect::getInstance()->lastInsertId());
		}catch(\PDOException $e) {
			echo $e;
		}
	}
	public function update(Post $post) {
		try {
			$query = Connect::getInstance()->prepare('UPDATE articles SET title = :title, article = :article WHERE id = :id');
			$query->bindValue(':title',$post->getTitle(),\PDO::PARAM_STR);
			$query->bindValue(':article',$post->getArticle(),\PDO::PARAM_STR);
			$query->bindValue(':id',$post->getId(),\PDO::PARAM_INT);

			$query->execute();
		}catch(\PDOException $e) {
			echo $e;
		}
	}
	public function delete(int $id) {
		try {
			$query = Connect::getInstance()->prepare('DELETE FROM articles WHERE id = :id');
			$query->bindValue(':id',$id,\PDO::PARAM_INT);

			$query->execute();
		}catch(\PDOException $e) {
			echo $e;
		}
	}
}