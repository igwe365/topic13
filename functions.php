<?php
    //find function no where clause
    function findAll($pdo, $table) {
    $stmt = $pdo->prepare('SELECT * FROM ' . $table );
    $stmt->execute();
    return $stmt->fetchAll();
    }

    // find function 
    function find($pdo, $table, $field, $value) {
        $stmt = $pdo->prepare('SELECT * FROM ' . $table . ' WHERE ' . $field . ' = :value');
        $values = [
        'value' => $value
        ];
        $stmt->execute($values);
        return $stmt->fetchAll();
    }

//Find a record from the person table where the id field is 123
$results = find($pdo, 'person', 'id', 123);
//If we only need one result, fetch the first from the list:
$person = $results[0];
echo $person['surname'];

//insert function
function insert($pdo, $table, $record) {
    $keys = array_keys($record);
    $values = implode(', ', $keys);
    $valuesWithColon = implode(', :', $keys);
    $query = 'INSERT INTO ' . $table . ' (' . $values . ') VALUES (:' . $valuesWithColon . ')';
    $stmt = $pdo->prepare($query);
    $stmt->execute($record);
}

//Update function
function update($pdo, $table, $record, $primaryKey) {
    $query = 'UPDATE ' . $table . ' SET ';

    $parameters = [];

    foreach ($record as $key => $value) {
    $parameters[] = $key . ' = :' .$key;
    }

    $query .= implode(', ', $parameters);
    $query .= ' WHERE ' . $primaryKey . ' = :primaryKey';
    $record['primaryKey'] = $record[$primaryKey];

    $stmt = $pdo->prepare($query);
    $stmt->execute($record);
}

//Delete function
function delete($pdo, $table, $field, $value) {
    $stmt = $pdo->prepare('DELETE FROM ' . $table . ' WHERE ' . $field . ' = :value');
    $criteria = [
    'value' => $value
    ];
    $stmt->execute($criteria);
}
?>