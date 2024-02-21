<?php
// Répertoire du fichier autoload.php
spl_autoload_register(function ($className) {
    @include __DIR__ . "/" . strtr($className, "\\", "/") . ".php";
});
// Répertoire Classes du répertoire du fichier autoload.php
spl_autoload_register(function ($className) {
    @include __DIR__ . "/Classes/".strtr($className, "\\", "/").".php";
});
// Répertoire Classes du répertoire du fichier autoload.php
spl_autoload_register(function ($className) {
    @include __DIR__ . "/Classes/Objet/".strtr($className, "\\", "/").".php";
});
spl_autoload_register(function ($className) {
    @include __DIR__ . "/Classes/DAO/".strtr($className, "\\", "/").".php";
});
// Répertoire courant
spl_autoload_register(function ($className) {
    @include strtr($className, "\\", "/") . ".php";
});
// Répertoire Classes du répertoire courant
spl_autoload_register(function ($className) {
    @include "Classes/".strtr($className, "\\", "/").".php";
});
