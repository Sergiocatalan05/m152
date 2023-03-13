<?php


require_once("database.php");



function lireId()
{
    $sql = "SELECT idPost 
    FROM post
    ORDER BY idPost DESC
    LIMIT 1";
    $param = [];
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
function ajouterUneImage($type, $nom, $id)
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

function ajouterEtPostImages($comm, $type, $nom, $id, $postDejaCree)
{
    try {
        $db = db();
        $db->beginTransaction();
        if (!$postDejaCree) {

            $sql = "INSERT INTO post(commentaire)
                      VALUES (?)";
            $param = [
                $comm
            ];
            dbRun($sql, $param);
        }
        $sql = "INSERT INTO media(TypeMedia, nomFichierMedia,idPost)
                VALUES (?,?,?)";
        $param = [
            $type,
            $nom,
            $id
        ];
        dbRun($sql, $param);
        $db->commit();
        return true;
    } catch (Exception $e) {
        $db->rollBack();
        return false;
    }
}
function supprimerEtPostImages($id, $media, $nom = "")
{

    try {
        $db = db();
        $db->beginTransaction();
        if ($media != 0) {

            $sql = "DELETE FROM media WHERE idPost=?";
            $param = [
                $id
            ];
            unlink("./upload/" . $nom);
            dbRun($sql, $param);
        }
        $sql = "DELETE FROM post WHERE idPost=?";
        $param = [
            $id
        ];

        dbRun($sql, $param);
        $db->commit();
        return true;
    } catch (Exception $e) {
        $db->rollBack();
        return false;
    }
}


function afficherTousLesPosts()
{

    $sql = "SELECT * from post";
    $param = [];
    $statement = dbRun($sql, $param);
    return $statement->fetchAll(PDO::FETCH_OBJ);
}

function recupereUnPost($id)
{
    $sql = "SELECT * from post WHERE idPost=?";
    $param = [$id];
    $statement = dbRun($sql, $param);
    return $statement->fetch(PDO::FETCH_OBJ);
}

function afficherLesImagesParId($idPost)
{
    $sql = "SELECT * from media where idPost in (SELECT idPost from post where idPost = ?)";
    $param = [
        $idPost,
    ];
    $statement = dbRun($sql, $param);
    return $statement->fetchAll(PDO::FETCH_OBJ);
}
function modification($files, $media, $comm, $id)
{
    try {
        $db = db();
        $db->beginTransaction();

        $sql = "UPDATE post SET commentaire = ? WHERE idPost=?";
        $param = [
            $comm,
            $id
        ];

        dbRun($sql, $param);
        if ($files["name"][0] != null) {
            foreach ($media as $m) {
                unlink("./upload/" . $m->nomFichierMedia);
            }
            $sql = "DELETE FROM media WHERE idPost=?";
            $param = [
                $id
            ];

            dbRun($sql, $param);
            foreach($files['name'] as $key => $value) {
                $ext = explode(".",  $files['name'][$key])[1];
                $file_name = uniqid(explode(".",  $files['name'][$key])[0]);
                $sql = "INSERT INTO media(TypeMedia, nomFichierMedia,idPost)
                    VALUES (?,?,?)";
                $param = [
                    $files["type"][$key],
                    $file_name . "." . $ext,
                    $id
                ];
                if(!move_uploaded_file($files['tmp_name'][$key], "./upload/" .  $file_name . "." . $ext)){
                        throw new Exception("Le fichier n'a pas été trouvé", 1);
                        
                }            
                dbRun($sql, $param); 
            }
            
        }
        $db->commit();
        return true;
    } catch (Exception $e) {
        $db->rollBack();
        return false;
    }
}
