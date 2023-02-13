<?php


require_once("database.php");



function lireId()
{
    $sql = "SELECT idPost 
    FROM post
    ORDER BY idPost DESC
    LIMIT 1";
    $param = [      
    ];
    $statement = dbRun($sql, $param);
    return $statement->fetch(PDO::FETCH_OBJ);
}

function ajouterUnePublication($nom)
{

    $sql = "INSERT INTO post(commentaire)
            VALUES (?)";
    $param = [
        $nom,
    ];
    $statement = dbRun($sql, $param);
    return $statement;
}
function ajouterUneImage($type,$nom,$id)
{
    $sql = "INSERT INTO media(TypeMedia, nomFichierMedia,idPost)
            VALUES (?,?,?)";
    $param = [
        $type,
        $nom,
        $id
    ];
    $statement = dbRun($sql, $param);
    return $statement;
}






