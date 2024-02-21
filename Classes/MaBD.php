<?php
/**
 * Classe pour l'accès à la table produit
 */
class MaBD {
   /**
    * Instance de la classe PDO
    */
   static private $pdo = null; // Le singleton

   /**
    * Constructeur, crée l'instance de PDO qui sera sollicitée
    */
   static function getInstance(): ?PDO {
      if (self::$pdo == null) {
         $dsn = "pgsql:host=gigondas;dbname=mathona";
         self::$pdo = new PDO($dsn, "mathona", "SuperLicornedu26");
         self::$pdo->query("SET search_path TO rdvgarage,public;");
      }
      return self::$pdo;
   }
}

