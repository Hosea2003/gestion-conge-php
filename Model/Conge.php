<?php
    function getConges(){
        $conges = explode("#", file_get_contents(dirname(__DIR__)."\\Files\\Conge.txt"));
        $conges=array_filter($conges, "verifyEmp");
        $Conges=array();
        foreach($conges as $conge){
            $conge=explode("~", $conge);
            $Conges[] = new Conge($conge[0], $conge[1], $conge[2], $conge[3],  getEmployeeById($conge[0]), $conge[4], $conge[5]);
            
        }
        return $Conges;
    }

    function getDemandeConge(){
        $conges = getConges();
        $Conges = array();
        foreach($conges as $conge){
            if($conge->getIsAccorde()=="not-seen" ||  $conge->getIsAccorde()=="seen"){
                $Conges[]=$conge;
            }
        }
        return $Conges;
    }

    function getCongeNotif(){
        $conges = getConges();
        $Conges = array();
        foreach($conges as $conge){
            if($conge->getIsAccorde()=="not-seen"){
                $Conges[]=$conge;
            }
        }
        return $Conges;
    }

    class Conge{
        private $id;
        private DateTime $date_debut;
        private DateTime $date_fin;
        private $employee;
        private $ID;
        private $isAccorde;//not-seen; accorde;non-accorde//seen
        private DateTime $date_envoi;


        /**
         * @param $id
         * @param $date_debut
         * @param $date_fin
         * @param $employee
         */
        public function __construct($id, $date_debut, $date_fin, $isAccorde, $employee, $date_envoi, $idConge)
        {
            $this->id = $id;
            $this->date_debut = DateTime::createFromFormat("Y-m-d", $date_debut);
            $this->date_fin = DateTime::createFromFormat("Y-m-d", $date_fin);
            $this->isAccorde= $isAccorde;
            $this->employee = $employee;
            $this->date_envoi=DateTime::createFromFormat("Y-m-d", $date_envoi);
            $this->ID=$idConge;
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
        public function getDateDebut():DateTime
        {
            return $this->date_debut;
        }

        /**
         * @param mixed $date_debut
         */
        public function setDateDebut($date_debut)
        {
            $this->date_debut = $date_debut;
        }

        /**
         * @return mixed
         */
        public function getDateFin():DateTime
        {
            return $this->date_fin;
        }

        /**
         * @param mixed $date_fin
         */
        public function setDateFin($date_fin)
        {
            $this->date_fin = $date_fin;
        }

        /**
         * @return mixed
         */
        public function getEmployee()
        {   
            return $this->employee;
        }

        /**
         * @return mixed
         */
        public function getIsAccorde()
        {
            return $this->isAccorde;
        }

        /**
         * @param mixed $isAccorde
         */
        public function setIsAccorde($isAccorde)
        {
            $this->isAccorde = $isAccorde;
        }

        // /**
        //  * @param mixed $employee
        //  */
        // public function setEmployee($employee)
        // {
        //     $this->employee = $employee;
        // }

        public function getDateEnvoi():DateTime{
            return $this->date_envoi;
        }


        public function setDateEnvoi($date_envoi){
            $this->date_envoi=$date_envoi;
        }

        /**
         * @return mixed
         */
        public function getIdConge()
        {
            return $this->ID;
        }

        /**
         * @param mixed $id
         */
        public function setIdConge($id)
        {
            $this->ID = $id;
        }

        public function ToString():string{
            return $this->id."~".$this->date_debut->format("Y-m-d")."~".$this->date_fin->format("Y-m-d")."~".$this->isAccorde."~".$this->date_envoi->format("Y-m-d")."~".$this->ID."#";
        }

        public static function add_conge(Conge $conge){
            file_put_contents(dirname(__DIR__)."\\Files\\Conge.txt", $conge->ToString(), FILE_APPEND);
        }

        public static function congeByEmployee($id_emp){
            $conges = getConges();
            $Conges=array();
            foreach($conges as $conge){
                if($conge->getId()==$id_emp)
                    $Conges[]=$conge;
            }
            return $Conges;
        }

        public static function EmployeeConge(){
            $employees = array();
            $conges = getConges();
            $today = new DateTime();
            foreach($conges as $conge){
                if($conge->getIsAccorde()=="accorder"){
                    if($today->getTimestamp()>=$conge->getDateDebut()->getTimeStamp())
                        $employee[]=$conge->getEmployee();
                }
            }
            return $employees;
        }

        public function Action($conges, $action){
            $this->isAccorde=$action;
            $content="";
            foreach($conges as $conge){
                $content.=$conge->ToString();
            }
            file_put_contents(dirname(__DIR__)."\\Files\\Conge.txt", $content);
        }

        public static function getCongeList($id){
            $conges = getConges();
            $result = array(1=>$conges);
            foreach($conges as $conge){
                if($conge->getIdConge()==$id){
                    $result[0]=$conge;
                    break;
                }
            }
            return $result;
        }

        public static function getNextId():int{
            return count(getConges())+1;
        }

    }
?>