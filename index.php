<?php
echo 'here Index file';
echo 'Another Echo';
echo 'echo 3';
/*
require_once('models/DatabaseInterface.php');
require_once('models/DatabaseMysqli.php');
//require_once('models/DatabaseAdapter.php');
require_once('models/MysqliQueryBuilder.php');
require_once('models/Model.php');
require_once('models/Employee.php');
require_once('models/Department.php');
require_once('models/EmployeeMapper.php');
require_once('models/DepartmentMapper.php');

//$database = new DatabaseMysqli();
$employeeMapper = new EmployeeMapper();
$employeeMapper->with(['DepartmentMapper']);
$employeeMapper->fields([EmployeeMapper::ID, EmployeeMapper::FIRST_NAME, DepartmentMapper::NAME]);
$employees = $employeeMapper->findAll();
echo '<pre>';
//print_r($employees);
foreach ($employees as $key => $employee) {
    echo $employee->getId() . ' -- ' . $employee->getFirstName() . ' -- ' . $employee->department()->getName();
    echo '<br>';
}

//$database = new DatabaseMysqli();
$departmentMapper = new DepartmentMapper();
$departmentMapper->with(['EmployeeMapper']);
$departmentMapper->group(DepartmentMapper::NAME);
$departmentMapper->fields([DepartmentMapper::NAME, EmployeeMapper::EMPLOYEES_COUNT]);
$departments = $departmentMapper->findAll();
echo '<pre>';
//print_r($departments);
foreach ($departments as $key => $department) {
    echo $department->getName() . ' -- ' . $department->employee()->getCount();
    echo '<br>';
}

//$database = new DatabaseMysqli();
$employeeMapper = new EmployeeMapper();
$employeeMapper->withLeft(['manager' => 'EmployeeMapper']);
$employeeMapper->fields([EmployeeMapper::ID, EmployeeMapper::FIRST_NAME, 'Manager' . EmployeeMapper::FIRST_NAME]);
$employees = $employeeMapper->findAll();
echo '<pre>';
//print_r($employees);
foreach ($employees as $key => $employee) {
    echo $employee->getId() . ' -- ' . $employee->getFirstName() . ' -- ' . $employee->manager()->getFirstName();
    echo '<br>';
}

//$database = new DatabaseMysqli();
$employeeMapper = new EmployeeMapper();
$employeeMapper->with(['DepartmentMapper']);
$employeeMapper->withLeft(['manager' => 'EmployeeMapper']);
$employeeMapper->fields([EmployeeMapper::ID, EmployeeMapper::FIRST_NAME,
    DepartmentMapper::NAME, 'Manager' . EmployeeMapper::FIRST_NAME]);
$employees = $employeeMapper->findAll();
echo '<pre>';
//print_r($employees);
foreach ($employees as $key => $employee) {
    echo $employee->getId() . ' -- ' . $employee->getFirstName() . ' -- ' . $employee->department()->getName() . ' -- ' . $employee->manager()->getFirstName();
    echo '<br>';
}

$employeeMapper = new EmployeeMapper();
$employeeMapper->with(['DepartmentMapper']);
$employeeMapper->group(EmployeeMapper::DEPT_ID);
$employeeMapper->fields([EmployeeMapper::MANAGERS_COUNT, DepartmentMapper::NAME]);
$employees = $employeeMapper->findAll();
echo '<pre>';
//print_r($employees);
foreach ($employees as $key => $employee) {
    echo $employee->department()->getName() . ' -- ' . $employee->getManagerCount();
    echo '<br>';
}

$employeeMapper = new EmployeeMapper();
$employeeMapper->andCondition([
    $employeeMapper->equals(EmployeeMapper::ID, 3),
    $employeeMapper->equals(EmployeeMapper::DEPT_ID, 1)
    ]);
$employeeMapper->fields([EmployeeMapper::ID, EmployeeMapper::FIRST_NAME, EmployeeMapper::DEPT_ID]);
$employees = $employeeMapper->findAll();
echo '<pre>';
//print_r($employees);
foreach ($employees as $key => $employee) {
    echo $employee->getId() . ' -- ' . $employee->getFirstName() . ' -- ' . $employee->getDeptId();
    echo '<br>';
}

$employeeMapper = new EmployeeMapper();
$employeeMapper->andCondition([$employeeMapper->greaterThan(EmployeeMapper::ID, 2)]);
$employeeMapper->fields([EmployeeMapper::ID, EmployeeMapper::FIRST_NAME, EmployeeMapper::DEPT_ID]);
$employees = $employeeMapper->findAll();
echo '<pre>';
//print_r($employees);
foreach ($employees as $key => $employee) {
    echo $employee->getId() . ' -- ' . $employee->getFirstName() . ' -- ' . $employee->getDeptId();
    echo '<br>';
}

$employeeMapper = new EmployeeMapper();
$employeeMapper->andCondition([$employeeMapper->equalsRelation('DepartmentMapper')]);
$employeeMapper->fields([EmployeeMapper::EMPLOYEES_COUNT]);
$departmentMapper = new DepartmentMapper();
$departmentMapper->andCondition([$departmentMapper->lessThan(2, $employeeMapper)]);
$departmentMapper->fields([DepartmentMapper::NAME]);
$departments = $departmentMapper->findAll();
echo '<pre>';
//print_r($departments);
foreach ($departments as $key => $department) {
    echo $department->getName();
    echo '<br>';
}

$departmentMapper = new DepartmentMapper();
$departmentMapper->andCondition([$departmentMapper->equalsRelation('EmployeeMapper')]);
$departmentMapper->fields([DepartmentMapper::NAME]);
$employeeMapper = new EmployeeMapper();
$employeeMapper->fields([EmployeeMapper::ID, EmployeeMapper::FIRST_NAME]);
$employeeMapper->fieldsWithMapper([DepartmentMapper::NAME => $departmentMapper]);
$employees = $employeeMapper->findAll();
echo '<pre>';
//print_r($employees);
foreach ($employees as $key => $employee) {
    echo $employee->getId() . ' -- ' . $employee->getFirstName() . ' -- ' . $employee->department()->getName();
    echo '<br>';
}
*/