<?php

require_once '../../loader.php';

$testFunctions = new StudentDAO();


function TestGetAllStudent() {
    $testFunctions = new StudentDAO();
    $AllStudents = $testFunctions->GetAllStudents();
    return $AllStudents;
}

function TestGetOneStudents() {
    $testFunctions = new StudentDAO();
    $getOneStudents = $testFunctions->GetStudent(1);
    return $getOneStudents;
}


function TestAddStudent() {
    $name = "Adnan";
    $email = "adnan@gmail.com";
    $date = date('Y-m-d H:i:s');
    $Student = new Student(0, $name, $email, $date);
    $testFunctions = new StudentDAO();
    $testFunctions->AddStudent($Student);
}

function TestUpdateStudent() {
    $id = 3;
    $name = "AdnanO";
    $email = "adnan@gmail.com";
    $date = date('Y-m-d H:i:s');
    $Student = new Student($id, $name, $email, $date);
    $testFunctions = new StudentDAO();
    $testFunctions->AddStudent($Student);
}

function TestDeleteStudents($id) {
    $testFunctions = new StudentDAO();
    $testFunctions->DeleteStudent($id);
}

function TestCheackIdExists($id) {
    $testFunctions = new StudentDAO();
    $checkId =  $testFunctions->IsIdExists($id);
    print_r($checkId);

}
$id = 1;
TestCheackIdExists($id);
function TestCheackIsEmailExists($email, $id) {
    $testFunctions = new StudentDAO();
    $checkEmail =  $testFunctions->IsEmailExists($email, $id);
    print_r($checkEmail);

}
$email = "adnan@gmail.com";
TestCheackIsEmailExists($email, 0);
?>