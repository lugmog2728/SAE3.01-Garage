<?php

/**
 * Créer l'entête du tableaux des articles 
 */

function articleTitle()
{

    echo "<head><title>Afficher Article</title></head>";
    echo "<br>
    <table class='table table-striped'>
      <main>
        <thead class='table-dark'>
          <tr>
      <th scope='col' style='width:6%'>Code article</th>
      <th scope='col' style='width:6%'>Type d'article</th>
      <th scope='col' style='width:40%'>Libellé de l'article</th>
      <th scope='col' style='width:5%'>Prix unitaire actuel HT</th>
      <th scope='col' style='width:6%'>Actions</th>
    </tr>
    </thead>
    <tbody>";
}

/**
 * Créer l'entête du tableaux des clients 
 */
function clientTitle()
{
    echo "<head><title>Afficher Clients</title></head>";
    echo ("<br>
    <table class='table table-striped'>
      <main>
        <thead class='table-dark'>
          <tr>
            <th scope='col' style='width:6%'>Code client</th>
            <th scope='col' style='width:6%'>Nom</th>
            <th scope='col' style='width:5%'>Prénom</th>
            <th scope='col' style='width:6%'>Téléphone</th>
            <th scope='col' style='width:40%'>Email</th>
            <th scope='col' style='width:6%'>Actions</th>
          </tr>
        </thead>
        <tbody>");
}

/**
 * Créer l'entête du tableaux des modèles 
 */
function modeleTitle()
{
    echo "<head><title>Afficher Modèles & Marques</title></head>";
    echo ("<br>
    <table class='table table-striped'>
      <main>
        <thead class='table-dark'>
          <tr>
            <th scope='col' style='width:6%'>Numéro de modèle</th>
            <th scope='col' style='width:5%'>Modèle</th>
            <th scope='col' style='width:6%'>Marque</th>
            <th scope='col' style='width:6%'>Actions</th>
          </tr>
        </thead>
        <tbody>");
}

/**
 * Créer l'entête du tableaux des règlements
 */
function reglementTitle()
{
    echo "<head><title>Afficher Mode Règlement</title></head>";
    echo ("<br>
    <table class='table table-striped'>
      <main>
        <thead class='table-dark'>
          <tr>
            <th scope='col' style='width:6%'>Numéro de mode de règlement</th>
            <th scope='col' style='width:40%'>Libellé du mode de règlement</th>
            <th scope='col' style='width:6%'>Actions</th>
          </tr>
        </thead>
        <tbody>");
}

/**
 * Créer l'entête du tableaux des operateurs
 */
function operateurTitle()
{
    echo "<head><title>Afficher Opérateurs</title></head>";
    echo ("<br>
    <table class='table table-striped'>
      <main>
        <thead class='table-dark'>
          <tr>
            <th scope='col' style='width:6%'>ID opérateur</th>
            <th scope='col' style='width:6%'>Nom</th>
            <th scope='col' style='width:5%'>Prénom</th>
            <th scope='col' style='width:6%'>Actions</th>
          </tr>
        </thead>
        <tbody>");
}

/**
 * Créer l'entête du tableaux des véhicules 
 */
function vehiculeTitle()
{
    echo "<head><title>Afficher Véhicules</title></head>";
    echo ("<br>
    <table class='table table-striped'>
      <main>
        <thead class='table-dark'>
          <tr>
            <th scope='col' style='width:6%'>Numéro d'immatriculation</th>
            <th scope='col' style='width:6%'>Marque</th>
            <th scope='col' style='width:5%'>Modèle</th>
            <th scope='col' style='width:40%'>Nom du client</th>
            <th scope='col' style='width:6%'>Actions</th>
          </tr>
        </thead>
        <tbody>");
}

/**
 * Créer l'entête du tableaux des opérations
 */
function operationTitle()
{
    echo "<head><title>Afficher Opérations</title></head>";
    echo ("<br>
    <table class='table table-striped'>
      <main>
        <thead class='table-dark'>
          <tr>
            <th scope='col' style='width:6%'>Code opération</th>
            <th scope='col' style='width:6%'>Libellé de l'opération</th>
            <th scope='col' style='width:5%'>Durée de l'opération</th>
            <th scope='col' style='width:6%'>coût horaire</th>
            <th scope='col' style='width:6%'>Actions</th>
          </tr>
        </thead>
        <tbody>");
}
