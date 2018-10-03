<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;
$app->get('/api/users', function (Request $request, Response $response) {
    $sql = "SELECT * FROM users";

    try{
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($sql);
        $users = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($users);
    }
    catch (PDOException $e){
        echo '{"error":{"text":'.$e->getMessage().'}';
    }
});


$app->get('/api/user/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $sql = "SELECT * FROM users WHERE id = $id";

    try{
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($sql);
        $user = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($user);
    }
    catch (PDOException $e){
        echo '{"error":{"text":'.$e->getMessage().'}';
    }
});


$app->post('/api/user/add', function (Request $request, Response $response) {
    

    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');

    $sql = "INSERT INTO users ("
                . "first_name,"
                . "last_name,"
                . "phone,"
                . "email,"
                . "address,"
                . "city,"
                . "state"
            . ")"
            . "VALUES"
            . "("
                . ":first_name,"
                . ":last_name,"
                . ":phone,"
                . ":email,"
                . ":address,"
                . ":city,"
                . ":state"
            . ")";

    try{
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':first_name',$first_name);
        $stmt->bindParam(':last_name',$last_name);
        $stmt->bindParam(':phone',$phone);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':address',$address);
        $stmt->bindParam(':city',$city);
        $stmt->bindParam(':state',$state);
        
        $stmt->execute();
        
        echo '{"notice":{"text":"user added"}';

    }    
    catch (PDOException $e){
        echo '{"error":{"text":'.$e->getMessage().'}';
    }
});

$app->put('/api/user/update/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');

    $sql = "UPDATE users SET 
                first_name = :first_name,
                last_name = :last_name,
                phone = :phone,
                email = :email,
                address = :address,
                city = :city,
                state = :state
            WHERE id = $id ";

    try{
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':first_name',$first_name);
        $stmt->bindParam(':last_name',$last_name);
        $stmt->bindParam(':phone',$phone);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':address',$address);
        $stmt->bindParam(':city',$city);
        $stmt->bindParam(':state',$state);
        
        $stmt->execute();
        
        echo '{"notice":{"text":"user updated"}';

    }    
    catch (PDOException $e){
        echo '{"error":{"text":'.$e->getMessage().'}';
    }
});


$app->delete('/api/user/delete/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $sql = "DELETE FROM users WHERE id = $id ";

    try{
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db= null;
        echo '{"notice":{"text":"user Deleted"}';

    }    
    catch (PDOException $e){
        echo '{"error":{"text":'.$e->getMessage().'}';
    }
});