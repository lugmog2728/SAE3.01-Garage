<?php
/**
 * Classe abstraite pour l'accès aux données d'une base
 */
abstract class DAO {
    /**
     * Instance de PDO
     * @var PDO
     */
    const UNKNOWN_ID = -1; // Identifiant non déterminé

    /**
     * Instance de PDO
     */
    protected $pdo; // Objet pdo pour l'accès à la table

    /**
     * Constructeur
     * @param PDO $pdo Instance de PDO
     */
    public function __construct(PDO $connector) { $this->pdo = $connector; }

    /**
     *  Récupération d'un objet dont on donne l'identifiant
     * @param string|int|array $id Identifiant de l'objet
     */
    abstract public function getOne(string|int|array $id): object;

    /**
     * Récupération de tous les objets
     */
    abstract public function getAll(): array;

    /**
     * Insertion d'un objet dans la base
     * @param object $object Objet à insérer
     */
    abstract public function insert(object $obj): int;

    /**
     * Mise à jour d'un objet dans la base
     * @param object $object Objet à mettre à jour
     */
    abstract public function update(object $obj): int;

    /**
     * Suppression d'un objet dans la base
     * @param object $object Objet à supprimer
     */
    abstract public function delete(object $obj): int;
}
