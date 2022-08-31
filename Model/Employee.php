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
        $new_employee = new Employee($employee[0], $employee[1], $employee[2], $employee[3],getUserByGroup($employee[0], "user"));
        $new_employee->isBloque=$employee[4];
        $Employees[] = $new_employee;
    }
    return $Employees;
}

function getEmployeeById($id){
    $employees = getEmployees();
    foreach($employees as $emp)
        if($emp->getId()==$id)
            return $emp;
    return null;
}

function getEmployeesById($id){
    $employees = getEmployees();
    $result=array(1=>$employees);
    foreach($employees as $emp)
        if($emp->getId()==$id){
            $result[0]=$emp;
            break;
        }
    return $result;
}

class Employee
{
    private $id;
    private $first_name;
    private $name;
    private $user;
    private $address;
    public $isBloque;

    /**
     * @param $id
     * @param $first_name
     * @param $name
     */

    public function __construct($id, $first_name, $name, $address, $user)
    {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->name = $name;
        $this->user=$user;
        $this->address = $address;
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

    public function getAddress(){
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    public function ToString():string{
        return $this->id."~".$this->first_name."~".$this->name."~".$this->address."~".$this->isBloque."#";
    }

    public static function add_employee(Employee $employee){
        file_put_contents(dirname(__DIR__)."\\Files\\Employee.txt", $employee->ToString(), FILE_APPEND);
    }

    public static function getNextId():int{
        return count(getEmployees())+1;
    }

    public function update($employees){
        $content = "";
        foreach($employees as $e){
            $content.=$e->ToString();
        }
        file_put_contents(dirname(__DIR__)."\\Files\\Employee.txt", $content);
    }

    public static function getEmployeeByUser($id){
        foreach(getEmployees() as $e){
            if($e->getUser()->getId()==$id){
                return $e;
            }
        }
    }
}