<?php
function verifyEmp($employee){
    if(!empty($employee))
        return $employee;
}

function getEmployees(){
    $employees = explode("#", file_get_contents(dirname(__DIR__)."\\Files\\Employee.txt"));
    $employees=array_filter($employees, "verifyEmp");
    $Employees=array();
    foreach($employees as $employee){
        $employee=explode("~", $employee);
        $Employees[] = new Employee($employee[0], $employee[1], $employee[2], getUserByGroup($employee[0], "user"));
    }
    return $Employees;
}

function getEmployeeById($id){
    $employees = getEmployees();
    foreach($employees as $emp)
        if($emp->getId()==$id)
            return $emp;
}

class Employee
{
    private $id;
    private $first_name;
    private $name;
    private $user;

    /**
     * @param $id
     * @param $first_name
     * @param $name
     */

    public function __construct($id, $first_name, $name, $user)
    {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->name = $name;
        $this->user=$user;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }



}